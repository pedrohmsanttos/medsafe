<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="ocorrencias-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Nome</th>
        <th>Categoria</th>
        <th>Titulo</th>
        <th>Status</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        
        @foreach($ocorrencias as $ocorrencia)
            <tr data-id="{!! $ocorrencia->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $ocorrencia->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $ocorrencia->id !!}" name="check[]">
                    <label for="item_{!! $ocorrencia->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $ocorrencia->user()->first()->name !!}</td>
            <td>{!! $ocorrencia->category()->first()->descricao !!}</td>
            <td>{!! $ocorrencia->titulo !!}</td>
            <td>{!! $ocorrencia->getStatus() !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>