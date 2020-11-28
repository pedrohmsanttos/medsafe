<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Pedido Id</th>
        <th>Negocio Id</th>
        <th>Tabela Preco Id</th>
        <th>Valor</th>
        <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>
                    <input id="item_{!! $item->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $item->id !!}" name="check[]">
                    <label for="item_{!! $item->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $item->pedido_id !!}</td>
            <td>{!! $item->negocio_id !!}</td>
            <td>{!! $item->tabela_preco_id !!}</td>
            <td>{!! $item->valor !!}</td>
            <td>{!! $item->quantidade !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>