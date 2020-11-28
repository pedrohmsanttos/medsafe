<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="produtos-table">
        <thead>
            <tr>
                <th style="width: 5%;">
                    <input id="select_all" class="checkbox filled-in chk-col-light-blue" type="checkbox">
                    <label for="select_all" style="margin-bottom: -10px;"></label>    
                </th>
                <th>ID</th>
                <th>Título</th>
                <th>Valor</th>
                <th>Solicitante</th>
                <th>Data Criação</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($negocios as $negocio)
            <tr data-id="{!! $negocio->id !!}">
                <td class="checkItem">
                    <input id="item_{!! $negocio->id !!}" class="checkbox filled-in chk-col-light-blue" type="checkbox" value="{!! $negocio->id !!}" name="check[]">
                    <label for="item_{!! $negocio->id !!}" style="margin-left: 10px;"></label>
                </td>
                <td>{!! str_pad($negocio->id, 8, "0", STR_PAD_LEFT) !!}</td>
                <td>{!! $negocio->titulo !!}</td>
                <td>{!! "R$ " . number_format((float) $negocio->valor, 2, ',', '.')  !!}</td>
                @if(!empty($negocio->organizacao()->first()))
                    <td>{!! $negocio->organizacao()->first()->nome !!}</td>
                @elseif(!empty($negocio->pessoa()->first()))   
                    <td>{!! $negocio->pessoa()->first()->nome !!}</td>
                @else    
                    <td></td>
                @endif

                @if(!empty($negocio->getDataCriacao()))
                    <td>{!! $negocio->getDataCriacao() !!}</td>
                @else    
                    <td></td>
                @endif

                <td>{!! status_negocio()[$negocio->status] !!}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

