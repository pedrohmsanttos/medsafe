<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="corretoradms-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Nome</th>
        <th>Email</th>
        <th>Período De Pagamento</th>
        <th>Aprovado</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($corretoradms as $corretoradm)
            <tr data-id="{!! $corretoradm->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $corretoradm->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $corretoradm->id !!}" name="check[]">
                    <label for="item_{!! $corretoradm->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $corretoradm->nome !!}</td>
            <td>{!! $corretoradm->email !!}</td>
            <td>{!! $corretoradm->periodo_de_pagamento !!}</td>
            <td>{!! $corretoradm->aprovado !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>