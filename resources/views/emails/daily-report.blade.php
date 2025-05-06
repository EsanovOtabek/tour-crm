@component('mail::message')
    # {{ $subject }}

    {!! nl2br(e($content)) !!}

    @component('mail::button', ['url' => url('/')])
        Saytga o'tish
    @endcomponent

    Hurmat bilan,<br>
    {{ config('app.name') }}
@endcomponent
