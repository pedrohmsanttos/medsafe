@extends('layouts.app')

@section('content')
    <div class="content">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-body">
                <div id="pedido" class="row" style="padding-left: 20px">
                    @include('pedidos.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/printThis.js')}}"></script>
    <script>
        $('#print').on("click", function () {
            $("#pedido").printThis();
        });
    </script>
@endsection