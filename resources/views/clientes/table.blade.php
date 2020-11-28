<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="clientes-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Nome</th>
                <th>CNPJ/CPF</th>
                <th>Tipo</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($clientes as $cliente)
            <tr data-id="{!! $cliente->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $cliente->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $cliente->id !!}" name="check[]">
                    <label for="item_{!! $cliente->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $cliente->nomeFantasia !!}</td>
                <td>{!! $cliente->CNPJCPF !!}</td>
                <td>{!! $cliente->getTipo() !!}</td>
                <td>{!! $cliente->email !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>