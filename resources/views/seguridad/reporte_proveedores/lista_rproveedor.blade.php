@php
    use Carbon\Carbon;
@endphp
<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>Base</th>
            <th>Proveedor</th>
            <th>Usuario Registro</th>
            <th>Fec.&nbsp;y&nbsp;Hora Registro</th>
            <th>H. Programada</th>
            <th>H. Real Llegada</th>
            <th>H. Ingreso Instalaciones</th>
            <th>H. Descarga Mercadería</th>
            <th>H. Salida</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($list_rproveedor as $list) {  ?>
        <tr>
            <td> <?php echo $list['base']; ?></td>
            <td><?php
                if($list['infosap']==1){
                    $busqueda = in_array($list['id_proveedor'], array_column($list_proveedor, 'clp_codigo'));
                    $posicion = array_search($list['id_proveedor'], array_column($list_proveedor, 'clp_codigo'));
                    if ($busqueda != false) {
                        echo $list_proveedor[$posicion]->clp_razsoc;
                    }
                }else{
                    $busqueda2 = in_array($list['id_proveedor'], array_column($list_proveedor2, 'id_proveedor'));
                    $posicion2 = array_search($list['id_proveedor'], array_column($list_proveedor2, 'id_proveedor'));
                    if ($busqueda2 != false) {
                        echo $list_proveedor2[$posicion2]['nombre_proveedor'];
                    }
                }?>
            </td>
            <td><?php echo $list['usuario_apater']." ".$list['usuario_amater'].", ".$list['usuario_nombres'] ?> </td>
            <td data-order="{{ Carbon::createFromFormat('d/m/Y H:i A', $list['fecha_registro'])->format('Y-m-d H:i A'); }}"><?php echo $list['fecha_registro']; ?></td>
            <td><?php echo $list['hora_programada']; ?></td>
            <td><?php if($list['hora_real_llegada']!="00:00:00"){echo $list['fecha_real_llegada'];}else{ ?>
                <a class="#" style="cursor:pointer" title="Actualizar hora real de llegada" onclick="Update_Hora_RProveedor('<?php echo $list['id_calendario']; ?>', '1')" id="delete" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </a>
                <?php }  ?>
            </td>
            <td><?php if($list['hora_ingreso_insta']!="00:00:00"){echo $list['fecha_ingreso_insta'];}else{
                if($list['hora_real_llegada']!="00:00:00"){?>
                <a class="#" style="cursor:pointer" title="Actualizar hora ingreso a instalaciones" onclick="Update_Hora_RProveedor('<?php echo $list['id_calendario']; ?>', '2')" id="delete" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </a>
                <?php }else{?>
                    <svg style="color: #3b3f5c85 !important;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <?php } } ?>
            </td>
            <td><?php if($list['hora_descargo_merca']!="00:00:00"){echo $list['fecha_descarga_merca'];}else{
                if($list['hora_real_llegada']!="00:00:00" && $list['hora_ingreso_insta']!="00:00:00"){?>
                <a class="#" style="cursor:pointer" title="Actualizar hora descarga de mercadería" onclick="Update_Hora_RProveedor('<?php echo $list['id_calendario']; ?>', '3')" id="delete" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </a>
                <?php }else{?>
                    <svg style="color: #3b3f5c85 !important;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <?php } } ?>
            </td>
            <td><?php if($list['hora_salida']!="00:00:00"){echo $list['fecha_salida'];}else{
                if($list['hora_real_llegada']!="00:00:00" && $list['hora_ingreso_insta']!="00:00:00" && $list['hora_descargo_merca']!="00:00:00"){?>
                    <a class="#" style="cursor:pointer" title="Actualizar hora de salida" onclick="Update_Hora_RProveedor('<?php echo $list['id_calendario']; ?>', '4')" id="delete" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </a>
                <?php }else{?>
                    <svg style="color: #3b3f5c85  !important;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <?php } } ?>
            </td>
            <td><?php
                    if( $list['estado_interno']=='1'){
                        echo "<span class='shadow-none badge badge-primary'>PROGRAMADO</span>";
                    }
                    else if( $list['estado_interno']=='2'){
                        echo "<span class='shadow-none badge badge-danger'>NO PROGRAMADO</span>";
                    }
                ?>
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
        "lengthMenu": [50, 70, 100],
        "pageLength": 50
    });
</script>
