<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\CustomProductParameter;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{

    public function searchProducts(Request $request, $minimumPrice, $maximumPrice, $text, $selectedCategories, $selectedFilters, $discountFilter, $page, $changed = false)
    {
        // set url for paginator
        $paginatorUrl = explode('/', $request->url());
        unset($paginatorUrl[count($paginatorUrl) - 1]);
        if ($changed) {
            unset($paginatorUrl[count($paginatorUrl) - 1]);
            $page = 1;
        }

        $paginatorUrl = implode('/', $paginatorUrl);
        
        // cast parameters
        $currentMinimumPrice = intval($minimumPrice);
        $currentMaximumPrice = intval($maximumPrice);
        $text = urldecode($text);
        $selectedCategories = json_decode(urldecode($selectedCategories));
        $selectedFilters = json_decode(urldecode($selectedFilters));
        $page = intval($page);
        $pageSize = 16;
    

        // create products query based on filters
        $products = \DB::table('products')->leftJoin('custom_product_parameters', 'products.id', '=', 'custom_product_parameters.product_id');
        $products = $products->select('products.*');
        $products = $products->where('active', '1');
        if ($discountFilter) {
            $products = $products->where('discount', '>', '0');
        }

        $products = $products->where('products.price', '>=', $currentMinimumPrice);
        $products = $products->where('products.price', '<=', $currentMaximumPrice);
        if ($text !== '*' && $text !== '') {
            $products = $products->where('products.name', 'LIKE', '%' . $text . '%');
        } else {
            $text = '';
        }

        // cateegory filter
        $categories = Category::select(['id', 'name'])->get();
        foreach ($categories as $category) {
            $category->checked = false;
            if (in_array($category->id, $selectedCategories)) {
                $category->checked = true;
            }
        }

        if (!empty($selectedCategories)) {
            $products = $products->whereIn('products.category_id', $selectedCategories);
        }

        // check for each filter
        $filters = CustomProductParameter::getListForFilter();
        foreach ($filters as $name => $filter) {
            $options = [];
            foreach ($filter as $option) {
                if (isset($selectedFilters->$name) && in_array($option->value, $selectedFilters->$name)) {
                    $option->checked = true;
                    array_push($options, $option->value);
                }
            }

            if(empty($options)) {
                continue;
            }

            $products = $products->whereExists(function ($query) use ($name, $options) {
                $query->select(\DB::raw(1))->from('custom_product_parameters')
                ->whereRaw('custom_product_parameters.product_id = products.id')
                ->where('custom_product_parameters.name', $name)
                ->whereIn('custom_product_parameters.value', $options);
            });
        }
        
        
        if (!Product::select('price')->orderBy('price', 'asc')->count()) {
            $minimumPriceLimit = new \StdClass();
            $maximumPriceLimit = new \StdClass();
            $minimumPriceLimit->price = 1;
            $maximumPriceLimit->price = 100;
        } else {            
            $minimumPriceLimit = Product::select('price')->orderBy('price', 'asc')->first();
            $maximumPriceLimit = Product::select('price')->orderBy('price', 'desc')->first();

            if ($minimumPriceLimit->price == $maximumPriceLimit->price) {
                $minimumPriceLimit->price = $currentMinimumPrice;
                $maximumPriceLimit->price = $currentMaximumPrice;
            }
        }

        $products = $products->groupBy('products.id')->paginate($pageSize, ['products.id'], 'page', $page)->withPath($paginatorUrl);
        return view('search_products', [
            'products' => $products,
            'categories' => json_encode($categories),
            'filters' => !count($filters) ? json_encode(new \StdClass()) : json_encode($filters),
            'discountFilter' => $discountFilter,
            'page' => $page,
            'currentMinimumPrice' => $currentMinimumPrice,
            'currentMaximumPrice' => $currentMaximumPrice,
            'minimumPriceLimit' => $minimumPriceLimit,
            'maximumPriceLimit' => $maximumPriceLimit,
            'text' => $text,
        ]);
    }

    public function searchProductsIndex(Request $request)
    {
        // redirect ugly url pagination
        if (!Product::select('price')->orderBy('price', 'asc')->count()) {
            $minimumPriceLimit = 1;
            $maximumPriceLimit = 100;
        } else {
            $minimumPriceLimit = Product::select('price')->orderBy('price', 'asc')->first()->price;
            $maximumPriceLimit = Product::select('price')->orderBy('price', 'desc')->first()->price;
            if ($minimumPriceLimit == $maximumPriceLimit) {
                $minimumPriceLimit -= 100;
                if ($minimumPriceLimit < 1) {
                    $minimumPriceLimit = 1;
                }

                $maximumPriceLimit += 100;
            }
        }
        
        $text = urlencode('*');
        $categories = urlencode(json_encode([]));
        $filters = urlencode(json_encode([]));
        $page = 1;


        $url = '/products/' . $minimumPriceLimit . '/' . $maximumPriceLimit . '/' . $text . '/' . $categories . '/' .
        $filters . '/0/' . $page;

        return redirect($url);
    }

    public function displayProductDetails(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        $customParameters = CustomProductParameter::getByProductId($id);
        
        return view('product_details', [
            'product' => $product,
            'customParameters' => json_encode($customParameters),
        ]);
    }

    public function getProductImage($fileName, $color = '000000', $extraPicture = '') {
        $coloredImage = Image::make(Storage::disk('public')->path($fileName));
        
        if ($color !== '000000') {
            $coloredImage->colorize(intval(hexdec(substr($color, 0, 2)) / 255 * 100), intval(hexdec(substr($color, 2, 2)) / 255 * 100), intval(hexdec(substr($color, 4, 2)) / 255 * 100));
        }
        
        $coloredImage->insert(Storage::disk('public')->path('watermark.png'));
        
        if ($extraPicture) {
            $coloredImage->insert(Storage::disk('public')->path('extra_images/' . $extraPicture));
        }

        return $coloredImage->response('png');
    }

    public function uploadProductImage(Request $request) {
        if (!$request->has('images')) {
            return;
        }

        $images = $request->images;
        foreach ($images as $image) {
            Storage::disk('public')->delete($image->getClientOriginalName());

            $image->move(storage_path('/app/public'), $image->getClientOriginalName());
        }
    }

}
