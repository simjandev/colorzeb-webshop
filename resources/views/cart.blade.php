@extends('layouts.app')

@section('head')
@endsection

@section('content')
    @php
        $cart = json_encode($cart);
    @endphp    
    <cart-component :_cart-items="{{ $cart }}"></cart-component>
@endsection