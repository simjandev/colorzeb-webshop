@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/image_slide.css') }}" rel="stylesheet">
    <link href="{{ asset('css/product_slide.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="welcome-text-box" class="row col-sm-12 col-xl-12 w-100">
        <div id="welcome-text" class="col-sm-12">
            <div id="welcome-text-left">
                <image-slide-component
                    :_images="['/images/home-page-image.jpg', '/images/home-page-image.jpg', '/images/home-page-image.jpg', '/images/home-page-image.jpg', '/images/home-page-image.jpg', '/images/home-page-image.jpg', '/images/home-page-image.jpg']"
                ></image-slide-component>
            </div>
            <div id="welcome-text-right">
                <div id="welcome-text-header">
                    <img src="/images/logo.png">
                </div>
                <h5>Matricák és sok más kreatív díszlet és ajándék!</h5>
                <div>
                    Nézz szét honlapunkon és válogass termékeink széles választékából, vagy kérj árajánlatot az egyedi ötleteid megvalósításához:
                    <ul>
                        <li>Egyedi céges logó matrica</li>
                        <li>Fali matricák</li>
                        <li>Autós matricák</li>
                        <li>Egyedi borítékok</li>
                        <li>Egyedi dobozok</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="categories" class="row col-sm-12">
        <div class="home-category-box col-sm-6 col-xl-3 text-center">
            <div class="home-category">
                <div class="home-category-image-box"><img src="/images/wall-stickers.jpg"></div>
                <div class="home-category-name">Matricák</div>
                <div class="home-category-description">Válogass a rengeteg előre megtervezett matricáink közül.</div>
                <a href="#"><button class="button blue">Fali matricák</button></a>
                <a href="#"><button class="button blue">Autós matricák</button></a>
                <a href="#"><button class="button blue">Laptop matricák</button></a>
            </div>
        </div>
        <div class="home-category-box col-sm-6 col-xl-3 text-center">
            <div class="home-category">
                <div class="home-category-image-box"><img src="/images/truck.jpg"></div>
                <div class="home-category-name">Egyedi matrica árajánlat</div>
                <div class="home-category-description">Kérj ajánlatot egyedi matricára a már meglévő mintádból. Remek lehetőség céges logó matricák készítéséhez.</div>
                <a href="#"><button class="button blue">Egyedi árajánlat</button></a>
            </div>
        </div>
        <div class="home-category-box col-sm-6 col-xl-3 text-center">
            <div class="home-category">
                <div class="home-category-image-box"><img src="/images/custom-photo-stickers.jpg"></div>
                <div class="home-category-name">Matrica fényképből</div>
                <div class="home-category-description">Készíts matricát a fényképek alapján. Nagyszerű választás matricák készítéséhez kedvenc háziállatodról.</div>
                <a href="#"><button class="button blue">Matrica fényképből</button></a>
            </div>
        </div>
        <div class="home-category-box col-sm-6 col-xl-3 text-center">
            <div class="home-category">
                <div class="home-category-image-box"><img src="/images/custom-boxes.jpg"></div>
                <div class="home-category-name">Papír ajándékok és díszek</div>
                <div class="home-category-description">Válogass papírból készült egyedi termékeink közül: díszdobozok, díszborítékok, adventi naptárak. </div>
                <a href="#"><button class="button blue">Papír díszek</button></a>
            </div>
        </div>
    </div>
    <product-slide-component :_products="{{ $newProducts }}" _title="Új termékek"></product-slide-component>
    <product-slide-component :_products="{{ $newProducts }}" _title="Akciós termékek"></product-slide-component>
</div>
@endsection
