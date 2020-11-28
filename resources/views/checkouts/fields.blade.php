<div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Resumo</span>
            <span class="badge badge-secondary badge-pill">{{ count($checkout->pedido->itens()->get()) }}</span>
          </h4>
          <ul class="list-group mb-3">
            @foreach ($checkout->pedido->itens()->get() as $item)
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">{{ $item->tabelaPreco()->first()->titulo() }}</h6>
                  <small class="text-muted">{{ 'R$ ' . number_format((float) $item->valor, 2, ',', '.') .' * '. $item->quantidade}}</small>
                </div>
                <span class="text-muted">{{ 'R$ ' . number_format((float) $item->subTotal(), 2, ',', '.') }}</span>
              </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between bg-light">
              <div class="text-success">
                <h6 class="my-0">CUPOM DE DESCONTO</h6>
                <small>EXAMPLECODE</small>
              </div>
              <span class="text-success">-R$0</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total</span>
              <strong>{{ 'R$ ' . number_format((float) $checkout->pedido->valor_total, 2, ',', '.') }}</strong>
              <input type="hidden" id="valor_total_pedido" ng-model="valor_total_pedido" name="valor_total_pedido" ng-init="valor_total_pedido='{{ $checkout->pedido->valor_total }}'" value="{{ $checkout->pedido->valor_total }}">
            </li>
          </ul>
          <!-- Desconto -->
          <div class="row">
            <form class="card p-2">
              <div class="input-group">
                <div class="col-md-6">
                  <div class="form-line">
                    <input type="text" class="form-control" placeholder="Cupom">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group-append">
                    <a type="submit" class="btn btn-success waves-effect">
                        <i class="material-icons">extension</i>
                        <span>Enviar</span>
                    </a>
                  </div>
                </div>
              </div>
          </div>
        </div>
        
        <div class="col-md-8 order-md-1">
          @if(!Auth::user()->hasRole('cliente_user'))
          <h4 class="mb-3">Aplicar desconto</h4>
            <hr class="mb-4">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="desconto">
              <label class="custom-control-label" for="desconto">Habilitar desconto no valor total</label>
            </div>
            <div class="custom-control custom-checkbox">
              <div class="form-line">
                <input class="form-control dinheiro" ng-change="loadDesconto()" ng-model="valor_desconto" name="valor_desconto" type="text" id="valor_desconto" disabled>
              </div>
            </div>
          @endif
            <h4 class="mb-3">Pagamento</h4>
            <hr class="mb-4">
            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input value="po" id="pagamento_operador" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                <label class="custom-control-label" for="pagamento_operador">Gerar lancamento(s)</label>
              </div>
              @if(!Auth::user()->hasRole('cliente_user'))
              <div class="custom-control custom-radio">
                <input value="pc" id="pagamento_cliente" name="paymentMethod" type="radio" class="custom-control-input" required="">
                <label class="custom-control-label" for="pagamento_cliente">Enviar checkout para cliente</label>
              </div>
              @endif
            </div>

            <div class="po">
              <h4 class="mb-3">Forma de pagamento</h4>
              <hr class="mb-4">
              @if(!Auth::user()->hasRole('cliente_user'))
              <div class="custom-control custom-checkbox">
                <div class="row clearfix">
                    <div class="col-md-3" style="margin-top: 10px;text-align: right;">
                        <label for="parcelas">Nº de parcelas</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-line" ng-init="parcelas=12">
                              <input class="form-control" ng-model="parcelas" name="parcelas" type="number" id="parcelas" value="12">
                            </div>
                        </div>
                    </div>
                </div> 
              </div>
              @else
              <input ng-model="desconto" name="desconto" type="hidden" id="desconto" value="0">
              <input ng-init="parcelas=12" ng-model="parcelas" name="parcelas" type="hidden" id="parcelas" value="12">
              @endif
              <div class="row">
                <div class="col-md-6">
                  <ul class="list-unstyled">
                    <li ng-repeat="option in getNumber(0, parcelas/2)" >
                      <input name="parcela" type="radio" id="radio_%%option%%" checked="" value="%%option%%">
                      <label for="radio_%%option%%"> %%option%%x %% ((valor_total_pedido - desconto)/(option)).toFixed(2) | currency : "R$ " %%</label>
                    </li>
                    </li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul class="list-unstyled">
                    <li ng-repeat="option in getNumber(parcelas/2, parcelas)" >
                      <input name="parcela" type="radio" id="radio_%%option%%" checked="" value="%%option%%">
                      <label for="radio_%%option%%"> %%option%%x %%  ((valor_total_pedido - desconto)/(option)).toFixed(2) | currency : "R$ " %%</label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="pc">
              %% desconto %%
            </div>

        </div>
      </div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! url('/pedidos/'.$checkout->pedido_id) !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
