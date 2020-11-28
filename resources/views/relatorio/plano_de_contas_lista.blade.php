@extends('layouts.app')

@section('css')
<style>
.dataTables_filter label{
    float: right;
}
.dt-button{
    background-color: #607D8B;
    color: #fff;
    padding: 7px 12px;
    margin-right: 5px;
    text-decoration: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    -ms-border-radius: 2px;
    border-radius: 2px;
    border: none;
    font-size: 13px;
    outline: none;
}

.dt-button:hover{
    text-decoration: none;
    color: #fff;
}
</style>
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Informe os dados para gerar o relatório
                    </h2>
                    <ul class="header-dropdown m-r-0">
                        <li>
                            <a href="{{ url('relatorio/planocontas') }}">
                                Voltar
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="body">
                    <!-- Exportable Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Receitas</th>
                                    <th>Despesas</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if(!empty($planosDeContas))
                                    @foreach($planosDeContas as $plano)
                                        <tr>
                                            <td>{{ $plano->descricaoConta() }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach($plano->movimentacao as $movimento)
                                        <tr>
                                            <td>{{ $movimento->getTitulo() }}</td>
                                            <td>{{ ($movimento->tipo != 'retirada') ? 'R$ '.number_format((float)$movimento->valor, 2, ',', '.') : '' }}</td>
                                            <td>{{ ($movimento->tipo == 'retirada') ? 'R$ '.number_format((float)$movimento->valor, 2, ',', '.') : '' }}</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- #END# Exportable Table -->
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
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <script src="{{asset('js/tableHTMLExport.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js"></script>
    <script>
        //Exportable table
        $('.js-exportable').DataTable({
            dom: 'Bfrtip',
            ordering: false,
            responsive: true,
            buttons: [
                {
                    extend: 'copy',
                    text: 'Copiar',
                    exportOptions: {
                        modifier: {
                            page: 'current',
                        },
                        
                    },
                    
                }, 'csv', 'excel', {
                    extend: 'print',
                    text: 'Imprimir',
                    exportOptions: {
                        modifier: {
                            page: 'current',
                        },
                        
                    },
                    
                },
                { 
                    extend: 'pdf',
                    text: 'PDF',
                    customize: function () {
                        var footer = $('tfoot');
                        if (footer.length > 0) {
                            var exportFooter = $(window.document.body).find('thead:eq(1)');
                            exportFooter.after(footer.clone());
                            exportFooter.remove();
                        }
                    },
                    footer: true
                }
            ],
            language: {
                lengthMenu: "Mostrando _MENU_ registros por página",
                zeroRecords: "Nada encontrado - desculpe",
                info: "Página _PAGE_ de _PAGES_",
                infoEmpty: "Nenhum registro disponível",
                infoFiltered: "(filtrado de _MAX_ registros no total)",
                paginate: {
                    "first":      "Primeiro",
                    "last":       "Último",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                },
                buttons: {
                    copyTitle: 'Copiado para sua área de transferencia',
                    copyKeys: 'Pressione <i> ctrl </ i> ou <i> \ u2318 </ i> + <i> C </ i> para copiar os dados da tabela para a área de transferência. <br> <br> Para cancelar, clique nesta mensagem ou pressione Esc.',
                    copySuccess: {
                        _: '%d Linhas copiadas',
                        1: '1 linha copiada'
                    },
                },
                search:"Pesquisar:"
            },
            footerCallback: function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            parseFloat(i) : 0.0;
                };
    
                // Total receitas over all pages
                totalReceita = api
                    .column(1)
                    .data()
                    .reduce( function (a, b) {
                        console.log(b);
                        b = b.replace('R$ ', '');
                        b = b.replace(/[\.]/g, '');
                        b = b.replace(',', '.');
                        console.log(b);
                        result =  intVal(a) + intVal(b);
                        console.log(intVal(a) +' _ '+ intVal(b));
                        return result;
                    }, 0 );
            
                // Total over this page
                pageTotal = api
                    .column( 1, { page: 'current'} )
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
    
                // Total over all pages
                totalDespesa = api
                    .column(2)
                    .data()
                    .reduce( function (a, b) {
                        b = b.replace('R$ ', '');
                        b = b.replace(/[\.]/g, '');
                        b = b.replace(',', '.');

                        result =  intVal(a) + intVal(b);
                        return result;
                    }, 0 );

                // Update footer
                var options1 = { style: 'currency', currency: 'BRL' };
                var numberFormat1 = new Intl.NumberFormat('pt-br', options1);

                $( api.column( 1 ).footer() ).html(
                    'Total '+ numberFormat1.format(totalReceita) +' reais'
                );
                $( api.column( 2 ).footer() ).html(
                    'Total '+ numberFormat1.format(totalDespesa) +' reais'
                );
            }
        });
        /*
        $(".js-exportable1").tableHTMLExport({
            // csv, txt, json, pdf
            type:'json',
            // file name
            filename:'sample.json',
            ignoreColumns: '.ignore',
            ignoreRows: '.ignore'
        });

        $(".js-exportable2").tableHTMLExport({
            // csv, txt, json, pdf
            type:'csv',
            // default file name
            filename: 'tableHTMLExport.csv',
            // for csv
            separator: ',',
            newline: '\r\n',
            trimContent: true,
            quoteFields: true,
            // CSS selector(s)
            ignoreColumns: '',
            ignoreRows: '',
            // your html table has html content?
            htmlContent: false,
            // debug
            consoleLog: false,        
        });

        /**  $(".buttons-csv").on('click', function() {
            $(".js-exportable").tableHTMLExport({
                // csv, txt, json, pdf
                type:'csv',
                // default file name
                filename: 'Plano de contas.csv',
                // for csv
                separator: ',',
                newline: '\r\n',
                trimContent: true,
                quoteFields: true,
                // CSS selector(s)
                ignoreColumns: '',
                ignoreRows: '',
                // your html table has html content?
                htmlContent: false,
                // debug
                consoleLog: false,        
            });
        });

        $('.buttons-pdf').on('click',function(){
            $(".js-exportable").tableHTMLExport({type:'pdf',filename:'Plano de Contas.pdf',htmlContent: true});
        })  */
        
    </script>
@endsection
