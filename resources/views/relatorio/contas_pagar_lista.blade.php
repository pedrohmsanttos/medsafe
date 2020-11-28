@extends('layouts.app')

@section('css')
<style>
.dataTables_filter label{
    float: right;
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
                            <a href="{{ url('relatorio/pagar') }}">
                                Voltar
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="body">
                    <!-- Exportable Table -->
                    <div class="table-responsive">
                    <style>.dt-buttons{padding-bottom: 15px;}</style>
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Fornecedor</th>
                                    <th>Valor</th>
                                    <th>Data Vencimento</th>
                                    <th>Data Emissão</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Total:</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if(!empty($lancamentos))
                                    @foreach($lancamentos as $lancamento)
                                        <tr>
                                            <td>{{ $lancamento->fornecedor->nomeFantasia }}</td>
                                            <td>R$ {{ number_format((float)$lancamento->valor_titulo, 2, ',', '.')  }}</td>
                                            <td>{{ date('d/m/Y', strtotime($lancamento->data_vencimento)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($lancamento->data_emissao)) }}</td>
                                        </tr>
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
    <script>
        //Exportable table
        $('.js-exportable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            ordering: false,
            searching: false,
            buttons: [
                {
                    extend: 'copy',
                    text: 'Copiar',
                    exportOptions: {
                        modifier: {
                            page: 'current',
                        },
                        
                    },
                    footer: true
                    
                }, 
                {
                    extend: 'csv',
                    text: 'CSV',
                    footer: true
                },
                {  
                    extend: 'excel',
                    text: 'Excel',
                    footer: true
                }, {
                    extend: 'print',
                    text: 'Imprimir',
                    exportOptions: {
                        modifier: {
                            page: 'current',
                        },
                        
                    },
                    footer: true
                    
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
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column(1)
                .data()
                .reduce( function (a, b) {
                    b = b.replace('R$ ', '');
                    b = b.replace(/[\.]/g, '');
                    b = b.replace(',', '.');
                    
                    return intVal(a) + intVal(b);
                }, 0 );
           
            // Total over this page
            pageTotal = api
                .column( 1, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            var options1 = { style: 'currency', currency: 'BRL' };
            var numberFormat1 = new Intl.NumberFormat('pt-br', options1);

            $( api.column( 1 ).footer() ).html(
                'Total  '+ numberFormat1.format(total) +' reais'
            );
        }
        });
    </script>
@endsection
