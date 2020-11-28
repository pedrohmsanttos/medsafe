<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="perdaNegocios-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Comentario</th>
                <th>Negócio</th>
                <th>Usuário</th>
                <th>Data da perda</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($perdaNegocios as $perdaNegocio)
            <tr data-id="{!! $perdaNegocio->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $perdaNegocio->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $perdaNegocio->id !!}" name="check[]">
                    <label for="item_{!! $perdaNegocio->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $perdaNegocio->comentario !!}</td>
                <td>{!! $perdaNegocio->getNegocio() !!}</td>
                <td>{!! $perdaNegocio->getUsuarioOperacao() !!}</td>
                <td>{!! $perdaNegocio->getDataPerda() !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>