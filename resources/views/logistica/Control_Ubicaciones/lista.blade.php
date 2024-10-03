<table id="zero-config2" class="table style-3 " style="width:100%">
    <thead>
        <tr>
            <th align="center">Fecha de Actualización</th>
            <th align="center">Estilo</th>
            <th align="center">Percha</th>
            <th align="center">Ubicación</th>
            <th align="center">Cantidad stock</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($list_estilo as $list) {
        $busqueda = in_array($list->art_estiloprd, array_column($list_control, 'estilo'));
        $posicion = array_search($list->art_estiloprd, array_column($list_control, 'estilo'));
        if ($busqueda!= false) { 
            $ubicacion="";
            $percha="";
            if($list_control[$posicion]['id_nicho']!=""){
                $control2=explode(",",$list_control[$posicion]['id_nicho']);
                $contador=0;
                
                while($contador<count($control2)){
                    $posicion_puesto=array_search($control2[$contador],array_column($list_nicho,'id_nicho'));
                    $ubicacion=$ubicacion.$list_nicho[$posicion_puesto]['nom_percha'].$list_nicho[$posicion_puesto]['numero'].",";
                    $percha=$percha.$list_nicho[$posicion_puesto]['nom_percha'].",";
                    $contador++;
                }
                
            }?>
            <tr>
                <td><?php echo $list_control[$posicion]['fecha'] ?></td>
                <td><?php echo $list_control[$posicion]['estilo'] ?></td>
                <td><?php echo substr($percha,0,-1); ?></td>
                <td><?php echo substr($ubicacion,0,-1); ?>
                </td>
                <td><?php echo $list->stock ?></td>
                <td class="text-center">
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ControlUbicaciones/Modal_Update_Control_Ubicaciones/'. $list_control[$posicion]['id_control_ubicacion']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                    </a>
                    <a href="#" class="" title="Eliminar" onclick="Delete_Control_Ubicacion('<?php echo $list_control[$posicion]['id_control_ubicacion']; ?>')" id="Eliminar" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>
                </td>
            </tr>
        <?php }else{?>
            <tr>
                <td></td>
                <td><?php echo $list->art_estiloprd ?></td>
                <td></td>
                <td>
                </td>
                <td><?php echo $list->stock ?></td>
                <td class="text-center">
                </td>
            </tr>
        <?php }
        ?>   
        
    <?php } ?>
    </tbody>
</table>

<script>
    $('#zero-config2').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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