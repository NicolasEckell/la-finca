$(document).ready( function () {
    $("#data-table, .data-table").DataTable({
        "processing": true,
        "language": {
            "decimal":        ",",
            "emptyTable":     "La tabla se encuentra vacía!",
            "info":           "Resultados: _START_ - _END_ (_TOTAL_)",
            "infoEmpty":      "Resultados: 0 ",
            "infoFiltered":   "<span style='font-size: 12px'>(filtro aplicado sobre un total de _MAX_)</span>",
            "infoPostFix":    "",
            "thousands":      ".",
            "lengthMenu":     "Agrupar : _MENU_",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar :",
            "zeroRecords":    "No se han encontrado entradas",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": activar para ordenar ascendentemente la columna",
                "sortDescending": ": activar para ordenar descendentemente la columna"
            },
            "buttons": {
                "print": "<i class='mdi mdi-printer icon-sm'></i>",
                "copy": "<i class='mdi mdi-content-copy icon-sm'></i",
                "excel": "<i class='mdi mdi-file-excel icon-sm'></i",
                "pdf": "<i class='mdi mdi-file-pdf-box icon-sm'></i",
               /* colvis: 'Colonne da visualizzare'*/
            }
        },
        "pagingType": "full_numbers",
        "aLengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "Todas"] ],
        "ordering": true,
        "colReorder": true,
        /*"responsive": true,*/
        'iDisplayLength': 10,
        /*"columns": columns,*/
        "autoWidth" : true,
        /*"dom": 'Bflrtip',*/
        "dom": "<'d-flex justify-content-between align-items-center'lfB>" 
        +"<'d-flex'rt>" 
        +"<'d-flex justify-content-between align-items-center'ip>",
        "buttons": [
            { extend: 'print', 
            exportOptions:
            { columns: ':visible' }
            },
            { extend: 'copy', exportOptions:
            { columns: [ 0, ':visible' ] }
            },
            { extend: 'excel', exportOptions:
            { columns: ':visible' }
            },
            { extend: 'pdf', exportOptions:
            { columns: [ 0, 1, 2, 3, 4 ] }
            },
            /*{ extend: 'colvis',   postfixButtons: [ 'colvisRestore' ] }*/
        ]
    });
});