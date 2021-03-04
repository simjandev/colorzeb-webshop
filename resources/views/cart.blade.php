@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/order_steps.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cart.css') }}" rel="stylesheet">
@endsection

@section('content')
    @php
        $cart = json_encode($cart);
    @endphp    
    <cart-component :_cart-items="{{ $cart }}"></cart-component>
@endsection