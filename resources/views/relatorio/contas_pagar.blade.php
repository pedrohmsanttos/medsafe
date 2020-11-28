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

                    {!! Form::open(['url' => '/relatorio/pagar']) !!}
                        <div class="row">
                            <!-- Cliente Id Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('fornecedor', 'Fornecedor:') !!}
                                    <div class="form-line {{$errors->has('fornecedor') ? 'focused error' : '' }}">
                                        <select id="fornecedor" name="fornecedor" class="form-control show-tick" data-live-search="true" required>
                                            <option value="*">Todos</option>
                                            @if(!empty($fornecedores))
                                                @foreach($fornecedores as $fornecedor)
                                                    <option value="{{$fornecedor->id}}">{{$fornecedor->razaoSocial}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label class="error">{{$errors->first('cliente')}}</label>
                                </div>
                            </div>
                            <!-- periodo Field -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('periodo', 'Período:') !!}
                                    <div class=" {{$errors->has('periodo') ? 'focused error' : '' }}">
                                        <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                            <div class="form-line">
                                                <input type="text" name="data_inicial" id="data_inicial" class="form-control" placeholder="Data inicial...">
                                            </div>
                                            <span class="input-group-addon">até</span>
                                            <div class="form-line">
                                                <input type="text" name="data_final" id="data_final" class="form-control" placeholder="Data final...">
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
