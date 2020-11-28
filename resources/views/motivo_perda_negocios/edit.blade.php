@extends('layouts.app')

@section('content')
<div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                    Informe os dados para editar o cadastro 
                    </h2>
                </div>

                <div class="body">
                    <br>
                    @include('adminlte-templates::common.errors')
                    {!! Form::model($motivoPerdaNegocio, ['route' => ['motivoPerdaNegocios.update', $motivoPerdaNegocio->id], 'method' => 'patch']) !!}

                        @include('motivo_perda_negocios.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection