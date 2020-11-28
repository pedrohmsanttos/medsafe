<div id="beneficio" class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="beneficios-table">
        <thead>
            <tr>
                <th>Apolice Nº</th>
                <th>Nome</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            @foreach($apolices as $apolice)
                <tr>
                    <td colspan="3">Apólice {!! $apolice->id !!}</td>
                </tr>
                @foreach($apolice->beneficios()->get() as $beneficio)
                    <tr>
                        <td></td>
                        <td>{!! $beneficio->nome !!}</td>
                        <td>{!! $beneficio->valor !!}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>