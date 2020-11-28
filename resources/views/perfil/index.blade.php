@extends('layouts.app')

@section('content')
<div class="card">
        <div class="header">
            <div class="row">
                <div class="col-xs-12 col-md-10">
                    <h3>{{$user->name}}</h3>
                </div>
                <div class="col-xs-12 col-md-2">
                    @if( !Auth::user()->hasRole('cliente_user') )
                    <span><a href="{{url('/usuarios/'.$user->id.'/edit')}}"><button type="button" class="btn btn-info button-header"><i class="material-icons">edit</i>&nbsp;&nbsp;Editar</button></a></span>
                    @else 
                    <span><a href="{{url('/clientes/'.$user->cliente->first()->id.'/edit')}}"><button type="button" class="btn btn-info button-header"><i class="material-icons">edit</i>&nbsp;&nbsp;Editar</button></a></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="body">
            <ul class="nav nav-tabs tab-col-blue" role="tablist">
                <li role="presentation" class="active">
                    <a href="#dadosbasicos" data-toggle="tab">
                        <i class="material-icons">face</i> Dados Básicos e Profissionais
                    </a>
                </li>
                <li role="presentation">
                    <a href="#dadosresidencias" data-toggle="tab">
                        <i class="material-icons">home</i> Dados Residenciais e Contato
                    </a>
                </li>
            </ul>

            <div class="tab-content m-t-20">
                <div role="tabpanel" class="tab-pane fade in active" id="dadosbasicos">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <h4 class="text-center">Dados Básicos</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Nome:</th>
                                        <td>
                                            {{$user->name}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <h4 class="text-center">Dados Profissionais</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Ocupação Profissional:</th>
                                        <td>
                                            Usuário
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="dadosresidencias">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <h4 class="text-center">Dados Residencias</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Endereço:</th>
                                        <td>
                                            Rua, numero
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <h4 class="text-center">Dados de Contato</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>E-mail:</th>
                                        <td>
                                            {{$user->email}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Login:</th>
                                        <td>
                                            {{$user->login}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

