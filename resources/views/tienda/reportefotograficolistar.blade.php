<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<table id="tabla-rf" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th> Orden</th>
            <th class="text-center">base</th>
            <th class="text-center">codigo</th>
            <th class="text-center">categoría</th>
            <th class="text-center">area</th>
            <th class="text-center">fecha</th>
            <th class="text-center no-content">foto</th>
            <th class="no-content"></th>
        </tr>
    </thead>

    <tbody>
    </tbody>
</table>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var tabla = $('#tabla-rf').DataTable({
        "order": [
            [0, "asc"]
        ],
        "oLanguage": {
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        // Ordenar por la primera columna de forma descendente
        "columnDefs": [{
            "targets": 0, // La primera columna
            "visible": false, // Ocultar la primera columna
            "searchable": false // No permitir buscar en la primera columna
        }],
    });
</script>