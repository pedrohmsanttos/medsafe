@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    <link href="{{asset('plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
@endsection

@section('content')
    
    @include('flash::message')

    <!-- Filter -->
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
                                <option value="pergunta">Pergunta</option>
                                <option value="resposta">Resposta</option>
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
                                    <a href="/perguntas" class="btn btn-primary waves-effect">Limpar</a>
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
    <!-- ./Filter -->

    <div class="card">
        <div class="header">
            <div class="row">
                <div class="col-md-10">
                    <h2>Lista de Perguntas</h2>
                </div>
                <ul class="header-dropdown ">
                    <li>
                        <a class="btn btn-success waves-effect pull-right" style="margin-top:-10px;margin-right: 10px;" href="{!! route('perguntas.create') !!}">Adicionar</a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);" id="editar" class="waves-effect waves-block">Editar</a></li>
                            <li><a href="javascript:void(0);" id="deletar" class=" waves-effect waves-block">Inativar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="body">
            @include('perguntas.table')
            <div class="row">
                <div class="col-md-6">
                    <p style="margin-top: 25px;">Mostrando página {{ $perguntas->currentPage() }} de {{ $perguntas->lastPage() }} página(s), total de {{ $perguntas->total() }} registros <p id="selecionados"></p> </p>
                </div>
                <div class="col-md-6 rigth">
                    {!! $perguntas->links() !!}
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>

        $(".gridBody td").click(function(){
            if(!$(this).hasClass('checkItem')){
                $('.page-loader-wrapper').fadeIn();
                window.location = 'perguntas/'+$( this ).parent().data( "id" )+'/edit'
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
                window.location = 'perguntas/'+$('.checkbox:checked')[indice].value+'/edit'
            }else{
                swal("Não foi possível executar essa ação",  "Para editar um cadastro selecione apenas um registro!", "error");
            }
        });
        // Botão de deletar
        $('#deletar').on('click', function(){
            var indice = $('.checkbox:checked').length;

            if($('.checkbox:checked').length > 0){
                //window.location = 'perguntas/'+$('.checkbox:checked')[indice].value+'/edit'
                swal({
                    title: "Você tem certeza?",
                    text: "Todo(s) o(s) registro(s) inativa(s) perderá(ão) o acesso ao sistema!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, Inativá-lo(s)!",
                    cancelButtonText: "Não, cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        var perguntas = [];
                        $.each($("input:checked"), function(){            
                            if($(this).val() != 'on'){
                                perguntas.push($(this).val());
                            }
                        });

                        var url = window.location.origin + window.location.pathname;

                        var request = $.ajax({
                            url: url + '/1',
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE',
                                ids: perguntas
                            },
                            success: function(result){
                                // Do something with the result
                                if(result.msg == 'Sucesso'){

                                    window.location.reload();
                                }else{
                                    swal("Erro", "Não foi possivel inativar os perguntas selecionados", "error");
                                }
                            }
                        });

                    } else {
                        swal("Cancelado", "Seus perguntas não foi(ram) inativado(s) :)", "error");
                    }
                });
            }else{
                swal("Não foi possível executar essa ação",  "Para deletar um cadastro selecione pelo menos um registro!", "error");
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
            }else{
                valor = $('#valor').val();
            }

            if(urlBusca != '' && urlBusca.indexOf(opCampo) ){
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
        // Variaveis para gerar o URL
        var ordemCampo = false;
        var ordemTipo  = false;

        $('#campo').on('change',function() {
            console.log($(this).val());
            var opcao = $(this).val();

            if(opcao == 'situacao'){
                $('#valor').hide();
                $('#valorOrdem').hide();
                $('#valorSituacao').show();
                $('#campo').selectpicker('render');
            }
        });

        $('#filtro').on('change',function() {
            console.log($(this).val());
            var opcao = $(this).val();

            if(opcao == 'orderBy'){
                $('#valor').hide();
                $('#valorSituacao').hide();
                $('#valorOrdem').show();
                $("#campo option[value='situacao']").prop('disabled',true);
                $("#campo").val('');
                $('#campo').selectpicker('render');
            }else{
                $('#valorOrdem').hide();
                $('#valorSituacao').hide();
                $('#valor').show();
                $("#campo option[value='situacao']").prop('disabled',false);
                $("#campo").val('');
                $('#campo').selectpicker('render');
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
            
            console.log(filtros);
            window.location = window.location.origin + window.location.pathname + urlCampos + urlFiltro + urlOrdem + situacao + boolean;
        }; 
    </script>
@endsection