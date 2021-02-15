@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/search_products.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row col-sm-12">
        <div class="row col-sm-12 col-md-4 col-lg-3 col-xl-2 100-h"></div>
        <div class="row col-sm-12 col-md-8 col-lg-9 col-xl-10">
            @php
                $links = str_replace('?page=', '/', $products->links());
                echo $links;
            @endphp
        </div>
    </div>
    <div id="products-page" class="row col-sm-12">
        <search-filter-component
            :_categories="{{ $categories }}"
            :_filters= "{{ $filters }}"
            :_discount-filter= "{{ $discountFilter }} == 1"
            :_page="{{ $page }}"
            :_minimum-price-limit="{{ $minimumPriceLimit->price }}"
            :_maximum-price-limit="{{ $maximumPriceLimit->price }}"
            :_current-minimum-price="{{ $currentMinimumPrice }}"
            :_current-maximum-price="{{ $currentMaximumPrice }}"
            _text="{{ $text }}"
        ></search-filter-component>
        <div id="products" class="col-sm-12 col-md-8 col-lg-9 col-xl-10 align-top">
            @foreach ($products as $key => $product)
                <div class="product-box">
                    <a href="/product/{{ $product->id }}">
                        <div class="product-inner-box">
                            <div class="product-image-box">
                                
                                @if ($product->discount > 0)
                                    <div class="product-box-discount"><i class="fa fa-tags"></i> {{ $product->discount }}%</div>
                                @endif
                                <img src="/product-image/{{ json_decode($product->main_image)->name }}/{{ json_decode($product->main_image)->color }}/{{ json_decode($product->main_image)->extraImage }}">
                            </div>
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-bottom-box">
                                <div class="product-price-box">
                                    @if ($product->discount_price && $product->discount_price < $product->price)
                                        <div class="product-price">{{ $product->discount_price }} Ft</div>
                                        <div class="product-old-price">{{ $product->price }} Ft</div>
                                    @else
                                        <div class="product-old-price"> </div>
                                        <div class="product-price">{{ $product->price }} Ft</div>
                                    @endif
                                </div>

                                @if ($product->has_custom_text_parameter)
                                    <div>
                                        <view-product-button-component :_id="{{ $product->id }}"></view-product-button-component>
                                    </div>
                                @else
                                    <add-to-cart-button-component :_id="{{ $product->id }}"></add-to-cart-button-component>
                                @endif

                                @auth
                                    @if (Auth::user()->hasRight('admin'))
                                    <div>
                                        <button class="edit-product-button button blue" title="Szerkesztés"><i class="add-to-cart-button fa fa-edit"></i></button>
                                    </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row col-sm-12">
        <div class="row col-sm-12 col-md-4 col-lg-3 col-xl-2 100-h"></div>
        <div class="row col-sm-12 col-md-8 col-lg-9 col-xl-10">
            @php
                $links = str_replace('?page=', '/', $products->links());
                echo $links;
            @endphp
        </div>
    </div>
@endsection