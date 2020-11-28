<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="usuarios-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Login</th>
                <th>Nome</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($usuarios as $usuario)
            <tr data-id="{!! $usuario->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $usuario->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $usuario->id !!}" name="check[]">
                    <label for="item_{!! $usuario->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $usuario->login !!}</td>
                <td>{!! $usuario->name !!}</td>
                <td>{!! $usuario->email !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>