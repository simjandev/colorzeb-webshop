<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('home');
    }

    public function userOrders(Request $request, $page = '') {
        // set url for paginator
        $pageSize = 10;
        $paginatorUrl = explode('/', $request->url());
        if ($page == '') {
            $page = 1;
        } else {
            unset($paginatorUrl[count($paginatorUrl) - 1]);
        }

        $paginatorUrl = implode('/', $paginatorUrl);

        $orders = Order::select('*')->where('user_id', Auth::user()->id)->paginate($pageSize, ['orders.id'], 'page', $page)->withPath($paginatorUrl);
        return view('user_orders', [
            'active' => 'Megrendeléseim',
            'orders' => $orders,
            'userName' => Auth::user()->name,
        ]);
    }

    public function userOrderDetails($id) {
        $order = Order::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $products = OrderProduct::where('order_id', $id)->get();
        if (!$order) {
            return abort(404);
        };

        return view('user_order_details', [
            'active' => 'Megrendelés részletek',
            'order' => $order,
            'products' => $products,
            'userName' => Auth::user()->name,
        ]);
    }

    public function dev()
    {
       
    }
}
