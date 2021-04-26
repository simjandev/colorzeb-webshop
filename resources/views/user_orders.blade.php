@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/user_orders.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="user-orders-box" class="col-sm-12">
        @php
            $links = str_replace('?page=', '/', $orders->links());
            if (strlen($links)) {
                echo '<div class="row pagination-row col-sm-12">' . $links . '</div>';
            }
        @endphp
        <table id="user-orders" class="table table-bordered table-sm col-lg-12 box-shadow">
            <thead>
                <tr>
                    <th>M. szám</th>
                    <th>Végösszeg</th>
                    <th>Fizetve</th>
                    <th>Állapot</th>
                    <th>Időpont</th>
                    <th>Megtekintés</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->price + $order->shipping_price }} Ft</td>
                        <td>{{ $order->payed ? 'Igen' : 'Nem' }}</td>
                        <td>{{ $order->status }}</td>
                        <td title="{{ explode(' ', $order->created_at)[1] }}">{{ explode(' ', $order->created_at)[0] }}</td>
                        <td>
                            <a href="/user/order/{{ $order->id }}">
                                <button class="product-button button blue" title="Megtekintés">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection