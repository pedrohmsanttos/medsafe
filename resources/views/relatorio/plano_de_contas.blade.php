@extends('layouts.app')

@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Informe os dados para gerar o relatório
                    </h2>
                </div>

                <div class="body">
                    <br>
                    @include('adminlte-templates::common.errors')

                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Filtros
                        <p>Selecione apenas cliente ou fornecedor para gerar o relatório. Caso selecione as 2 opções, será gerado apenas o relatório de cliente.</p>
                    </div>

                    {!! Form::open(['url' => '/relatorio/planocontas']) !!}
                        <div class="row">

                            <!-- Cliente Id Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('cliente', 'Cliente:') !!}
                                    <div class="form-line {{$errors->has('cliente') ? 'focused error' : '' }}">
                                        <select id="cliente" name="cliente" class="form-control show-tick" data-live-search="true">
                                            <option value="">Selecione um Cliente</option>
                                            @if(!empty($clientes))
                                                @foreach($clientes as $cliente)
                                                    <option value="{{$cliente->id}}">{{$cliente->nomeFantasia}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('cliente')}}</label>
                                </div>
                            </div>

                            <!-- Fornecedor Id Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('fornecedor', 'Fornecedor:') !!}
                                    <div class="form-line {{$errors->has('fornecedor') ? 'focused error' : '' }}">
                                        <select id="fornecedor" name="fornecedor" class="form-control show-tick" data-live-search="true">
                                            <option value="">Selecione um Fornecedor</option>
                                            @if(!empty($fornecedores))
                                                @foreach($fornecedores as $fornecedor)
                                                    <option value="{{$fornecedor->id}}">{{$fornecedor->nomeFantasia}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('fornecedor')}}</label>
                                </div>
                            </div>

                            <!-- Cliente Id Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('tipo_operacao', 'Tipo de Operação:') !!}
                                    <div class="form-line {{$errors->has('tipo_operacao') ? 'focused error' : '' }}">
                                        <select id="tipo_operacao" name="tipo_operacao" class="form-control show-tick" data-live-search="true">
                                            <option value="*">Todos</option>
                                            <option value="rec">Receitas</option>
                                            <option value="des">Despesas</option>
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('tipo_operacao')}}</label>
                                </div>
                            </div>

                            <!-- Plano de contas Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('plano_de_contas', 'Plano de contas:') !!}
                                    <div class="form-line {{$errors->has('plano_de_contas') ? 'focused error' : '' }}">
                                        <select id="plano_de_contas" name="plano_de_contas" class="form-control show-tick" data-live-search="true" required>
                                            <option value="*">Todos</option>
                                            @if(!empty($planoDeContas))
                                                @foreach($planoDeContas as $plano)
                                                    <option value="{{$plano->id}}">{{$plano->descricaoConta()}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('plano_de_contas')}}</label>
                                </div>
                            </div>
                            <!-- periodo Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('periodo', 'Período:') !!}
                                    <div class=" {{$errors->has('periodo') ? 'focused error' : '' }}">
                                        <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                            <div class="form-line">
                                                <input autocomplete="off" type="text" name="data_inicial" id="data_inicial" class="form-control" placeholder="Data inicial...">
                                            </div>
                                            <span class="input-group-addon">até</span>
                                            <div class="form-line">
                                                <input autocomplete="off" type="text" name="data_final" id="data_final" class="form-control" placeholder="Data final...">
                                            </div>
                                        </div>
                                    </div>
                                    <label class="error">{{$errors->first('periodo')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Submit Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::submit('Gerar', ['class' => 'btn btn-primary']) !!}
                                <a href="{!! url('/relatorio/receber') !!}" class="btn btn-default">Limpar</a>
                            </div>
                        </div>
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
    <script>
        $('#bs_datepicker_range_container').datepicker({
            autoclose: true,
            container: '#bs_datepicker_range_container',
            format: "dd/mm/yyyy",
            language: 'pt-BR',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Proximo',
            prevText: 'Anterior'
        });
    </script>
@endsection
