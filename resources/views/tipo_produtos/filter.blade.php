<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    Filtros
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-3">
                        <select id="filtro">
                            <option value="">Selecione o filtro</option>
                            <option value="orderBy">Ordernar por</option>
                            <option value="igual">Igual a</option>
                            <option value="contem">Contém</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="campo">
                            <option value="">Selecione o campo</option>
                            <option value="situacao">Situação</option>
                            <option value="descricao">Descrição</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-line">
                        <div id="valorOrdem">
                            <select id="sortedBy">
                                <option value="">Selecione a ordem</option>
                                <option value="asc">Crescente</option>
                                <option value="desc">Decrescente</option>
                            </select>
                        </div>
                        <div id="valorSituacao">
                            <select id="status">
                                <option value="">Selecione a situação</option>
                                <option value="all">Todos</option>
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>
                        <input type="text" id="valor" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <a href="javascript:void(0)" class="add btn btn-success waves-effect">Adicionar filtro</a>
                    </div>
                </div>
                <div class="row table-responsive">
                    <table class="table" id="filtros">
                        <thead>
                            <th>Filtro</th>
                            <th>Campo</th>
                            <th>Valor</th>
                            <th>
                            @if(count($filters) > 0)
                                <a href="/tipoProdutos" class="btn btn-primary waves-effect">Limpar</a>
                            @endif
                            </th>
                        </thead>
                        <tbody>
                            @if(count($filters) > 0)
                                @foreach($filters as $filter)
                                    <tr class="teste">
                                        <td class="center" id="tr-init">{{ $filter->filtro }}</td>
                                        <td class="center" id="tr-init">{{ $filter->campo }}</td>
                                        <td class="center" id="tr-init">{{ $filter->valor }}</td>
                                        <td class="center" id="tr-init">  </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="teste">
                                    <td class="center" colspan="4" id="tr-init">Não existem filtros cadastrados</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>