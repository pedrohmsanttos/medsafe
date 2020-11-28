<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="permissoes-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Nome Abreviado</th>
                <th>Nome</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($permissoes as $permissoes)
            <tr data-id="{!! $permissoes->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $permissoes->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $permissoes->id !!}" name="check[]">
                    <label for="item_{!! $permissoes->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $permissoes->name !!}</td>
                <td>{!! $permissoes->display_name !!}</td>
                <td>{!! $permissoes->description !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>