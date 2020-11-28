<div class="row">
    <!-- Banco Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('banco', 'Banco*:') !!}
            <div class="form-line {{$errors->has('banco') ? 'focused error' : '' }}">
                <select class="form-control" name="banco" >
                	@if(isset($contaBancaria['banco']))
                        @foreach(bancos() as $banco)
	                        <option value="{{$banco['code']}}"  {{ ($banco['code']== $contaBancaria['banco'] ) ? "selected" : ""}}>{{$banco['name']}}</option>
	                    @endforeach 
					@else
						<option value="" selected disabled>Escolha um banco</option>
	                    @foreach(bancos() as $banco)
	                        <option value="{{$banco['code'] }}" {{ (old('banco')==$banco['code']) ? 'selected' : ''}}>{{$banco['name']}}</option>
	                    @endforeach 
					@endif
                </select>
            </div>
            <label class="error">{{$errors->first('banco')}}</label>
        </div>
    </div>

    <!-- Datasaldoinicial Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('dataSaldoInicial', 'Data do Saldo Inicial*:') !!}  
            <div class="form-line {{$errors->has('dataSaldoInicial') ? 'focused error' : '' }}">
                @if(isset($contaBancaria['dataSaldoInicial']))
                    <input class="form-control dataCalendario" name="dataSaldoInicial" type="text" value="{{ date( 'd/m/Y' , strtotime($contaBancaria['dataSaldoInicial']) ) }}" id="dataSaldoInicial">
                @else    
                    <input class="form-control dataCalendario" name="dataSaldoInicial" type="text" value="" id="dataSaldoInicial">
                
                @endif                
            </div>
            <label class="error">{{$errors->first('dataSaldoInicial')}}</label>
        </div>
    </div>

     

    <!-- Saldoinicial Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('saldoInicial', 'Saldo Inicial*:') !!}  
            <div class="form-line {{$errors->has('saldoInicial') ? 'focused error' : '' }}">
                {!! Form::text('saldoInicial', null, ['class' => 'form-control dinheiro']) !!}
            </div>
            <label class="error">{{$errors->first('saldoInicial')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Classificacao Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('classificacao', 'Classificação*:') !!}
            <div class="form-line {{$errors->has('classificacao') ? 'focused error' : '' }}">
                {!! Form::text('classificacao', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('classificacao')}}</label>
        </div>
    </div>

    <!-- Descrição Field -->
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
    <!-- Numero conta Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('numeroConta', 'N° Conta*:') !!}
            <div class="form-line {{$errors->has('numeroConta') ? 'focused error' : '' }}">
                {!! Form::text('numeroConta', null, ['class' => 'form-control', 'onkeyup' => 'codConta(this)']) !!}
            </div>
            <label class="error">{{$errors->first('numeroConta')}}</label>
        </div>
    </div>

    <!-- Numero agencia Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('numeroAgencia', 'N° Agência*:') !!}  
            <div class="form-line {{$errors->has('numeroAgencia') ? 'focused error' : '' }}">
                {!! Form::text('numeroAgencia', null, ['class' => 'form-control', 'onkeyup' => 'codConta(this)']) !!}
            </div>
            <label class="error">{{$errors->first('numeroAgencia')}}</label>
        </div>
    </div>

    <!-- Caixa Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('caixa', 'Caixa*:') !!}  
            <div class="form-line {{$errors->has('caixa') ? 'focused error' : '' }}">
                {!! Form::text('caixa', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('caixa')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Operação Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('operacao', 'Operação:') !!}  
            <div class="form-line {{$errors->has('operacao') ? 'focused error' : '' }}">
                {!! Form::text('operacao', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('operacao')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('contasbancarias.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>

<script>
    function codConta(num) {
        var er = /[A-z0-9-]+$/;
        
        er.lastIndex = 0;
        var campo = num;
        
        if (!er.test(campo.value)) {
            //console.log("entrou");
            campo.value = "";
        }
    }
</script>
