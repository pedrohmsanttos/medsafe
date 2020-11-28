<div class="row">

<!-- Tipo Field -->
<div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tipo', 'Tipo*:') !!}
            <div class="form-line {{$errors->has('tipo') ? 'focused error' : '' }}">
                @if(!empty($tesouraria->tipo))
                    <select id="tipo" name="tipo" class="form-control show-tick" disabled>
                        <option disabled selected value="">Selecione o tipo</option>
                        <option value="1" {{$tesouraria->tipo=='1' ? 'selected' : ''}}>Cliente</option>
                        <option value="2" {{$tesouraria->tipo=='2' ? 'selected' : ''}}>Fornecedor</option>
                    </select>
                @else
                    <select id="tipo" name="tipo" class="form-control show-tick">
                        <option disabled selected value="">Selecione o tipo</option>
                        <option value="1" {{ (old('tipo')=='1') ? 'selected' : ''}}>Cliente</option>
                        <option value="2" {{ (old('tipo')=='2') ? 'selected' : ''}}>Fornecedor</option>
                    </select>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('conta_bancaria_id', 'Conta Banco*:') !!}
            <div class="form-line {{$errors->has('conta_bancaria_id') ? 'focused error' : '' }}">
                <select id="conta_bancaria_id" name="conta_bancaria_id" class="form-control show-tick" data-live-search="true" required>
                    <option disabled selected value="">Selecione a conta</option>
                    @if(!empty($contasbancarias) && !empty($tesouraria) )
                        @foreach($contasbancarias as $conta)
                            <option value="{{$conta->id}}" {{ ($conta->id == old('conta_bancaria_id', $tesouraria->conta_bancaria_id) ) ? 'selected' : '' }}>{{$conta->getName()}}</option>
                        @endforeach
                    @elseif(!empty($contasbancarias))
                        @foreach($contasbancarias as $conta)
                            <option value="{{$conta->id}}" {{ ($conta->id == old('conta_bancaria_id') ) ? 'selected' : '' }}>{{$conta->getName()}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <label class="error">{{$errors->first('conta_bancaria_id')}}</label>
        </div>
    </div>
<!-- ./Tipo Field -->

<!-- Plano De Contas Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('plano_de_contas_id', 'Plano de Contas*:') !!}
        <div class="form-line {{$errors->has('plano_de_contas_id') ? 'focused error' : '' }}">
            <select id="plano_de_contas_id" name="plano_de_contas_id" class="form-control show-tick" data-live-search="true" required>
                <option disabled selected value="">Selecione o Plano de Contas</option>
                @if(!empty($planos_de_conta))
                    @foreach($planos_de_conta as $plano_de_conta)
                        <option value="{{$plano_de_conta->id}}" {{ ($plano_de_conta->id == old('plano_de_contas_id', $tesouraria->plano_de_contas_id) ) ? 'selected' : '' }}>{{ $plano_de_conta->descricaoConta() }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <label class="error">{{$errors->first('plano_de_contas_id')}}</label>
    </div>
</div>
<!-- ./Plano De Contas Id Field -->

<!-- Formas De Pagamento Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('formas_de_pagamento_id', 'Forma de Pagamento*:') !!}
        <div class="form-line {{$errors->has('formas_de_pagamento_id') ? 'focused error' : '' }}">
            <select id="formas_de_pagamento_id" name="formas_de_pagamento_id" class="form-control show-tick" data-live-search="true" required>
                <option disabled selected value="">Selecione a Forma de Pagamento</option>
                @if(!empty($formas_de_pagamento))
                    @foreach($formas_de_pagamento as $forma_de_pagamento)
                        <option value="{{$forma_de_pagamento->id}}" {{ ($forma_de_pagamento->id == old('formas_de_pagamento_id', $tesouraria->formas_de_pagamento_id) ) ? 'selected' : '' }}>{{$forma_de_pagamento->titulo}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <label class="error">{{$errors->first('formas_de_pagamento_id')}}</label>
    </div>
</div>
<!-- ./Formas De Pagamento Id Field -->

<!-- Fornecedor Id Field -->
<div class="col-md-6" id="blocoFornecedor" style="display: none">
    <div class="form-group">
        {!! Form::label('fornecedor_id', 'Fornecedor*:') !!}
        <div class="form-line {{$errors->has('fornecedor_id') ? 'focused error' : '' }}">
            <select id="fornecedor_id" name="fornecedor_id" class="form-control show-tick" data-live-search="true" >
                <option disabled selected value="">Selecione o Fornecedor</option>
                @if(!empty($fornecedores))
                    @foreach($fornecedores as $fornecedor)
                        <option value="{{$fornecedor->id}}" {{ ($fornecedor->id == old('fornecedor_id',$tesouraria->fornecedor_id) ) ? 'selected' : '' }}>{{$fornecedor->nomeFantasia}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <label class="error">{{$errors->first('fornecedor_id')}}</label>
    </div>
</div>
<!-- ./Fornecedor Id Field -->

<!-- Cliente Id Field -->
<div class="col-md-6" id="blocoCliente" style="display: none">
    <div class="form-group">
        {!! Form::label('cliente_id', 'Cliente*:') !!}
        <div class="form-line {{$errors->has('cliente_id') ? 'focused error' : '' }}">
            <select id="cliente_id" name="cliente_id" class="form-control show-tick" data-live-search="true" >
                <option disabled selected value="">Selecione o Cliente</option>
                @if(!empty($clientes))
                    @foreach($clientes as $cliente)
                        <option value="{{$cliente->id}}" {{ ($cliente->id == old('cliente_id', $tesouraria->cliente_id) ) ? 'selected' : '' }}>{{$cliente->razaoSocial}}</option>
                    @endforeach
                @endif
                </select>
        </div>
        <label class="error">{{$errors->first('cliente_id')}}</label>
    </div>
</div>
<!-- ./Cliente Id Field -->

<!-- Valor Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('valor', 'Valor*:') !!}
        <div class="form-line {{$errors->has('valor') ? 'focused error' : '' }}">
            {!! Form::text('valor', old('valor', $tesouraria->valor), ['class' => 'form-control dinheiro']) !!}
        </div>
        <label class="error">{{$errors->first('valor')}}</label>
    </div>
</div>
<!-- ./Valor Field -->

<!-- Numero Documento Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('numero_documento', 'Número Documento:') !!}
        <div class="form-line {{$errors->has('numero_documento') ? 'focused error' : '' }}">
            {!! Form::text('numero_documento', null, ['class' => 'form-control']) !!}
        </div>
        <label class="error">{{$errors->first('numero_documento')}}</label>
    </div>
</div>
<!-- ./Numero Documento Field -->

<!-- Data Emissao Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('data_emissao', 'Data Emissão:') !!}
        <div id="datepicker_component_container_1" class="form-line {{$errors->has('data_emissao') ? 'focused error' : '' }}">

            @if( is_null($tesouraria->getDataEmissao()) ) 
                {!! Form::text('data_emissao', null, ['class' => 'form-control']) !!}
            @else
                {!! Form::text('data_emissao', $tesouraria->getDataEmissao(), ['class' => 'form-control']) !!}
            @endif


        </div>
        <label class="error">{{$errors->first('data_emissao')}}</label>
    </div>
</div>
<!-- ./Data Emissao Field -->

<!-- Data Vencimento Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('data_vencimento', 'Data Vencimento:') !!}
        <div id="datepicker_component_container_2" class="form-line {{$errors->has('data_vencimento') ? 'focused error' : '' }}">

        @if( is_null($tesouraria->getDataVencimento()) ) 
            {!! Form::text('data_vencimento', null, ['class' => 'form-control']) !!}
        @else
            {!! Form::text('data_vencimento', $tesouraria->getDataVencimento(), ['class' => 'form-control']) !!}
        @endif
            
        </div>
        <label class="error">{{$errors->first('data_vencimento')}}</label>
    </div>
</div>
<!-- ./Data Vencimento Field -->

<!-- Data Disponibilidade Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('data_disponibilidade', 'Data Disponibilidade:') !!}
        <div id="datepicker_component_container_3" class="form-line {{$errors->has('data_disponibilidade') ? 'focused error' : '' }}">
            
            @if( is_null($tesouraria->getDataDisponibilidade()) ) 
                {!! Form::text('data_disponibilidade', null, ['class' => 'form-control']) !!}
            @else
                {!! Form::text('data_disponibilidade', $tesouraria->getDataDisponibilidade(), ['class' => 'form-control']) !!}
            @endif

        </div>
        <label class="error">{{$errors->first('data_disponibilidade')}}</label>
    </div>
</div>
<!-- ./Data Disponibilidade Field -->
</div>

@section('scripts')
    <script src="{{asset('js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jquery.maskMoney.min.js')}}"></script>
    <script src="{{asset('js/mask.js')}}"></script>
    <script src="{{asset('js/cep.js')}}"></script>

    <script>

       $(document).ready(function(){
           if($("#tipo").val() != ""){
                clickTipo($("#tipo").val());
           }
       });

        function clickTipo(tipo){
            console.log(tipo);
            if($.trim(tipo) == "1"){ //cliente
                $("#fornecedor_id").val("");
                $('#fornecedor_id').selectpicker('deselectAll');
                $("#fornecedor").val("");
                $("#blocoCliente").show();
                $("#blocoFornecedor").hide();
            }else if($.trim(tipo) == "2"){ //fornecedor
                $("#cliente_id").val("");
                $('#cliente_id').selectpicker('deselectAll');
                $("#cliente").val("");
                $("#blocoCliente").hide();
                $("#blocoFornecedor").show();
            }
        }    

        $("#tipo").change(function(){
            clickTipo(this.value);
        });

    </script>
@endsection

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('tesourarias.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
