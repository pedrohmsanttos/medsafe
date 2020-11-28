<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="pedidoTipoProdutos-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>ID</th>
                <th>Cliente</th>  
                <th>Valor Total</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody  class="gridBody">
        @foreach($pedidos as $pedido)
            @if(!empty($pedido->pedidoTipoProdutos()->get()->first()))
                <tr data-id="{!! $pedido->id !!}">
                    <td class="checkItem">
                        <input id="item_{!! $pedido->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $pedido->id !!}" name="check[]">
                        <label for="item_{!! $pedido->id !!}" style="margin-left: 10px;"></label>
                    </td>
                    <td>{!! str_pad($pedido->id, 8, "0", STR_PAD_LEFT)   !!}</td>
                    <td>{!! $pedido->cliente()->first()->razaoSocial !!}</td>

                    
                    <td>
                        @if (!empty($pedido->valor_total))
                            @php echo "R$ " . number_format((float) $pedido->valor_total, 2, ',', '') @endphp
                        @else
                            @php echo "R$ 0,00" @endphp
                        @endif
                    </td>
                    
                    <td> {!! $pedido->getDataPedido() !!}  </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>