<div class="row">
    <!-- Pergunta Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('pergunta', 'Pergunta:') !!}
        <div class="form-line {{$errors->has('pergunta') ? 'focused error' : '' }}">
            {!! Form::text('pergunta', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('pergunta')}}</label>
    </div>
</div>
<!-- ./Pergunta Field -->

<!-- Resposta Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('resposta', 'Resposta:') !!}
        <div class="form-line {{$errors->has('resposta') ? 'focused error' : '' }}">
        <div style="border: 1px solid #5499C7; border-radius: 15px;">
            <div style="padding:10px;">
            {!! Form::textarea('resposta', null, ['class' => 'form-control']) !!}
            </div>
            </div>
        </div>
        <label class="error">{{$errors->first('resposta')}}</label>
    </div>
</div>
<!-- ./Resposta Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('perguntas.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
