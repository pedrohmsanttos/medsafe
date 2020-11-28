
<div class="row">
    <div class="col-md-3">
        <!-- Cep Field -->
        <div class="form-group">
            {!! Form::label('cep', 'CEP*:') !!}
            <div class="form-line {{$errors->has('cep') ? 'focused error' : '' }}">
                @if(!empty($endereco->cep))
                    {!! Form::text('cep', $endereco->cep, ['class' => 'form-control cep']) !!}
                @else
                    {!! Form::text('cep', null, ['class' => 'form-control cep']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('cep')}}</label>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Rua Field -->
        <div class="form-group">
            {!! Form::label('rua', 'Logradouro*:') !!}
            <div class="form-line {{$errors->has('rua') ? 'focused error' : '' }}">
                @if(!empty($endereco->rua))
                    {!! Form::text('rua', $endereco->rua, ['class' => 'form-control']) !!}
                @else
                    {!! Form::text('rua', null, ['class' => 'form-control']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('rua')}}</label>
        </div>
    </div>

    <div class="col-md-3">
        <!-- Numero Field -->
        <div class="form-group">
            {!! Form::label('numero', 'Número*:') !!}
            <div class="form-line {{$errors->has('numero') ? 'focused error' : '' }}">
                @if(!empty($endereco->numero))
                    {!! Form::text('numero', $endereco->numero, ['class' => 'form-control']) !!}
                @else
                    {!! Form::text('numero', null, ['class' => 'form-control']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('numero')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <!-- Bairro Field -->
        <div class="form-group">
            {!! Form::label('bairro', 'Bairro*:') !!}
            <div class="form-line {{$errors->has('bairro') ? 'focused error' : '' }}">
                @if(!empty($endereco->bairro))
                    {!! Form::text('bairro', $endereco->bairro, ['class' => 'form-control']) !!}
                @else
                    {!! Form::text('bairro', null, ['class' => 'form-control']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('bairro')}}</label>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Municipio Field -->
        <div class="form-group">
            {!! Form::label('municipio', 'Município*:') !!}
            <div class="form-line {{$errors->has('municipio') ? 'focused error' : '' }}">
                @if(!empty($endereco->municipio))
                    {!! Form::text('municipio', $endereco->municipio, ['class' => 'form-control']) !!}
                @else
                    {!! Form::text('municipio', null, ['class' => 'form-control']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('municipio')}}</label>
        </div>
    </div>

    <div class="col-md-3">
        <!-- Uf Field -->
        <div class="form-group">
            <label>UF *</label>
            <select id="uf" class="form-control" name="uf">
                <option disabled selected value="">Selecione um estado*</option>
                @if(!empty($endereco->uf))
                    @foreach(estados() as $estado)
                        <option value="{{$estado['sigla']}}" {{$estado['sigla']==old('uf', $endereco->uf ? $endereco->uf : '') ? "selected" : ""}}>{{$estado['nome']}}</option>
                    @endforeach
                @else
                    @foreach(estados() as $estado)
                        <option value="{{$estado['sigla']}}" {{ (old('uf')==$estado['sigla']) ? 'selected' : ''}}>{{$estado['nome']}}</option>
                    @endforeach
                @endif
            </select>
            <label class="error">{{$errors->first('uf')}}</label>
        </div>
    </div>
</div>