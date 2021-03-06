@extends('layouts.app')

@section('content')
<div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Informe os dados para o cadastro 
                    </h2>
                </div>

                <div class="body">
                    <br>
                    @include('adminlte-templates::common.errors')
                    {!! Form::open(['route' => 'formaDePagamentos.store']) !!}

                        @include('forma_de_pagamentos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
