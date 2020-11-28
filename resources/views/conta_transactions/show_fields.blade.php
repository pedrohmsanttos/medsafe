<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $contaTransaction->id !!}</p>
</div>

<!-- Conta Bancaria Id Field -->
<div class="form-group">
    {!! Form::label('conta_bancaria_id', 'Conta Bancaria Id:') !!}
    <p>{!! $contaTransaction->conta_bancaria_id !!}</p>
</div>

<!-- Valor Field -->
<div class="form-group">
    {!! Form::label('valor', 'Valor:') !!}
    <p>{!! $contaTransaction->valor !!}</p>
</div>

<!-- Hash Field -->
<div class="form-group">
    {!! Form::label('hash', 'Hash:') !!}
    <p>{!! $contaTransaction->hash !!}</p>
</div>

<!-- Tipo Field -->
<div class="form-group">
    {!! Form::label('tipo', 'Tipo:') !!}
    <p>{!! $contaTransaction->tipo !!}</p>
</div>

<!-- Accepted Field -->
<div class="form-group">
    {!! Form::label('accepted', 'Accepted:') !!}
    <p>{!! $contaTransaction->accepted !!}</p>
</div>

<!-- Meta Field -->
<div class="form-group">
    {!! Form::label('meta', 'Meta:') !!}
    <p>{!! $contaTransaction->meta !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $contaTransaction->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $contaTransaction->updated_at !!}</p>
</div>

