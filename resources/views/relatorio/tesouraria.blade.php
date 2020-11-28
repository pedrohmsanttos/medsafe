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

                    {!! Form::open(['url' => '/relatorio/tesouraria']) !!}
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
                                                    <option value="{{$cliente->id}}">{{$cliente->razaoSocial}}</option>
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
                                                    <option value="{{$fornecedor->id}}">{{$fornecedor->razaoSocial}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('fornecedor')}}</label>
                                </div>
                            </div>

                             <!-- Plano de Conta Id Field -->
                             <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('plano_de_contas', 'Plano de Contas:') !!}
                                    <div class="form-line {{$errors->has('plano_de_contas') ? 'focused error' : '' }}">
                                        <select id="plano_de_contas" name="plano_de_contas" class="form-control show-tick" data-live-search="true" required>
                                            <option value="*">Todos</option>
                                            @if(!empty($planos_de_conta))
                                                @foreach($planos_de_conta as $plano_de_conta)
                                                    <option value="{{ $plano_de_conta->id }}">{{$plano_de_conta->descricaoConta()}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('plano_de_conta')}}</label>
                                </div>
                            </div>

                            <!-- Plano de Conta Id Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('forma_de_pagamento', 'Formas de Pagamento:') !!}
                                    <div class="form-line {{$errors->has('forma_de_pagamento') ? 'focused error' : '' }}">
                                        <select id="forma_de_pagamento" name="forma_de_pagamento" class="form-control show-tick" data-live-search="true" required>
                                            <option value="*">Todos</option>
                                            @if(!empty($formas_de_pagamento))
                                                @foreach($formas_de_pagamento as $forma_de_pagamento)
                                                    <option value="{{ $forma_de_pagamento->id }}">{{$forma_de_pagamento->titulo}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('forma_de_pagamento')}}</label>
                                </div>
                            </div>


                            <!-- periodo Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('data_emissao', 'Data de Emissão:') !!}
                                    <div class=" {{$errors->has('data_emissao') ? 'focused error' : '' }}">
                                        <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                            <div class="form-line">
                                                <input type="text" name="data_inicial" id="data_inicial" class="form-control" placeholder="Data Inicial...">
                                            </div>
                                            <span class="input-group-addon">até</span>
                                            <div class="form-line">
                                                <input type="text" name="data_final" id="data_final" class="form-control" placeholder="Data Final...">
                                            </div>
                                        </div>
                                    </div>
                                    <label class="error">{{$errors->first('data_emissao')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Submit Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::submit('Gerar', ['class' => 'btn btn-primary']) !!}
                                <a href="{!! url('/relatorio/tesouraria') !!}" class="btn btn-default">Limpar</a>
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
