@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/admin_order_details.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('admin.side_panel')
    <div class="col-lg-8 offset-lg-1">
        <a href="#" onclick="window.location.replace(document.referrer);">
            <button id="back-button" class="button blue">
                <i class="add-to-cart-button fa fa-arrow-left"></i> Vissza
            </button>
        </a>
        <table id="order-items" class="table table-bordered table-sm col-sm-12">
            <thead>
                <tr>
                    <th></th>
                    <th>Termék</th>
                    <th>Mennyiség</th>
                    <th>Egységár</th>
                    <th>Összesen</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($products); $i++)
                    @php
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
                    <tr>
                        <td><img src="{{ $products[$i]->image }}" class="order-item-image"></td>
                        <td>{{ $products[$i]->name . $parameterText }}</td>
                        <td>{{ $products[$i]->quantity }}</td>
                        <td>{{ $products[$i]->price }} Ft</td>
                        <td>{{ $products[$i]->price * $products[$i]->quantity }} Ft</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <table id="order-customer-data" class="table table-bordered table-sm col-sm-12">
            <thead>
                <tr>
                    <th colspan="2">Vevő adatok</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>E-mail cím</td>
                    <td>{{ $order->email }}</td>
                </tr>
                <tr>
                    <td>Megjegyzés</td>
                    <td>{{ $order->user_comment }}</td>
                </tr>
                
            </tbody>
        </table>

        <table id="order-customer-shipping-data" class="table table-bordered table-sm col-sm-12">
            <thead>
                <tr>
                    <th colspan="2">Szállítási adatok</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Név</td>
                    <td>{{ $order->shipping_name }}</td>
                </tr>
                <tr>
                    <td>Telefonszám</td>
                    <td>{{ $order->shipping_phone }}</td>
                </tr>
                <tr>
                    <td>Cím</td>
                    <td>
                        {{ $order->shipping_zip . ' ' . $order->shipping_city . ', ' . $order->shipping_address}}
                    </td>
                </tr>
            </tbody>
        </table>

        <table id="order-customer-billing-data" class="table table-bordered table-sm col-sm-12">
            <thead>
                <tr>
                    <th colspan="2">Számlázási adatok</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Név</td>
                    <td>{{ $order->billing_name }}</td>
                </tr>
                @if ($order->billing_tax_number)
                    <tr>
                        <td>Adószám</td>
                        <td>{{ $order->billing_tax_number }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Cím</td>
                    <td>
                        {{ $order->billing_zip . ' ' . $order->billing_city . ', ' . $order->billing_address}}
                    </td>
                </tr>
            </tbody>
        </table>

        @php
            $sumPriceAfterTax = $order->price + $order->shipping_price;
            $vat = round($sumPriceAfterTax - $sumPriceAfterTax / 1.27);
            $priceBeforeTax = $sumPriceAfterTax - $vat;
        @endphp
        <table id="order-sum" class="table table-bordered table-sm col-sm-12">
            <thead>
                <tr>
                    <th class="alignment-column"></th>
                    <th>Tétel</th>
                    <th>Összeg</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="alignment-column"></td>
                    <td>Szállítás:</td>
                    <td>{{ $order->shipping_price }} Ft</td>
                </tr>
                <tr>
                    <td class="alignment-column"></td>
                    <td>Nettó végösszeg:</td>
                    <td>{{ $priceBeforeTax }}</td>
                </tr>
                <tr>
                    <td class="alignment-column"></td>
                    <td>Áfa (27%):</td>
                    <td>{{ $vat }}</td>
                </tr>
                <tr>
                    <td class="alignment-column"></td>
                    <td>Fizetendő:</td>
                    <td>{{ $sumPriceAfterTax }} Ft</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection