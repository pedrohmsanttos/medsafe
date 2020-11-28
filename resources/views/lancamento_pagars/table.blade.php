<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="lancamentosPagar-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>ID</th>
                <th>Fornecedor</th>
                <th>Corretor</th>
                <th>Data de Vencimento</th>
                <th>Data de Emissão</th>
                <th>Valor do Título</th>
                <th>Número do Documento</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($lancamentosPagar as $lancamentoPagar)
            <tr data-id="{!! $lancamentoPagar->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $lancamentoPagar->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $lancamentoPagar->id !!}" name="check[]" data-baixado="{!!  ($lancamentoPagar->getStatus()) ? '1' : '0' !!}">
                    <label for="item_{!! $lancamentoPagar->id !!}" style="margin-left: 10px;"></label>
                    <input type="hidden" id="lancamento_{!! $lancamentoPagar->id !!}" value="{{ $lancamentoPagar }}" />
                </td>
                <td>{!! str_pad($lancamentoPagar->id, 8, "0", STR_PAD_LEFT); !!}</td>
                @if(isset($lancamentoPagar->fornecedor()->first()->nomeFantasia))
                    <td>{!! $lancamentoPagar->fornecedor()->first()->nomeFantasia !!}</td>
                @else
                    <td></td>
                @endif
                @if(isset($lancamentoPagar->corretor()->first()->nome))
                    <td>{!! $lancamentoPagar->corretor()->first()->nome !!}</td>
                @else
                    <td></td>
                @endif
                <td>{!! $lancamentoPagar->getDataVencimento() !!}</td>
                <td>{!! $lancamentoPagar->getDataEmissao() !!}</td>
                <td>R$ {!! number_format((float) $lancamentoPagar->valor_titulo, 2, ',', '.') !!}</td>
                <td>{!! $lancamentoPagar->numero_documento !!}</td>
                <td>{!!  ($lancamentoPagar->getStatus()) ? "PAGO" : "" !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>