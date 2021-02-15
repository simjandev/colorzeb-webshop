@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/user_order_details.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('user_side_panel')
    <div class="col-lg-8 offset-lg-1">
        <a href="#" onclick="window.location.replace(document.referrer);">
            <button id="back-button" class="button blue">
                <i class="add-to-cart-button fa fa-arrow-left"></i> Vissza
            </button>
        </a>

        <h5>Rendelés részletei</h5>
        <hr>
        
        <div id="order-products" class="col-sm-12">
            <div id="order-products-header">
                <div id="order-product-count">{{ count($products) }} db termék</div>
            </div><hr class="gray">
            @php
                $sumPriceAfterTax = 0;
                $shippingPrice = $order->shipping_price;
            @endphp
            @for ($i = 0; $i < count($products); $i++)
                @php
                    $sumPriceAfterTax += $products[$i]->price * $products[$i]->quantity;
                    $parameters = json_decode($products[$i]->parameters);

                    if ($parameters[2] == '') {
                        unset($parameters[2]);
                    }

                    if ($parameters[1] == '') {
                        unset($parameters[1]);
                    }

                    if ($parameters[0] == '') {
                        unset($parameters[0]);
                    }

                    $parameterText = ' (' . implode(', ', $parameters) . ')';
                    if ($parameterText == ' ()') {
                        $parameterText = '';
                    }
                @endphp
                <div class="order-product">
                    <div class="order-product-image"><img src="{{ $products[$i]->image }}" class="order-item-image"></div>
                    <div class="order-product-name">{{ $products[$i]->name . $parameterText }}</div>
                    <div class="order-product-price">{{ $products[$i]->quantity . 'x' . $products[$i]->price }} Ft</div>
                </div>
            @endfor
        </div>

        <div id="order-customer-data" class="col-sm-12">
            <div class="order-info-line title">Megrendelés adatok</div>
            <div class="order-info-line">
                <div class="order-info-label">E-mail cím</div>
                <div class="order-info-value">{{ $order->email }}</div>
            </div>
            <div class="order-info-line">
                <div class="order-info-label">Megjegyzés</div>
                <div class="order-info-value">{{ $order->comment }}</div>
            </div>
            <div class="order-info-line">
                <div class="order-info-label">Fizetve</div>
                <div class="order-info-value">{{ $order->payed ? 'Igen' : 'Nem' }}</div>
            </div>
        </div>

        <div id="order-customer-shipping-data" class="col-sm-12">
            <div class="order-info-line title">Szállítási adatok</div>
            <div class="order-info-line">
                <div class="order-info-label">Név</div>
                <div class="order-info-value">{{ $order->shipping_name }}</div>
            </div>
            <div class="order-info-line">
                <div class="order-info-label">Telefonszám</div>
                <div class="order-info-value">{{ $order->shipping_phone }}</div>
            </div>
            <div class="order-info-line">
                <div class="order-info-label">Cím</div>
                <div class="order-info-value">{{ $order->shipping_zip_code . ' ' . $order->shipping_city . ', ' . $order->shipping_address}}</div>
            </div>
        </div>

        <div id="order-customer-billing-data" class="col-sm-12">
            <div class="order-info-line title">Számlázási adatok</div>
            <div class="order-info-line">
                <div class="order-info-label">Név</div>
                <div class="order-info-value">{{ $order->billing_name }}</div>
            </div>
            @if ($order->billing_tax_number)
                <div class="order-info-line">
                    <div class="order-info-label">Adószám</div>
                    <div class="order-info-value">{{ $order->billing_tax_number }}</div>
                </div>
            @endif
            <div class="order-info-line">
                <div class="order-info-label">Cím</div>
                <div class="order-info-value">{{ $order->billing_zip . ' ' . $order->billing_city . ', ' . $order->billing_address}}</div>
            </div>
        </div>

        @php
            $sumPriceAfterTax += $shippingPrice;
            $vat = round($sumPriceAfterTax - $sumPriceAfterTax / 1.27);
            $priceBeforeTax = $sumPriceAfterTax - $vat;
        @endphp
        <div id="order-confirm-sum" class="col-lg-3 offset-lg-9">
            <div class="order-confirm-sum-line">Szállítás: <div class="order-confirm-sum-line-value">{{ $shippingPrice }} Ft</div></div>
            <div class="order-confirm-sum-line">Nettó végösszeg: <div class="order-confirm-sum-line-value">{{ $priceBeforeTax }} Ft</div></div>
            <div class="order-confirm-sum-line">Áfa (27%): <div class="order-confirm-sum-line-value">{{ $vat }} Ft</div></div>
            <div class="order-confirm-sum-line">Végösszeg: <div class="order-confirm-sum-line-value">{{ $sumPriceAfterTax }} Ft</div></div>
        </div>
    </div>
</div>
@endsection