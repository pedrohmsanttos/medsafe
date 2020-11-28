$(document).ready(function() {
    $.fn.dataTableExt.sErrMode = 'none';
    $('#datatable').dataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'rt><'row'<'col-sm-6'i><'col-sm-6'p>>",
        "language": {
            "lengthMenu": "Mostrando _MENU_  por página",
            "zeroRecords": "Nenhum resultado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": " ",
            "loadingRecords": "Carregando...",
            "paginate": {
                "first":      "Início",
                "last":       "Fim",
                "next":       "Próximo",
                "previous":   "Anterior"
            },
            "search":         "Buscar:",
        },
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
        responsive:true,
        autoWidth: false,
        ordering:true
    });
});
