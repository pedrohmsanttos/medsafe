<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="especialidades-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Descricao</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($especialidades as $especialidade)
            <tr data-id="{!! $especialidade->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $especialidade->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $especialidade->id !!}" name="check[]">
                    <label for="item_{!! $especialidade->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $especialidade->descricao !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>