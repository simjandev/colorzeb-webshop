@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/order_confirm.css') }}" rel="stylesheet">
@endsection

@section('content')
    <order-steps-component :_active="4"></order-steps-component>
    <table id="order-confirm-items" class="table table-bordered table-sm col-lg-8 offset-lg-2">
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
            @foreach ($cart as $cartItem)
                @php
                    if ($cartItem->parameters[2] == '') {
                        unset($cartItem->parameters[2]);
                    }

                    if ($cartItem->parameters[1] == '') {
                        unset($cartItem->parameters[1]);
                    }

                    if ($cartItem->parameters[0] == '') {
                        unset($cartItem->parameters[0]);
                    }
                @endphp
                <tr>
                    <td><img src="{{ $cartItem->image }}" class="order-confirm-item-image"></td>
                    <td>{{ $cartItem->productName . ' (' . implode(', ', $cartItem->parameters) . ')' }}</td>
                    <td>{{ $cartItem->quantity }}</td>
                    <td>{{ $cartItem->price }} Ft</td>
                    <td>{{ $cartItem->price * $cartItem->quantity }} Ft</td>
                </tr>
            @endforeach           
        </tbody>
    </table>

    <table id="order-customer-data" class="table table-bordered table-sm col-lg-8 offset-lg-2">
        <thead>
            <tr>
                <th colspan="2">Vevő adatok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>E-mail cím</td>
                <td>{{ $orderCustomerData->email }}</td>
            </tr>
            <tr>
                <td>Megjegyzés</td>
                <td>{{ $orderCustomerData->comment }}</td>
            </tr>
            
        </tbody>
    </table>

    <table id="order-customer-shipping-data" class="table table-bordered table-sm col-lg-8 offset-lg-2">
        <thead>
            <tr>
                <th colspan="2">Szállítási adatok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Név</td>
                <td>{{ $orderCustomerData->shippingName }}</td>
            </tr>
            <tr>
                <td>Telefonszám</td>
                <td>{{ $orderCustomerData->shippingPhone }}</td>
            </tr>
            <tr>
                <td>Cím</td>
                <td>
                    {{ $orderCustomerData->shippingZip . ' ' . $orderCustomerData->shippingCity . ', ' . $orderCustomerData->shippingAddress}}
                </td>
            </tr>
        </tbody>
    </table>

    <table id="order-customer-billing-data" class="table table-bordered table-sm col-lg-8 offset-lg-2">
        <thead>
            <tr>
                <th colspan="2">Számlázási adatok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Név</td>
                <td>{{ $orderCustomerData->billingName }}</td>
            </tr>
            @if ($orderCustomerData->billingTaxNumber)
                <tr>
                    <td>Adószám</td>
                    <td>{{ $orderCustomerData->billingTaxNumber }}</td>
                </tr>
            @endif
            <tr>
                <td>Cím</td>
                <td>
                    {{ $orderCustomerData->billingZip . ' ' . $orderCustomerData->billingCity . ', ' . $orderCustomerData->billingAddress}}
                </td>
            </tr>
        </tbody>
    </table>

    <table id="order-confirm-sum" class="table table-bordered table-sm col-lg-8 offset-lg-2">
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
                <td></td>
            </tr>
            <tr>
                <td class="alignment-column"></td>
                <td>Nettó végösszeg:</td>
                <td></td>
            </tr>
            <tr>
                <td class="alignment-column"></td>
                <td>Áfa (27%):</td>
                <td></td>
            </tr>
            <tr>
                <td class="alignment-column"></td>
                <td>Bruttó végösszeg:</td>
                <td></td>
            </tr>
        </tbody>
    </table>
@endsection