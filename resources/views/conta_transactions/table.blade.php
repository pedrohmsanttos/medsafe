<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="contaTransactions-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Conta Bancaria Id</th>
        <th>Valor</th>
        <th>Hash</th>
        <th>Tipo</th>
        <th>Accepted</th>
        <th>Meta</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contaTransactions as $contaTransaction)
            <tr>
                <td>
                    <input id="item_{!! $contaTransaction->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $contaTransaction->id !!}" name="check[]">
                    <label for="item_{!! $contaTransaction->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $contaTransaction->conta_bancaria_id !!}</td>
            <td>{!! $contaTransaction->valor !!}</td>
            <td>{!! $contaTransaction->hash !!}</td>
            <td>{!! $contaTransaction->tipo !!}</td>
            <td>{!! $contaTransaction->accepted !!}</td>
            <td>{!! $contaTransaction->meta !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>