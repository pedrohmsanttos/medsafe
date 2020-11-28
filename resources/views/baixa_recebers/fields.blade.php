<div class="row">
    
    <!-- Lancamentopagar Id Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('lancamentoreceber_id', 'Lançamento*:') !!}
            <div class="form-line {{$errors->has('lancamentoreceber_id') ? 'focused error' : '' }}">
                <select id="lancamentoreceber_id" name="lancamentoreceber_id" class="form-control show-tick" data-live-search="true" required>
                    <option disabled selected value="">Lançamento a Receber</option>
                    @if(!empty($lancamentoReceber) && !empty($baixaReceber) )
                        @foreach($lancamentoReceber as $lancamento)
                            <option value="{{$lancamento->id}}" {{ ($lancamento->id == $baixaReceber->lancamentoreceber_id) ? 'selected' : '' }}>{{$lancamento->getTitulo()}}</option>
                        @endforeach
                    @elseif(!empty($lancamentoReceber))
                        @foreach($lancamentoReceber as $lancamento)
                            <option value="{{$lancamento->id}}" {{ ($lancamento->id == old('lancamentoreceber_id')) ? 'selected' : '' }}>{{$lancamento->getTitulo()}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <label class="error">{{$errors->first('lancamentoreceber_id')}}</label>
        </div>
    </div>
    <!-- ./Lancamentopagar Id Field -->

    <!-- Baixa Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('baixa', 'Baixa*:') !!}
            <div id="datepicker_component_container_2" class="form-line {{$errors->has('baixa') ? 'focused error' : '' }}">
                @if(!empty($baixaReceber))
                    <input class="form-control" name="baixa" type="text" autocomplete="off" value="{!! $baixaReceber->getBaixa() !!}" id="baixa">
                @else
                    <input class="form-control" name="baixa" type="text" autocomplete="off" value="{{ old('baixa') }}" id="baixa">
                @endif
            </div>
            <label class="error">{{$errors->first('baixa')}}</label>
        </div>
    </div>
    <!-- ./Baixa Field -->

    <!-- Valor Pago Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('valor_pago', 'Valor Pago*:') !!}
            <div class="form-line {{$errors->has('valor_pago') ? 'focused error' : '' }}">
                {!! Form::text('valor_pago', null, ['class' => 'form-control dinheiro']) !!}
            </div>
            <label class="error">{{$errors->first('valor_pago')}}</label>
        </div>
    </div>
    <!-- ./Valor Pago Field -->

    <!-- Valor Residual Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('valor_residual', 'Valor Residual:') !!}
            <div class="form-line {{$errors->has('valor_residual') ? 'focused error' : '' }}">
                {!! Form::text('valor_residual', null, ['class' => 'form-control dinheiro']) !!}
            </div>
            <label class="error">{{$errors->first('valor_residual')}}</label>
        </div>
    </div>
    <!-- ./Valor Residual Field -->

    <!-- Pagamento Id Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('conta_bancaria_id', 'Conta Banco*:') !!}
            <div class="form-line {{$errors->has('conta_bancaria_id') ? 'focused error' : '' }}">
                <select id="conta_bancaria_id" name="conta_bancaria_id" class="form-control show-tick" data-live-search="true" required>
                    <option disabled selected value="">Selecione a conta</option>
                    @if(!empty($contasbancarias) && !empty($baixaReceber) )
                        @foreach($contasbancarias as $conta)
                            <option value="{{$conta->id}}" {{ ($conta->id == $baixaReceber->conta_bancaria_id) ? 'selected' : '' }}>{{$conta->getName()}}</option>
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
    <!-- ./Pagamento Id Field -->

    <!-- plano de contas Id Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('plano_de_conta_id', 'Plano de Contas*:') !!}
            <div class="form-line {{$errors->has('plano_de_conta_id') ? 'focused error' : '' }}">
                <select id="plano_de_conta_id" name="plano_de_conta_id" class="form-control show-tick" data-live-search="true" required>
                    <option disabled selected value="">Selecione um plano de conta</option>
                    @if(!empty($planos_contas) && !empty($baixaReceber) )
                        @foreach($planos_contas as $plano_conta)
                            <option value="{{$plano_conta->id}}" {{ ($plano_conta->id == $baixaReceber->plano_de_conta_id) ? 'selected' : '' }}>{{$plano_conta->descricaoConta()}}</option>
                        @endforeach
                    @elseif(!empty($planos_contas))
                        @foreach($planos_contas as $plano_conta)
                            <option value="{{$plano_conta->id}}" {{ ($plano_conta->id == old('plano_de_conta_id') ) ? 'selected' : '' }}>{{$plano_conta->descricaoConta()}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <label class="error">{{$errors->first('plano_de_conta_id')}}</label>
        </div>
    </div>
    <!-- ./plano de contas Id Field -->

    <!-- Pagamento Id Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('pagamento_id', 'Forma de Pagamento*:') !!}
            <div class="form-line {{$errors->has('pagamento_id') ? 'focused error' : '' }}">
                <select id="pagamento_id" name="pagamento_id" class="form-control show-tick" data-live-search="true" required>
                    <option disabled selected value="">Selecione a forma de pagamento</option>
                    @if(!empty($formaPagamentos) && !empty($baixaReceber) )
                        @foreach($formaPagamentos as $formaPagamento)
                            <option value="{{$formaPagamento->id}}" {{ ($formaPagamento->id == $baixaReceber->pagamento_id) ? 'selected' : '' }}>{{$formaPagamento->titulo}}</option>
                        @endforeach
                    @elseif(!empty($formaPagamentos))
                        @foreach($formaPagamentos as $formaPagamento)
                            <option value="{{$formaPagamento->id}}" {{ ($formaPagamento->id == old('pagamento_id')) ? 'selected' : '' }}>{{$formaPagamento->titulo}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <label class="error">{{$errors->first('pagamento_id')}}</label>
        </div>
    </div>
    <!-- ./Pagamento Id Field -->

    

    <!-- Disponibilidade Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('disponibilidade', 'Disponibilidade:') !!}
            <div id="datepicker_component_container_1" class="form-line {{$errors->has('disponibilidade') ? 'focused error' : '' }}">
                @if(!empty($baixaReceber) )
                    <input class="form-control" name="disponibilidade" type="text" autocomplete="off"  value="{!! $baixaReceber->getDisponibilidade() !!}" id="disponibilidade">
                @else
                    <input class="form-control" name="disponibilidade" type="text" autocomplete="off" value="{{ old('disponibilidade') }}" id="disponibilidade">
                @endif
            </div>
            <label class="error">{{$errors->first('disponibilidade')}}</label>
        </div>
    </div>
    <!-- ./Disponibilidade Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('baixareceber.index') !!}" class="btn btn-default" id="btnCancelar">Cancelar</a>
    </div>
</div>
