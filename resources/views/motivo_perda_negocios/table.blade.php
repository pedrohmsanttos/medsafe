<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="motivoPerdaNegocio-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($motivoPerdaNegocios as $motivoPerdaNeg)
            <tr data-id="{!! $motivoPerdaNeg->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $motivoPerdaNeg->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $motivoPerdaNeg->id !!}" name="check[]">
                    <label for="item_{!! $motivoPerdaNeg->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $motivoPerdaNeg->descricao !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>