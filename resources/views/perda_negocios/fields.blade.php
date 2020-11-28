<div class="row">
    <!-- Comentario Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('comentario', 'Comentário:') !!}
            <div class="form-line {{$errors->has('comentario') ? 'focused error' : '' }}">
                {!! Form::text('comentario', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('comentario')}}</label>
        </div>
    </div>
    <!-- ./Comentario Field -->

    <!-- Data Perda Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('data_perda', 'Data Perda*:') !!}
            <div class="form-line {{$errors->has('data_perda') ? 'focused error' : '' }}">
                {!! Form::text('data_perda', null, ['class' => 'form-control dataBaixa']) !!}
            </div>
            <label class="error">{{$errors->first('data_perda')}}</label>
        </div>
    </div>
    <!-- ./Data Perda Field -->

    <!-- Perda Negocio Id Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('motivo_perda_id', 'Motivo da perda*:') !!}
            <select id="motivo_perda_id" name="motivo_perda_id" class="form-control show-tick" required >
                <option disabled selected value="">Selecione o motivo</option>
                @if(!empty($motivos))
                    @foreach($motivos as $motivo)
                        <option value="{{$motivo->id}}" {{ ( old('motivo_perda_id')==$motivo->id ) ? 'selected' : ''}} >{{$motivo->descricao}}</option>
                    @endforeach
                @endif
            </select>
            <label class="error">{{$errors->first('motivo_perda_id')}}</label>
        </div>
    </div>
    <!-- ./Perda Negocio Id Field -->
</div>

<div class="row">
    <!-- Perda Negocio Id Field -->
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
            <label class="error">{{$errors->first('negocio_id')}}</label>
        </div>
    </div>
    <!-- ./Perda Negocio Id Field -->

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

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('negocios.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
