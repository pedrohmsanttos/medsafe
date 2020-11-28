<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="atividades-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>Assunto</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Tipo</th>
                <th>Realizada</th>
                <th>Atribuído</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($atividades as $atividade)
            <tr data-id="{!! $atividade->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $atividade->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $atividade->id !!}" name="check[]">
                    <label for="item_{!! $atividade->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! $atividade->assunto !!}</td>
                <td>{{ date( 'd/m/Y' , strtotime($atividade->data) ) }}</td>
                <td>{!! $atividade->hora !!}</td>
                <td>{!! $atividade->tipoAtividade()->first()->descricao !!}</td>
                <td style="text-align: center">
                    @if($atividade->realizada == "1") 
                        <i class="material-icons" style="color: green;">check</i>
                    @else
                        <i class="material-icons" style="color: red;">do_not_disturb_alt</i>
                    @endif
                </td>
                <td>{!! $atividade->atribuido()->first()->name !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>