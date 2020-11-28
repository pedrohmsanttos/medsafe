<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="corretoras-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Descricao</th>
        <th>Cnpj</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Susep</th>
            </tr>
        </thead>
        <tbody>
        @foreach($corretoras as $corretora)
            <tr>
                <td>
                    <input id="item_{!! $corretora->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $corretora->id !!}" name="check[]">
                    <label for="item_{!! $corretora->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $corretora->descricao !!}</td>
            <td>{!! $corretora->cnpj !!}</td>
            <td>{!! $corretora->telefone !!}</td>
            <td>{!! $corretora->email !!}</td>
            <td>{!! $corretora->susep !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>