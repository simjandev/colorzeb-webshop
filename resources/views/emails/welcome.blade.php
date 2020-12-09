@component('mail::layout')
    @slot ('header')
        @component('mail::header')
        @endcomponent
    @endslot

    <div class="order-text-box">
        <h3>Kedves {{ $user->name }},</h3>
        köszönjük, hogy regisztráltál az oldalunkra!
    </div>

    @slot ('footer')
        @component('mail::footer')
        @endcomponent
    @endslot
@endcomponent