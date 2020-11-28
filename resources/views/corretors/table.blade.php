<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="corretors-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Nome</th>
        <th>Cpf</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Celular</th>
        <th>Corretora Id</th>
            </tr>
        </thead>
        <tbody>
        @foreach($corretors as $corretor)
            <tr>
                <td>
                    <input id="item_{!! $corretor->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $corretor->id !!}" name="check[]">
                    <label for="item_{!! $corretor->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $corretor->nome !!}</td>
            <td>{!! $corretor->cpf !!}</td>
            <td>{!! $corretor->telefone !!}</td>
            <td>{!! $corretor->email !!}</td>
            <td>{!! $corretor->celular !!}</td>
            <td>{!! $corretor->corretora_id !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>