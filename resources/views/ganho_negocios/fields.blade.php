<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    DADOS DO NEGÓCIO
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <!-- Comentario Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('comentario', 'Comentário:') !!}
                            <div class="form-line {{$errors->has('comentario') ? 'focused error' : '' }}">
                                {!! Form::text('comentario', null, ['class' => 'form-control']) !!}
                            </div>
                            <label class="error">{{$errors->first('comentario')}}</label>
                        </div>
                    </div>
                    <!-- ./Comentario Field -->

                    <!-- Data Ganho Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('data_ganho', 'Data Ganho*:') !!}
                            <div id="datepicker_component_container_1" class="form-line {{$errors->has('data_ganho') ? 'focused error' : '' }}">
                                {!! Form::text('data_ganho', null, ['class' => 'form-control', 'autocomplete'=>"off"]) !!}
                            </div>
                            <label class="error">{{$errors->first('data_ganho')}}</label>
                        </div>
                    </div>
                    <!-- ./Data Ganho Field -->
                </div>

                <div class="row">

                    <!-- Negocio Id Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('negocio_id', 'Negócio*:') !!}
                            <select id="negocio_id" name="negocio_id" class="form-control show-tick" required >
                                <option disabled selected value="">Selecione o Negócio</option>
                                @if(!empty($negocios))
                                    @foreach($negocios as $negocio)

                                        @php $selected = $disabled = ""; @endphp

                                        @if(isset($currentnegocio) )
                                            @if($negocio->id == $currentnegocio->id)
                                                @php $selected="selected"; @endphp
                                            @else
                                                @php $disabled = "disabled"; @endphp
                                            @endif
                                        @endif

                                        <option value="{{$negocio->id}}" {{ $selected }} {{ $disabled }}  >{{$negocio->titulo}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label class="error">{{$errors->first('perda_negocio_id')}}</label>
                        </div>
                    </div>
                    <!-- ./Negocio Id Field -->

                    <!-- Usuario Operacao Id Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('usuario_operacao_id', 'Usuário da operação*:') !!}
                            <select id="usuario_operacao_id" name="usuario_operacao_id" class="form-control show-tick" required >
                                <option disabled selected value="">Selecione o usuário</option>
                                @if(!empty($usuarios))
                                    @foreach($usuarios as $usuario)

                                        @php $selected = $disabled = ""; @endphp

                                        @if(isset($currentUser) )
                                            @if($usuario->id == $currentUser->id)
                                                @php $selected="selected"; @endphp
                                            @else
                                                @php $disabled = "disabled"; @endphp
                                            @endif
                                        @endif

                                        <option value="{{$usuario->id}}" {{ $selected }} {{ $disabled }}  >{{$usuario->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label class="error">{{$errors->first('usuario_operacao_id')}}</label>
                        </div>
                    </div>
                    <!-- ./Usuario Operacao Id Field -->
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    PRODUTOS E SERVIÇOS
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Valor</th>
                                    <th>Qnt</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($currentnegocio->itens()->get() as $item)
                                    <tr>
                                        <td>{{ $item->tabelaPreco()->first()->titulo() }}</td>
                                        <td>{{ 'R$ ' . number_format((float) $item->valor, 2, ',', '.') }}</td>
                                        <td>{{ $item->quantidade }}</td>
                                        <td>{{ 'R$ ' . number_format((float) $item->subTotal(), 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td style="float:right">Total: </td>
                                    <td >{{ 'R$ ' . number_format((float) $currentnegocio->valor, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    DADOS DO CLIENTE
                </h2>
            </div>
            <div class="body">
                @include('clientes.fields') 
            </div>
        </div>
    </div>
</div>

@if(!empty($endereco->id))
    <input type="hidden" value="{!! $endereco->id !!}" name="endereco_id">
@endif


<!--<div class="row">
    
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! url('/ganhoNegocios') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div> -->
