<?php
    $sesion =  Session('usuario');
    $id_nivel = Session('usuario')->id_nivel;
    $id_puesto = Session('usuario')->id_puesto;

?>
<table id="multi-column-orderingg" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Centro de Labores</th>
            <th>DNI</th>
            <th>Colaborador</th>
            <th>Fecha</th>
            <th>Ingreso</th>
            <th>Inicio Descanso</th>
            <th>Fin Descanso</th>
            <th>Salida</th>

            <th>Día Laborado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $p=1;$d=0;
                foreach($list_asistencia as $num_doc=>$registros){
                    foreach($registros as $list) { ?>
                        <tr>
                            <td><?php echo $list['orden']; ?></td>
                            <td> <?php echo $list['centro_labores']; ?> </td>
                            <td> <?php echo $list['num_doc']; ?> </td>
                            <td> <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?></td>
                            <td> <?php echo $list['fecha'];?> </td>
                            <td> <?php echo $list['ingreso']; ?></td>
                            <td> <?php echo $list['inicio_refrigerio']; ?></td>
                            <td> <?php echo $list['fin_refrigerio']; ?></td>
                            <td> <?php echo $list['salida']; ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php }
                }
        ?>
    </tbody>
</table>

<script>
$('#multi-column-orderingg').DataTable({
    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
    "<'table-responsive'tr>" +
    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
    responsive: true,
    "order": [[0, "desc"]],  // Columna de "Fecha" (índice 4) en orden descendente
    "oLanguage": {
        "oPaginate": { 
            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', 
            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' 
        },
        "sInfo": "Mostrando página _PAGE_ de _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
        "sLengthMenu": "Resultados :  _MENU_",
        "sEmptyTable": "No hay datos disponibles en la tabla"
    },
    "stripeClasses": [],
    "lengthMenu": [10, 25, 50, 100],
    "pageLength": 10,  // Cambia según la cantidad de resultados por página deseada
    "paging": true,  // Asegura que la paginación esté activada
    "searching": true,  // Asegura que la búsqueda esté activada
    "columnDefs": [
        {
            "targets": 0,            // La primera columna (índice 0)
            "visible": false,        // Ocultar la columna
            "searchable": false      // Excluir de la búsqueda
        }
    ]
});

</script>
