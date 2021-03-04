@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/order_steps.css') }}" rel="stylesheet">
    <link href="{{ asset('css/order_login.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="order-login">
        <order-steps-component :_active="2"></order-steps-component>
        <div class="col-lg-12 col-xl-10 offset-xl-1 row">
            <div class="col-sm-12 col-md-6 order-login-box">
                @guest
                    <order-login-component></order-login-component>
                @endguest
            </div>
            <div class="col-sm-12 col-md-6 order-login-box">
                <div class="alert alert-success">
                    <b>Miért regisztrálj?</b>
                    <ul>
                        <li>Megrendeléseid egyszerűbben nyomon követheted</li>
                        <li>Emailben értesülhetsz a legújabb ajánlatainkról</li>
                        <li>Nem kell minden rendelésnél újra megadnod az adataidat</li>
                    </ul>
                </div>
                <a href="/order-shipping">
                    <button class="button">Folytatás bejelentkezés nélkül</button>
                </a>
            </div>
        </div>
    </div>
@endsection