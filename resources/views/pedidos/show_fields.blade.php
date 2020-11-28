<div class="card">
    <div class="body">
        <!-- Main content -->
        <section class="invoice">
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    De
                    <address>
                        <strong>MedSafer</strong><br>
                        Av. Marquês de Olinda, Recife 200<br>
                        Recife, PE 50030-230<br>
                        Phone: (81) 1234-5678<br>
                        E-mail: suporte@medsafer.com.br
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    Para
                    <address>
                        <strong>
                            {{ $pedido->cliente->nomeFantasia }}
                        </strong><br>
                        {{ $pedido->cliente->first()->endereco()->first()->rua .' Nº'. $pedido->cliente->first()->endereco()->first()->numero .', '. $pedido->cliente->first()->endereco()->first()->bairro}}<br>
                        {{ $pedido->cliente->first()->endereco()->first()->municipio .', '. $pedido->cliente->first()->endereco()->first()->uf .' '. $pedido->cliente->first()->endereco()->first()->cep }}<br>
                        Telefone: {{ $pedido->cliente->telefone }}<br>
                        E-mail: {{ $pedido->cliente->email }}<br>
                    </address>
                </div>

                @if(isset($pedido->endereco()->first()->rua))
                <div class="col-sm-4 invoice-col">
                    <strong>Dados do Segurado</strong>
                    <address>
                        {{ $pedido->endereco()->first()->rua .' Nº'. $pedido->endereco()->first()->numero .', '. $pedido->endereco()->first()->bairro}}<br>
                        {{ $pedido->endereco()->first()->municipio .', '. $pedido->endereco()->first()->uf .' '. $pedido->endereco()->first()->cep }}<br>
                        Cpf: {{ $pedido->cpf }}<br>
                        Telefone: {{ $pedido->telefone }}<br>
                        Nome Completo segurado: {{ $pedido->nome_completo }}<br>
                        E-mail: {{ $pedido->email }}
                    </address>
                </div>
                @endif
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Pedido # {{ $codigo }}</b><br>
                    <br>
                    <b>Título:</b> {{ $pedido->titulo }}<br>
                    <b>Usuário da operação:</b> {{ $pedido->user->name }}<br>
                    <b>Data do Negócio:</b> {{ dateSqlToBR($pedido->created_at) }}
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Valor</th>
                                <th>Qnt</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedido->itens()->get() as $item)
                                <tr>
                                    <td>{{ $item->tabelaPreco()->first()->titulo() }}</td>
                                    <td>{{ 'R$ ' . number_format((float) $item->valor, 2, ',', '.') }}</td>
                                    <td>{{ $item->quantidade }}</td>
                                    <td>{{ 'R$ ' . number_format((float) $item->subTotal(), 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">
                    <!--
                    <p class="lead">Métodos de Pagamento:</p>
                    <img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/visa.png" alt="Visa">
                    <img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/mastercard.png" alt="Mastercard">
                    <img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/american-express.png" alt="American Express">
                    <img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/paypal2.png" alt="Paypal">

                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s
                    </p>
                    -->
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                    <p class="lead">Valor a pagar</p>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Total:</th>
                                <td>{{ 'R$ ' . number_format((float) $pedido->valor_total, 2, ',', '.') }}</td>
                            </tr>
                            @if($pedido->valor_desconto > 0)
                            <tr>
                                <th style="width:50%">Desconto:</th>
                                <td>{{ '- R$ ' . number_format((float) $pedido->valor_desconto, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">Total a pagar:</th>
                                <td>{{ 'R$ ' . number_format((float) $pedido->valor_total - $pedido->valor_desconto, 2, ',', '.') }}</td>
                            </tr>
                            @endif
                            @if(!empty($lancamento))
                            <tr>
                                <th style="width:50%">Forma de pagamento:</th>
                                <td>{{ $pedido->checkouts()->first()->parcelas .'x de R$ ' . number_format((float) $pedido->checkouts()->first()->valor / $pedido->checkouts()->first()->parcelas, 2, ',', '.') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- Submit Field -->
                <div class="col-md-6">
                    <div class="form-group">
                        @if(empty($lancamento))
                        {!! Form::open(['route' => 'checkouts.store']) !!}
                            <a href="{!! route('pedidos.index') !!}" class="btn btn-default waves-effect">Cancelar</a>
                            <input type="hidden" id="pedido_id" name="pedido_id" value="{{ $pedido->id }}"> 
                            {!! Form::submit('Faturar', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                        @else
                        <a href="{!! route('pedidos.index') !!}" class="btn btn-default waves-effect">Cancelar</a>
                        @endif
                        
                    </div>
                </div>

                <div class="col-md-6">
                    <a id="print" style="float:right;" href="#print" class="btn btn-default waves-effect">
                        <i class="material-icons">print</i>
                    </a>
                </div>
            </div>
        </section>
    </div>

    
</div>
