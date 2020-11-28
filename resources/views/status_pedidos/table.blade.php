<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="statusPedidos-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Status do Pedido</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($statusPedidos as $statusPedido)
            <tr data-id="{!! $statusPedido->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $statusPedido->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $statusPedido->id !!}" name="check[]">
                    <label for="item_{!! $statusPedido->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $statusPedido->status_pedido !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
