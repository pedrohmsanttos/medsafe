<div class="row">
    <!-- Comment Field -->
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('comment', 'Resposta:') !!}
            <div class="form-line {{$errors->has('comment') ? 'focused error' : '' }}">
                {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('comment')}}</label>
        </div>
    </div>
<!-- ./Comment Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('tickets.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
