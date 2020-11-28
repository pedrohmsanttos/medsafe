<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="tipoAtividades-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tipoAtividades as $tipoAtividade)
            <tr>
                <td>
                    <input id="item_{!! $tipoAtividade->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $tipoAtividade->id !!}" name="check[]">
                    <label for="item_{!! $tipoAtividade->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $tipoAtividade->descricao !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>