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
                    {!! Form::model($contrato, ['route' => ['contratos.update', $contrato->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}

                        @include('contratos.fields')

                        

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
