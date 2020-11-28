<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="produtoTipoProdutos-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Produto/Serviço</th>
                <th>Tipo Produto</th>
                <th>Categoria Produto</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($produtoTipoProdutos as $produtoTipoProduto)
            <tr data-id="{!! $produtoTipoProduto->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $produtoTipoProduto->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $produtoTipoProduto->id !!}" name="check[]">
                    <label for="item_{!! $produtoTipoProduto->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $produtoTipoProduto->produto()->first()->descricao !!}</td>
                <td>{!! $produtoTipoProduto->tipoProduto()->first()->descricao !!}</td>
                <td>{!! $produtoTipoProduto->categoriaProduto()->first()->descricao !!}</td>
                <td>{!! 'R$ ' . number_format((float) $produtoTipoProduto->valor, 2, ',', '.') !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

