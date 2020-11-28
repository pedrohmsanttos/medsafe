<div class="row">

    <div class="col-sm-6">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col"></th>
                <th scope="col">Cliente</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">nome</th>
                <td>{!! $segurado->cliente->nomeFantasia !!}</td>
                </tr>

                <tr>
                <th scope="row">Email</th>
                <td>{!! $segurado->cliente->email !!}</td>
                </tr>

                <tr>
                <th scope="row">Telefone</th>
                <td>{!! $segurado->cliente->telefone !!}</td>
                </tr>

                <tr>
                <th scope="row">Nome do titular</th>
                <td>{!! $segurado->cliente->nomeTitular !!}</td>
                </tr>

                <tr>
                <th scope="row">Razão social</th>
                <td>{!! $segurado->cliente->razaoSocial !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
        <div class="col-sm-6">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col"></th>
                <th scope="col">Apólice</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">Classe bonus</th>
                <td>{!! $segurado->classe_bonus !!}</td>
                </tr>

                <tr>
                <th scope="row">Proposta</th>
                <td>{!! $segurado->proposta !!}</td>
                </tr>

                <tr>
                <th scope="row">endosso</th>
                <td>{!! $segurado->endosso !!}</td>
                </tr>

                <tr>
                <th scope="row">ci</th>
                <td>{!! $segurado->ci !!}</td>
                </tr>

                <tr>
                <th scope="row">Número</th>
                <td>{!! $segurado->numero !!}</td>
                </tr>

            </tbody>
        </table>
    </div>

</div>