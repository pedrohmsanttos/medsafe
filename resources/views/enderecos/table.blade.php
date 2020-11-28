<table class="table table-responsive" id="enderecos-table">
    <thead>
        <tr>
            <th>Rua</th>
        <th>Bairro</th>
        <th>Municipio</th>
        <th>Uf</th>
        <th>Cep</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($enderecos as $endereco)
        <tr>
            <td>{!! $endereco->rua !!}</td>
            <td>{!! $endereco->bairro !!}</td>
            <td>{!! $endereco->municipio !!}</td>
            <td>{!! $endereco->uf !!}</td>
            <td>{!! $endereco->cep !!}</td>
            <td>
                {!! Form::open(['route' => ['enderecos.destroy', $endereco->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('enderecos.show', [$endereco->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('enderecos.edit', [$endereco->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>