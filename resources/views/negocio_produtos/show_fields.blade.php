<!-- Negocio Id Field -->
<div class="form-group">
    {!! Form::label('negocio_id', 'Negocio Id:') !!}
    <p>{!! $negocioProduto->negocio_id !!}</p>
</div>

<!-- Produto Tipo Produto Id Field -->
<div class="form-group">
    {!! Form::label('produto_tipo_produto_id', 'Produto Tipo Produto Id:') !!}
    <p>{!! $negocioProduto->produto_tipo_produto_id !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $negocioProduto->deleted_at !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $negocioProduto->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $negocioProduto->updated_at !!}</p>
</div>

