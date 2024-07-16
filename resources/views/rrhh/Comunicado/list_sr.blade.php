<table id="tabla_js" class="table table-hover ordenar" style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
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
        <?php foreach($list_slider_rrhh as $list) {  ?>   
            <tr>
                <td><?= $list['orden']; ?></td>
                <td><?= $list['tipo_slide']; ?></td>
                <td><?= $list['duracion']; ?></td>
                <td><?= $list['titulo']; ?></td>
                <td><?= $list['descripcion']; ?></td>
                <td><?= $list['creado']; ?></td>
                <td>
                    <?php if(substr($list['archivoslide'],-3) === "mp4"){ ?>
                        <video loading="lazy" class="img-thumbnail img-presentation-small" controls >
                            <source class="img_post img-thumbnail img-presentation-small" src="<?= $list['archivoslide']; ?>" type="video/mp4">
                        </video>
                    <?php } else { ?>
                        <img loading="lazy" class="img_post img-thumbnail img-presentation-small" style="max-width:100px" src="<?= $list['archivoslide']; ?>">
                    <?php } ?>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" title="Editar" 
                    data-toggle="modal" data-target="#ModalUpdateSlide" 
                    app_upd_slide="{{ url('Modal_Update_Slider_Rrhh/' . $list['id_slide'])  }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="" title="Eliminar" onclick="Delete_Slider_Rrhh('<?= $list['id_slide']; ?>')" id="delete" role="button">
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
        if('<?= $tipo ?>'=="2"){
            <?php $encryptedString = base64_encode('Slider_Vista_Tienda'); ?>
            $("#btn_slide").html('<a id="hslider" target="_blank" class="btn btn-primary mb-2 mr-2" title="Registrar" href="{{ url('Slider/'.$encryptedString) }}">Visualizar Slide Tienda</a>');
        }else{
            <?php
            $funcion = base64_encode('Slider_Vista_RRHH');
            $base = base64_encode($tipo);
            ?>
            $("#btn_slide").html('<a id="hslider" target="_blank" class="btn btn-primary mb-2 mr-2" title="Registrar" href="{{ url('Slider/'.$funcion.'__'.$base) }}">Visualizar Slide de Base <?php echo $tipo ?></a> ');
        }

        $('#tabla_js').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
            },
            responsive: true,
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10
        });
    });
</script>