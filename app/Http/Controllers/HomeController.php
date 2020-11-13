<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\CustomProductParameter;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('home');
    }

    public function dev()
    {
        $products = Product::all();

        foreach ($products as $index => $product) {
            if (true || ($index > 140 && $index < 147)) {
                $parameter = new CustomProductParameter();
                $parameter->product_id = $product->id;
                $parameter->type = 'select';
                $parameter->name = 'méret';
                $parameter->value = 'S';
                $parameter->save();
            }

            if (true || ($index > 100 && $index < 107)) {
                $parameter = new CustomProductParameter();
                $parameter->product_id = $product->id;
                $parameter->type = 'select';
                $parameter->name = 'méret';
                $parameter->value = 'M';
                $parameter->save();
            }

            if (true || ($index > 50 && $index < 57)) {
                $parameter = new CustomProductParameter();
                $parameter->product_id = $product->id;
                $parameter->type = 'select';
                $parameter->name = 'méret';
                $parameter->value = 'L';
                $parameter->save();
            }

            if (true || ($index > 20 && $index < 25)) {
                $parameter = new CustomProductParameter();
                $parameter->product_id = $product->id;
                $parameter->type = 'select';
                $parameter->name = 'szín';
                $parameter->value = 'piros';
                $parameter->save();
            }

            if (true || ($index > 180 && $index < 185)) {
                $parameter = new CustomProductParameter();
                $parameter->product_id = $product->id;
                $parameter->type = 'select';
                $parameter->name = 'szín';
                $parameter->value = 'zöld';
                $parameter->save();
            }

            if (true || ($index > 170 && $index < 185)) {
                $parameter = new CustomProductParameter();
                $parameter->product_id = $product->id;
                $parameter->type = 'select';
                $parameter->name = 'szín';
                $parameter->value = 'kék';
                $parameter->save();
            }

            $parameter = new CustomProductParameter();
            $parameter->product_id = $product->id;
            $parameter->type = 'text';
            $parameter->name = 'egyedi szöveg';
            $parameter->value = '';
            $parameter->save();
        }
    }
}
