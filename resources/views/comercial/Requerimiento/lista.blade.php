<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>Fecha de Requerimiento</th>
            <th>Usuario</th>
            <th>División</th>
            <th>Cantidad</th>
            <th>Año</th>
            <th>Semana</th>
            <th>Estado</th>
            <th class="no-content">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_requerimiento as $list) {  ?>
            <tr>
                <td><?php echo $list->fec_reg; ?></td>
                <td><?php echo $list->user_reg; ?></td>
                <td><?php echo $list->tipo_usuario; ?></td>
                <td><?php echo $list->total; ?></td>
                <td><?php echo $list->anio; ?></td>
                <td><?php echo $list->semana; ?></td>
                <td><?php //echo "PENDIENTE";
                    if ($list->estado == "1") {
                        echo "PENDIENTE";
                    } else {
                        echo "CERRADO";
                    }
                    ?></td>
                <td class="text-center">
                    <?php if ($list->estado == "1") { ?>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Pedido('<?php echo $list->id_pedido_lnuno; ?>','<?php echo $list->tipo_usuario; ?>','<?php echo $list->user_reg; ?>')" id="delete" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $('#zero-config').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10
    });
</script>