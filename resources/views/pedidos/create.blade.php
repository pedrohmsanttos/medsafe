@extends('layouts.app')

@section('content')
    <div class="row clearfix" ng-app="MedSafer"> 
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Informe os dados para o cadastro 
                    </h2>
                </div>

                <div class="body" ng-controller="Negocio">
                    <br>
                    @include('adminlte-templates::common.errors')
                    {!! Form::open(['route' => 'pedidos.store']) !!}

                        @include('pedidos.fields')

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
    <script src="{{asset('js/cep.js')}}"></script>
    <script src="{{asset('plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script src="{{asset('plugins/ngCart/ngCart.min.js')}}"></script>
    <script src="{{asset('app/app.js')}}"></script>
    <script src="{{asset('app/controllers.js')}}"></script>
    <script src="{{asset('app/services.js')}}"></script>
    <script>

        $(document).ready(function(){
            $("#endereco").hide();
                if($("#beneficio_terceiros").val() != ""){
                        clickTipo($("#beneficio_terceiros").val());
                }
            });

        function clickTipo(tipo){
            if(tipo == "SIM"){
                $("#endereco").show();
            }else if(tipo == "NAO"){ 
                $("#endereco").hide();
            }
        }    

        $("#beneficio_terceiros").change(function(){
            clickTipo(this.value);
        });
    
        var memsagemAddItem = function(){
            $.notify({
                title: '<strong>Item adicionado ao seu carrinho!</strong><br>',
                message: 'Produto adicionado com sucesso.'
            },{
                type: 'success'
            });
        }
    </script>
@endsection

