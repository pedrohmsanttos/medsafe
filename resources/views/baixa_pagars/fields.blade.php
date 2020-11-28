<div class="row">

<!-- Lancamentopagar Id Field -->
<div class="col-md-3">
        <div class="form-group">
            {!! Form::label('lancamentopagar_id', 'Lançamento*:') !!}
            <div class="form-line {{$errors->has('lancamentopagar_id') ? 'focused error' : '' }}">
                <select id="lancamentopagar_id" name="lancamentopagar_id" class="form-control show-tick" data-live-search="true" required>
                    <option disabled selected value="">Lançamento a Pagar</option>
                    @if(!empty($lancamentoPagar) && !empty($baixaPagar) )
                        @foreach($lancamentoPagar as $lancamento)
                            <option value="{{$lancamento->id}}" {{ ($lancamento->id == $baixaPagar->lancamentopagar_id) ? 'selected' : '' }}>{{$lancamento->getTitulo()}}</option>
                        @endforeach
                    @elseif(!empty($lancamentoPagar))
                        @foreach($lancamentoPagar as $lancamento)
                            <option value="{{$lancamento->id}}" {{ ($lancamento->id == old('lancamentopagar_id')) ? 'selected' : '' }}>{{$lancamento->getTitulo()}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <label class="error">{{$errors->first('lancamentopagar_id')}}</label>
        </div>
    </div>
    <!-- ./Lancamentopagar Id Field -->

    

    <!-- Baixa Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('baixa', 'Baixa*:') !!}
            <div id="datepicker_component_container_2" class="form-line {{$errors->has('baixa') ? 'focused error' : '' }}">
                @if(!empty($baixaPagar) )
                    <input class="form-control " name="baixa" type="text" autocomplete="off" value="{!! date('d/m/Y', strtotime($baixaPagar->baixa)) !!}" id="baixa">
                @else
                    <input class="form-control " name="baixa" type="text" autocomplete="off" value="" id="baixa" required>
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
                {!! Form::text('valor_pago', null, ['class' => 'form-control dinheiro', 'required' => true]) !!}
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

<!-- plano de contas Id Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('plano_de_conta_id', 'Plano de Contas*:') !!}
            <div class="form-line {{$errors->has('plano_de_conta_id') ? 'focused error' : '' }}">
                <select id="plano_de_conta_id" name="plano_de_conta_id" class="form-control show-tick" data-live-search="true" required>
                    <option disabled selected value="">Selecione um plano de conta</option>
                    @if(!empty($planos_contas) && !empty($baixaPagar) )
                        @foreach($planos_contas as $plano_conta)
                            <option value="{{$plano_conta->id}}" {{ ($plano_conta->id == $baixaPagar->plano_de_conta_id) ? 'selected' : '' }}>{{$plano_conta->descricaoConta()}}</option>
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
            {!! Form::label('conta_bancaria_id', 'Conta Banco*:') !!}
            <div class="form-line {{$errors->has('conta_bancaria_id') ? 'focused error' : '' }}">
                <select id="conta_bancaria_id" name="conta_bancaria_id" class="form-control show-tick" data-live-search="true" required>
                    <option disabled selected value="">Selecione a conta</option>
                    @if(!empty($contasbancarias) && !empty($baixaPagar) )
                        @foreach($contasbancarias as $conta)
                            <option value="{{$conta->id}}" {{ ($conta->id == $baixaPagar->conta_bancaria_id) ? 'selected' : '' }}>{{$conta->getName()}}</option>
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

    <!-- Pagamento Id Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('pagamento_id', 'Forma de Pagamento*:') !!}
            <div class="form-line {{$errors->has('pagamento_id') ? 'focused error' : '' }}">
                <select id="pagamento_id" name="pagamento_id" class="form-control show-tick" data-live-search="true" required>
                    <option disabled selected value="">Selecione a forma de pagamento</option>
                    @if(!empty($formaPagamentos) && !empty($baixaPagar) )
                        @foreach($formaPagamentos as $formaPagamento)
                            <option value="{{$formaPagamento->id}}" {{ ($formaPagamento->id == $baixaPagar->pagamento_id) ? 'selected' : '' }}>{{$formaPagamento->titulo}}</option>
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
                @if(!empty($baixaPagar) )
                    <input class="form-control" name="disponibilidade" type="text" autocomplete="off" value="{!! date('d/m/Y', strtotime($baixaPagar->disponibilidade)) !!}" id="disponibilidade">
                @else
                    <input class="form-control" name="disponibilidade" type="text" autocomplete="off" value="" id="disponibilidade">
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
        <a href="{!! route('baixapagar.index') !!}" class="btn btn-default" id="btnCancelar">Cancelar</a>
    </div>
</div>
