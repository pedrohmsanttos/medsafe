<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $statusPedido->id !!}</p>
</div>

<!-- Status Pedido Field -->
<div class="form-group">
    {!! Form::label('status_pedido', 'Status Pedido:') !!}
    <p>{!! $statusPedido->status_pedido !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $statusPedido->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $statusPedido->updated_at !!}</p>
</div>

