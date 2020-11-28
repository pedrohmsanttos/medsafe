<div class="row">
    <!-- Conta Bancaria Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('conta_bancaria_id', 'Conta Bancaria Id:') !!}
        <div class="form-line {{$errors->has('conta_bancaria_id') ? 'focused error' : '' }}">
            {!! Form::number('conta_bancaria_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('conta_bancaria_id')}}</label>
    </div>
</div>
<!-- ./Conta Bancaria Id Field -->

<!-- Valor Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('valor', 'Valor:') !!}
        <div class="form-line {{$errors->has('valor') ? 'focused error' : '' }}">
            {!! Form::number('valor', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('valor')}}</label>
    </div>
</div>
<!-- ./Valor Field -->

<!-- Hash Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('hash', 'Hash:') !!}
        <div class="form-line {{$errors->has('hash') ? 'focused error' : '' }}">
            {!! Form::text('hash', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('hash')}}</label>
    </div>
</div>
<!-- ./Hash Field -->

<!-- Tipo Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('tipo', 'Tipo:') !!}
        <div class="form-line {{$errors->has('tipo') ? 'focused error' : '' }}">
            {!! Form::text('tipo', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('tipo')}}</label>
    </div>
</div>
<!-- ./Tipo Field -->

<!-- Accepted Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accepted', 'Accepted:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('accepted', false) !!}
        {!! Form::checkbox('accepted', '1', null) !!} 1
    </label>
</div>

<!-- Meta Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('meta', 'Meta:') !!}
        <div class="form-line {{$errors->has('meta') ? 'focused error' : '' }}">
            {!! Form::textarea('meta', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('meta')}}</label>
    </div>
</div>
<!-- ./Meta Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('contaTransactions.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
