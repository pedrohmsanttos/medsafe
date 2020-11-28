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
        @foreach($novidades as $novidade)
            <tr data-id="{!! $novidade->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $novidade->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $novidade->id !!}" name="check[]">
                    <label for="item_{!! $novidade->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $novidade->titulo !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>