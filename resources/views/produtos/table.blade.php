<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="produtos-table">
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
        @foreach($produtos as $produto)
            <tr data-id="{!! $produto->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $produto->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $produto->id !!}" name="check[]">
                    <label for="item_{!! $produto->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $produto->descricao !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>