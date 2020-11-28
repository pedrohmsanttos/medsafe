<div class="row">
    <!-- Descricao Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('descricao', 'Descricao:') !!}
        <div class="form-line {{$errors->has('descricao') ? 'focused error' : '' }}">
            {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('descricao')}}</label>
    </div>
</div>
<!-- ./Descricao Field -->

<!-- Cnpj Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('cnpj', 'Cnpj:') !!}
        <div class="form-line {{$errors->has('cnpj') ? 'focused error' : '' }}">
            {!! Form::text('cnpj', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('cnpj')}}</label>
    </div>
</div>
<!-- ./Cnpj Field -->

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

<!-- Susep Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('susep', 'Susep:') !!}
        <div class="form-line {{$errors->has('susep') ? 'focused error' : '' }}">
            {!! Form::text('susep', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('susep')}}</label>
    </div>
</div>
<!-- ./Susep Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('corretoras.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
