<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="contratos-table">
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
        @foreach($contratos as $contrato)
            <tr data-id="{!! $contrato->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $contrato->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $contrato->id !!}" name="check[]">
                    <label for="item_{!! $contrato->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $contrato->titulo !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>