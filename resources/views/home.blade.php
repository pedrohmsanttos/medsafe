@extends('layouts.app')

@section('content')
<div class="row clearfix">
    <!-- Task Info -->
    @if( !Auth::user()->hasRole('cliente_user') && !Auth::user()->hasRole('corretor_user') )
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <div class="card">
            <div class="header">
                <h2>TOP 10 Colaboradores</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach($topFuncionarios as $index => $funcionario)
                                <td>{{ ++$index }}</td>
                                <td>{{ $funcionario->usuarioOperacao()->first()->name }}</td>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Task Info -->
    <!-- Browser Usage -->
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <div class="row">
            <div class="card">
                <div class="header">
                    <h2>Status dos serviços</h2>
                </div>
                <div class="body">
                    <div id="negociacoes_chart"></div>
                    @piechart('Negociacoes', 'negociacoes_chart')
                </div>
            </div>
            <div class="card">
                <div class="header">
                    <h2>TOP 5 Serviços</h2>
                </div>
                <div class="body">
                    <ul class="list-group">
                    @foreach($topServicos as $servico)
                        <li class="list-group-item">{{ $servico->id }} <span class="badge bg-blue">{{ $servico->quantidade }}</span></li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Browser Usage -->
    @elseif(Auth::user()->hasRole('corretor_user'))
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>Novidades</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($novidades as $index => $novidade)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td><a href="{{ url('novidades/'.$novidade->id) }}"> {{ $novidade->titulo }} </a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>Meus Indicadores</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>Mês Atual</th>
                                <th>Mês Anterior</th>
                                <th>Conclusão</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> {{ $numAtivacoesMes }}</td>
                                <td> {{ $ativacoesMesAnterior }}</td>
                                <td> {{ $conclusaoPercentual }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>Próximas Renovações - <a href="{{ url('renovacaos/') }}">Lista Completa </a></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Proposta</th>
                                <th>Detalhar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($renovacoesProximas as $index => $renovacao)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td> {{ $renovacao->nome }}</td>
                                <td> {{ $renovacao->proposta }} </td>
                                <td>
                                    <a href="{{ url('renovacaos/'.$renovacao->id.'/edit') }}">
                                    <i class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>Ativações de Hoje - <a href="{{ url('apolices/') }}">Lista Completa </a></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Proposta</th>
                                <th>Detalhar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ativacoesHoje as $index => $ativacao)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td> {{ $ativacao->nome }}</td>
                                <td> {{ $ativacao->proposta }} </td>
                                <td>
                                    <a href="{{ url('apolices/'.$ativacao->id) }}">
                                    <i class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="header">
                <h2>Ativações no mês - <a href="{{ url('apolices/') }}">Lista Completa </a></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Proposta</th>
                                <th>Detalhar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ativacoesMes as $index => $ativacao)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td> {{ $ativacao->nome }}</td>
                                <td> {{ $ativacao->proposta }} </td>
                                <td>
                                    <a href="{{ url('apolices/'.$ativacao->id) }}">
                                    <i class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    @else 
        <h2>Meu Medsafer!</h2>
    @endif
</div>
@endsection
