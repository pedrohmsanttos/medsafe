@extends('layouts.app')

@section('content')
    <div class="content">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-body">
                <div id="pedido" class="row" style="">
                    @include('novidades.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
