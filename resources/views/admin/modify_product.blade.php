@extends('layouts.app')

@section('head')
@endsection

@section('content')
    @include('admin.side_panel')

    @if (isset($name))
        <modify-product-component 
            :_category-list="{{ $categories }}"
            :_id="{{ $id }}"
            _name="{{ $name }}"
            :_category-id="{{ $categoryId }}"
            :_discount="{{ $discount }}"
            _description="{{ $description }}"
            :_active="{{ $isActive }} == 1"
            :_image-color-pairs="{{ $imageColorPairs }}"
            :_image-names="{{ $imageNames }}"
            :_custom-parameters="{{ $customParameters }}"
            :_parameter-settings="{{ $parameterSettings }}">
        </modify-product-component>
    @else
        <modify-product-component :_category-list="{{ $categories }}">
        </modify-product-component>
    @endif
@endsection