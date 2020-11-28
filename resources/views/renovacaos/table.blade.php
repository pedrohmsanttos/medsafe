<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="renovacaos-table">
        <thead>
            <tr>
        <th>Pedido Nº</th>
        <th>Cliente</th>
        <th>Numero</th>
        <th>Endosso</th>
        <th>Ci</th>
        <th>Classe Bônus</th>
        <th>Proposta</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($renovacaos as $renovacao)
            <tr data-id="{!! $renovacao->id !!}">
                <td>{!! $renovacao->pedido_id !!}</td>
                <td>{!! $renovacao->cliente->nomeFantasia !!}</td>
                <td>{!! $renovacao->numero !!}</td>
                <td>{!! $renovacao->endosso !!}</td>
                <td>{!! $renovacao->ci !!}</td>
                <td>{!! $renovacao->classe_bonus !!}</td>
                <td>{!! $renovacao->proposta !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>