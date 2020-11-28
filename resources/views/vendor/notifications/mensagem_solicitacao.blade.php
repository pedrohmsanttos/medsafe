@component('mail::message')

    {{-- Action Button --}}
    @isset($actionText)
        @component('mail::button', ['url' => $actionUrl, 'color' => 'blue'])
        {{ $actionText }}
        @endcomponent
    @endisset

    {!! $conteudo !!}

    {{-- Subcopy --}}
    @isset($actionText)
        @component('mail::subcopy')
        Se você tiver problemas para clicar no botão "{{ $actionText }}", copie e cole o URL abaixo
        em seu navegador: [{{ $actionUrl }}]({{ $actionUrl }})
        @endcomponent
    @endisset

@endcomponent