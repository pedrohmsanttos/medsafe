@if(!\Entrust::ability('cliente_user', ''))
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    DADOS PEDIDO
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('cliente_id', 'Cliente*:') !!}
                            <select id="cliente_id" name="cliente_id" class="form-control show-tick" data-live-search="true">
                                <option disabled selected value="">Selecione o Cliente</option>
                                    @if(isset($pedido_cp->cliente_id))
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ (old('cliente_id',$pedido_cp->cliente_id) == $cliente->id) ? "selected" : "" }}>{{ $cliente->nomeFantasia }}</option>
                                        @endforeach
                                    @else
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ (old('cliente_id') == $cliente->id) ? "selected" : "" }}>{{ $cliente->nomeFantasia }}</option>
                                        @endforeach
                                    @endif
                            </select>
                            <label class="error">{{$errors->first('cliente_id')}}</label>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('data_vencimento', 'Data de Vencimento*:') !!}
                            <div id="datepicker_component_container_1" class="form-line {{$errors->has('data_vencimento') ? 'focused error' : '' }}">
                                @if (isset($pedido))
                                    {!! Form::text('data_vencimento', $pedido->getDataVencimento(), ["autocomplete"=>"off", 'class' => 'form-control', 'disabled' => true]) !!}
                                @else
                                    {!! Form::text('data_vencimento', null, ["autocomplete"=>"off", 'class' => 'form-control']) !!}
                                @endif
                            </div>
                            <label class="error">{{$errors->first('data_vencimento')}}</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('beneficio_terceiros', 'Seguro em benefício de terceiros*:') !!}
                            <div class="form-line {{$errors->has('beneficio_terceiros') ? 'focused error' : '' }}">
                                @if(!empty($pedido->beneficio_terceiros))
                                    <select id="beneficio_terceiros" name="beneficio_terceiros" class="form-control show-tick" disabled>
                                        <option disabled selected value="">Selecione uma opção</option>
                                        <option value="SIM" {{$pedido->beneficio_terceiros=='SIM' ? 'selected' : ''}}>SIM</option>
                                        <option value="NAO" {{$pedido->beneficio_terceiros=='NAO' ? 'selected' : ''}}>NÃO</option>
                                    </select>
                                @else
                                    <select id="beneficio_terceiros" name="beneficio_terceiros" class="form-control show-tick">
                                        <option disabled selected value="">Selecione uma opção</option>
                                        <option value="SIM" {{ (old('beneficio_terceiros')=='SIM') ? 'selected' : ''}}>SIM</option>
                                        <option value="NAO" {{ (old('beneficio_terceiros')=='NAO') ? 'selected' : ''}}>NÃO</option>
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>
                <div id="endereco">
                <div class="row">
                <!-- NOME completo Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('nome_completo', 'Nome Completo*:') !!}
                            <div class="form-line {{$errors->has('nome_completo') ? 'focused error' : '' }}">
                                {!! Form::text('nome_completo', null, ['class' => 'form-control']) !!}
                            </div>
                            <label class="error">{{$errors->first('nome_completo')}}</label>
                        </div>
                    </div>
                <!-- ./NOME completo Field -->

                <!-- email Field -->
                <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email', 'Email*:') !!}
                            <div class="form-line {{$errors->has('email') ? 'focused error' : '' }}">
                                {!! Form::email('email', null, ['class' => 'form-control']) !!}
                            </div>
                            <label class="error">{{$errors->first('email')}}</label>
                        </div>
                    </div>
                <!-- ./email Field -->

                <!-- cpf Field -->
                <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('cpf', 'Cpf*:') !!}
                            <div class="form-line {{$errors->has('cpf') ? 'focused error' : '' }}">
                                {!! Form::text('cpf', null, ['class' => 'form-control cpf']) !!}
                            </div>
                            <label class="error">{{$errors->first('cpf')}}</label>
                        </div>
                    </div>
                <!-- ./cpf Field -->

                <!-- telefone Field -->
                <div class="col-md-6">
                        <div class="form-group">
                        <div class="form-group">
                        {!! Form::label('telefone', 'Telefone*:') !!}
                        <div class="form-line {{$errors->has('telefone') ? 'focused error' : '' }}">
                            @if(!empty($pedido->telefone))
                                <input type="text" name="telefone", class="form-control telefone fone" value="{!! !empty($pedido->telefone) ? $pedido->telefone : ''  !!}">
                            @else
                                <input type="text" name="telefone", class="form-control telefone fone" value="{!! (old('telefone')) !!}">
                            @endif
                        </div>
                        <label class="error">{{$errors->first('telefone')}}</label>
                        </div>
                        </div>
                </div>
                <!-- ./telefone Field -->

                </div>

                @include('enderecos.fields')
                
                </div>

            </div>
        </div>
    </div>
</div>
@else
<input type="hidden" id="cliente_id" name="cliente_id" value="{{ Auth::user()->cliente()->first()->id }}">
<input type="hidden" id="data_vencimento" name="data_vencimento" value="{{ date('Y-m-d') }}">
@endif

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
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" id="itens" name="itens" ng-model="itens" value="%% ngCart.getCart().items %%">
                            {!! Form::label('produto_id', 'Produto/Serviço*:') !!}
                            <select ng-model="produto" ng-change="getTabelaDePreco()" data-live-search="true" id="produto_id" name="produto_id" class="form-control show-tick" >
                                <option disabled selected value="">Selecione o Produto</option>
                                @foreach($produtos as $produto)
                                    <option value="{{$produto->id}}" {{ ($produto->id == old('produto_id')) ? 'selected' : '' }}>{{$produto->descricao}}</option>
                                @endforeach
                            </select>
                            <label class="error">{{$errors->first('produto_id')}}</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('categoria_produto_id', 'Categoria*:') !!}
                            <select ng-model="categoria" ng-change="getTabelaDePreco()" data-live-search="true" id="categoria_produto_id" name="categoria_produto_id" class="form-control show-tick" >
                                <option disabled selected value="">Selecione o Categoria do Produto</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{$categoria->id}}" {{ ($categoria->id == old('categoria_produto_id')) ? 'selected' : '' }}>{{$categoria->descricao}}</option>
                                @endforeach
                            </select>
                            <label class="error">{{$errors->first('categoria_produto_id')}}</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('tipo_produto_id', 'Plano*:') !!}
                            <select ng-model="tipoProduto" ng-change="getTabelaDePreco()" data-live-search="true" id="tipo_produto_id" name="tipo_produto_id" class="form-control show-tick" >
                                <option disabled selected value="">Selecione o Tipo do Produto</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{$tipo->id}}" {{ ($tipo->id == old('tipo_produto_id')) ? 'selected' : '' }}>{{$tipo->descricao}}</option>
                                @endforeach
                            </select>
                            <label class="error">{{$errors->first('tipo_produto_id')}}</label>
                        </div>
                    </div>
                </div>
                @if(isset($pedido_cp))
                    <div ng-app="MedSafer" ng-controller="Negocio" ng-init="clearCart()"></div>
                @endif
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
                                            <button type="button" onclick="memsagemAddItem()" class="btn btn-success waves-effect" ng-click="ngCart.addItem(tabela.id, titulo, tabela.valor, quantidade)">
                                                ADICIONAR
                                            </button>
                                        </th>
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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    ITENS DO PEDIDO
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div style="    text-align: center;" class="alert alert-warning" role="alert" ng-show="ngCart.getTotalItems() === 0">
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
</div>

@if(isset($pedido))
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
                <p id="selecionados" ></p>
            </div>
        </div>
    </div>
</div>
@endif

<input type="hidden" name="itens_pedido" id="itens_pedido">


<div class="row">
    <!-- Submit Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary waves-effect' , 'id'=>"btnSave"]) !!}
            <a href="{!! route('pedidoTipoProdutos.index') !!}" class="btn btn-default waves-effect">Cancelar</a>
        </div>
    </div>
</div>

