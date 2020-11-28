<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="faturamentos-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Faixa</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($faturamentos as $faturamento)
            <tr data-id="{!! $faturamento->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $faturamento->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $faturamento->id !!}" name="check[]">
                    <label for="item_{!! $faturamento->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $faturamento->descricao !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>