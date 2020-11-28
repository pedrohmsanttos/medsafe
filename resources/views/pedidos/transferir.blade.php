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
                        Informe os dados para o transferir seus pedidos 
                    </h2>
                </div>

                <div class="body" ng-controller="Negocio">
                    <br>
                    @include('adminlte-templates::common.errors')
                    {!! Form::open(['url' => 'transferir/pedidos']) !!}

                        <div class="row">
                            <!-- Usuario Operacao Id Field -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('usuario_operacao_id', 'Usuário da operação:') !!}
                                    <select data-live-search="true" id="usuario_operacao_id" name="usuario_operacao_id" class="form-control show-tick" >
                                        <option disabled selected value="">Selecione o usuário</option>
                                        @if(!empty($usuarios))
                                            @foreach($usuarios as $usuario)
                                                @if(empty($negocio->id))
                                                    <option value="{{$usuario->id}}" {{ ($usuario->id == $currentUser->id) ? 'disabled' : '' }} >{{$usuario->name}}</option>
                                                @else
                                                    <option value="{{$usuario->id}}" {{ ($usuario->id == $currentUser->id) ? 'disabled' : '' }} >{{$usuario->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <label class="error">{{$errors->first('usuario_operacao_id')}}</label>
                                </div>
                            </div>
                            <!-- ./Usuario Operacao Id Field -->
                        </div>

                        <div class="row">
                            <!-- Submit Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::submit('Salvar', ['class' => 'btn btn-primary waves-effect']) !!}
                                    <a href="{!! route('negocios.index') !!}" class="btn btn-default waves-effect">Cancelar</a>
                                </div>
                            </div>
                        </div>

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
    <script src="{{asset('plugins/ngCart/ngCart.min.js')}}"></script>
    <script src="{{asset('app/app.js')}}"></script>
    <script src="{{asset('app/controllers.js')}}"></script>
    <script src="{{asset('app/services.js')}}"></script>
    <script>
        $(function () {
            $('.js-modal-buttons .btn').on('click', function () {
                $('#mdModal').modal('show');
            });
        });
    </script>
@endsection
