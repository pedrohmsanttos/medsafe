<div class="row">
   

<!-- Cliente Id Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('fornecedor_id', 'Fornecedor*:') !!}
        <div class="form-line {{$errors->has('fornecedor_id') ? 'focused error' : '' }}">
            <select id="fornecedor_id" name="fornecedor_id" class="form-control show-tick" data-live-search="true" required>
                <option disabled selected value="">Selecione o Fornecedor</option>
                @if(!empty($fornecedores))
                    @foreach($fornecedores as $fornecedor)
                        <option value="{{$fornecedor->id}}" {{ ($fornecedor->id == $lancamentoPagar->fornecedor_id) ? 'selected' : '' }}>{{$fornecedor->nomeFantasia}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <label class="error">{{$errors->first('fornecedor_id')}}</label>
    </div>
</div>
<!-- ./Cliente Id Field -->

<!-- Data Vencimento Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('data_vencimento', 'Data Vencimento*:') !!}
        <div id="datepicker_component_container_1" class="form-line {{$errors->has('data_vencimento') ? 'focused error' : '' }}">
            @if( is_null($lancamentoPagar->getDataVencimento()) ) 
                {!! Form::text('data_vencimento', null,['class' => 'form-control', 'required' => 'required', 'autocomplete'=>'off']) !!}
            @else
                {!! Form::text('data_vencimento', $lancamentoPagar->getDataVencimento(),['class' => 'form-control', 'required' => 'required', 'autocomplete'=>'off']) !!}
            @endif
        </div>
        <label class="error">{{$errors->first('data_vencimento')}}</label>
    </div>
</div>
<!-- ./Data Vencimento Field -->

<!-- Data Emissao Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('data_emissao', 'Data Emissão*:') !!}
        <div id="datepicker_component_container_2" class="form-line {{$errors->has('data_emissao') ? 'focused error' : '' }}">
            @if( is_null($lancamentoPagar->getDataEmissao()) ) 
                {!! Form::text('data_emissao', null,['class' => 'form-control', 'required' => 'required', 'autocomplete'=>'off']) !!}
            @else
                {!! Form::text('data_emissao',  $lancamentoPagar->getDataEmissao(),['class' => 'form-control', 'required' => 'required', 'autocomplete'=>'off']) !!}
            @endif
        </div>

        <label class="error">{{$errors->first('data_emissao')}}</label>
    </div>
</div>
<!-- ./Data Emissao Field -->

<!-- Valor Titulo Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('valor_titulo', 'Valor Título*:') !!}
        <div class="form-line {{$errors->has('valor_titulo') ? 'focused error' : '' }}">

            @if(empty($lancamentoPagar->valor_titulo))
                {!! Form::text('valor_titulo', null, ['class' => 'form-control dinheiro', 'required' => 'required']) !!}
            @else
                {!! Form::text('valor_titulo', number_format((float)$lancamentoPagar->valor_titulo, 2, '.', ''), ['class' => 'form-control dinheiro', 'required' => 'required']) !!}
            @endif
        </div>
        <label class="error">{{$errors->first('valor_titulo')}}</label>
    </div>
</div>
<!-- ./Valor Titulo Field -->

<!-- Numero Documento Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('numero_documento', 'Número Documento*:') !!}
        <div class="form-line {{$errors->has('numero_documento') ? 'focused error' : '' }}">
            {!! Form::text('numero_documento', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
        <label class="error">{{$errors->first('numero_documento')}}</label>
    </div>
</div>
<!-- ./Numero Documento Field -->

<!-- Data Vencimento Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('recorrencia', 'Recorrência (meses):') !!}
        <div class="form-line {{$errors->has('recorrencia') ? 'focused error' : '' }}">
            @if( is_null($lancamentoPagar->getDataVencimento()) ) 
                {!! Form::number('recorrencia', 1,['class' => 'form-control', 'required' => 'required', 'autocomplete'=>'off', 'min'=>"1", 'max'=>"12"]) !!}
            @else
                {!! Form::number('recorrencia', $lancamentoPagar->getDataVencimento(),['class' => 'form-control', 'required' => 'required', 'autocomplete'=>'off', 'min'=>"1", 'max'=>"12"]) !!}
            @endif
        </div>
        <label class="error">{{$errors->first('recorrencia')}}</label>
    </div>
</div>
<!-- ./Data Vencimento Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('lancamentosPagar.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
