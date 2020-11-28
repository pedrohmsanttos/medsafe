<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="materialItems-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Arquivo</th>
        <th>Material Id</th>
            </tr>
        </thead>
        <tbody>
        @foreach($materialItems as $materialItem)
            <tr>
                <td>
                    <input id="item_{!! $materialItem->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $materialItem->id !!}" name="check[]">
                    <label for="item_{!! $materialItem->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $materialItem->arquivo !!}</td>
            <td>{!! $materialItem->material_id !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>