<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="coberturas-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Apolice Id</th>
        <th>Nome</th>
        <th>Valor</th>
            </tr>
        </thead>
        <tbody>
        @foreach($coberturas as $cobertura)
            <tr>
                <td>
                    <input id="item_{!! $cobertura->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $cobertura->id !!}" name="check[]">
                    <label for="item_{!! $cobertura->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $cobertura->apolice_id !!}</td>
            <td>{!! $cobertura->nome !!}</td>
            <td>{!! $cobertura->valor !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>