<div class="row">
    <!-- Titulo Field -->
<div class="col-md-6">
   <b>Titulo:</b> {!! $materialCorretor->titulo !!}
</div>
<!-- ./Titulo Field -->

<!-- Arquivo Field -->
<div class="col-md-6">
   <b>Arquivo(s):</b>
</div>

@foreach($materialCorretor->itens()->get() as  $materialCorretorItem)
    @php
        $url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];
        $url =  str_replace($_SERVER['APP_URL'], $url, Storage::url($materialCorretorItem->arquivo));
    @endphp
    <div class="row">
    <div class="col-md-6"></div>
        <div class="col-md-6">
            <a href="{!! $url !!}" class="">{!! $materialCorretorItem->arquivo !!}</a>
        </div>
    </div>

@endforeach

