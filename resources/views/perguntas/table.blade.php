<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="perguntas-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Pergunta</th>
        <th>Resposta</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($perguntas as $pergunta)
            <tr data-id="{!! $pergunta->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $pergunta->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $pergunta->id !!}" name="check[]">
                    <label for="item_{!! $pergunta->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $pergunta->pergunta !!}</td>
            <td>{!! $pergunta->resposta !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>