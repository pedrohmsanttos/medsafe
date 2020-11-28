@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($actionText)
        @component('mail::subcopy')
        Se você tiver problemas para clicar no botão "{{ $actionText }}", copie e cole o URL abaixo
        em seu navegador: [{{ $actionUrl }}]({{ $actionUrl }})
        @endcomponent
    @endisset
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
