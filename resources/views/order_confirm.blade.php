@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/order_confirm.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="order-confirm" class="row">
        <order-steps-component :_active="4"></order-steps-component>
        <div id="order-confirm-items" class="col-sm-12 col-lg-8 offset-lg-2">
            <div id="order-confirm-items-header">
                <div id="order-confirm-items-count">{{ count($cart) }} db termék</div>
            </div>
            <hr class="gray">
            @php
                $sumPriceAfterTax = 0;
                $shippingPrice = 0;
            @endphp
            @foreach ($cart as $cartItem)
                @php
                    $sumPriceAfterTax += $cartItem->price * $cartItem->quantity;
                    if ($cartItem->shippingPrice > $shippingPrice) {
                        $shippingPrice = $cartItem->shippingPrice;
                    }

                    if ($cartItem->parameters[2] == '') {
                        unset($cartItem->parameters[2]);
                    }

                    if ($cartItem->parameters[1] == '') {
                        unset($cartItem->parameters[1]);
                    }

                    if ($cartItem->parameters[0] == '') {
                        unset($cartItem->parameters[0]);
                    }
                    
                    $parameterText = ' (' . implode(', ', $cartItem->parameters) . ')';
                    if ($parameterText == ' ()') {
                        $parameterText = '';
                    }
                @endphp
                <div class="order-confirm-item">
                    <div class="order-confirm-item-image"><img src="{{ $cartItem->image }}"></div>
                    <div class="order-confirm-item-name"><a href="/product/{{$cartItem->productId}}">{{ $cartItem->productName . $parameterText }}</a></div>
                    <div class="order-confirm-item-price">{{ $cartItem->quantity }}x{{ $cartItem->price }} Ft</div>
                </div>
            @endforeach
        </div>

        <div id="order-customer-data" class="col-sm-12 col-lg-8 offset-lg-2">
            <div class="order-info-line title">Megrendelés adatok</div>
            <div class="order-info-line">
                <div class="order-info-label">E-mail cím</div>
                <div class="order-info-value">{{ $orderCustomerData->email }}</div>
            </div>
            <div class="order-info-line">
                <div class="order-info-label">Megjegyzés</div>
                <div class="order-info-value">{{ $orderCustomerData->comment }}</div>
            </div>
        </div>

        <div id="order-customer-shipping-data" class="col-sm-12 col-lg-8 offset-lg-2">
            <div class="order-info-line title">Szállítási adatok</div>
            <div class="order-info-line">
                <div class="order-info-label">Név</div>
                <div class="order-info-value">{{ $orderCustomerData->shippingName }}</div>
            </div>
            <div class="order-info-line">
                <div class="order-info-label">Telefonszám</div>
                <div class="order-info-value">{{ $orderCustomerData->shippingPhone }}</div>
            </div>
            <div class="order-info-line">
                <div class="order-info-label">Cím</div>
                <div class="order-info-value">{{ $orderCustomerData->shippingZip . ' ' . $orderCustomerData->shippingCity . ', ' . $orderCustomerData->shippingAddress}}</div>
            </div>
        </div>

        <div id="order-customer-billing-data" class="col-sm-12 col-lg-8 offset-lg-2">
            <div class="order-info-line title">Számlázási adatok</div>
            <div class="order-info-line">
                <div class="order-info-label">Név</div>
                <div class="order-info-value">{{ $orderCustomerData->billingName }}</div>
            </div>
            @if ($orderCustomerData->billingTaxNumber)
                <div class="order-info-line">
                    <div class="order-info-label">Adószám</div>
                    <div class="order-info-value">{{ $orderCustomerData->billingTaxNumber }}</div>
                </div>
            @endif
            <div class="order-info-line">
                <div class="order-info-label">Cím</div>
                <div class="order-info-value">{{ $orderCustomerData->billingZip . ' ' . $orderCustomerData->billingCity . ', ' . $orderCustomerData->billingAddress}}</div>
            </div>
        </div>

        @php
            $sumPriceAfterTax += $shippingPrice;
            $vat = round($sumPriceAfterTax - $sumPriceAfterTax / 1.27);
            $priceBeforeTax = $sumPriceAfterTax - $vat;
        @endphp
        <div id="order-confirm-sum" class="col-lg-2 offset-lg-8">
            <div class="order-confirm-sum-line">Szállítás: <div class="order-confirm-sum-line-value">{{ $shippingPrice }} Ft</div></div>
            <div class="order-confirm-sum-line">Nettó végösszeg: <div class="order-confirm-sum-line-value">{{ $priceBeforeTax }} Ft</div></div>
            <div class="order-confirm-sum-line">Áfa (27%): <div class="order-confirm-sum-line-value">{{ $vat }} Ft</div></div>
            <div class="order-confirm-sum-line">Fizetendő: <div class="order-confirm-sum-line-value">{{ $sumPriceAfterTax }} Ft</div></div>
        </div>
        <div id="order-confirm-button-box" clasS="col-sm-12 col-lg-8 offset-lg-2 text-right">
            <a href="/create-order">
                <button class="button blue"><i class="fa fa-smile-o"></i><div>Megrendelés</div></button>
            </a>
        </div>
    </div>
@endsection