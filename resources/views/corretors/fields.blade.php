<div class="row">
    <!-- Nome Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('nome', 'Nome:') !!}
        <div class="form-line {{$errors->has('nome') ? 'focused error' : '' }}">
            {!! Form::text('nome', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('nome')}}</label>
    </div>
</div>
<!-- ./Nome Field -->

<!-- Cpf Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('cpf', 'Cpf:') !!}
        <div class="form-line {{$errors->has('cpf') ? 'focused error' : '' }}">
            {!! Form::text('cpf', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('cpf')}}</label>
    </div>
</div>
<!-- ./Cpf Field -->

<!-- Telefone Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('telefone', 'Telefone:') !!}
        <div class="form-line {{$errors->has('telefone') ? 'focused error' : '' }}">
            {!! Form::text('telefone', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('telefone')}}</label>
    </div>
</div>
<!-- ./Telefone Field -->

<!-- Email Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        <div class="form-line {{$errors->has('email') ? 'focused error' : '' }}">
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('email')}}</label>
    </div>
</div>
<!-- ./Email Field -->

<!-- Celular Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('celular', 'Celular:') !!}
        <div class="form-line {{$errors->has('celular') ? 'focused error' : '' }}">
            {!! Form::text('celular', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('celular')}}</label>
    </div>
</div>
<!-- ./Celular Field -->

<!-- Corretora Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('corretora_id', 'Corretora Id:') !!}
        <div class="form-line {{$errors->has('corretora_id') ? 'focused error' : '' }}">
            {!! Form::number('corretora_id', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('corretora_id')}}</label>
    </div>
</div>
<!-- ./Corretora Id Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('corretors.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
