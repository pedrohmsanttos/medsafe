<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="tickets-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Titulo</th>
                <th>Cliente</th>
                <th>Categoria</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($tickets as $ticket)
            <tr data-id="{!! $ticket->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $ticket->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $ticket->id !!}" name="check[]">
                    <label for="item_{!! $ticket->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $ticket->titulo !!}</td>
                <td>{!! $ticket->user->cliente->first()->nomeFantasia !!}</td>
                <td>{!! $ticket->category->descricao !!}</td>
                <td>{!! $ticket->getStatus() !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>