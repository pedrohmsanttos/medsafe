<div class="row">
    <!-- Produto Tipo Produto Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('produto_tipo_produto_id', 'Produto Tipo Produto Id:') !!}
        <div class="form-line {{$errors->has('produto_tipo_produto_id') ? 'focused error' : '' }}">
            {!! Form::number('produto_tipo_produto_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('produto_tipo_produto_id')}}</label>
    </div>
</div>
<!-- ./Produto Tipo Produto Id Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('negocioProdutos.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
