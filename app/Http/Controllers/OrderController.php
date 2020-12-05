<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use App\Order;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function __construct()
    {
        
    }

    public function orderLogin() {
        if (Auth::check()) {
            return redirect('order-shipping');
        }

        return view('order_login');
    }

    public function orderShipping() {
        if (!session()->has('cart')) {
            return redirect('cart');
        }

        // get order customer data from session
        if (session()->has('order-customer-data')) {
            $orderCustomerData = json_decode(session('order-customer-data'));

            return view('order_shipping', [
                'orderCustomerData' => $orderCustomerData,
            ]);
        }
        
        // get order customer data from user settings
        if(Auth::check()){
            $user = Auth::user();

            $orderCustomerData = new \StdClass();
            $orderCustomerData->email = $user->email;
            $orderCustomerData->comment = '';

            $orderCustomerData->shippingName = $user->shipping_name;
            $orderCustomerData->shippingPhone = $user->shipping_phone;
            $orderCustomerData->shippingZip = $user->shipping_zip_code;
            $orderCustomerData->shippingCity = $user->shipping_city;
            $orderCustomerData->shippingAddress = $user->shipping_address;

            $orderCustomerData->billingName = $user->billing_name;
            $orderCustomerData->billingTaxNumber = $user->billing_tax_number;
            $orderCustomerData->billingZip = $user->billing_zip_code;
            $orderCustomerData->billingCity = $user->billing_city;
            $orderCustomerData->billingAddress = $user->billing_address;
            
            session(['order-customer-data' => json_encode($orderCustomerData)]);

            return view('order_shipping', [
                'orderCustomerData' => $orderCustomerData,
            ]);
        }

        return view('order_shipping');
    }

    public function orderCustomerData(Request $request) {
        $data = $request->all();

        $customerData = new \StdClass();
        $customerData->email = $data['email'];
        $customerData->comment = $data['comment'];

        $customerData->shippingName = $data['shippingName'];
        $customerData->shippingPhone = $data['shippingPhone'];
        $customerData->shippingZip = $data['shippingZip'];
        $customerData->shippingCity = $data['shippingCity'];
        $customerData->shippingAddress = $data['shippingAddress'];

        $customerData->billingName = $data['billingName'];
        $customerData->billingTaxNumber = $data['billingTaxNumber'];
        $customerData->billingZip = $data['billingZip'];
        $customerData->billingCity = $data['billingCity'];
        $customerData->billingAddress = $data['billingAddress'];

        session(['order-customer-data' => json_encode($customerData)]);
        return 'success';
    }

    public function orderConfirm() {
        if (!session()->has('cart')) {
            return redirect('order-shipping');
        }

        if (!session()->has('order-customer-data')) {
            return redirect('order-shipping');
        }

        Cart::updateData();

        $orderCustomerData = json_decode(session('order-customer-data'));
        $cart = json_decode(session('cart'));
        return view('order_confirm', [
            'orderCustomerData' => $orderCustomerData,
            'cart' => $cart,
        ]);
    }

    public function createOrder(Request $request) {
        if (!session()->has('cart')) {
            return redirect('order-shipping');
        }
        
        if (!session()->has('order-customer-data')) {
            return redirect('order-shipping');
        }

        $orderCustomerData = json_decode(session('order-customer-data'));
        $cart = json_decode(session('cart'));

        for ($i = 0; $i < 400; $i++) {
            // calculate price and shipping price
            $sumPrice = 0;
            $shippingPrice = 0;
            foreach ($cart as $cartItem) {
                $sumPrice += $cartItem->price * $cartItem->quantity;
                if ($cartItem->shippingPrice > $shippingPrice) {
                    $shippingPrice = $cartItem->shippingPrice;
                }
            }

            // create order
            $order = new Order();
            $order->user_id = Auth::check() ? Auth::user()->id : null;
            $order->email = $orderCustomerData->email;
            $order->user_comment = is_null($orderCustomerData->comment) ? '' : $orderCustomerData->comment;
            $order->admin_comment = '';
            $order->billing_name = $orderCustomerData->billingName;
            $order->billing_tax_number = is_null($orderCustomerData->billingTaxNumber) ? '' : $orderCustomerData->billingTaxNumber;
            $order->billing_zip_code = $orderCustomerData->billingZip;
            $order->billing_city = $orderCustomerData->billingCity;
            $order->billing_address = $orderCustomerData->billingAddress;
            $order->shipping_name = $orderCustomerData->shippingName;
            $order->shipping_phone = $orderCustomerData->shippingPhone;
            $order->shipping_zip_code = $orderCustomerData->shippingZip;
            $order->shipping_city = $orderCustomerData->shippingCity;
            $order->shipping_address = $orderCustomerData->shippingAddress;
            $order->price = $sumPrice;
            $order->shipping_price = $shippingPrice;
            $order->payed = false;
            $order->status = 'Feldolgozásra vár';
            $order->save();
            
            // create order items
            foreach ($cart as $cartItem) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $cartItem->productId;
                $orderProduct->name = $cartItem->productName;
                $orderProduct->price = $cartItem->price;
                $orderProduct->quantity = $cartItem->quantity;
                $orderProduct->image = $cartItem->image;
                $orderProduct->parameters = json_encode($cartItem->parameters);
                $orderProduct->save();
            }

            // save order customer data for user
            if (Auth::check()) {
                $user = Auth::user();
                $user->billing_name = $orderCustomerData->billingName;
                $user->billing_tax_number = is_null($orderCustomerData->billingTaxNumber) ? '' : $orderCustomerData->billingTaxNumber;
                $user->billing_zip_code = $orderCustomerData->billingZip;
                $user->billing_city = $orderCustomerData->billingCity;
                $user->billing_address = $orderCustomerData->billingAddress;
                $user->shipping_name = $orderCustomerData->shippingName;
                $user->shipping_phone = $orderCustomerData->shippingPhone;
                $user->shipping_zip_code = $orderCustomerData->shippingZip;
                $user->shipping_city = $orderCustomerData->shippingCity;
                $user->shipping_address = $orderCustomerData->shippingAddress;
                $user->save();
            }
        }

        // forget cart and order customer data
        $request->session()->forget('order-customer-data');
        $request->session()->forget('cart');


        return view('home');
    }
}
