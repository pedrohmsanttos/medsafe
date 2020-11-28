<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="comissaos-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>ID</th>
                <th>Corretor</th>
        <th>Percentual da comissão</th>
        <th>Comissão do corretor</th>
        <th>Valor Total do checkout</th>
        <th>Status Aprovacao</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($comissaos as $comissao)
            <tr data-id="{!! $comissao->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $comissao->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $comissao->id !!}" name="check[]">
                    <label for="item_{!! $comissao->id !!}" style="margin-left: 10px;"></label>
                </td>
                <!-- <td>{!! str_pad($comissao->id, 8, "0", STR_PAD_LEFT) !!}</td> -->
                <td>{!! $comissao->id !!}</td>
                <td>{!! $comissao->corretor()->first()->nome !!}</td>
            <td>{!! $comissao->percentual_comissao !!} %</td>
            <td>{!! "R$ " . number_format((float) $comissao->comissao, 2, ',', '.') !!}</td>
            <td>{!! "R$ " . number_format((float) $comissao->valor, 2, ',', '.') !!}</td>
            <td>{!! $comissao->status_aprovacao !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>