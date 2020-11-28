<div class="row">
    <!-- Arquivo Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('arquivo', 'Arquivo:') !!}
        <div class="form-line {{$errors->has('arquivo') ? 'focused error' : '' }}">
            {!! Form::text('arquivo', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('arquivo')}}</label>
    </div>
</div>
<!-- ./Arquivo Field -->

<!-- Material Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('material_id', 'Material Id:') !!}
        <div class="form-line {{$errors->has('material_id') ? 'focused error' : '' }}">
            {!! Form::number('material_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('material_id')}}</label>
    </div>
</div>
<!-- ./Material Id Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('materialItems.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
