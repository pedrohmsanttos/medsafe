<div class="row">
    <!-- Título Field -->
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('titulo', 'Título*:') !!}
            <div class="form-line {{$errors->has('titulo') ? 'focused error' : '' }}">
                {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('titulo')}}</label>
        </div>
    </div>
</div>

@if(isset($formaDePagamento->id))
    <input type="hidden" name="id" value="{{$formaDePagamento->id}}">
@endif

<div class="row">
    <!-- Submit Field -->
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::submit('Salvar', ['class' => 'btn btn btn-block btn-lg bg-blue waves-effect']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <a href="{!! route('formaDePagamentos.index') !!}" class="btn btn-block btn-default btn-lg">Cancelar</a>
        </div>
    </div>
</div>




