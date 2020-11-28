@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    <link href="{{asset('plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />

@section('content')
    @include('flash::message')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Informe os dados para o cadastro 
                    </h2>
                </div>

                <div class="body">
                    <br>
                    @include('adminlte-templates::common.errors')
                    {!! Form::open(['route' => 'pedidoTipoProdutos.store']) !!}

                        @include('pedido_tipo_produtos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jquery.maskMoney.min.js')}}"></script>
    <script src="{{asset('js/mask.js')}}"></script>
    <script src="{{asset('js/cep.js')}}"></script>
    <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>        
        var produto, categoria, tipo = 0;
        var tabelaPrecos = [];
        var url = '/api/v1/tabelapreco?search=';
        var boolean   = '&searchJoin=and';
        var inHTML = "";
        var inHTML1 = "";
        var desconto = 0;
        var itemId = 1;
        var qtd = 0;
        var plano;
        var valor;
        var result;
        // var itens = [];
        var itens = new Array();


        var ItemPedido = function(itemId, produto, produtoId, tipoProduto, tipoProdutoId, categoria, categoriaId, valorU, quantidade,qtdParcela,valorParcela,total) {
            this.itemId         = itemId;
            this.produto        = produto;
            this.produtoId      = produtoId;
            this.tipoProduto    = tipoProduto;
            this.tipoProdutoId  = tipoProdutoId;
            this.categoria      = categoria;
            this.categoriaId    = categoriaId;
            this.valorU         = valorU;
            this.quantidade     = quantidade;
            this.qtdParcela     = qtdParcela;
            this.valorParcela   = valorParcela; 
            this.total          = total;
        };

        var categoriaText, produtoText, tipoProdutoText;

        $('#produto_id').on('change',function() {
            console.log($(this).val());
            produto = $(this).val();
            produtoText = $(this).children("option:selected").text();
            //getTablelaPreco();
        });

        $('#categoria_produto_id').on('change',function() {
            console.log($(this).val());
            categoria = $(this).val();
            categoriaText = $(this).children("option:selected").text();
            //getTablelaPreco();
        });

        $('#tipo_produto_id').on('change',function() {
            console.log($(this).val());
            tipo = $(this).val();
            tipoProdutoText = $(this).children("option:selected").text();
            //getTablelaPreco();
        });

        $('#desconto').on('change',function() {
            console.log($(this).val());
            desconto = $(this).val();
            $('font#desconto').html(desconto);
            $('font#valorTotal').html(plano-desconto);
        });

        $('input[name=valor]').on('change',function() {
            valor = $('#valor').val();
            valor = valor.substr(2,(valor.length))
            $('#valor').val(valor);
            
            valor = getMoney(valor);

            atualizaValor()
        });


        function atualizaValor(){
            if($.trim($("#valor").val()) != "" && $.trim($("#qtd").val()) != ""){
                var valor = $.trim($("#valor").val()).replace(".", "");
                valor = parseFloat(valor.replace(",", "."));
                var qtd   = parseFloat($.trim($("#qtd").val()).replace(",", "."));
                
                var total = valor * qtd;
                var labelTotal = total.toFixed(2).toString().replace(".", ",");
                $('#total').html("R$ "+labelTotal);
            }   
        }

        $('#qtd').on('change',function() {
            qtd = parseFloat($(this).val());
            console.log(valor,"trem");
            //valor = getMoney(valor);
            result = (valor * qtd).toFixed(2);
            result = formatReal(result.toString().replace('.',''));
            console.log(valor,qtd,"=",result,formatReal(result));
            // $('#total').html("R$ "+result);

            atualizaValor()
        });

        var setPlano = function(planoSelecionado, idPlano, valorParcela = null, qtdParcela = null){
            plano = planoSelecionado;
            if (plano.toString().indexOf(".") == -1){
                plano = plano.toString();
                plano = plano + "00";
                plano = formatReal(plano);
               
            }else{
                plano = formatReal(plano.toString().replace('.',''));
            }
            
            console.log( getMoney(plano)+" - saida");
            console.log(planoSelecionado +" "+ idPlano);
            valor = getMoney(plano);
            $('#valor').val(plano);
            $('#tabela_preco_id').val(idPlano);

            if(valorParcela != null){
                $("#valor_parcela").val(valorParcela);
            }

            if(qtdParcela != null){
                $("#qtd_parcela").val(qtdParcela);
            }

        }

        function formatReal( int ){
            var tmp = int+'';
            tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
            if( tmp.length > 6 )
                    tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

            return tmp;
        }

        function getMoney( str )
        {       temp  = str.replace(/[\D]+/g,'');

                return parseFloat(temp.substr(0,(temp.length - 2)) + "."+ temp.substr(-2));
        }

        var getTablelaPreco = function(){
            url = '/api/v1/tabelapreco?search=';
            var on1 = false;
            var on2 = false;
            var on3 = false;

            if(produto != 0 && produto != undefined){
                url += 'produto_id:'+produto+';';
                on1 = true;
            }

            if(categoria != 0 && categoria != undefined){
                url += 'categoria_produto_id:'+categoria+';';
                on2 = true;
            }

            if(tipo != 0 && tipo != undefined){
                url += 'tipo_produto_id:'+tipo+';';
                on3 = true;
            }

            console.log(url);

            if(on1 && on2 && on3){

                $('.page-loader-wrapper').fadeIn();

                $.get(url.slice(0, -1) + boolean, function(data) {
                    tabelaPrecos = data;
                    console.log(tabelaPrecos);
                    inHTML = '';
                    $.each(tabelaPrecos.data, function(index, value){

                        var qtdParcela      = value.qtd_parcela;
                        var valorParcela    = value.valor_parcela;

                        var newItem = "<tr>"
                        newItem    += "<td> <input onclick='setPlano("+value.valor+","+value.id+","+ valorParcela +","+qtdParcela+");' name='tabela' type='radio' id='tabela_preco"+value.id+"' class='with-gap radio-col-blue'> <label for='tabela_preco"+value.id+"'>Selecionar</label> <input type='hidden' id='negocio_"+value.id+"' name='negocio_"+value.id+"' value='"+value.id+"'> </td>";
                        if (value.valor.toString().indexOf(".") == -1){
                            saida = value.valor.toString();
                            saida = saida + "00";
                            saida = formatReal(saida);
                            newItem    += "<td> R$ "+saida+"</td>";
                        }else{
                            saida = formatReal(value.valor.toString().replace('.',''));
                            newItem    += "<td> R$ "+saida+"</td>";
                        }
                        
                        newItem    += "<td>"+value.qtd_parcela+"x </td>";
                        if (value.valor_parcela.toString().indexOf(".") == -1){
                            saida = value.valor_parcela.toString();
                            saida = saida + "00";
                            saida = formatReal(saida);
                            newItem    += "<td> R$ "+saida+"</td>";
                        }else{
                            saida = formatReal(value.valor_parcela.toString().replace('.',''));
                            newItem    += "<td> R$ "+saida+"</td>";
                        }
                        newItem    += "</tr>"
                        inHTML     += newItem;  
                    });
                    $("tbody#dynamicTable").empty();
                    $("tbody#dynamicTable").html(inHTML);

                    $('.page-loader-wrapper').fadeOut();
                });
            }
        }

        
        $('#adicionarItem').on('click',function(){            
            $('.page-loader-wrapper').fadeIn();
            $("#conteudo").show();
            // document.getElementById("conteudo").style.display = "block";

            var produtoId       = $('#produto_id').val();
            var tipoProdutoId   = $('#tipo_produto_id').val();
            var categoriaId     = $('#categoria_produto_id').val();
            
            var qtdParcela      = 1;
            var valorParcela    = getMoney(result);

            if($.trim($("#qtd_parcela").val()) != "" ){
                qtdParcela      = $("#qtd_parcela").val();
            }

            if($.trim($("#valor_parcela").val()) != "" ){
                valorParcela    = $("#valor_parcela").val();
            }

            var novoValor = $.trim($("#valor").val());

            itens.push(new ItemPedido(itemId, produtoText, produtoId, tipoProdutoText, tipoProdutoId, categoriaText, categoriaId, novoValor, qtd, qtdParcela, valorParcela, getMoney(result)));

            itemId++;

            console.log(itens);
            if (itens != []){

                inHTML1 = '';
                    $.each(itens, function(index, value){
                        var newItem = "<tr id='linha_"+index+"'>";
                        
                        newItem    +=  "<td> <center>"+value.produto+"</center></td>";
                        newItem    +=  "<td> <center>"+value.tipoProduto+"</center></td>";
                        newItem    +=  "<td> <center>"+value.categoria+"</center></td>";
                        newItem    +=  "<td> <center>R$ "+value.valorU+"</center></td>";
                        newItem    +=  "<td> <center>"+value.quantidade+"</center></td>";
                        newItem    += "<td> <center>R$ "+value.total.toFixed(2).toString().replace(".", ",");+"</center></td>";
                        newItem    += "<td> <center><button onclick='remove("+index+")' type='button' class='btn bg-red waves-effect'><i class='material-icons'>delete</i></button></center></td>";

                        newItem    += "</tr>"
                        inHTML1     += newItem;  
                    });

                    $("#itens_pedido").val( JSON.stringify( itens ) );

            }
            $("tbody#pedidosDynamicTable").empty();
            $("tbody#pedidosDynamicTable").html(inHTML1);
            
            $("#qtd_parcela").val("");
            $("#valor_parcela").val("");

            $('.page-loader-wrapper').fadeOut();   
        });

        var remove = function(index){
            
            $('.page-loader-wrapper').fadeIn();
            //$("#conteudo").show();

            itens = itens.splice(index);

            if (itens != []){

                inHTML1 = '';
                    $.each(itens, function(index, value){
                        var newItem = "<tr id='linha_"+index+"'>";
                        
                        newItem    +=  "<td> <center>"+value.produto+"</center></td>";
                        newItem    +=  "<td> <center>"+value.tipoProduto+"</center></td>";
                        newItem    +=  "<td> <center>"+value.categoria+"</center></td>";
                        newItem    +=  "<td> <center>R$ "+value.valorU+"</center></td>";
                        newItem    +=  "<td> <center>"+value.quantidade+"</center></td>";
                        newItem    += "<td> <center>R$ "+value.total.toFixed(2).toString().replace(".", ",");+"</center></td>";
                        newItem    += "<td> <center><button onclick='delete("+index+")' type='button' class='btn bg-red waves-effect'><i class='material-icons'>delete</i></button></center></td>";

                        newItem    += "</tr>"
                        inHTML1     += newItem;  
                    });

                    $("#itens_pedido").val( JSON.stringify( itens ) );

            }

            $("tbody#pedidosDynamicTable").empty();
            $("tbody#pedidosDynamicTable").html(inHTML1);
            
            $("#qtd_parcela").val("");
            $("#valor_parcela").val("");

            $('.page-loader-wrapper').fadeOut();  
        }

        //select all checkboxes
        $("#select_all").change(function(){  //"select all" change 
            $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change 
        $('.checkbox').change(function(){ 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(false == $(this).prop("checked")){ //if this item is unchecked
                $("#select_all").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkbox:checked').length == $('.checkbox').length ){
                $("#select_all").prop('checked', true);
            }
            var selecionados = $('.checkbox:checked').length;
            var selectAll    = $('#select_all:checked').prop("checked");
            if(selectAll){
                selecionados = selecionados - 1;
            }
            $("#selecionados").html(selecionados+" Itens selecionados");
        });

        // Botão de deletar
        $('#deletar').on('click', function(){
            var indice = $('.checkbox:checked').length;

            if($('.checkbox:checked').length > 0){
                //window.location = 'pedido_tipo_produtos/'+$('.checkbox:checked')[indice].value+'/edit'
                swal({
                    title: "Você tem certeza?",
                    text: "Todo(s) os pedido(s) inativado(s) perderá(ão) o acesso ao sistema!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, Inativá-lo(s)!",
                    cancelButtonText: "Não, cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        var pedido_tipo_produtos = [];
                        $.each($("input:checked"), function(){            
                            if($(this).val() != 'on'){
                                console.log($(this).val());
                            }
                        }); 

                    } else {
                        swal("Cancelado", "Seu(s) pedido(s) não foi(ram) inativado(s) :)", "error");
                    }
                });
            }else{
                swal("Não foi possível executar essa ação",  "Para deletar um cadastro selecione pelo menos um registro!", "error");
            }
        });
    </script>
@endsection
