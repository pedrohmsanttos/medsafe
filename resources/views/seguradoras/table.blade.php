<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="formasDePagamento-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Descrição do Corretor</th>
                <th>CNPJ</th>
                <th>Telefone</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($seguradoras as $seguradora)
            <tr data-id="{!! $seguradora->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $seguradora->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $seguradora->id !!}" name="check[]">
                    <label for="item_{!! $seguradora->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $seguradora->descricaoCorretor !!}</td>
                <td>{!! $seguradora->CNPJ !!}</td>
                <td>{!! $seguradora->telefone !!}</td>
                <td>{!! $seguradora->email !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>