@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/product_details.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="back-button-box" class="col-sm-12 col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
        <a href="#" onclick="window.location.replace(document.referrer);">
            <button id="back-button" class="button blue">
                <i class="add-to-cart-button fa fa-arrow-left"></i> Vissza
            </button>
        </a>
    </div>
    @if (is_null($product))
        <div class="col-sm-12 col-lg-10 col-xl-8 ffset-lg-1 soffset-xl-2">
            Nincs ilyen termék
        </div>
    @else
        <div id="category" class="col-sm-12 col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
            Kategória:&nbsp;<a class="btn-link" href="">{{ $product->category_name }}</a>
        </div>

        <div id="product-box" class="row col-sm-12 col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
            @php
                // is admin
                $isAdmin = false;
                if (Auth::check() && Auth::user()->hasRight('admin')) {
                    $isAdmin = true;
                }

                // images
                $imagesArray = array();
                $imagesList = json_decode($product->images)->images;
                for ($i = 0; $i < count($imagesList); $i++) {
                    
                    $item = new StdClass();
                    $item->name = $imagesList[$i]->name;
                    $item->color = $imagesList[$i]->color;
                    $item->extraImage = $imagesList[$i]->extraImage;
                    $item->visible = true;
                    array_push($imagesArray, $item);
                }
            @endphp
            <product-details-component
                :_main-image="{{ $product->main_image }}"
                :_image-list="{{ json_encode($imagesArray) }}"
                :_id="{{ $product->id }}"
                _name="{{ $product->name }}"
                _description="{{ nl2br($product->description) }}"
                :_price="{{ $product->price }}"
                :_discount-price="{{ $product->discount_price }}"
                :_discount="{{ $product->discount }}"
                :_parameter-settings="{{ $product->parameter_settings }}"
                :_custom-parameters="{{ $customParameters }}"
                :_is-admin="{{ $isAdmin ? 'true' : 'false' }}">
                
            </product-details-component>
        
            <div id="product-instruction-box">
                <div id="thank-you-text">Köszönöm, hogy a ColorZeb termékét választottad!</div>
                <div id="instruction-title">Pár tipp, hogy tökéletesen sikerüljön matricád felrakása az autódra:</div>
                <ul id="instruction-list">
                    <li>
                        Alaposan tisztítsd meg a felületet, ahová a matrica kerülni fog.
                        ( mezei ablaktisztító is megfelel, a lényeg, hogy por és zsírmentes legyen)
                    </li>
                    <li>
                        Távolítsd el a hordozóréteget ( ez a matricád tapadós oldalán van,
                        általában egy vastagabb papír, mintával a hátulján )
                    </li>
                    <li>
                        Illeszd a helyére a matricát.
                    </li>
                    <li>
                        Simogasd ki a levegőt alóla ( hasznos egy bankkártya hozzá,
                        vagy egy összegyűrt mikroszálas kendő.)
                    </li>
                    <li>
                        Húzd le óvatosan a felvivő réteget.
                    </li>
                    <li>
                        Ha esetleg valamely elem nem ragad oda rögtön, vagy fent marad a felvivő
                        rétegen, nyomkodd meg óvatosan.
                        (ez általában a vékonyabb részeknél fordul elő,ott alaposabb rásimítás szükséges)
                    </li>
                    <li>
                        Élvezd az autód új kinézetét, és ha elégedett vagy a termékkel,
                        meséld el másoknak is ;)
                    </li>
                </ul>
                <div id="good-bye-text">Jó munkát!</div>
            </div>
        </div>
    @endif
@endsection