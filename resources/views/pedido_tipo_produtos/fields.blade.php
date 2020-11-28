@php $disabled = ""; $displayItens = "block"; @endphp
@if (isset($pedido))
   @php $disabled = "disabled"; $displayItens = "none"; @endphp
@endif

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
                            <select id="cliente_id" name="cliente_id" class="form-control show-tick" {{ $disabled }} data-live-search="true">
                                <option disabled selected value="">Selecione o Cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ (isset($pedido) && $pedido->cliente_id == $cliente->id ) ? "selected" : "" }}>{{ $cliente->razaoSocial() }}</option>
                                    @endforeach
                            </select>
                            <label class="error">{{$errors->first('cliente_id')}}</label>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('data_vencimento', 'Data de Vencimento*:') !!}
                            <div class="form-line {{$errors->has('data_vencimento') ? 'focused error' : '' }}">
                                @if (isset($pedido))
                                    {!! Form::text('data_vencimento', $pedido->getDataVencimento(), ['class' => 'form-control dataBaixa', 'disabled' => true]) !!}
                                @else
                                    {!! Form::text('data_vencimento', null, ['class' => 'form-control dataBaixa']) !!}
                                @endif
                            </div>
                            <label class="error">{{$errors->first('data_vencimento')}}</label>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('produto_id', 'Produto*:') !!}
                            <select id="produto_id" name="produto_id" class="form-control show-tick" {{ $disabled }}>
                                <option disabled selected value="">Selecione o Produto</option>
                                    @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}" {{ ( isset($pedidoTipoProduto) && $pedidoTipoProduto->produto_id == $produto->id ) ? "selected" : "" }} >{{ $produto->descricao }}</option>
                                    @endforeach
                            </select>
                            <label class="error">{{$errors->first('produto_id')}}</label>
                        </div>
                    </div>

                    <!-- Categoria Produto Id Field -->
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('categoria_produto_id', 'Categoria*:') !!}
                            <select id="categoria_produto_id" name="categoria_produto_id" class="form-control show-tick" {{ $disabled }}>
                                <option disabled selected value="">Selecione o Categoria do Produto</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ ( isset($pedidoTipoProduto) && $pedidoTipoProduto->categoria_produto_id == $categoria->id ) ? "selected" : "" }} >{{ $categoria->descricao }}</option>
                                    @endforeach
                            </select>
                            <label class="error">{{$errors->first('categoria_produto_id')}}</label>
                        </div>
                    </div>
                    <!-- ./Categoria Produto Id Field -->

                    <!-- Tipo Produto Id Field -->
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('tipo_produto_id', 'Tipo do Produto*:') !!}
                            <select id="tipo_produto_id" name="tipo_produto_id" class="form-control show-tick" {{ $disabled }}>
                                <option disabled selected value="">Selecione o Tipo do Produto</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}" {{ ( isset($pedidoTipoProduto) && $pedidoTipoProduto->tipo_produto_id == $tipo->id ) ? "selected" : "" }} >{{ $tipo->descricao }}</option>
                                    @endforeach
                            </select>
                            <label class="error">{{$errors->first('tipo_produto_id')}}</label>
                        </div>
                    </div>
                    <!-- ./Tipo Produto Id Field -->
                </div>

                <div class="row"> 
                    <div class="col-mod-12" style="display: none">
                        <table id="dataTableNegocio" class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Valor</th>
                                    <th>Parcelas</th>
                                    <th>Prestações</th>
                                </tr>
                            </thead>
                            <tbody id="dynamicTable">

                            </tbody>
                        </table>
                    </div>
                    <!-- Valor Field -->
                    <div class="col-md-4" style="display:{{$displayItens}}">
                        <div class="form-group">
                            <label for="valor">Valor do produto escolhido*:</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <div class="form-line {{$errors->has('valor') ? 'focused error' : '' }}">
                                    @if(empty($negocio->valor))
                                    <input class="form-control dinheiro" name="valor" type="numeric" id="valor"> @else
                                    <input disabled class="form-control dinheiro" name="valor" type="numeric" id="valor" value="{{ $negocio->getValor() }}"> @endif
                                    <input name="tabela_preco_id" id="tabela_preco_id" type="hidden" value="0">
                                </div>
                                <label class="error">{{$errors->first('valor')}}</label>
                            </div>
                        </div>
                    </div>

                    <!-- ./Valor Field -->

                    <!-- Quantidade Field -->
                    <div class="col-md-4" style="display:{{$displayItens}}">
                        <div class="form-group">
                            {!! Form::label('quantidade', 'Quantidade:') !!}
                            <div class="form-line {{$errors->has('quantidade') ? 'focused error' : '' }}">
                                {!! Form::number('quantidade', null, ['class' => 'form-control', 'min'=>'1','id'=> 'qtd']) !!}
                            </div>
                            <label class="error">{{$errors->first('quantidade')}}</label>
                        </div>
                    </div>
                    <!-- ./Quantidade Field -->

                    <!-- Total Field -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="valor">Total:</label>
                            <div class="input-group">
                                <span id="total"class="input-group-addon">R$ {!! ( isset($pedido) && !empty($pedido->valor_total)) ? number_format($pedido->valor_total, 2, ',', '.') : "0,00" !!}</span>
                                <label class="error">{{$errors->first('valor')}}</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="qtd_parcela" id="qtd_parcela">
                    <input type="hidden" name="valor_parcela" id="valor_parcela">

                    <!-- ./Total Field -->
                    <div class="col-md-4" style="display:{{$displayItens}}">
                        <div class="form-group">
                            <a id="adicionarItem" class="btn btn-success waves-effect pull-right" style="margin-top:-75px;" href="javascript:void(0);">Adicionar item(ns)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
    ITENS DO PEDIDO
 -->
    @php $displayItens = "none"; @endphp
 @if (isset($itens))
    @php $displayItens = "block"; @endphp
 @endif

<div id="conteudo" class="row" style="display:{{$displayItens}};">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2>
                    ITENS DO PEDIDO
                </h2>
                
            </div>
            <div class="body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable" id="pedidos">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Produto</center>
                                    </th>
                                    <th>
                                        <center>Tipo Produto</center>
                                    </th>
                                    <th>
                                        <center>Categoria Produto</center>
                                    </th>
                                    <th>
                                        <center>Valor Unitário</center>
                                    </th>
                                    <th>
                                        <center>Quantidade</center>
                                    </th>
                                    <th>
                                        <center>Valor Total</center>
                                    </th>
                                    <th>
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="pedidosDynamicTable">
                                @if (isset($itens))
                                    @foreach($itens as $item)
                                        <tr>
                                            <td>
                                                <center>{!! $item->produto()->first()->descricao !!}</center>
                                            </td>
                                            <td>
                                                <center>{!! $item->tipoProduto()->first()->descricao !!}</center>
                                            </td>
                                            <td>
                                                <center>{!! $item->categoriaProduto()->first()->descricao !!}</center>
                                            </td>
                                            <td>
                                                <center>R$ {!! number_format($item->valor, 2, ',', '.') !!}</center>
                                            </td>
                                            <td>
                                                <center>{!! $item->quantidade !!}</center>
                                            </td>
                                            <td>
                                                <center>R$ {!! number_format($item->valor_final, 2, ',', '.')   !!}</center>
                                            </td>
                                        </tr>
                                    @endforeach  
                                @endif
                                
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