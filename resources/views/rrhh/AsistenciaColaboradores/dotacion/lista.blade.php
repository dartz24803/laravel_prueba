<table id="tabla_js" class="table table-hover non-hover" style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Base</th>
            <th>Dotación</th>
            <th>Presentes</th>
            <th>Ausentes</th>
            <th>% de asistencia</th>
            <th>Hora de apertura</th>
            <th>Estado</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_dotacion as $list) { ?>
            <tr>
                <td><?php echo $list->orden; ?></td>
                <td><?php echo $list->centro_labores; ?></td>
                <td><?php echo $list->dotacion; ?></td>
                <td><?php echo $list->presentes; ?></td>
                <td><?php echo $list->ausentes; ?></td>
                <td><?php echo $list->porcentaje_asistencia; ?></td>
                <td><?php echo $list->hora_apertura; ?></td>
                <td><?php echo $list->nom_estado; ?></td>
                <td class="text-center">
                    <a href="javascript:void(0);" title="Marcaciones" data-toggle="modal" data-target="#ModalUpdate" <?php echo $list->centro_labores; ?>/<?php echo $fecha; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-info">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('#tabla_js').DataTable({
            responsive: true,
            order: [
                [0, "asc"]
            ],
            "oLanguage": {
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
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 50,
            "aoColumnDefs": [{
                'targets': [0],
                'visible': false
            }]
        });
    });
</script>