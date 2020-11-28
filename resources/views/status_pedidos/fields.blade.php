<div class="row">
    <!-- Status Pedido Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('status_pedido', 'Status Pedido*:') !!}
            <div class="form-line {{$errors->has('razaoSocial') ? 'focused error' : '' }}">
            {!! Form::text('status_pedido', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('status_pedido')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('statusPedidos.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
