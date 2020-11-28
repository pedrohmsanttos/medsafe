<div class="row">

<!-- Cliente Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('cliente_id', 'Cliente*:') !!}
        <div class="form-line {{$errors->has('cliente_id') ? 'focused error' : '' }}">

            <select id="cliente_id" name="cliente_id" class="form-control show-tick" data-live-search="true" required>
                <option disabled selected value="">Selecione o Cliente</option>
                @if(!empty($clientes))
                    @foreach($clientes as $cliente)
                        <option value="{{$cliente->id}}" {{ ($cliente->id == $lancamentoReceber->cliente_id) ? 'selected' : '' }}>{{$cliente->nomeFantasia}}</option>
                    @endforeach
                @endif
            </select>


        </div>
        <label class="error">{{$errors->first('cliente_id')}}</label>
    </div>
</div>
<!-- ./Cliente Id Field -->

<!-- Data Vencimento Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('data_vencimento', 'Data Vencimento*:') !!}
        <div class="form-line {{$errors->has('data_vencimento') ? 'focused error' : '' }}" id="datepicker_component_container_1">
            @if( is_null($lancamentoReceber->getDataVencimento()) ) 
                {!! Form::text('data_vencimento', null,['class' => 'form-control', "autocomplete"=>"off",'required' => 'required']) !!}
            @else
                <input autocomplete="off" class="form-control" name="data_vencimento" type="text" value="{{ $lancamentoReceber->getDataVencimento() }}" id="data_vencimento" required>
            @endif
        </div>
        <label class="error">{{$errors->first('data_vencimento')}}</label>
    </div>
</div>
<!-- ./Data Vencimento Field -->

<!-- Data Emissao Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('data_emissao', 'Data Emissão:') !!}
        <div class="form-line {{$errors->has('data_emissao') ? 'focused error' : '' }}" id="datepicker_component_container_2">
            @if( is_null($lancamentoReceber->getDataEmissao()) ) 
                {!! Form::text('data_emissao', null,['class' => 'form-control', "autocomplete"=>"off", 'required' => 'required']) !!}
            @else
                <input autocomplete="off" class="form-control" name="data_emissao" type="text" value="{{ $lancamentoReceber->getDataEmissao() }}" id="data_emissao" required>
            @endif
        </div>

        <label class="error">{{$errors->first('data_emissao')}}</label>
    </div>
</div>
<!-- ./Data Emissao Field -->

<!-- Numero Documento Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('valor_titulo', 'Valor Título*:') !!}
        <div class="form-line {{$errors->has('valor_titulo') ? 'focused error' : '' }}">
            @if(empty($lancamentoReceber->valor_titulo))
                {!! Form::text('valor_titulo', null, ['class' => 'form-control dinheiro','required' => 'required']) !!}
            @else
                <input class="form-control dinheiro" required="required" name="valor_titulo" type="text" value="{!!  number_format((float)$lancamentoReceber->valor_titulo, 2, ',', '.')   !!}" required id="valor_titulo" maxlength="14">
            @endif


        </div>
        <label class="error">{{$errors->first('valor_titulo')}}</label>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('numero_documento', 'Número Documento:') !!}
        <div class="form-line {{$errors->has('numero_documento') ? 'focused error' : '' }}">
            {!! Form::text('numero_documento', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
        <label class="error">{{$errors->first('numero_documento')}}</label>
    </div>
</div>
<!-- ./Numero Documento Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('lancamentoRecebers.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
