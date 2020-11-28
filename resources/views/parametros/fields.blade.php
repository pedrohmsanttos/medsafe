<div class="row">
    <!-- Nome Field -->
    <div class="col-md-6">
        <b>Nome: </b> {!! $parametro->nome !!}
        <div class="form-group" style="display: none;">
            {!! Form::label('nome', 'Nome:') !!}
            <div class="form-line {{$errors->has('nome') ? 'focused error' : '' }}">
                {!! Form::text('nome', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('nome')}}</label>
        </div>
    </div>
</div>
<!-- ./Nome Field -->

<!-- Valor Field -->
<div class="row">
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
        <a href="{!! route('parametros.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
