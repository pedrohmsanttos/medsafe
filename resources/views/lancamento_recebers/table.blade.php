<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="lancamentoRecebers-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox" >
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data Vencimento</th>
                <th>Data Emissão</th>
                <th>Valor Título</th>
                <th>Pedido</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($lancamentoRecebers as $lancamentoReceber)
            <tr data-id="{!! $lancamentoReceber->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $lancamentoReceber->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $lancamentoReceber->id !!}" data-id="{!! $lancamentoReceber->id !!}" name="check[]" data-baixado="{!!  ($lancamentoReceber->getStatus()) ? '1' : '0' !!}">
                    <label for="item_{!! $lancamentoReceber->id !!}" style="margin-left: 10px;"></label>
                    <input type="hidden" id="lancamento_{!! $lancamentoReceber->id !!}" value="{{ $lancamentoReceber }}" />
                </td>
                <td>{!! str_pad($lancamentoReceber->id, 8, "0", STR_PAD_LEFT); !!}</td>
                <td>{!! $lancamentoReceber->cliente->nomeFantasia !!}</td>
                <td>{!! $lancamentoReceber->getDataVencimento() !!}</td>
                <td>{!! $lancamentoReceber->getDataEmissao() !!}</td>
                <td>R$ {!! number_format((float) $lancamentoReceber->valor_titulo, 2, ',', '.') !!}</td>
                <td>{!! (!empty($lancamentoReceber->pedido()->first())) ? str_pad($lancamentoReceber->pedido()->first()->id, 8, "0", STR_PAD_LEFT) : '' !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>