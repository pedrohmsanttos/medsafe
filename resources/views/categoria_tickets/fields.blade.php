<div class="row">
    <!-- Descricao Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('descricao', 'Descrição*:') !!}
        <div class="form-line {{$errors->has('descricao') ? 'focused error' : '' }}">
            {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('descricao')}}</label>
    </div>
</div>
<!-- ./Descricao Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('categoriaTickets.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
