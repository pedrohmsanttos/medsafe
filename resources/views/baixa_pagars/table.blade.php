<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="baixapagar-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>ID</th>
                <th>Disponibilidade</th>
                <th>Baixa</th>
                <th>Valor Pago</th>
                <th>Valor Residual</th>
                <th>Conta Bancária</th>
                <th>Tipo Pagamento</th>
                <th>Lançamento</th>
            </tr>
        </thead>
        <tbody>
        @foreach($baixapagar as $baixaPagar)
            <tr class="gridBody" data-id="{!! $baixaPagar->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $baixaPagar->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $baixaPagar->id !!}" name="check[]">
                    <label for="item_{!! $baixaPagar->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! str_pad($baixaPagar->id, 8, "0", STR_PAD_LEFT); !!}</td>
                <td>{!! date('d/m/Y', strtotime($baixaPagar->disponibilidade)) !!}</td>
                <td>{!! date('d/m/Y', strtotime($baixaPagar->baixa)) !!}</td>
                <td>RS {!! number_format($baixaPagar->valor_pago, 2, ',', '.') !!}</td>
                <td>RS {!! number_format($baixaPagar->valor_residual, 2, ',', '.') !!}</td>
                <td>{!! $baixaPagar->contasBancaria->getName() !!}</td>
                <td>{!! $baixaPagar->formasDePagamento->titulo !!}</td>
                <td>{!! $baixaPagar->lancamentosPagar->getTitulo() !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>