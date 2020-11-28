<div class="table-responsive" id="fornecedores-table">
    <table class="table table-bordered table-striped table-hover dataTable" id="fornecedores-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Razão Social</th>
                <th>Nome Fantasia</th>
                <th>Nome Titular</th>
                <th>CPFCNPJ</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($fornecedores as $fornecedor)
            <tr data-id="{!! $fornecedor->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $fornecedor->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $fornecedor->id !!}" name="check[]">
                    <label for="item_{!! $fornecedor->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $fornecedor->razaoSocial !!}</td>
                <td>{!! $fornecedor->nomeFantasia !!}</td>
                <td>{!! $fornecedor->nomeTitular !!}</td>
                <td>{!! $fornecedor->CNPJCPF !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>