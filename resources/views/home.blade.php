@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row col-sm-12 col-xl-12">
    <div id="welcome-text" class="row col-sm-12">
        <div class="col-sm-6">
            <img id="home-page-image" src="/images/home-page-image.jpg">
        </div>
        <div class="col-sm-6">
            <h6>What is Lorem Ipsum?</h6>
            <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
        </div>
        
    </div>

    <div id="categories" class="row col-sm-12">
        <div class="home-category-box col-sm-6 cl-lg-4 col-xl-3 text-center">
            <div class="home-category">
                <div class="home-category-image-box"><img src="/images/wall-stickers.jpg"></div>
                <div class="home-category-name">Fal matricák</div>
                <div class="home-category-description">Egyedi készítésű falmatricák széles választékban, mellyel szebbé varázsolhatja otthonát.</div>
                <a href="#"><button class="button blue">Megtekintés</button></a>
            </div>
        </div>

        <div class="home-category-box col-sm-6 cl-lg-4 col-xl-3 text-center">
            <div class="home-category">
                <div class="home-category-image-box"><img src="/images/car-stickers.jpg"></div>
                <div class="home-category-name">Motor és autó matricák</div>
                <div class="home-category-description">Díszítse fel és tegye egyedivé járművét a matricáink széles választékával.</div>
                <a href="#"><button class="button blue">Megtekintés</button></a>
            </div>
        </div>

        <div class="home-category-box col-sm-6 cl-lg-4 col-xl-3 text-center">
            <div class="home-category">
                <div class="home-category-image-box"><img src="/images/custom-stickers.jpg"></div>
                <div class="home-category-name">Egyedi matricák</div>
                <div class="home-category-description">Válasszon egyedi matricáink széles választékából, széleskörü felhasználással.</div>
                <a href="#"><button class="button blue">Megtekintés</button></a>
            </div>
        </div>

        <div class="home-category-box col-sm-6 cl-lg-4 col-xl-3 text-center">
            <div class="home-category">
                <div class="home-category-image-box"><img src="/images/wall-stickers.jpg"></div>
                <div class="home-category-name">Fal matricák</div>
                <div class="home-category-description">Egyedi készítésű falmatricák széles választékban, mellyel szebbé varázsolhatja otthonát.</div>
                <a href="#"><button class="button blue">Megtekintés</button></a>
            </div>
        </div>

    </div>
</div>
@endsection
