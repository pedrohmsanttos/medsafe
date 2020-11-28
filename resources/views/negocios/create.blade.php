@extends('layouts.app')

@section('css')
<style>
.cadastro-box{
	box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
    padding: 5px 0px;
    background-color: #717171 !important;
    height: auto;
    margin-top: 5px;
    margin-bottom: 10px;
    color: white !important;
}
.ngCart.cart span[ng-click] {
    cursor: pointer;
}
.ngCart.cart .glyphicon.disabled {
    color:#aaa;
}
</style>
@endsection

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
                    {!! Form::open(['route' => 'negocios.store']) !!}

                        @include('negocios.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
        $(function () {
            $('.js-modal-buttons .btn').on('click', function () {
                $('#mdModal').modal('show');
            });
            var tipopf = '{{old('tipopessoa')}}';
            if(tipopf == '1'){
                $('#dvfaturamento').css('display', 'none' );
            }
        });
        $('.close').on('click', function () {
            $("#largeModal").removeClass("in");
            $('#largeModal').modal('hide');
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
