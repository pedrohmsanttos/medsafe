<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="formasDePagamento-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Título</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($formaDePagamentos as $formaDePagamento)
            <tr data-id="{!! $formaDePagamento->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $formaDePagamento->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $formaDePagamento->id !!}" name="check[]">
                    <label for="item_{!! $formaDePagamento->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $formaDePagamento->titulo !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>