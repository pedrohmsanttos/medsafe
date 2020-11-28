<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $pergunta->id !!}</p>
</div>

<!-- Pergunta Field -->
<div class="form-group">
    {!! Form::label('pergunta', 'Pergunta:') !!}
    <p>{!! $pergunta->pergunta !!}</p>
</div>

<!-- Resposta Field -->
<div class="form-group">
    {!! Form::label('resposta', 'Resposta:') !!}
    <p>{!! $pergunta->resposta !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $pergunta->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $pergunta->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $pergunta->deleted_at !!}</p>
</div>

