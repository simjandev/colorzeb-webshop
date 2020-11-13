@extends('layouts.app')

@section('head')
    
@endsection

@section('content')
    <order-steps-component :_active="3"></order-steps-component>
    @if (isset($orderCustomerData))
    <order-shipping-component
        _email="{{ $orderCustomerData->email }}"
        _comment="{{ $orderCustomerData->comment }}"
        
        _shipping-name="{{ $orderCustomerData->shippingName }}"
        _shipping-phone="{{ $orderCustomerData->shippingPhone }}"
        _shipping-zip="{{ $orderCustomerData->shippingZip }}"
        _shipping-city="{{ $orderCustomerData->shippingCity }}"
        _shipping-address="{{ $orderCustomerData->shippingAddress }}"

        _billing-name="{{ $orderCustomerData->billingName }}"
        _billing-tax-number="{{ $orderCustomerData->billingTaxNumber }}"
        _billing-zip="{{ $orderCustomerData->billingZip }}"
        _billing-city="{{ $orderCustomerData->billingCity }}"
        _billing-address="{{ $orderCustomerData->billingAddress }}"

    >
    </order-shipping-component>
    @else
        <order-shipping-component></order-shipping-component>
    @endif
@endsection