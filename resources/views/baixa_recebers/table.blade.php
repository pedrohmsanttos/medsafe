<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="baixaRecebers-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>ID</th>
                <th>Lançamento</th>
                <th>Cliente</th>
                <th>Baixa</th>
                <th>Valor Pago</th>
                <th>Valor Residual</th>
                <th>Conta Bancária</th>
                <th>Tipo Pagamento</th>
            </tr>
        </thead>
        <tbody>
        @foreach($baixaRecebers as $baixaReceber)
            <tr class="gridBody" data-id="{!! $baixaReceber->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $baixaReceber->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $baixaReceber->id !!}" name="check[]">
                    <label for="item_{!! $baixaReceber->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! str_pad($baixaReceber->id, 8, "0", STR_PAD_LEFT); !!}</td>
                <td>{!! $baixaReceber->lancamentosReceber->getTitulo() !!}</td>
                <td>{!! $baixaReceber->lancamentosReceber->cliente->razaoSocial !!}</td>
                <td>{!! date('d/m/Y', strtotime($baixaReceber->baixa)) !!}</td>
                <td>RS {!! number_format($baixaReceber->valor_pago, 2, ',', '.') !!}</td>
                <td>RS {!! number_format($baixaReceber->valor_residual, 2, ',', '.') !!}</td>
                <td>{!! $baixaReceber->contasBancaria->getName() !!}</td>
                <td>{!! $baixaReceber->formasDePagamento->titulo !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>