<div class="row">
    <!-- classificacao Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('classificacao', 'Classificação*:') !!}
            <div class="form-line {{$errors->has('classificacao') ? 'focused error' : '' }}">
                {!! Form::text('classificacao', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('classificacao')}}</label>
        </div>
    </div>

    <!-- tipoConta Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('tipoConta', 'Tipo de Conta*:') !!}
            <div class="form-line {{$errors->has('tipoConta') ? 'focused error' : '' }}">
                @if(isset($planoDeContas->tipoConta))
                    <select id="tipoConta" name="tipoConta" class="form-control show-tick">
                        <option disabled selected value="">Selecione o tipo</option>
                        <option value="t" {{ ($planoDeContas->tipoConta=='t') ? 'selected' : ''}}>Título</option>
                        <option value="a" {{ ($planoDeContas->tipoConta=='a') ? 'selected' : ''}}>Analítica</option>
                    </select>
                @else
                    <select id="tipoConta" name="tipoConta" class="form-control show-tick">
                        <option disabled selected value="">Selecione o tipo</option>
                        <option value="t"  {{ (old('tipoConta')=='t') ? 'selected' : ''}} >Título</option>
                        <option value="a" {{ (old('tipoConta')=='a') ? 'selected' : ''}} >Analítica</option>
                    </select>
                @endif
            </div>
            <label class="error">{{$errors->first('tipoConta')}}</label>
        </div>
    </div>

    <!-- descricao Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('descricao', 'Descrição*:') !!}
            <div class="form-line {{$errors->has('descricao') ? 'focused error' : '' }}">
                {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('descricao')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- caracteristicas Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('caracteristicas', 'Características:') !!}
            <div class="form-line {{$errors->has('caracteristicas') ? 'focused error' : '' }}">
                <!-- Caixa Field -->
                @if(isset($planoDeContas->caixa))
                    <input id="caixa" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="c" name="caixa" {{ ($planoDeContas->caixa=='c') ? 'checked' : ''}}>
                @else   
                    <input id="caixa" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="c" name="caixa" {{ (old('caixa')=='c') ? 'checked' : ''}}>
                @endif
                <label for="caixa">Caixa</label>
                <!-- Banco Field -->
                @if(isset($planoDeContas->banco))
                    <input id="banco" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="b" name="banco" {{ ($planoDeContas->banco=='b') ? 'checked' : ''}}>
                @else
                    <input id="banco" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="b" name="banco" {{ (old('banco')=='b') ? 'checked' : ''}}>
                @endif
                <label for="banco">Banco</label>
                <!-- Cliente Field -->
                @if(isset($planoDeContas->cliente))
                    <input id="cliente" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="cl" name="cliente" {{ ($planoDeContas->cliente=='cl') ? 'checked' : ''}}>
                @else
                    <input id="cliente" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="cl" name="cliente" {{ (old('cliente')=='cl') ? 'checked' : ''}}>
                @endif
                <label for="cliente">Cliente</label>
                <!-- Fornecedor Field -->
                @if(isset($planoDeContas->fornecedor))
                    <input id="fornecedor" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="f" name="fornecedor" {{ ($planoDeContas->fornecedor=='f') ? 'checked' : ''}}>
                @else
                    <input id="fornecedor" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="f" name="fornecedor" {{ (old('fornecedor')=='f') ? 'checked' : ''}} >
                @endif
                <label for="fornecedor">Fornecedor</label>
            </div>
        </div>
    </div>

    <!-- Contabancaria Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('contabancaria_id', 'Conta Bancária*:') !!}
            <div class="form-line {{$errors->has('contabancaria_id') ? 'focused error' : '' }}">
                @if(isset($planoDeContas->tipoConta))
                    <select id="contabancaria_id" name="contabancaria_id" class="form-control show-tick">
                        <option disabled selected value="">Selecione o tipo</option>
                        @foreach($contasBancarias as $conta)
                            <option value="{{ $conta->id }}" {{ ($planoDeContas->contabancaria_id==$conta->id) ? 'selected' : ''}}>{{ $conta->getName() }}</option>
                        @endforeach
                    </select>
                @else
                    <select id="contabancaria_id" name="contabancaria_id" class="form-control show-tick">
                        <option disabled selected value="">Selecione o tipo</option>
                        @foreach($contasBancarias as $conta)
                            <option value="{{ $conta->id }}" {{ (old('contabancaria_id')==$conta->id) ? 'selected' : ''}} >{{ $conta->getName() }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <label class="error">{{$errors->first('contabancaria_id')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('planodecontas.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>