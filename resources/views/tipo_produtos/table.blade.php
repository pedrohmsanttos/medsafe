<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="tipoProdutos-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($tipoProdutos as $tipoProduto)
            <tr data-id="{!! $tipoProduto->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $tipoProduto->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $tipoProduto->id !!}" name="check[]">
                    <label for="item_{!! $tipoProduto->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $tipoProduto->descricao !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>