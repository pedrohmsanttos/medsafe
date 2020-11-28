<div class="row">
    <!-- Corretor Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('corretor_id', 'Corretor Id:') !!}
        <div class="form-line {{$errors->has('corretor_id') ? 'focused error' : '' }}">
            {!! Form::number('corretor_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('corretor_id')}}</label>
    </div>
</div>
<!-- ./Corretor Id Field -->

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

<!-- Cliente Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('cliente_id', 'Cliente Id:') !!}
        <div class="form-line {{$errors->has('cliente_id') ? 'focused error' : '' }}">
            {!! Form::number('cliente_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('cliente_id')}}</label>
    </div>
</div>
<!-- ./Cliente Id Field -->

<!-- Numero Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('numero', 'Numero:') !!}
        <div class="form-line {{$errors->has('numero') ? 'focused error' : '' }}">
            {!! Form::text('numero', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('numero')}}</label>
    </div>
</div>
<!-- ./Numero Field -->

<!-- Endosso Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('endosso', 'Endosso:') !!}
        <div class="form-line {{$errors->has('endosso') ? 'focused error' : '' }}">
            {!! Form::text('endosso', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('endosso')}}</label>
    </div>
</div>
<!-- ./Endosso Field -->

<!-- Ci Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('ci', 'Ci:') !!}
        <div class="form-line {{$errors->has('ci') ? 'focused error' : '' }}">
            {!! Form::text('ci', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('ci')}}</label>
    </div>
</div>
<!-- ./Ci Field -->

<!-- Classe Bonus Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('classe_bonus', 'Classe Bonus:') !!}
        <div class="form-line {{$errors->has('classe_bonus') ? 'focused error' : '' }}">
            {!! Form::text('classe_bonus', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('classe_bonus')}}</label>
    </div>
</div>
<!-- ./Classe Bonus Field -->

<!-- Proposta Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('proposta', 'Proposta:') !!}
        <div class="form-line {{$errors->has('proposta') ? 'focused error' : '' }}">
            {!! Form::text('proposta', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('proposta')}}</label>
    </div>
</div>
<!-- ./Proposta Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('apolices.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
