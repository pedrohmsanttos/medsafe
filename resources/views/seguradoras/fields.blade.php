<div class="row">
    <!-- Descricaocorretor Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('descricaoCorretor', 'Descrição do Corretor*:') !!}
            <div class="form-line {{$errors->has('descricaoCorretor') ? 'focused error' : '' }}">
                {!! Form::text('descricaoCorretor', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('descricaoCorretor')}}</label>
        </div>
    </div>

    <!-- CNPJ Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('CNPJ', 'CNPJ*:') !!}
            <div class="form-line {{$errors->has('CNPJ') ? 'focused error' : '' }}">
                {!! Form::text('CNPJ', null, ['class' => 'form-control cnpj']) !!}
            </div>
            <label class="error">{{$errors->first('CNPJ')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Telefone Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('telefone', 'Telefone*:') !!}
            <div class="form-line {{$errors->has('telefone') ? 'focused error' : '' }}">
                {!! Form::text('telefone', null, ['class' => 'form-control fone']) !!}
            </div>
            <label class="error">{{$errors->first('telefone')}}</label>
        </div>
    </div>

    <!-- Email Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('email', 'Email*:') !!}
            <div class="form-line {{$errors->has('email') ? 'focused error' : '' }}">
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('email')}}</label>
        </div>
    </div>
</div>

@if(isset($seguradora->id))
    <input type="hidden" name="id" value="{{$seguradora->id}}">
@endif

<div class="row">
    <!-- Submit Field -->
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::submit('Salvar', ['class' => 'btn btn btn-block btn-lg bg-blue waves-effect']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <a href="{!! route('seguradoras.index') !!}" class="btn btn-block btn-default btn-lg">Cancelar</a>
        </div>
    </div>
</div>
