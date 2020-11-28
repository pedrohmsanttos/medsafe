<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="medsafeBeneficios-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Produto/Serviço</th>
        <th>Nome</th>
        <th>Valor</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($medsafeBeneficios as $medsafeBeneficio)
            <tr data-id="{!! $medsafeBeneficio->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $medsafeBeneficio->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $medsafeBeneficio->id !!}" name="check[]">
                    <label for="item_{!! $medsafeBeneficio->id !!}" style="margin-left: 10px;"></label>
                </td>
            <td>{!! $medsafeBeneficio->produto()->first()->descricao !!}</td>
            <td>{!! $medsafeBeneficio->nome !!}</td>
            <td>{!! $medsafeBeneficio->valor !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>