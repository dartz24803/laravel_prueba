<table id="zero-config" class="table table-hover non-hover" style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Base</th>
            <th>F. de registro</th>
            <th>U. de registro</th>
            <th>Título</th>
            <th>Asignado a</th>
            <th>Área</th>
            <th>Vence en</th>
            <th>Estado</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_pendiente as $list) {  ?>    
            <tr>
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['cod_base']; ?></td>
                <td><?php echo $list['fecha_tabla']; ?></td>
                <td><?php echo ucwords($list['usuario_solicitante']); ?></td>
                <td><?php echo ucfirst($list['titulo_min']); ?></td>
                <td><?php echo ucwords($list['responsable']); ?></td>
                <td><?php echo ucfirst($list['nom_area_min']); ?></td>
                <td><?php echo $list['vence']; ?></td>
                <td>
                    <?php if ( $list['estado']==1) { ?>
                        <span class="badge" style="background:#FF786B;color: white;"><?php echo $list['nom_estado_tickets']; ?></span>
                    <?php }elseif($list['estado']==2){ ?>
                        <span class="badge" style="background:#FFE881;color:#726f73;"><?php echo $list['nom_estado_tickets']; ?></span>
                    <?php }elseif($list['estado']==3){ ?>
                        <span class="badge" style="background:#5FB17B;color: white;"><?php echo $list['nom_estado_tickets']; ?></span>
                    <?php }elseif($list['estado']==4){ echo ""; ?>    
                        <span class="badge" style="background:#E2A03F;color: white;"><?php echo $list['nom_estado_tickets']; ?></span>
                    <?php }else{ echo ""; } ?>
                </td>
                <td class="text-center">
                    <div class="btn-group dropleft" role="group">
                        <a id="btnDropLeft" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="btnDropLeft" style="padding:0;">
                            <?php if($list['estado']==1){ ?>
                                <a class="dropdown-item"  data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Tareas/Modal_Ver_Pendiente/' . $list['id_pendiente']) }}" style="cursor:pointer;">Ver</a>
                            <?php }else{ ?>
                                <a class="dropdown-item"  data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Tareas/Modal_Ver_Solucion_Pendiente/' . $list['id_pendiente']) }}" style="cursor:pointer;">Ver</a>
                            <?php } ?>
                            <?php if($list['estado']==1){ ?>
                                <a class="dropdown-item" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Tareas/Modal_Update_Pendiente/' . $list['id_pendiente']) }}" style="cursor:pointer;">Editar</a>
                            <?php }else{ ?>
                                <a class="dropdown-item" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Tareas/Modal_Solucion_Pendiente/' . $list['id_pendiente']) }}" style="cursor:pointer;">Editar</a>
                            <?php } ?>
                            <?php if($list['estado']==1){ ?> 
                                <a class="dropdown-item" onclick="Delete_Pendiente('<?php echo $list['id_pendiente']; ?>')" style="cursor:pointer;">Eliminar</a>
                            <?php } ?>
                        </div>
                    </div>
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
        order: [[0,"desc"]],
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
        "sLengthMenu": "Resultados :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 50,
        <?php if(session('usuario')->id_nivel==1){ ?>
            "aoColumnDefs" : [ 
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        <?php }else{ ?>
            "aoColumnDefs" : [ 
                {
                    'targets' : [ 0,2 ],
                    'visible' : false
                } 
            ]
        <?php } ?>
    });
</script>