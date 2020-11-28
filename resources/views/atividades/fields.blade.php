<div class="row">
    <!-- Assunto Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('assunto', 'Assunto*:') !!}
            <div class="form-line {{$errors->has('assunto') ? 'focused error' : '' }}">
                {!! Form::text('assunto', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('assunto')}}</label>
        </div>
    </div>
    <!-- ./Assunto Field -->

    <!-- Negocio Id Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('negocio_id', 'Negócio*:') !!}
            <select id="negocio_id" name="negocio_id" class="form-control show-tick" >
            @if(!empty($negocios))
                @foreach($negocios as $negocio)

                    @php $selected = $disabled = ""; @endphp

                    @if(!empty($atividade->negocio_id) || isset($idNegocio) )
                        @if( ( isset($atividade) && $atividade->negocio_id == $negocio->id ) || isset($idNegocio) && $negocio->id == $idNegocio)
                            @php $selected="selected"; @endphp
                        @else
                            @php $disabled = "disabled"; @endphp
                        @endif
                    @endif

                    <option value="{{$negocio->id}}" {{ $selected }} {{ $disabled }}  {{ (old('negocio_id')==$negocio->id) ? 'selected' : ''}} >{{$negocio->titulo}}</option>
                @endforeach
            @endif
            </select>
            <label class="error">{{$errors->first('negocio_id')}}</label>
        </div>
    </div>
    <!-- ./Negocio Id Field -->
</div>

<div class="row">
    <!-- Data Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('data', 'Data*:') !!}
            <div id="datepicker_component_container_1" class="form-line {{$errors->has('data') ? 'focused error' : '' }}">
                @if(isset($atividade->data))
                    <input class="form-control" name="data" type="text" value="{{ date( 'd/m/Y' , strtotime($atividade->data) ) }}" id="data">
                @else    
                    {!! Form::text('data', null, ['class' => 'form-control']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('data')}}</label>
        </div>
    </div>
    <!-- ./Data Field -->

    <!-- Hora Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('hora', 'Hora* (00:00):') !!}
            <div class="form-line {{$errors->has('hora') ? 'focused error' : '' }}">
            @if(isset($atividade->hora))
                    <input class="form-control hora1" name="hora" type="text" value="{{ substr_replace($atividade->hora ,'', -3) }}" id="hora">
                @else    
                    {!! Form::text('hora', null, ['class' => 'form-control hora1']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('hora')}}</label>
        </div>
    </div>
    <!-- ./Hora Field -->
</div>


<div class="row">
    <!-- Duracao Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('duracao', 'Duração* (00:00):') !!}
            <div class="form-line {{$errors->has('duracao') ? 'focused error' : '' }}">
                @if(isset($atividade->duracao))
                    <input class="form-control hora1" name="duracao" type="text" value="{{ substr_replace($atividade->duracao ,'', -3) }}" id="duracao">
                @else
                    {!! Form::text('duracao', null, ['class' => 'form-control hora1']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('duracao')}}</label>
        </div>
    </div>
    <!-- ./Duracao Field -->

    <!-- Tipo Atividade Id Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tipo_atividade_id', 'Tipo de Atividade*:') !!}
            <select data-live-search="true" id="tipo_atividade_id" name="tipo_atividade_id" class="form-control show-tick" required >
                <option disabled selected value="">Selecione o Tipo de Atividade*</option>
                @if(!empty($tipoAtividades))
                    @foreach($tipoAtividades as $tipoAtividade)
                        @php $selected = ""; @endphp

                        @if(!empty($atividade->tipo_atividade_id))
                            @if($atividade->tipo_atividade_id == $tipoAtividade->id)
                                @php $selected="selected"; @endphp
                            @endif
                        @endif

                        <option value="{{$tipoAtividade->id}}" {{ $selected }} {{ (old('tipo_atividade_id')==$tipoAtividade->id) ? 'selected' : ''}} >{{$tipoAtividade->descricao}}</option>
                    @endforeach
                @endif
            </select>
            <label class="error">{{$errors->first('tipo_atividade_id')}}</label>
        </div>
    </div>
    <!-- ./Tipo Atividade Id Field -->

   
</div>

<div class="row">
     <!-- Notas Field -->
     <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('notas', 'Notas:') !!}
            <div class="form-line {{$errors->has('notas') ? 'focused error' : '' }}">
                {!! Form::textarea('notas', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('notas')}}</label>
        </div>
    </div>
    <!-- ./Notas Field -->
</div>

<div class="row">
    <!-- Urlproposta Field -->
    <!--div class="col-md-6">
        <div class="form-group">
            {!! Form::label('urlProposta', 'URL da Proposta:') !!}
            <div class="form-line {{$errors->has('urlProposta') ? 'focused error' : '' }}">
                {!! Form::text('urlProposta', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('urlProposta')}}</label>
        </div>
    </div-->
    <!-- ./Urlproposta Field -->

    <!-- Atribuido Id Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('atribuido_id', 'Atribuído para*:') !!}
            <select id="atribuido_id" name="atribuido_id" class="form-control show-tick" required >
                <option disabled selected value="">Selecione o Atribuído</option>
                @if(!empty($usuarios))
                    @foreach($usuarios as $usuario)

                        @php $selected = ""; @endphp

                        @if(!empty($atividade->atribuido_id))
                            @if($atividade->atribuido_id == $usuario->id)
                                @php $selected="selected"; @endphp
                            @endif
                        @endif

                        <option value="{{$usuario->id}}" {{ $selected }} {{ (old('atribuido_id')==$usuario->id) ? 'selected' : ''}} >{{$usuario->name}}</option>
                    @endforeach
                @endif
            </select>
            <label class="error">{{$errors->first('atribuido_id')}}</label>
        </div>
    </div>
    <!-- ./Atribuido Id Field -->

    
</div>

<div class="row">
    <!-- Realizada Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('realizada', 'Realizada:') !!}
            <div class="demo-radio-button">
                @php $checkedSim = $checkedNao = ""; @endphp
                
                @if(isset($atividade->realizada))
                    @if($atividade->realizada == "1")
                        @php $checkedSim = "checked"; @endphp
                    @else
                        @php $checkedNao = "checked"; @endphp
                    @endif
                @endif

                <input type="radio" id="realizada_1" value="0" name="realizada" {{ $checkedNao }} />
                <label for="realizada_1">Não</label>
                <input type="radio" id="realizada_2" value="1" name="realizada" {{ $checkedSim }}/>
                <label for="realizada_2">Sim</label>
            </div>
            <label class="error">{{$errors->first('realizada')}}</label>
        </div>
    </div>
    <!-- ./Realizada Field -->

    <!-- Datavencimento Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('dataVencimento', 'Data de Vencimento:') !!}
            <div id="datepicker_component_container_2" class="form-line {{$errors->has('dataVencimento') ? 'focused error' : '' }}">
                @if(isset($atividade->dataVencimento))
                    <input class="form-control" name="dataVencimento" type="text" value="{{ date( 'd/m/Y' , strtotime($atividade->dataVencimento) ) }}" id="dataVencimento">
                @else    
                    {!! Form::text('dataVencimento', null, ['class' => 'form-control']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('dataVencimento')}}</label>
        </div>
    </div>
    <!-- ./Datavencimento Field -->
</div>

<div class="row">
    <!-- Criador Id Field -->
    @if(isset($atividade))
        <input type="hidden" value="{{ $atividade->criador_id }}" name="criador_id">
    @else
        <input type="hidden" value="{{ Auth::user()->id }}" name="criador_id">
    @endif
    <!-- ./Criador Id Field -->

    
</div>


<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="javascript:window.history.back();" class="btn btn-default">Cancelar</a>
    </div>
</div>
