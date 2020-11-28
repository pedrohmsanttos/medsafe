@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    <link href="{{asset('plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
@endsection

@section('content')
    
    @include('flash::message')

    @include('negocios.filter')

    <div class="card">
        <div class="header">
            <div class="row">
                <div class="col-md-10">
                    <h2>Lista de Negócios</h2>
                </div>
                <ul class="header-dropdown ">
                    <li>
                        <a class="btn btn-success waves-effect pull-right" style="margin-top:-10px;margin-right: 10px;" href="{!! url('negocios/create') !!}">Adicionar</a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);" id="editar" class="waves-effect waves-block">Editar</a></li>
                            <li><a href="javascript:void(0);" id="deletar" class=" waves-effect waves-block">Inativar</a></li>
                            <li><a href="javascript:void(0);" id="copiar" class=" waves-effect waves-block">Copiar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="body">
            @include('negocios.table')
            <div class="row">
                <div class="col-md-6">
                    <p style="margin-top: 25px;">Mostrando página {{ $negocios->currentPage() }} de {{ $negocios->lastPage() }} página(s), total de {{ $negocios->total() }} registros <p id="selecionados"></p> </p>
                </div>
                <div class="col-md-6 rigth">
                    {!! $negocios->links() !!}
                </div>
            </div>
        </div>
    </div>
    
    <div ng-app="MedSafer" ng-controller="Negocio" ng-init="clearCart()"></div>
    
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('plugins/ngCart/ngCart.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>

    <script src="{{asset('js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jquery.maskMoney.min.js')}}"></script>
    <script src="{{asset('js/mask.js')}}"></script>
    <script src="{{asset('app/app.js')}}"></script>
    <script src="{{asset('app/controllers.js')}}"></script>
    <script src="{{asset('app/services.js')}}"></script>
    <script>

        $(".gridBody td").click(function(){
            if(!$(this).hasClass('checkItem')){
                $('.page-loader-wrapper').fadeIn();
                window.location = 'negocios/'+$( this ).parent().data( "id" )+'/edit'
            }
        });

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
        // Botão de editar
        $('#editar').on('click', function(){
            var indice = $('.checkbox:checked').length - 1;

            if($('.checkbox:checked').length < 2 && $('.checkbox:checked').length > 0){
                window.location = 'negocios/'+$('.checkbox:checked')[indice].value+'/edit'
            }else{
                swal("Não foi possível executar essa ação",  "Para editar um cadastro selecione apenas um registro!", "error");
            }
        });
        
        // Botão de deletar
        $('#deletar').on('click', function(){
            var indice = $('.checkbox:checked').length;

            if($('.checkbox:checked').length > 0){
                //window.location = 'negocios/'+$('.checkbox:checked')[indice].value+'/edit'
                swal({
                    title: "Você tem certeza?",
                    text: "Todos as Tipo de Negócios(s) inativada(s) não poderá(ão) ser mais utilizadas no sistema!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, Inativá-lo(s)!",
                    cancelButtonText: "Não, cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        var negocios = [];
                        $.each($("input:checked"), function(){            
                            if($(this).val() != 'on'){
                                negocios.push($(this).val());
                            }
                        });

                        var url = window.location.origin + window.location.pathname;

                        $('.page-loader-wrapper').fadeIn();

                        var request = $.ajax({
                            url: url + '/1',
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE',
                                ids: negocios
                            },
                            success: function(result){
                                // Do something with the result
                                if(result.msg == 'Sucesso'){

                                    window.location.reload();
                                }else{
                                    swal("Erro", "Não foi possivel inativar os tipos de negocios selecionados", "error");
                                }
                            }
                        });

                    } else {
                        swal("Cancelado", "Tipo de negocios não foram inativadas", "error");
                    }
                });
            }else{
                swal("Não foi possível executar essa ação",  "Para deletar um cadastro selecione pelo menos um registro!", "error");
            }
        });

        // Botão de copiar
        $('#copiar').on('click', function(){
            var indice = $('.checkbox:checked').length - 1;

            if($('.checkbox:checked').length < 2 && $('.checkbox:checked').length > 0){
                window.location = 'negocios/copia/'+$('.checkbox:checked')[indice].value
            }else{
                swal("Não foi possível executar essa ação",  "Para editar um cadastro selecione apenas um registro!", "error");
            }
        });

        // Validar filtros
        var urlOrdem  = '';
        var urlFiltro = '&searchFields=';
        var urlCampos = '?search=';
        var situacao  = '&situacao=';
        var boolean   = '&searchJoin=and';
        var url       = '';
        var index     = 0;
        var filtros   = [];

        // Adicionar um filtro
        $(".add").click(function(){
            // TODO: Vars
            var urlBusca = window.location.search;
            var opFiltro = $('#filtro').val();
            var opCampo  = $('#campo').val();
            // Valor dos filtro
            if(opFiltro == 'orderBy'){
                valor = $('#sortedBy').val();
            }else if(opCampo == 'situacao'){
                valor = $('#status').val();
                situacao += valor;
            }else if(opCampo == 'status'){
                valor = $('#status_negocio').val();
            }else if(opCampo == 'data_criacao'){
                valor = $('#valorData').val();
            }else if(opCampo == 'pessoa_id'){
                valor = $('#pessoa').val();
            }else if(opCampo == 'organizacao_id'){
                valor = $('#organizacao').val();
            }else{
                valor = $('#valor').val();
            }

            if(urlBusca != '' && urlBusca.indexOf(opCampo) !== -1 ){
                swal("Não foi possível executar essa ação" ,  "Já existe um filtro sendo utilizado!" ,  "error" );
            }else{
                if(valor != '' &&
                    opFiltro != '' &&
                    opCampo != ''){
                    
                    if($("#filtro").val() == 'orderBy' && opCampo != 'situacao'){
                        if(urlOrdem == ''){
                            urlOrdem = '&orderBy='+$("#campo").val()+'&sortedBy='+valor;
                            filtrar();
                        }else{
                            swal("Não foi possível executar essa ação" ,  "Já foi escolhido um filtro para ordem!" ,  "error" );
                        }
                    }else if($("#filtro").val() == 'contem' && opCampo != 'situacao'){
                        let params = $("#campo").val()+':like';
                        filtros[index] = {
                            tipo: 'contem',
                            campo: $("#campo").val(),
                            filtro: $("#campo").val()+':'+valor,
                            valor: params
                        }
                        ++index;
                        filtrar();
                    }else if($("#filtro").val() == 'igual' && opCampo != 'situacao'){
                        let params = $("#campo").val()+':=';
                        filtros[index] = {
                            tipo: 'igual',
                            campo: $("#campo").val(),
                            filtro: $("#campo").val()+':'+valor,
                            valor: params
                        }
                        ++index;
                        filtrar();
                    }else if(opCampo == 'situacao'){
                        filtrar();
                    }
                }else{
                    swal("Não foi possível executar essa ação" ,  "Todos os campos do filtro são obrigatório!" ,  "error" );
                }
            }
        });
    
        $(".remove").click(function(){
            console.log($(this).parent('tr'));
        });
        // Iniciar com valor oculto para a ordem
        $('#valorOrdem').hide();
        $('#valorSituacao').hide();
        $('#valorStatus').hide();
        $('#valorData').hide();
        $('#valorPessoa').hide();
        $('#valorOrganizacao').hide();
        // Variaveis para gerar o URL
        var ordemCampo = false;
        var ordemTipo  = false;

        

        $('#campo').on('change',function() {
            console.log($(this).val());
            var opcao = $(this).val();
            var opSelecionada = $('#filtro').val();
            if (opSelecionada == 'orderBy'){
                if(opcao == 'status'){
                    $('#valor').hide();
                    $('#valorOrdem').show();
                    $('#valorSituacao').hide();
                    $('#valorData').hide();
                    $('#valorStatus').hide();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').hide();

                }
                else if(opcao == 'data_criacao'){
                    $('#valor').hide();
                    $('#valorOrdem').show();
                    $('#valorStatus').hide();
                    $('#valorData').hide();
                    $('#valorSituacao').hide();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').hide();

                }else if(opcao == 'pessoa_id'){
                    $('#valor').hide();
                    $('#valorOrdem').show();
                    $('#valorStatus').hide();
                    $('#valorData').hide();
                    $('#valorSituacao').hide();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').hide();
                
                }else if(opcao == 'organizacao_id'){
                    $('#valor').hide();
                    $('#valorOrdem').show();
                    $('#valorStatus').hide();
                    $('#valorData').hide();
                    $('#valorSituacao').hide();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').hide();
                }
                
            }else{
                if(opcao == 'situacao'){
                    $('#valor').hide();
                    $('#valorOrdem').hide();
                    $('#valorStatus').hide();
                    $('#valorData').hide();
                    $('#valorSituacao').show();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').hide();

                }else if(opcao == 'status'){
                    $('#valor').hide();
                    $('#valorOrdem').hide();
                    $('#valorSituacao').hide();
                    $('#valorData').hide();
                    $('#valorStatus').show();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').hide();

                }else if(opcao == 'orderBy'){
                    
                    $('#valor').hide();
                    $('#valorStatus').hide();
                    $('#valorData').hide();
                    $('#valorSituacao').hide();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').hide();
                    $('#valorOrdem').show();
                }
                else if(opcao == 'data_criacao'){
                    $('#valor').hide();
                    $('#valorOrdem').hide();
                    $('#valorStatus').hide();
                    $('#valorData').show();
                    $('#valorSituacao').hide();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').hide();

                }else if(opcao == 'pessoa_id'){
                    $('#valor').hide();
                    $('#valorOrdem').hide();
                    $('#valorStatus').hide();
                    $('#valorData').hide();
                    $('#valorSituacao').hide();
                    $('#valorPessoa').show();
                    $('#valorOrganizacao').hide();
                
                }else if(opcao == 'organizacao_id'){
                    $('#valor').hide();
                    $('#valorOrdem').hide();
                    $('#valorStatus').hide();
                    $('#valorData').hide();
                    $('#valorSituacao').hide();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').show();
                }
                else{
                    $('#valor').show();
                    $('#valorOrdem').hide();
                    $('#valorStatus').hide();
                    $('#valorData').hide();
                    $('#valorSituacao').hide();
                    $('#valorPessoa').hide();
                    $('#valorOrganizacao').hide();
                }
            }
        });

        $('#filtro').on('change',function() {
            console.log($(this).val());
            var opcao = $(this).val();

            if(opcao == 'orderBy'){
                $('#valor').hide();
                $('#valorSituacao').hide();
                $('#valorData').hide();
                $('#valorOrdem').show();
                $("#campo option[value='situacao']").prop('disabled',true);
                $("#campo").val('');
                $('#campo').selectpicker('render');
                $('#valorPessoa').hide();
                $('#valorOrganizacao').hide();
            }else{
                $('#valorOrdem').hide();
                $('#valorSituacao').hide();
                $('#valorData').hide();
                $('#valor').show();
                $("#campo option[value='situacao']").prop('disabled',false);
                $("#campo").val('');
                $('#campo').selectpicker('render');
                $("#campo option[value='pessoa_id']").prop('disabled',false);
                $("#campo option[value='organizacao_id']").prop('disabled',false);
            }
        });
        
        // Filtrar
        var filtrar = function(){
            var urlSearch = window.location.search;
            var buscas = urlSearch.split('&');
            var filtroOrdem = '';
            var campoOrdem = '';

            if(urlSearch != ''){    
                buscas.forEach(element => {
                    var temp = element.split('=');
                    if(temp[0] == '?search'){
                        var arrTemp = temp[1].split(':');
                        console.log(arrTemp);
                        if(arrTemp.length > 0 && arrTemp[0] != ''){
                            var objTemp = {
                                tipo: 'contem',
                                campo: arrTemp[0],
                                filtro: arrTemp[0]+':'+arrTemp[1],
                                valor: arrTemp[0]+':like'
                            }
                            filtros.push(objTemp);
                        }
                    }else if(temp[0] == 'situacao'){
                        if(temp[1] != ""){
                            situacao = '&situacao=' + temp[1];
                        }
                    }else if(temp[0] == 'orderBy' || temp[0] == '?orderBy'){
                        campoOrdem = temp[1];
                    }else if(temp[0] == 'sortedBy'){
                        filtroOrdem = temp[1];
                    }
                    console.log(temp[0]);
                });
                urlOrdem = '&orderBy='+campoOrdem+'&sortedBy='+filtroOrdem;
            }
            
            for(var i = 0; i < filtros.length; i++){
                let objTmp = filtros[i];
                console.log(objTmp);
                if(objTmp.tipo == 'igual' || objTmp.tipo == 'contem'){
                    if(urlFiltro.length == 14){
                        urlFiltro += objTmp.valor;
                    }else{
                        urlFiltro += ';'+objTmp.valor;
                    }

                    if(urlCampos.length == 8){
                        urlCampos += objTmp.filtro;
                    }else{
                        urlCampos += ';'+objTmp.filtro;
                    }
                }
            }

            window.location = window.location.origin + window.location.pathname + urlCampos + urlFiltro + urlOrdem + situacao + boolean;
        }; 
    </script>
@endsection

