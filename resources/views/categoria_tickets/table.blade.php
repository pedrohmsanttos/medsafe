<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="categoriaTickets-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Descricao</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categoriaTickets as $categoriaTicket)
            <tr>
                <td>
                    <input id="item_{!! $categoriaTicket->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $categoriaTicket->id !!}" name="check[]">
                    <label for="item_{!! $categoriaTicket->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $categoriaTicket->descricao !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>