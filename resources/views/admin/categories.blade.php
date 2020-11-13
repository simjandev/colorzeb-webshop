@extends('layouts.app')

@section('head')

@endsection

@section('content')
    @include('admin.side_panel')
    <modify-categories-component :_category-list="{{ $categories }}">
    </modify-categories-component>
@endsection