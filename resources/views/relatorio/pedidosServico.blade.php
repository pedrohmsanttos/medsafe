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
                    </div>

                    {!! Form::open(['url' => '/relatorio/pedidosServico']) !!}
                        <div class="row">
                            <!-- Cliente Id Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('servico', 'Serviço:') !!}
                                    <div class="form-line {{$errors->has('cliente') ? 'focused error' : '' }}">
                                        <select id="servico" name="servico" class="form-control show-tick" data-live-search="true" required>
                                            <option value="*">Todos</option>
                                            @if(!empty($servicos))
                                                @foreach($servicos as $servico)
                                                    <option value="{{$servico->id}}">{{$servico->descricao}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('servico')}}</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('cliente', 'Cliente:') !!}
                                    <div class="form-line {{$errors->has('cliente') ? 'focused error' : '' }}">
                                        <select id="cliente" name="cliente" class="form-control show-tick" data-live-search="true" required>
                                            <option value="*">Todos</option>
                                            @if(!empty($clientes))
                                                @foreach($clientes as $cliente)
                                                    <option value="{{$cliente->id}}">{{$cliente->razaoSocial()}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('cliente')}}</label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <!-- Submit Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::submit('Gerar', ['class' => 'btn btn-primary']) !!}
                                <a href="{!! url('/relatorio/pedidosServico') !!}" class="btn btn-default">Limpar</a>
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
