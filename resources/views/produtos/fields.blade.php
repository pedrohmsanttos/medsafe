<div class="row">
    <!-- Descricao Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('descricao', 'Descrição*:') !!}
            <div class="form-line {{$errors->has('descricao') ? 'focused error' : '' }}">
                {!! Form::text('descricao', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <label class="error">{{$errors->first('descricao')}}</label>
        </div>
    </div>
    @if(isset($produto->id))
    <input type="hidden" id="id" name="id" value="{{ $produto->id }}">
    @endif
</div>



<div class="row">
    <!-- Submit Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary waves-effect']) !!}
            <a href="{!! route('produtos.index') !!}" class="btn btn-default waves-effect">Cancelar</a>
        </div>
    </div>
</div>
