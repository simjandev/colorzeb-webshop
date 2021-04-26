@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/admin_orders.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('admin.side_panel')
    <div class="row col-lg-9 col-xl-8 offset-xl-1">
        @php
            $links = str_replace('?page=', '/', $orders->links());
            if (strlen($links)) {
                echo '<div class="row col-sm-12">' . $links . '</div>';
            }
        @endphp
        <table id="admin-orders" class="table table-bordered table-sm col-lg-12 box-shadow">
            <thead>
                <tr>
                    <th>M. szám</th>
                    <th>Megrendelő</th>
                    <th>Fizetendő</th>
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
                        <td>{{ $order->billing_name }}</td>
                        <td>{{ $order->price + $order->shipping_price }} Ft</td>
                        <td>{{ $order->payed ? 'Igen' : 'Nem' }}</td>
                        <td>{{ $order->status }}</td>
                        <td title="{{ explode(' ', $order->created_at)[1] }}">{{ explode(' ', $order->created_at)[0] }}</td>
                        <td>
                            <a href="/admin/order/{{ $order->id }}">
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