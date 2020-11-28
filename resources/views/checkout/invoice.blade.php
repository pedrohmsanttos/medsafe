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
            @if(!empty($negocio->pessoa()->first()))
            <address>
                <strong>
                    {{ $negocio->pessoa()->first()->nome }}
                </strong><br>
                {{ $negocio->pessoa()->first()->enderecos()->first()->rua .' Nº'. $negocio->pessoa()->first()->enderecos()->first()->numero .', '. $negocio->pessoa()->first()->enderecos()->first()->bairro}}<br>
                {{ $negocio->pessoa()->first()->enderecos()->first()->municipio .', '. $negocio->pessoa()->first()->enderecos()->first()->uf .' '. $negocio->pessoa()->first()->enderecos()->first()->cep }}<br>
                Telefone: {{ $negocio->pessoa()->first()->telefone }}<br>
                E-mail: {{ $negocio->pessoa()->first()->email }}
            </address>
            @elseif(!empty($negocio->organizacao()->first()))
            <address>
                <strong>
                    {{ $negocio->organizacao()->first()->nome }}
                </strong><br>
                {{ $negocio->organizacao()->first()->enderecos()->first()->rua .' Nº'. $negocio->organizacao()->first()->enderecos()->first()->numero .', '. $negocio->organizacao()->first()->enderecos()->first()->bairro}}<br>
                {{ $negocio->organizacao()->first()->enderecos()->first()->municipio .', '. $negocio->organizacao()->first()->enderecos()->first()->uf .' '. $negocio->organizacao()->first()->enderecos()->first()->cep }}<br>
                Telefone: {{ $negocio->organizacao()->first()->telefone }}<br>
                E-mail: {{ $negocio->organizacao()->first()->email }}
            </address>
            @endif
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Negócio # {{ $codigo }}</b><br>
            <br>
            <b>Título:</b> {{ $negocio->titulo }}<br>
            <b>Usuário da operação:</b> {{ $negocio->usuarioOperacao->name }}<br>
            <b>Data Negócio:</b> {{ dateSqlToBR($negocio->data_criacao) }}
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
                    @foreach ($negocio->itens()->get() as $item)
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
                        <td>{{ 'R$ ' . number_format((float) $negocio->valor, 2, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<div class="row">
    <!-- Submit Field -->
    <div class="col-md-6">
        <div class="form-group">
            <a href="{!! route('negocios.index') !!}" class="btn btn-default waves-effect">Cancelar</a>
        </div>
    </div>
</div>