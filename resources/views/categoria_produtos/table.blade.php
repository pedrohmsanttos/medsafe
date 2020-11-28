<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="categoriaProdutos-table">
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
        @foreach($categoriaProdutos as $categoriaProduto)
            <tr data-id="{!! $categoriaProduto->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $categoriaProduto->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $categoriaProduto->id !!}" name="check[]">
                    <label for="item_{!! $categoriaProduto->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $categoriaProduto->descricao !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>