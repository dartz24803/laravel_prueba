
<table id="zero-config" class="table table-hover" style="width:100%">
    <thead class="text-center">
        <tr>
            <th align="center"><b>C.L.</b></th>
            <th align="center"><b>Colaborador</b></th>
            <th align="center"><b>Puesto</b></th>
            <th align="center"><b>Fec. Reg.</b></th>
            <th align="center"><b>Motivo</b></th>
            <th align="center"><b>Detalles</b></th>
            <th align="center"><b>Propuesta</b></th>
            <th align="center"><b>Estado</b></th>
            <th align="center"><b>Acciones</b></th>
        </tr>
    </thead>

    <tbody class="text-center">
        <?php foreach($list_intencion as $list) {  ?>                                           
            <tr >
                <td align="center" ><?php echo $list['centro_labores']; ?></td>
                <td align="center" ><?php echo $list['colaborador']; ?></td>
                <td align="center" ><?php echo $list['nom_puesto']; ?></td>
                <td align="center" ><?php echo $list['fecha']; ?></td>
                <td align="center" ><?php echo $list['nom_motivo']; ?></td>
                <td align="center" ><?php echo $list['detalle']; ?></td>
                <td align="center" ><?php echo $list['propuesta']; ?></td>
                <td align="center" ><?php echo $list['estado_intencion']; ?></td>
                <td class="text-center"  width="80">
                    <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Update_Intencion_Renuncia') ?>/<?php echo $list["id_intencion"]; ?>" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <?php if($list['estado_intencion']=='EN PROCESO'){?> 
                        <a href="javascript:void(0)" class="" title="Actualizar a estado Cesado" onclick="Update_Estado_Intencion_Renuncia('<?php echo $list['id_intencion']; ?>')" id="delete" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </a>
                    <?php }?>
                    <a href="#" class="" title="Eliminar" onclick="Delete_Intencion_Renuncia('<?php echo $list['id_intencion']; ?>')" id="delete" role="button">
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
$('#zero-config').DataTable({
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

