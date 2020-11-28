<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="pedidos-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Código</th>
                <th>Cliente</th>
                <th>Usuário Operacao</th>
                <th>Data Vencimento</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($pedidos as $pedido)
            <tr data-id="{!! $pedido->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $pedido->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $pedido->id !!}" name="check[]">
                    <label for="item_{!! $pedido->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! str_pad($pedido->id, 8, "0", STR_PAD_LEFT) !!}</td>
                <td>{!! $pedido->cliente->nomeFantasia !!}</td>
                <td>{!! $pedido->user->name !!}</td>
                <td>{!! dateSqlToBR($pedido->data_vencimento) !!}</td>
                <td>{!! "R$ " . number_format((float) $pedido->valor_total, 2, ',', '.') !!}</td>
                <td> {!! ($pedido->getStatus()) ? "PAGO" : "" !!} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>