
<table id="zero-config-reclutado2" class="table table-hover" style="width:100%">
    <thead class="text-center">
        <tr>
            <th align="center"><b>Nombre</b></th>
            <th align="center"><b>Documento</b></th>
            <th align="center"><b>Fecha de Inicio</b></th>
            <th></th>
        </tr>
    </thead>

    <tbody class="text-center">
        <?php foreach($list_detalle_reclutamiento as $list) {  ?>
            <tr>
                <td align="center" ><?php echo $list['usuario_nombres']; ?></td>
                <td align="center" ><?php echo $list['num_doc']; ?></td>
                <td align="center" ><?php echo $list['fec_ingreso'] ?></td>
                <td class="text-center">
                    <a href="javascript:void()" class="" title="Eliminar" onclick="Delete_Reclutado('<?php echo $list['id_reclutamiento'] ?>','<?php echo $list['id_detalle'] ?>')" id="delete" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
$('#zero-config-reclutado2').DataTable({
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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
