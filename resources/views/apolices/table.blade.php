<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="apolices-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Corretor(a)</th>
                <th>Pedido Nº</th>
                <th>Numero</th>
                <th>Classe Bonus</th>
                <th>Proposta</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($apolices as $apolice)
            <tr data-id="{!! $apolice->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $apolice->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $apolice->id !!}" name="check[]">
                    <label for="item_{!! $apolice->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $apolice->corretor->nome !!}</td>
                <td>{!! $apolice->pedido_id !!}</td>
                <td>{!! $apolice->numero !!}</td>
                <td>{!! $apolice->classe_bonus !!}</td>
                <td>{!! $apolice->proposta !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>