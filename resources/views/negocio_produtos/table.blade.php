<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="negocioProdutos-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Produto Tipo Produto Id</th>
            </tr>
        </thead>
        <tbody>
        @foreach($negocioProdutos as $negocioProduto)
            <tr>
                <td>
                    <input id="item_{!! $negocioProduto->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $negocioProduto->id !!}" name="check[]">
                    <label for="item_{!! $negocioProduto->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $negocioProduto->produto_tipo_produto_id !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>