<table id="zero-configg" class="table table-hover ordenar" style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Base</th>

            <th>Tipo de slide</th>
            <th>Duración</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Creado</th>
            <th>Archivo</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($slider as $list) {  ?>   
            <tr>
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['base']; ?></td>
                <td><?php if($list['tipo_slide']=="1"){echo "Imagen";} else{echo 'Video' ;} ?></td>
                <td><?php echo $list['duracion']; ?></td>
                <td><?php echo word_limiter($list['titulo'], 4) ?></td>
                <td><?php echo word_limiter($list['descripcion'], 4) ?></td>
                <td><?php echo format_date($list['fec_reg']) ?></td>
                <td>
                    <?php if(substr($list['archivoslide'],-3) === "mp4"){ ?>
                            <?php echo ' 
                                    <video loading="lazy" class="img-thumbnail img-presentation-small" controls >
                                        <source class="img_post img-thumbnail img-presentation-small" src="' . $url[0]['url_config'] . $list['archivoslide'] . '" type="video/mp4">
                                    </video>';
                            ?>
                    <?php } else {
                        echo'<img loading="lazy" class="img_post img-thumbnail img-presentation-small" src="' . $url[0]['url_config'] . $list['archivoslide'] . '">'; 
                    } ?>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" title="Editar" 
                    data-toggle="modal" data-target="#ModalUpdateSlide" 
                    app_upd_slide="<?= site_url('Corporacion/Modal_Update_slide_Comercial') ?>/<?php echo $list['id_slide']  ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="" title="Eliminar" onclick="Delete_slide_Comercial('<?php echo $list['id_slide']; ?>')" id="delete" role="button">
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
        $(".img_post").click(function () {
    window.open($(this).attr("src"), 'popUpWindow', 
    "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
});
</script>