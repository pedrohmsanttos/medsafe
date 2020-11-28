@extends('layouts.app')

@section('css')
    <link href="{{asset('plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Dados do negócio 
                    </h2>
                        @if($negocio->status != 1 && $negocio->status != 2)
                            <a class="btn btn-danger waves-effect pull-right" style="margin-top:-10px;margin-right: 10px;"  href="{{ url('negocios/'.$negocio->id.'/perda/create') }}">Perder</a>
                            <a class="btn btn-success waves-effect pull-right" style="margin-top:-10px;margin-right: 10px;"  href="{{ url('negocios/'.$negocio->id.'/ganho/create') }}">Ganhar</a>
                            <a class="btn btn-primary waves-effect pull-right" style="margin-top:-10px;margin-right: 10px;"  href="{{ url('negocios/atividades/' . $negocio->id) }}">Atividades</a>
                        @elseif($negocio->status == 2 && !\Entrust::ability('corretor_user', ''))
                            <a class="btn btn-primary waves-effect pull-right" style="margin-top:-10px;margin-right: 10px;" href="{{ url('pedidos/' . $negocio->itens()->first()->pedido_id ) }}">Pedido</a>
                        @endif 
                         <br>
                </div>

                <div class="body">
                    <br>
                    @include('adminlte-templates::common.errors')
                    {!! Form::model($negocio, ['route' => ['negocios.update', $negocio->id], 'method' => 'patch']) !!}

                        @include('negocios.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="formularioBaixa" tabindex="-1" role="dialog" style="display: hide; padding-right: 15px;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4  style="float:left"  class="modal-title" id="largeModalLabel">Baixar Lançamentos a Receber</h4>
                    <button style="float:right" type="button" class="btn btn-link waves-effect" data-dismiss="modal"><span style="">X</span></button>
                </div>
                <div class="modal-body">
                    @include('adminlte-templates::common.errors')
                    {!! Form::open(['route' => 'baixareceber.store']) !!}
                        @include('baixa_recebers.fields')
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jquery.maskMoney.min.js')}}"></script>
    <script src="{{asset('js/mask.js')}}"></script>
    <script src="{{asset('js/cep.js')}}"></script>
    <script>
        //select all checkboxes
        $("#select_all").change(function(){  //"select all" change 
            $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        // Botão de editar
        $('#baixar').on('click', function(){
            var indice = $('.checkbox:checked').length - 1;

            if($('.checkbox:checked').length < 2 && $('.checkbox:checked').length > 0){
                var baixa = $.trim($('.checkbox:checked').data('baixado'));
                if(baixa == "1"){
                    swal("Não foi possível executar essa ação",  "Esse registro já foi baixado!", "error");
                }else{
                    var lancamento;
                    $.each($("input[type='checkbox']:checked"), function(){            
                        if($(this).val() != 'on'){
                            console.log($(this).val());
                            lancamento = JSON.parse($('#lancamento_'+$(this).val()).val());
                            $('select option[value="'+lancamento.id+'"]').prop("selected",true);
                            $('#baixa').datepicker('setDate', 'today');
                            valor = lancamento.valor_titulo.indexOf('.') == -1  ? lancamento.valor_titulo+'.00' : lancamento.valor_titulo;
                            valor = parseFloat(valor);
                            $('#valor_pago').val(valor.toFixed(2));
                            $('#valor_pago').prop("autofocus",true);
                            document.getElementById("valor_pago").focus();
                            document.getElementById("valor_pago").select();
                            $('#lancamentoreceber_id').selectpicker('render');
                            console.log(lancamento);
                        }
                    });
                    $('#formularioBaixa').modal();
                    $("#btnCancelar").hide();
                }
                
            }else{
                swal("Não foi possível executar essa ação",  "Para baixar um cadastro selecione apenas um registro!", "error");
            }
        });
    </script>
@endsection
