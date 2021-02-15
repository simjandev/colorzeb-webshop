@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/admin_order_details.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('admin.side_panel')
    <modify-order-component 
        :_order="{{ $order }}"
        :_order-products="{{ $products }}"
        :_order-emails="{{ $emails }}"
    ></modify-order-component>
@endsection