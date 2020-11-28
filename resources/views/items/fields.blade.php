<div class="row">
    <!-- Pedido Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('pedido_id', 'Pedido Id:') !!}
        <div class="form-line {{$errors->has('pedido_id') ? 'focused error' : '' }}">
            {!! Form::number('pedido_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('pedido_id')}}</label>
    </div>
</div>
<!-- ./Pedido Id Field -->

<!-- Negocio Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('negocio_id', 'Negocio Id:') !!}
        <div class="form-line {{$errors->has('negocio_id') ? 'focused error' : '' }}">
            {!! Form::number('negocio_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('negocio_id')}}</label>
    </div>
</div>
<!-- ./Negocio Id Field -->

<!-- Tabela Preco Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('tabela_preco_id', 'Tabela Preco Id:') !!}
        <div class="form-line {{$errors->has('tabela_preco_id') ? 'focused error' : '' }}">
            {!! Form::number('tabela_preco_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('tabela_preco_id')}}</label>
    </div>
</div>
<!-- ./Tabela Preco Id Field -->

<!-- Valor Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('valor', 'Valor:') !!}
        <div class="form-line {{$errors->has('valor') ? 'focused error' : '' }}">
            {!! Form::number('valor', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('valor')}}</label>
    </div>
</div>
<!-- ./Valor Field -->

<!-- Quantidade Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('quantidade', 'Quantidade:') !!}
        <div class="form-line {{$errors->has('quantidade') ? 'focused error' : '' }}">
            {!! Form::number('quantidade', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('quantidade')}}</label>
    </div>
</div>
<!-- ./Quantidade Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('items.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
