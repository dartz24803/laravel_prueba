<?php $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
$id_puesto=$_SESSION['usuario'][0]['id_puesto'];
$menu_gestion_pendiente=explode(",",$_SESSION['usuario'][0]['grupo_puestos']);
$mostrar_menu=in_array($_SESSION['usuario'][0]['id_puesto'],$menu_gestion_pendiente);?>
<table id="zero-configg" class="table table-hover non-hover" style="width:100%">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Código</th>
            <?php if($id_nivel==2 || $id_nivel==1 || $id_puesto==133){ ?>
                <th>Revisado por</th> 
            <?php }?> 
            <th>Colaborador</th>
            <?php if($id_nivel==2 || $id_nivel==1 || $id_puesto==133){ ?>
                <th>Solicitante</th> 
            <?php }?>
            <th>Tipo</th>
            <th>Gravedad</th>
            <th>Motivo</th>
            <th>Estado</th>
            <th class="no-content"></th>
            <th class="no-content"></th> 
        </tr> 
    </thead>

    <tbody>
        <?php foreach($list_recibidas as $list) {  ?>                                           
            <tr>
                <td class="text-center"><?php echo $list['fecha']; ?></td>
                <td class="text-center"><?php echo $list['cod_amonestacion']; ?></td>
                <?php if($id_nivel==2 || $id_nivel==1 || $id_puesto==133){?>
                    <td><?php echo $list['revisor']; ?></td>
                <?php }?>
                <td><?php echo $list['colaborador']; ?></td>
                <?php if($id_nivel==2 || $id_nivel==1 || $id_puesto==133){?>
                    <td><?php echo $list['solicitante']; ?></td>
                <?php }?>
                <td><?php echo $list['nom_tipo_amonestacion']; ?></td>
                <td><?php echo $list['nom_gravedad_amonestacion']; ?></td>
                <td><?php echo $list['nom_motivo_amonestacion']; ?></td>
                <td><?php echo $list['desc_estado_amonestacion']; ?></td> 
                <td class="text-center">
                    <?php if($list['v_documento']=="Si"){ ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <?php }else{ ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <?php } ?>
                </td> 
                <td class="text-center">
                    <div class="btn-group dropleft" role="group">
                        <a id="btnDropLeft" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="btnDropLeft" style="padding:0;">
                            <a class="dropdown-item" href="<?= site_url('Corporacion/Pdf_Amonestacion') ?>/<?php echo $list['id_amonestacion']; ?>" target="_blank" style="cursor:pointer;">Amonestación</a>
                            <?php if($list['documento']!=""){ ?> 
                                <a class="dropdown-item" data-toggle="modal" data-target="#Modal_IMG" data-imagen="<?php echo $url[0]['url_config'].$list['documento']; ?>" data-title="Documento Adjuntado" style="cursor:pointer;">Documento Adjuntado</a>
                            <?php } ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
$(document).ready(function() {
    $('#zero-configg').DataTable({
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