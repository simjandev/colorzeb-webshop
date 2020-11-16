@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/admin_orders.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('admin.side_panel')
    <table id="admin-orders" class="table table-bordered table-sm col-lg-8 offset-lg-1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Megrendelő</th>
                <th>Ár</th>
                <th>Fizetve</th>
                <th>Állapot</th>
                <th>Megrendelve</th>
                <th>Megtekintés</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->billing_name }}</td>
                    <td>{{ $order->price }} Ft</td>
                    <td>{{ $order->payed ? 'Igen' : 'Nem' }}</td>
                    <td>{{ $order->status }}</td>
                    <td title="{{ explode(' ', $order->created_at)[1] }}">{{ explode(' ', $order->created_at)[0] }}</td>
                    <td>
                        <a target="_blank" href="/admin/order/{{ $order->id }}">
                            <button class="product-button button blue" title="Megtekintés">
                                <i class="fa fa-eye"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection