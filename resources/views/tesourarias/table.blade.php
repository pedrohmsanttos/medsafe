<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="tesourarias-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>ID</th>
                <th>N° Documento</th>
                <th>Tipo</th>
                <th>Fonte</th>
                <th>Plano de conta</th>
                <th>Valor</th>
                <th>Data Emissão</th>
                <th>Data Vencimento</th>
                <th>Data Disponibilidade</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($tesourarias as $tesouraria)
            <tr data-id="{!! $tesouraria->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $tesouraria->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $tesouraria->id !!}" name="check[]">
                    <label for="item_{!! $tesouraria->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $tesouraria->id !!}</td>
                <td>{!! $tesouraria->numero_documento !!}</td>
                <td>{!! (!is_null($tesouraria->fornecedor_id)) ? 'DÉBITO' : 'CRÉDITO' !!}</td>
                <td>{!! (!is_null($tesouraria->fornecedor_id)) ? $tesouraria->fornecedor()->first()->nomeFantasia : $tesouraria->cliente()->first()->nomeFantasia !!}</td>
                <td>{!! $tesouraria->planoDeConta()->first()->descricaoConta() !!}</td>
                <td>{{ $tesouraria->valor }}</td>
                <td>{!! $tesouraria->getDataEmissao() !!}</td>
                <td>{!! $tesouraria->getDataVencimento() !!}</td>
                <td>{!! $tesouraria->getDataDisponibilidade() !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>