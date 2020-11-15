<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use App\CustomProductParameter;

class CartController extends Controller
{
    public function __construct()
    {
        
    }

    public function displayCart(Request $request)
    {
        $cart = [];
        if (session()->has('cart')) {
            $cartItems = json_decode(session('cart'));
            for ($i = 0; $i < count($cartItems); $i++) {
                $product = Product::where('id', $cartItems[$i]->productId)->first();
                
                $item = new \StdClass();
                $item->id = $cartItems[$i]->id;
                $item->name = $product->name;
                $item->quantity = intval($cartItems[$i]->quantity);
                $item->price = $cartItems[$i]->price;
                $item->shippingPrice = $cartItems[$i]->shippingPrice;
                $item->image = $cartItems[$i]->image;
                $item->parameters = $cartItems[$i]->parameters;
                array_push($cart, $item);
            }
        }

        return view('cart', [
            'cart' => $cart,
            'shippingPrice' => Cart::getShippingPrice(),
        ]);
    }

    public function addToCart(Request $request) {
        $data = $request->all();

        $product = Product::where('id', $request->input('id'))->first();
        if (is_null($product)) {
            return abort(404);
        }

        $customParameters = CustomProductParameter::getByProductId($product->id);
        $parameterSettings = json_decode($product->parameter_settings);
        $selectedParameters = json_decode($data['parameters']);

        if ($selectedParameters[0] == '' && $selectedParameters[1] == '' && $selectedParameters[2] == '') {
            $selectedParameters[0] = $parameterSettings[0]->param1;
            $selectedParameters[1] = $parameterSettings[0]->param2;
            $selectedParameters[2] = $parameterSettings[0]->param3;
        }

        // retrieve or create cart
        if (session()->has('cart')) {
            $cart = json_decode(session('cart'));
        } else {
            $cart = [];
        }

        // store new item in cart
        $itemFound = false;
        $newCartItemId = 0;
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]->id > $newCartItemId) {
                $newCartItemId = $cart[$i]->id;
            }
            
            if ($cart[$i]->productId == $data['id'] &&
                $selectedParameters[0] == $cart[$i]->parameters[0] &&
                $selectedParameters[1] == $cart[$i]->parameters[1] &&
                $selectedParameters[2] == $cart[$i]->parameters[2]) {
                    $cart[$i]->quantity += $data['quantity'];
                    $itemFound = true;
            }
        }

        if (!$itemFound) {
            $item = new \StdClass();
            $item->id = $newCartItemId + 1;
            $item->productId = $data['id'];
            $item->productName = $product->name;
            $item->quantity = $data['quantity'];
            $item->parameters = $selectedParameters;
            $item->price = 0;
            $item->shippingPrice = 0;
            $item->image = '';
            array_push($cart, $item);
        }

        // save cart in session
        session(['cart' => json_encode($cart)]);
        Cart::updateData();
        return redirect('cart');
    }

    public function modifyCartItem(Request $request) {
        $id = intval($request->input('id'));
        $quantity = intval($request->input('quantity'));
    
        // retrieve cart
        if (session()->has('cart')) {
            $cart = json_decode(session('cart'));
        }

        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]->id == $id) {
                $cart[$i]->quantity = $quantity;
                break;
            }
        }
        
        session(['cart' => json_encode($cart)]);
        Cart::updateData();
        echo 'success';
    }

    public function removeCartItem(Request $request) {
        $id = intval($request->input('id'));
    
        // retrieve cart
        if (session()->has('cart')) {
            $cart = json_decode(session('cart'));
        }

        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]->id == $id) {
                array_splice($cart, $i, 1);
                break;
            }
        }
        
        session(['cart' => json_encode($cart)]);
        echo 'success';
    }
}
