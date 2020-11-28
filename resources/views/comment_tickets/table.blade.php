<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="commentTickets-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Ticket Id</th>
        <th>User Id</th>
        <th>Comment</th>
            </tr>
        </thead>
        <tbody>
        @foreach($commentTickets as $commentTicket)
            <tr>
                <td>
                    <input id="item_{!! $commentTicket->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $commentTicket->id !!}" name="check[]">
                    <label for="item_{!! $commentTicket->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $commentTicket->ticket_id !!}</td>
            <td>{!! $commentTicket->user_id !!}</td>
            <td>{!! $commentTicket->comment !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>