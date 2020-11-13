<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
