<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="contas-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Classificação</th>
                <th>Descrição</th>
                <th>Conta Bancária</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($planoDeContas as $conta)
            <tr data-id="{!! $conta->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $conta->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $conta->id !!}" name="check[]">
                    <label for="item_{!! $conta->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $conta->classificacao !!}</td>
                <td>{!! $conta->descricao !!}</td>
                <td>{!! $conta->contasBancaria()->first()->getName() !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>