<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
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

        if (session()->has('order-customer-data')) {
            $orderCustomerData = json_decode(session('order-customer-data'));

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
        if (!session()->has('order-customer-data')) {
            return redirect('order-shipping');
        }

        if (!session()->has('cart')) {
            return redirect('order-shipping');
        }

        $orderCustomerData = json_decode(session('order-customer-data'));
        $cart = json_decode(session('cart'));
        return view('order_confirm', [
            'orderCustomerData' => $orderCustomerData,
            'cart' => $cart,
        ]);
    }

    public function createOrder(Request $request) {

    }
}
