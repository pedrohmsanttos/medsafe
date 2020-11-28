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
                            <option value="titulo">Título</option>
                            <option value="situacao">Situação</option>
                            <option value="organizacao_id">Organização</option>
                            <option value="pessoa_id">Pessoa</option>
                            <option value="status">Status</option>
                            <option value="data_criacao">Data Criação</option>
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
                        <div id="valorStatus">
                            <select id="status_negocio">
                                <option value="">Selecione o Status</option>
                                @foreach( status_negocio() as $key => $status)
                                    <option value="{{ $key }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="valorOrganizacao">
                            <select data-live-search="true" id="organizacao">
                                <option value="">Selecione a Organização</option>
                                @foreach($organizacoes as $organizacao)
                                    <option value="{{ $organizacao->id }}">{{ $organizacao->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="valorPessoa">
                            <select data-live-search="true" id="pessoa">
                                <option value="">Selecione a Pessoa</option>
                                @foreach($pessoas as $pessoa)
                                    <option value="{{ $pessoa->id }}">{{ $pessoa->nome }}</option>
                                @endforeach
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
                        <input type="text" id="valorData" class="form-control dataCalendarioAntes">
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
                                <a href="/negocios" class="btn btn-primary waves-effect">Limpar</a>
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