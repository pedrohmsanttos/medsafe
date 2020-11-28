<div class="row">
    <!-- Nome Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('nome', 'Nome*:') !!}
        <div class="form-line {{$errors->has('nome') ? 'focused error' : '' }}">
            {!! Form::text('nome', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('nome')}}</label>
    </div>
</div>
<!-- ./Nome Field -->

<!-- Cpf Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('cpf', 'Cpf*:') !!}
        <div class="form-line {{$errors->has('cpf') ? 'focused error' : '' }}">
            {!! Form::text('cpf', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('cpf')}}</label>
    </div>
</div>
<!-- ./Cpf Field -->

<!-- Telefone Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('telefone', 'Telefone') !!}
        <div class="form-line {{$errors->has('telefone') ? 'focused error' : '' }}">
            {!! Form::text('telefone', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('telefone')}}</label>
    </div>
</div>
<!-- ./Telefone Field -->

<!-- Email Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('email', 'Email*:') !!}
        <div class="form-line {{$errors->has('email') ? 'focused error' : '' }}">
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('email')}}</label>
    </div>
</div>
<!-- ./Email Field -->

<!-- Celular Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('celular', 'Celular:') !!}
        <div class="form-line {{$errors->has('celular') ? 'focused error' : '' }}">
            {!! Form::text('celular', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('celular')}}</label>
    </div>
</div>
<!-- ./Celular Field -->

<!-- Corretora Id Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('corretora_id', 'Corretora*:') !!}
        <select id="corretora_id" name="corretora_id" class="form-control show-tick" data-live-search="true" required>
                <option disabled selected value="">Selecione a Corretora</option>
                @if(!empty($corretoras))
                    @foreach($corretoras as $corretora)
                        <option value="{{$corretora->id}}" {{ ($corretora->id == $corretoradm->corretora_id) ? 'selected' : '' }}>{{$corretora->descricao}}</option>
                    @endforeach
                @endif
            </select>
        <label class="error">{{$errors->first('corretora_id')}}</label>
    </div>
</div>
<!-- ./Corretora Id Field -->

<!-- User Id Field -->
<!-- <div class="col-md-4">
    <div class="form-group">
        {!! Form::label('user_id', 'User Id:') !!}
        <div class="form-line {{$errors->has('user_id') ? 'focused error' : '' }}">
            {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('user_id')}}</label>
    </div>
</div> -->
<!-- ./User Id Field -->

<!-- Aprovado Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('aprovado', 'Aprovado*:') !!}
        <select data-live-search="true" id="aprovado" name="aprovado" class="form-control show-tick" required>
                <option disabled selected value="">Aprovado</option>
                <option value="NÃO" {{ ($corretoradm->aprovado == 'NÃO') ? 'selected' : '' }}>NÃO</option>
                    <option value="SIM" {{ ($corretoradm->aprovado =='SIM') ? 'selected' : '' }}>SIM</option>
            </select>
        <label class="error">{{$errors->first('aprovado')}}</label>
    </div>
</div>
<!-- ./Aprovado Field -->

<!-- Comissao Field -->
<div class="col-md-2">
    <div class="form-group">
        {!! Form::label('comissao', 'Comissão %*:') !!}
        <div class="form-line {{$errors->has('comissao') ? 'focused error' : '' }}">
            {!! Form::text('comissao', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('comissao')}}</label>
    </div>
</div>
<!-- ./Comissao Field -->

<!-- Periodo De Pagamento Field -->
<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('periodo_de_pagamento', 'Período De Pagamento*:') !!}
        <select data-live-search="true" id="periodo_de_pagamento" name="periodo_de_pagamento" class="form-control show-tick" required>
                <option disabled selected value="">Selecione o período de pagamento</option>
                <option value="QUINZENAL" {{ ($corretoradm->periodo_de_pagamento == 'QUINZENAL') ? 'selected' : '' }}>QUINZENAL</option>
                    <option value="MENSAL" {{ ($corretoradm->periodo_de_pagamento =='MENSAL') ? 'selected' : '' }}>MENSAL</option>
            </select>
        <label class="error">{{$errors->first('periodo_de_pagamento')}}</label>
    </div>
</div>
<!-- ./Periodo De Pagamento Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('corretoradms.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
