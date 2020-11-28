<table class="table table-responsive" id="organizacaos-table">
    <thead>
        <tr>
            <th>Nome</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Faturamento Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($organizacaos as $organizacao)
        <tr>
            <td>{!! $organizacao->nome !!}</td>
            <td>{!! $organizacao->telefone !!}</td>
            <td>{!! $organizacao->email !!}</td>
            <td>{!! $organizacao->faturamento_id !!}</td>
            <td>
                {!! Form::open(['route' => ['organizacaos.destroy', $organizacao->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('organizacaos.show', [$organizacao->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('organizacaos.edit', [$organizacao->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>