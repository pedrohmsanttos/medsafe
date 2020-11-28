<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="parametros-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Nome</th>
        <th>Valor</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($parametros as $parametro)
            <tr data-id="{!! $parametro->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $parametro->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $parametro->id !!}" name="check[]">
                    <label for="item_{!! $parametro->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $parametro->nome !!}</td>
            <td>{!! $parametro->valor !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>