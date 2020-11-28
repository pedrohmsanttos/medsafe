<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="checkouts-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Negocio Id</th>
        <th>Pedido Id</th>
        <th>User Id</th>
        <th>Cliente Id</th>
        <th>Valor</th>
        <th>Parcelas</th>
        <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($checkouts as $checkout)
            <tr>
                <td>
                    <input id="item_{!! $checkout->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $checkout->id !!}" name="check[]">
                    <label for="item_{!! $checkout->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $checkout->negocio_id !!}</td>
            <td>{!! $checkout->pedido_id !!}</td>
            <td>{!! $checkout->user_id !!}</td>
            <td>{!! $checkout->cliente_id !!}</td>
            <td>{!! $checkout->valor !!}</td>
            <td>{!! $checkout->parcelas !!}</td>
            <td>{!! $checkout->status !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>