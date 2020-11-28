<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="segurados-table">
        <thead>
            <tr>
        <th>Cliente</th>
        <th>Numero</th>
        <th>Endosso</th>
        <th>Ci</th>
        <th>Classe Bônus</th>
        <th>Proposta</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($segurados as $segurado)
 
            <tr data-id="{!! $segurado->id !!}">
            
            <td>{!! $segurado->cliente->nomeFantasia!!}</td>
            <td>{!! $segurado->numero !!}</td>
            <td>{!! $segurado->endosso !!}</td>
            <td>{!! $segurado->ci !!}</td>
            <td>{!! $segurado->classe_bonus !!}</td>
            <td>{!! $segurado->proposta !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>