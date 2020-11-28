<div class="row">
    <!-- Apolice Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('apolice_id', 'Apolice Id:') !!}
        <div class="form-line {{$errors->has('apolice_id') ? 'focused error' : '' }}">
            {!! Form::number('apolice_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('apolice_id')}}</label>
    </div>
</div>
<!-- ./Apolice Id Field -->

<!-- Nome Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('nome', 'Nome:') !!}
        <div class="form-line {{$errors->has('nome') ? 'focused error' : '' }}">
            {!! Form::text('nome', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('nome')}}</label>
    </div>
</div>
<!-- ./Nome Field -->

<!-- Valor Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('valor', 'Valor:') !!}
        <div class="form-line {{$errors->has('valor') ? 'focused error' : '' }}">
            {!! Form::text('valor', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('valor')}}</label>
    </div>
</div>
<!-- ./Valor Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('beneficios.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
