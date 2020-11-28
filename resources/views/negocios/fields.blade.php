@php
    if(!isset($negocio_cp)){
        $dis = 'disabled';
    }else{
        $dis = '';
    }
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    DADOS DO SOLICITANTE
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <!-- Nome titular Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('nome', 'Nome*:') !!}
                            <div class="form-line {{$errors->has('nome') ? 'focused error' : '' }}">
                            @if($negocio->pessoa()->first() != null)
                                <input type="hidden" id="pessoa_id" name="pessoa_id" value="{{ $negocio->pessoa()->first()->id }}">
                                {!! Form::text('nome', $negocio->pessoa()->first()->nome, ['class' => 'form-control', 'placeholder' => ''.$negocio->pessoa()->first()->nome.'', $dis]) !!}
                            @elseif($negocio->organizacao()->first() != null)
                                <input type="hidden" id="organizacao_id" name="organizacao_id" value="{{ $negocio->organizacao()->first()->id }}">
                                {!! Form::text('nome', $negocio->organizacao()->first()->nome, ['class' => 'form-control', 'placeholder' => ''.$negocio->organizacao()->first()->nome.'', $dis]) !!}
                            @else
                                {!! Form::text('nome', null, ['class' => 'form-control']) !!}
                            @endif
                            </div>
                            <label class="error">{{$errors->first('nome')}}</label>
                        </div>
                    </div>

                    <!-- Telefone Field -->
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('telefone', 'Telefone*:') !!}
                            <div class="form-line {{$errors->has('telefone') ? 'focused error' : '' }}">
                                @if($negocio->pessoa()->first() != null)
                                    {!! Form::text('telefone', $negocio->pessoa()->first()->telefone, ['class' => 'form-control telefone fone', 'placeholder' => ''.$negocio->pessoa()->first()->telefone.'', $dis]) !!}
                                @elseif($negocio->organizacao()->first() != null)
                                    {!! Form::text('telefone', $negocio->organizacao()->first()->telefone, ['class' => 'form-control telefone fone', 'placeholder' => ''.$negocio->organizacao()->first()->telefone.'', $dis]) !!}
                                @else
                                    {!! Form::text('telefone', null, ['class' => 'form-control telefone fone']) !!}
                                @endif
                            </div>
                            <label class="error">{{$errors->first('telefone')}}</label>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('email', 'E-mail*:') !!}
                            <div class="form-line {{$errors->has('email') ? 'focused error' : '' }}">
                                @if($negocio->pessoa()->first() != null)
                                        {!! Form::text('email', $negocio->pessoa()->first()->email, ['class' => 'form-control email', 'placeholder' => ''.$negocio->pessoa()->first()->email.'', $dis]) !!}
                                @elseif($negocio->organizacao()->first() != null)
                                        {!! Form::text('email', $negocio->organizacao()->first()->email, ['class' => 'form-control email', 'placeholder' => ''.$negocio->organizacao()->first()->email.'', $dis]) !!}
                                @else
                                    {!! Form::text('email', null, ['class' => 'form-control email']) !!}
                                @endif
                            </div>
                            <label class="error">{{$errors->first('email')}}</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="demo-radio-button">
                            @if($negocio->pessoa()->first() != null || $negocio->organizacao()->first() != null)
                            <input type="radio" id="tipopessoa_1" value="1" name="tipopessoa" {{ ( ($negocio->pessoa()->first() != null || $negocio->organizacao()->first() != null ) && !isset($negocio_cp)) ? 'disabled' : '' }}  {{ ($negocio->pessoa()->first() != null ) ? 'checked' : '' }} onclick="$('#dvfaturamento').css('display', 'none' );" />
                            <label for="tipopessoa_1">Pessoa Física</label>
                            <input type="radio" id="tipopessoa_2" value="2" name="tipopessoa"  {{ ( ($negocio->pessoa()->first() != null || $negocio->organizacao()->first() != null) && !isset($negocio_cp) ) ? 'disabled' : '' }}  {{ ($negocio->pessoa()->first() == null ) ? 'checked' : '' }} onclick="$('#dvfaturamento').css('display', 'block' );" />
                            <label for="tipopessoa_2">Pessoa Jurídica</label>
                            @else
                            <input type="radio" id="tipopessoa_1" value="1" name="tipopessoa" {{ ($negocio->pessoa()->first() != null || $negocio->organizacao()->first() != null) ? 'disabled' : '' }}  {{ (old('tipopessoa') == 1) ? 'checked' : '' }}  onclick="$('#dvfaturamento').css('display', 'none' );" />
                            <label for="tipopessoa_1">Pessoa Física</label>
                            <input type="radio" id="tipopessoa_2" value="2" name="tipopessoa"  {{ ($negocio->pessoa()->first() != null || $negocio->organizacao()->first() != null) ? 'disabled' : '' }}  {{ (old('tipopessoa') == 2) ? 'checked' : '' }} onclick="$('#dvfaturamento').css('display', 'block' );" />
                            <label for="tipopessoa_2">Pessoa Jurídica</label>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="row" id="dvfaturamento" style="{{ ($negocio->pessoa()->first() != null) ? 'display:none;' : '' }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('organizacao_nome', 'Nome para contato:') !!}
                            <div class="form-line">
                                @if($negocio->organizacao()->first() != null)
                                <input class="form-control" name="organizacao_nome" type="text" id="organizacao_nome" value="{{$negocio->organizacao()->first()->organizacao_nome}}">
                                @else
                                <input class="form-control" name="organizacao_nome" type="text" id="organizacao_nome">
                                @endif
                            </div>
                            <label class="error">{{$errors->first('organizacao_nome')}}</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('faturamento_id', 'Faturamento Anual:') !!}
                            <select data-live-search="true" id="faturamento_id" name="faturamento_id" class="form-control show-tick"  {{ ( ($negocio->pessoa()->first() != null || $negocio->organizacao()->first() != null) && $dis == 'disabled') ? 'disabled' : '' }} >
                                <option disabled selected value="">Selecione o Faturamento Anual</option>
                            @if(!empty($faturamentos))
                                @if($negocio->organizacao()->first() != null)
                                    @foreach($faturamentos as $faturamento)
                                        <option value="{{$faturamento->id}}" {{ ($faturamento->id == $negocio->organizacao()->first()->faturamento_id) ? 'selected' : '' }}>{{$faturamento->descricao}}</option>
                                    @endforeach
                                @else        
                                    @foreach($faturamentos as $faturamento)
                                        <option value="{{$faturamento->id}}" {{ ($faturamento->id == old('faturamento_id')) ? 'selected' : '' }}>{{$faturamento->descricao}}</option>
                                    @endforeach
                                @endif
                            @endif
                            </select>
                            <label class="error">{{$errors->first('faturamento_id')}}</label>
                        </div>
                    </div>
                </div>

                @include('enderecos.fields')
            </div>
        </div>    
    </div>    
</div>    

@if(empty($negocio->itens()->first()) || isset($negocio_cp))
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    Produtos e Serviços 
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li style="cursor: pointer;">
                        <a data-toggle="modal" data-target="#largeModal">
                            <i class="material-icons">shopping_cart</i>
                            <span class="badge">%% ngCart.getTotalItems() %%</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" id="itens" name="itens" ng-model="itens" value="%% ngCart.getCart().items %%">
                            {!! Form::label('produto_id', 'Produto/Serviço*:') !!}
                            <select ng-model="produto" ng-change="getTabelaDePreco()" data-live-search="true" id="produto_id" name="produto_id" class="form-control show-tick"  {{ (($negocio->pessoa()->first() != null || $negocio->organizacao()->first() != null) && empty($negocio->copia)) ? 'disabled' : '' }} >
                                <option disabled selected value="">Selecione o Produto</option>
                                @if(!empty($produtos))
                                    @if($negocio->produtos()->first() != null)
                                        @foreach($produtos as $produto)
                                            <option value="{{$produto->id}}" {{ ($produto->id == $negocio->produtos()->first()->produto()->first()->id) ? 'selected' : '' }}>{{$produto->descricao}}</option>
                                        @endforeach
                                    @else   
                                        @foreach($produtos as $produto)
                                            <option value="{{$produto->id}}" {{ ($produto->id == old('produto_id')) ? 'selected' : '' }}>{{$produto->descricao}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                            <label class="error">{{$errors->first('produto_id')}}</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('categoria_produto_id', 'Categoria*:') !!}
                            <select ng-model="categoria" ng-change="getTabelaDePreco()" data-live-search="true" id="categoria_produto_id" name="categoria_produto_id" class="form-control show-tick"  (($negocio->pessoa()->first() != null || $negocio->organizacao()->first() != null) && empty($negocio->copia)) ? 'disabled' : '' }} >
                                <option disabled selected value="">Selecione o Categoria do Produto</option>
                                @if(!empty($categorias))
                                    @if($negocio->produtos()->first() != null)
                                        @foreach($categorias as $categoria)
                                            <option value="{{$categoria->id}}" {{ ($categoria->id == $negocio->produtos()->first()->categoriaProduto()->first()->id) ? 'selected' : '' }}>{{$categoria->descricao}}</option>
                                        @endforeach
                                    @else    
                                        @foreach($categorias as $categoria)
                                            <option value="{{$categoria->id}}" {{ ($categoria->id == old('categoria_produto_id')) ? 'selected' : '' }}>{{$categoria->descricao}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                            <label class="error">{{$errors->first('categoria_produto_id')}}</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('tipo_produto_id', 'Plano*:') !!}
                            <select ng-model="tipoProduto" ng-change="getTabelaDePreco()" data-live-search="true" id="tipo_produto_id" name="tipo_produto_id" class="form-control show-tick" (($negocio->pessoa()->first() != null || $negocio->organizacao()->first() != null) && empty($negocio->copia)) ? 'disabled' : '' }} >
                                <option disabled selected value="">Selecione o Tipo do Produto</option>
                            @if(!empty($tipos))
                                @if($negocio->produtos()->first() != null)
                                    @foreach($tipos as $tipo)
                                        <option value="{{$tipo->id}}" {{ ($tipo->id == $negocio->produtos()->first()->tipoProduto()->first()->id) ? 'selected' : '' }}>{{$tipo->descricao}}</option>
                                    @endforeach
                                @else    
                                    @foreach($tipos as $tipo)
                                        <option value="{{$tipo->id}}" {{ ($tipo->id == old('tipo_produto_id')) ? 'selected' : '' }}>{{$tipo->descricao}}</option>
                                    @endforeach
                                @endif
                            @endif
                            </select>
                            <label class="error">{{$errors->first('tipo_produto_id')}}</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-mod-12">
                        <div class="body table-responsive">
                            <table id="dataTableNegocio" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Valor</th>
                                        <th>Quantidade</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody ng-show="list.length === 0">
                                    <tr>
                                        <td colspan='3'>
                                            <p style='text-align: center;' class='font-bold col-red' >
                                                Não há tabela de preço cadastrada para a combinação selecionada.
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody ng-repeat="tabela in list">
                                    <tr style="padding-top: 10px;">
                                        <th>%% tabela.valor | currency:"R$" %%</th>
                                        <th>
                                            <div class="form-group form-group-sm">
                                                <div class="form-line">
                                                    <input type="number" id="quantidade" name="quantidade" ng-model="quantidade" value="1" class="form-control">
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <button type="button" class="btn btn-success waves-effect" onclick="memsagemAddItem()" ng-click="ngCart.addItem(tabela.id, titulo, tabela.valor, quantidade)">
                                                
                                                ADICIONAR
                                            </button>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="body" style="background: #f4f4f4;">
                                <div class="alert alert-warning" role="alert" ng-show="ngCart.getTotalItems() === 0">
                                    Seu carrinho está vazio!
                                </div>

                                <div style="display: contents;" class="table-responsive col-lg-12" ng-show="ngCart.getTotalItems() > 0">
                                    <table class="table table-striped ngCart cart">

                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Quantidade</th>
                                            <th>Valor</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr ng-show="ngCart.getTax()">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Taxa (%% ngCart.getTaxRate() %% %):</td>
                                            <td>%% ngCart.getTax() | currency:'R$' %%</td>
                                        </tr>
                                        <tr ng-show="ngCart.getShipping()">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Encargos:</td>
                                            <td>%% ngCart.getShipping() | currency:'R$' %%</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total:</td>
                                            <td>%% ngCart.totalCost() | currency:'R$' %%</td>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        <tr ng-repeat="item in ngCart.getCart().items track by $index">
                                            <td><span ng-click="ngCart.removeItemById(item.getId())" class="glyphicon glyphicon-remove"></span></td>

                                            <td>%% item.getName() %%</td>
                                            <td><span class="glyphicon glyphicon-minus" ng-class="{'disabled':item.getQuantity()==1}"
                                                    ng-click="item.setQuantity(-1, true)"></span>&nbsp;&nbsp;
                                                %% item.getQuantity() | number %%&nbsp;&nbsp;
                                                <span class="glyphicon glyphicon-plus" ng-click="item.setQuantity(1, true)"></span></td>
                                            <td>%% item.getPrice() | currency:'R$' %%</td>
                                            <td>%% item.getTotal() | currency:'R$' %%</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@else
<!-- Itens -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    Produtos e Serviços 
                </h2>
            </div>
            <div class="body">
                <div class="row">
                        <div class="table-responsive col-lg-12" ng-show="ngCart.getTotalItems() > 0">
                            <table class="table table-striped ngCart cart">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Valor</th>
                                        <th>Qnt</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td>{{ 'R$ ' . number_format((float) $negocio->valor, 2, ',', '.') }}</td>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($negocio->itens()->get() as $item)
                                        <tr>
                                            <td>{{ $item->tabelaPreco()->first()->titulo() }}</td>
                                            <td>{{ 'R$ ' . number_format((float) $item->valor, 2, ',', '.') }}</td>
                                            <td>{{ $item->quantidade }}</td>
                                            <td>{{ 'R$ ' . number_format((float) $item->subTotal(), 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    DADOS NEGÓCIO
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <!-- Título Field -->
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Título*:') !!}
                            <div class="form-line {{$errors->has('titulo') ? 'focused error' : '' }}">
                                {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                            </div>
                            <label class="error">{{$errors->first('titulo')}}</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <!-- Usuario Operacao Id Field -->
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('usuario_operacao_id', 'Usuário da operação:') !!}
                            <select id="usuario_operacao_id" name="usuario_operacao_id" class="form-control show-tick" >
                                <option disabled selected value="">Selecione o usuário</option>
                                @if(!empty($usuarios))
                                    @foreach($usuarios as $usuario)
                                        @if(empty($negocio->id))
                                            <option value="{{$usuario->id}}" {{ ($usuario->id == $currentUser->id) ? 'selected' : ''}} {{ (\Entrust::ability(['super_user'], [])) ? '' : 'disabled' }} >{{$usuario->name}}</option>
                                        @else
                                            <option value="{{$usuario->id}}" {{ ($usuario->id == $negocio->usuario_operacao_id) ? 'selected' : ''}} {{ (\Entrust::ability(['super_user'], [])) ? '' : 'disabled' }} >{{$usuario->name}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @if (!\Entrust::ability(['super_user'], []))
                                <input type="hidden" value="{{ $currentUser->id }}" id="usuario_operacao_id" name="usuario_operacao_id" />
                            @endif
                            <label class="error">{{$errors->first('usuario_operacao_id')}}</label>
                        </div>
                    </div>
                    <!-- ./Usuario Operacao Id Field -->

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('data_criacao', 'Data Negócio*:') !!}
                            <div id="datepicker_component_container_1" class="form-line {{$errors->has('data_criacao') ? 'focused error' : '' }}">
                              
                                @if( is_null($negocio->getDataNegocio()) ) 
                                    {!! Form::text('data_criacao', null,['class' => 'form-control', "autocomplete"=>"off"]) !!}
                                @else
                                    <input class="form-control" name="data_criacao" autocomplete="off" type="text" value="{{ $negocio->getDataNegocio() }}" id="data_criacao">
                                @endif
                            </div>
                            <label class="error">{{$errors->first('data_criacao')}}</label>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('status', 'Status Negócio:') !!}
                            <select id="status" name="status" class="form-control show-tick" disabled>
                                <option disabled selected value="">Selecione o Status</option>
                                @if(trim($negocio->status) != "")
                                    @foreach(status_negocio() as $i => $status)
                                        <option value="{{$i}}" {{ (trim($i) == trim($negocio->status)) ? 'selected' : '' }}>{{$status}}</option>
                                    @endforeach
                                @else
                                    @foreach(status_negocio() as $i => $status)
                                        <option value="{{$i}}" {{ (trim($i) == trim('0')) ? 'selected' : '' }}>{{$status}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label class="error">{{$errors->first('status')}}</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>    
    </div>    
</div>    

@if($negocio->status == 2 && !isset($negocio_cp))
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    LANÇAMENTOS A RECEBER
                </h2>
                <ul class="header-dropdown ">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                           <li><a href="javascript:void(0);" id="baixar" class=" waves-effect waves-block">Baixar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            
            <div class="body">
                <div class="row">
                @include('lancamento_recebers.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(isset($negocio_cp))
    <div ng-app="MedSafer" ng-controller="Negocio" ng-init="clearCart()"></div>
@endif

<!-- Itens -->
<div class="modal fade right" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-full-height modal-right modal-notify" role="document" >
        <div class="modal-content" style="width: 100% !important;">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="modal-title" id="largeModalLabel">Carrinho</h4>
                    </div>
                    <div class="col-md-6">
                        <div style="float:right;">
                            <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves-float close">
                                <i class="material-icons">close</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert" ng-show="ngCart.getTotalItems() === 0">
                    Seu carrinho está vazio!
                </div>

                <div class="table-responsive col-lg-12" ng-show="ngCart.getTotalItems() > 0">
                    <table class="table table-striped ngCart cart">

                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Quantidade</th>
                            <th>Valor</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr ng-show="ngCart.getTax()">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Taxa (%% ngCart.getTaxRate() %% %):</td>
                            <td>%% ngCart.getTax() | currency:'R$' %%</td>
                        </tr>
                        <tr ng-show="ngCart.getShipping()">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Encargos:</td>
                            <td>%% ngCart.getShipping() | currency:'R$' %%</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total:</td>
                            <td>%% ngCart.totalCost() | currency:'R$' %%</td>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr ng-repeat="item in ngCart.getCart().items track by $index">
                            <td><span ng-click="ngCart.removeItemById(item.getId())" class="glyphicon glyphicon-remove"></span></td>

                            <td>%% item.getName() %%</td>
                            <td><span class="glyphicon glyphicon-minus" ng-class="{'disabled':item.getQuantity()==1}"
                                    ng-click="item.setQuantity(-1, true)"></span>&nbsp;&nbsp;
                                %% item.getQuantity() | number %%&nbsp;&nbsp;
                                <span class="glyphicon glyphicon-plus" ng-click="item.setQuantity(1, true)"></span></td>
                            <td>%% item.getPrice() | currency:'R$' %%</td>
                            <td>%% item.getTotal() | currency:'R$' %%</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <!-- Submit Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary waves-effect']) !!}
            <a href="{!! route('negocios.index') !!}" class="btn btn-default waves-effect">Cancelar</a>
        </div>
    </div>
</div>
