<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\CustomProductParameter;

class Cart extends Model
{
    public static function getValue() {
        if (!session()->has('cart')) {
            return 0;
        }
        
        $cart = json_decode(session('cart'));
        $cartValue = 0;
        for ($i = 0; $i < count($cart); $i++) {
            $cartValue += $cart[$i]->price * $cart[$i]->quantity;
        }
        
        return $cartValue;
    }

    public static function getNumberOfItems() {
        if (!session()->has('cart')) {
            return 0;
        }
        
        $cart = json_decode(session('cart'));
        return count($cart);
    }

    public static function getShippingPrice() {
        if (session()->has('cart')) {
            $cart = json_decode(session('cart'));
        } else {
            return 0;
        }

        $shippingPrice = 0;
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]->shippingPrice > $shippingPrice) {
                $shippingPrice = $cart[$i]->shippingPrice;
            }
        }
        
        return $shippingPrice;
    }

    public static function updateData() {
        if (session()->has('cart')) {
            $cart = json_decode(session('cart'));
        } else {
            $cart = [];
        }

        for ($i = 0; $i < count($cart); $i++) {
            $product = Product::where('id', $cart[$i]->productId)->first();

            $customParameters = CustomProductParameter::getByProductId($cart[$i]->productId);
            $parameterSettings = json_decode($product->parameter_settings);
            $cart[$i]->parameters = $cart[$i]->parameters;

            for ($j = 1; $j < count($parameterSettings); $j++) {
                if ($parameterSettings[$j]->param1 !== '' && $parameterSettings[$j]->param1 !== $cart[$i]->parameters[0] &&
                    $customParameters[0]->type == 'select') {
                        continue;
                }

                if ($parameterSettings[$j]->param2 !== '' && $parameterSettings[$j]->param2 !== $cart[$i]->parameters[1] &&
                    $customParameters[1]->type == 'select') {
                        continue;
                }

                if ($parameterSettings[$j]->param3 !== '' && $parameterSettings[$j]->param3 !== $cart[$i]->parameters[2] &&
                    $customParameters[2]->type == 'select') {
                        continue;
                }

                if ($parameterSettings[$j]->price) {
                    $cart[$i]->price = $parameterSettings[$j]->price;
                    if ($product->discount) {
                        $cart[$i]->price = round($parameterSettings[$j]->price * (1 - $product->discount / 100));
                    }
                }

                if ($parameterSettings[$j]->image !== '') {
                    $cart[$i]->image = '/product-image/' . $parameterSettings[$j]->image->name . '/' . $parameterSettings[$j]->image->color . '/' . $parameterSettings[$j]->image->extraImage->file;
                }

                if ($parameterSettings[$j]->shippingPrice) {
                    $cart[$i]->shippingPrice = $parameterSettings[$j]->shippingPrice;
                }

            }
            
            $cart[$i]->parameters = $cart[$i]->parameters;
        }
        
        session(['cart' => json_encode($cart)]);
    }
}
