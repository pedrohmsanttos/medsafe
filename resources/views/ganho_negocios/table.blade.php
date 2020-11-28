<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="ganhoNegocios-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Comentario</th>
        <th>Negocio Id</th>
        <th>Usuario Operacao Id</th>
        <th>Data Ganho</th>
            </tr>
        </thead>
        <tbody>
        @foreach($ganhoNegocios as $ganhoNegocio)
            <tr>
                <td>
                    <input id="item_{!! $ganhoNegocio->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $ganhoNegocio->id !!}" name="check[]">
                    <label for="item_{!! $ganhoNegocio->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $ganhoNegocio->comentario !!}</td>
            <td>{!! $ganhoNegocio->negocio_id !!}</td>
            <td>{!! $ganhoNegocio->usuario_operacao_id !!}</td>
            <td>{!! $ganhoNegocio->data_ganho !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>