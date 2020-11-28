
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
                <td>{!! $renovacao->cliente->nomeFantasia !!}</td>
                </tr>

                <tr>
                <th scope="row">Email</th>
                <td>{!! $renovacao->cliente->email !!}</td>
                </tr>

                <tr>
                <th scope="row">Telefone</th>
                <td>{!! $renovacao->cliente->telefone !!}</td>
                </tr>

                <tr>
                <th scope="row">Nome do titular</th>
                <td>{!! $renovacao->cliente->nomeTitular !!}</td>
                </tr>

                <tr>
                <th scope="row">Razão social</th>
                <td>{!! $renovacao->cliente->razaoSocial !!}</td>
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
                <th scope="row">Classe bônus</th>
                <td>{!! $renovacao->classe_bonus !!}</td>
                </tr>

                <tr>
                <th scope="row">Data de vencimento</th>
                <td>{!! $renovacao->data_vencimento !!}</td>
                </tr>

                <tr>
                <th scope="row">Proposta</th>
                <td>{!! $renovacao->proposta !!}</td>
                </tr>

                <tr>
                <th scope="row">endosso</th>
                <td>{!! $renovacao->endosso !!}</td>
                </tr>

                <tr>
                <th scope="row">ci</th>
                <td>{!! $renovacao->ci !!}</td>
                </tr>

                <tr>
                <th scope="row">Número</th>
                <td>{!! $renovacao->numero !!}</td>
                </tr>

            </tbody>
        </table>
    </div>

</div>