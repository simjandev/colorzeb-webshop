@component('mail::layout')
    @slot ('header')
        @component('mail::header')
        @endcomponent
    @endslot
    <div class="order-text-box">
        <h3>Kedves {{ $user->name }},</h3>
        @if ($status == 'Megerősítve')
            #{{ $order->id }} számú rendelésed megerősítésre került!
        @endif

        @if ($status == 'Elutasítva')
            #{{ $order->id }} számú rendelésed elutasításra került!
        @endif

        @if ($status == 'Fizetésre vár')
            #{{ $order->id }} számú rendelésed fizetésre vár!
        @endif

        @if ($status == 'Feladva')
            #{{ $order->id }} számú rendelésed feladásra került!
        @endif

        @if ($status == 'Teljesítve')
            #{{ $order->id }} számú rendelésed sikeresen teljesítve!
        @endif
        
        @if ($status == 'Törölve')
            #{{ $order->id }} számú rendelésed törölve!
        @endif

        @if (strlen($customText))
    <br><br>{!! nl2br($customText) !!}
        @endif
    </div>

    <table id="order-products" class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Kép</th>
                <th>Terméknév</th>
                <th>Db.</th>
                <th>Összesen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderProducts as $product)
                @php
                    $parameters = json_decode($product->parameters);
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
                    <td>
                        <img class="product-image" src="{{ Config::get('app.url') . $product->image }}">
                    </td>
                    <td>{{ $product->name . $parameterText}} </td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->price * $product->quantity}} Ft</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table id="order-customer-data" class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th colspan="2">Megrendelés adatok</th>
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
                <tr>
                    <td>Állapot</td>
                    <td>{{ $status }}</td>
                </tr>
                <tr>
                    <td>Időpont</td>
                    <td>{{ $order->created_at->format('Y.m.d. H:i') }}</td>
                </tr>
            </tbody>
        </table>

        <table id="order-customer-shipping-data" class="table table-bordered table-sm">
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
                        {{ $order->shipping_zip_code . ' ' . $order->shipping_city . ', ' . $order->shipping_address}}
                    </td>
                </tr>
            </tbody>
        </table>

        <table id="order-customer-billing-data" class="table table-bordered table-sm">
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
                        {{ $order->billing_zip_code . ' ' . $order->billing_city . ', ' . $order->billing_address}}
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table id="order-sum" class="table table-bordered table-sm">
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
                    <td>Termékek ára:</td>
                    <td>{{ $order->price }} Ft</td>
                </tr>
                <tr>
                    <td class="alignment-column"></td>
                    <td>Összesen:</td>
                    <td>{{ $order->price + $order->shipping_price }} Ft</td>
                </tr>
            </tbody>
        </table>
    @slot ('footer')
        @component('mail::footer')
        @endcomponent
    @endslot
@endcomponent