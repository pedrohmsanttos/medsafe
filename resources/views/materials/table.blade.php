<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="materials-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Titulo</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($materials as $material)
            <tr data-id="{!! $material->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $material->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $material->id !!}" name="check[]">
                    <label for="item_{!! $material->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $material->titulo !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>