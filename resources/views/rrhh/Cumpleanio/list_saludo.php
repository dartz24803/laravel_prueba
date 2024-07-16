<table id="zero-config-detalle-cumple2" class="table table-hover" style="width:100%; overflow:auto;">
    <thead>
        <tr>
            <th>Fecha Registro</th>
            <th>Cumpleaños</th>
            <th>Cumpleañero</th>
            <th>Saludo por</th>
            <th>Saludo</th>
            <th>Estado</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_cumpleanio as$list){?> 
        <tr>
            <td><?php echo date('d/m/Y',strtotime($list['fec_reg'])) ?></td>
            <td><?php echo date('d/m/Y', strtotime($list['cumpleanio'])) ?></td>
            <td><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></td>
            <td><?php echo $list['saludado_por'] ?></td>
            <td><?php echo nl2br($list['mensaje']) ?></td>
            <td><?php echo $list['desc_estado_registro']; ?></td>
            <td nowrap>
                <?php if($list['estado_registro']==1){?>
                <a href="javascript:void(0)" class="" title="Desaprobar" onclick="Aprobar_Saludo_Cumpleanio('<?php echo $list['id_historial']; ?>','2','<?php echo $id_usuario ?>')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                </a>     
                <?php }else{?> 
                <a href="javascript:void(0)" class="" title="Aprobar" onclick="Aprobar_Saludo_Cumpleanio('<?php echo $list['id_historial']; ?>','1','<?php echo $id_usuario ?>')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </a>  
                <?php }?>
                <!--<a href="javascript:void(0)" class="" title="Desaprobar" onclick="Aprobar_Saludo_Cumpleanio('<?php echo $list['id_historial']; ?>','2')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                </a>
                <a href="javascript:void(0)" class="" title="Eliminar" onclick="Delete_Reg_Detalle_Ausencia_Dias_Libres('<?php echo $list['id_historial']; ?>','2')" id="delete" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </a>   --> 
            </td>
        </tr>    
        <?php }?>
    </tbody>
</table> 
<script>
$(document).ready(function() {
        $('#zero-config-detalle-cumple2').DataTable({
        "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Mostrando página _PAGE_ de _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
        "sLengthMenu": "Resultados :  _MENU_",
        "sEmptyTable": "No hay datos disponibles en la tabla",
    },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10
    });
});
</script>
