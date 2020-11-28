<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $produtos->id !!}</p>
</div>

<!-- Descricao Field -->
<div class="form-group">
    {!! Form::label('descricao', 'Descricao:') !!}
    <p>{!! $produtos->descricao !!}</p>
</div>

<!-- Valor Field -->
<div class="form-group">
    {!! Form::label('valor', 'Valor:') !!}
    <p>{!! $produtos->valor !!}</p>
</div>

<!-- Tipo Produto Id Field -->
<div class="form-group">
    {!! Form::label('tipo_produto_id', 'Tipo Produto Id:') !!}
    <p>{!! $produtos->tipo_produto_id !!}</p>
</div>

<!-- Categoria Produto Id Field -->
<div class="form-group">
    {!! Form::label('categoria_produto_id', 'Categoria Produto Id:') !!}
    <p>{!! $produtos->categoria_produto_id !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $produtos->deleted_at !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $produtos->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $produtos->updated_at !!}</p>
</div>

