@component('mail::layout')
    @slot ('header')
        @component('mail::header')
        @endcomponent
    @endslot
    <style>
        #signature {
            display: none !important;
        }
    </style>
    {{ $email }}<br>
    {{ $name }}:<br><br>

    {!! nl2br(htmlspecialchars($text)) !!}
    @slot ('footer')
        @component('mail::footer')
        @endcomponent
    @endslot
@endcomponent