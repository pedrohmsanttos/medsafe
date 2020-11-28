<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $lancamentoReceber->id !!}</p>
</div>

<!-- Cliente Id Field -->
<div class="form-group">
    {!! Form::label('cliente_id', 'Cliente Id:') !!}
    <p>{!! $lancamentoReceber->cliente_id !!}</p>
</div>

<!-- Data Vencimento Field -->
<div class="form-group">
    {!! Form::label('data_vencimento', 'Data Vencimento:') !!}
    <p>{!! $lancamentoReceber->data_vencimento !!}</p>
</div>

<!-- Data Emissao Field -->
<div class="form-group">
    {!! Form::label('data_emissao', 'Data Emissao:') !!}
    <p>{!! $lancamentoReceber->data_emissao !!}</p>
</div>

<!-- Numero Documento Field -->
<div class="form-group">
    {!! Form::label('numero_documento', 'Numero Documento:') !!}
    <p>{!! $lancamentoReceber->numero_documento !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $lancamentoReceber->deleted_at !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $lancamentoReceber->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $lancamentoReceber->updated_at !!}</p>
</div>

