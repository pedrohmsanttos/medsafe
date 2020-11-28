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
                    {!! Form::model($contaBancaria, ['route' => ['contasbancarias.update', $contaBancaria->id], 'method' => 'patch']) !!}

                        @include('conta_bancarias.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jquery.maskMoney.min.js')}}"></script>
    <script src="{{asset('js/mask.js')}}"></script>

    <script>
        $('#dataSaldoInicial').datepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
        });
    </script>

    <script>



        $(document).ready(function(){
            $("#saldoInicial").focus();
        });
    
    </script> 
@endsection