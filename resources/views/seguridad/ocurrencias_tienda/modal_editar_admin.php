<link href="<?php echo base_url(); ?>template/inputfiles/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/piexif.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/sortable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/fr.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/es.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.js" type="text/javascript"></script>

<style>
    .input-group>.input-group-append>.btn,
    .input-group>.input-group-append>.input-group-text,
    .input-group>.input-group-prepend:first-child>.btn:not(:first-child),
    .input-group>.input-group-prepend:first-child>.input-group-text:not(:first-child),
    .input-group>.input-group-prepend:not(:first-child)>.btn,
    .input-group>.input-group-prepend:not(:first-child)>.input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        /* padding: initial; */
        padding-top: 11px;
    }

    .kv-file-upload {
        display: none !important;
    }

    .img-presentation-small-actualizar {
        width: 100%;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
        margin: 5px;
    }

    .img-presentation-small-actualizar_support {
        width: 100%;
        height: 150px;
        object-fit: cover;
        cursor: pointer;
        margin: 5px;
    }
</style>

<form id="formulario_ocurrenciae" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Ocurrencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Base: </label>
            </div>
            <div  class="form-group col-md-4">
                <select class="form-control" name="cod_basee" id="cod_basee" onchange="Buscar_Tipo_Ocu('2')"> 
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_base as $list){ 
                        if($get_id[0]['cod_base']==$list['cod_base']){?> 
                        <option selected value="<?php echo $list['cod_base']; ?>"><?php echo $list['cod_base']; ?></option> 
                        <?php }else{?>
                        <option value="<?php echo $list['cod_base']; ?>"><?php echo $list['cod_base']; ?></option> 
                        <?php } } ?>
                </select>   
            </div>

            <div class="form-group col-md-2">
                <label>Tipo: </label>
            </div>
            <div class="form-group col-md-4" id="div_tipo_oe">
                <select class="form-control" name="id_tipoe" id="id_tipoe" onchange="Tipo_Piochae();">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_tipo as $list) { ?>
                        <option value="<?php echo $list['id_tipo_ocurrencia']; ?>" <?php if($get_id[0]['id_tipo']==$list['id_tipo_ocurrencia']){echo "selected";}?>>
                            <?php echo $list['nom_tipo_ocurrencia']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 ocultar_tipo_piocha_u">
                <label>Zona: </label>
            </div>
            <div  class="form-group col-md-4 ocultar_tipo_piocha_u">
                <select class="form-control" name="id_zona_u" id="id_zona_u">
                    <option value="0" <?php if($get_id[0]['id_zona']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_zona']==1){ echo "selected"; } ?>>Hombre</option>
                    <option value="2" <?php if($get_id[0]['id_zona']==2){ echo "selected"; } ?>>Mujer</option>
                    <option value="3" <?php if($get_id[0]['id_zona']==3){ echo "selected"; } ?>>Infantil</option>
                </select>   
            </div>

            <div class="form-group col-md-2 ocultar_tipo_piocha_u">
                <label>Estilo: </label>
            </div>
            <div  class="form-group col-md-4 ocultar_tipo_piocha_u">
                <select class="form-control" name="id_estilo_u" id="id_estilo_u">
                    <option value="0" <?php if($get_id[0]['id_estilo']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_estilo']==1){ echo "selected"; } ?>>Lector de código de barra</option>
                </select>   
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Colaborador: </label>
            </div>            
            <div class="form-group col-md-10">
                <select class="form-control basic_update" name="id_usuarioe" id="id_usuarioe">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_usuario']))) { echo "selected=\"selected\""; } ?>>Seleccionar</option>
                    <?php foreach($list_usuario as $list){ ?>
                        <option value="<?php echo $list['id_usuario']; ?>" <?php if (!(strcmp($list['id_usuario'], $get_id[0]['id_usuario']))) { echo "selected=\"selected\""; } ?>>
                            <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Fecha: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_ocurrenciae" name="fec_ocurrenciae" value="<?php echo $get_id[0]['fec_ocurrencia']; ?>" >
            </div>

            

            <div class="form-group col-md-2">
                <label>Conclusión: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_conclusione" id="id_conclusione">
                    <option value="0" >Seleccione</option>
                    <?php foreach ($list_conclusion as $list) { ?>
                        <option value="<?php echo $list['id_conclusion']; ?>" <?php if($get_id[0]['id_conclusion']==$list['id_conclusion']){echo "selected";}?>><?php echo $list['nom_conclusion']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Gestión: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_gestione" id="id_gestione">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_gestion']))) {
                                            echo "selected=\"selected\"";
                                        } ?>>Seleccione</option>
                    <?php foreach ($list_gestion as $list) { ?>
                        <option value="<?php echo $list['id_gestion']; ?>" <?php if (!(strcmp($list['id_gestion'], $get_id[0]['id_gestion']))) {
                                                                                echo "selected=\"selected\"";
                                                                            } ?>><?php echo $list['nom_gestion']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Cantidad: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cantidade" name="cantidade" placeholder="Ingresar cantidad" value="<?php echo $get_id[0]['cantidad'] ?>">
            </div>

            <div class="form-group col-md-2">
                <label>Monto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="montoe" name="montoe" placeholder="Ingresar monto" value="<?php echo $get_id[0]['monto'] ?>">
            </div>

            

            <div class="form-group col-md-2">
                <label>Hora: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" class="form-control" id="horae" name="horae" value="<?php echo $get_id[0]['hora']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Descripción: </label>
            </div>
            <div class="form-group col-md-10">
                <textarea class="form-control" id="descripcione" name="descripcione" rows="5" placeholder="Ingresar descripción" autofocus><?php echo $get_id[0]['descripcion'] ?></textarea>
            </div>

            <!--<div class="form-group col-md-2">
                <label>Acción Inmediata: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="accion_inmediata" name="accion_inmediata" value="<?php echo $get_id[0]['accion_inmediata'] ?>">  
            </div>-->

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Tus Archivos Actuales: <a href="#" title="Puedes descargarlos o eliminarlos según lo decidas" class="anchor-tooltip tooltiped">
                        <div class="divdea">?</div>
                    </a></label>
            </div>

            <?php foreach ($get_id_files_ocurrencia as $list) {  ?>
                <?php if (substr($list['archivo'], -3) === "jpg" || substr($list['archivo'], -3) === "JPG") { ?>
                    <div id="i_<?php echo  $list['id_ocurrencia_archivo'] ?>" class="form-group col-sm-3">
                        <?php
                        echo '<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="' . substr($list['archivo'], -27) . '" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>';
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_ocurrencia_archivo'] ?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_ocurrencia_archivo'] ?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php } elseif (substr($list['archivo'], -3) === "png" || substr($list['archivo'], -3) === "PNG") { ?>
                    <div id="i_<?php echo  $list['id_ocurrencia_archivo'] ?>" class="form-group col-sm-3">
                        <?php
                        echo '<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="' . substr($list['archivo'], -27) . '" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>';
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_ocurrencia_archivo'] ?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_ocurrencia_archivo'] ?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php } elseif (substr($list['archivo'], -4) === "jpeg" || substr($list['archivo'], -4) === "JPEG") { ?>
                    <div id="i_<?php echo  $list['id_ocurrencia_archivo'] ?>" class="form-group col-sm-3">
                        <?php
                        echo '<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="' . substr($list['archivo'], -28) . '" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>';
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_ocurrencia_archivo'] ?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_ocurrencia_archivo'] ?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php } else {
                    echo "";
                } ?>
            <?php } ?>

            <div class="form-group col-md-12">
                <br>
            </div>

            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label text-bold">Agregar más archivos: <a href="#" title="Puede subir máximo 5 a la vez" class="anchor-tooltip tooltiped">
                        <div class="divdea">?</div>
                    </a> </label>
            </div>
            <div class="form-group col-sm-12">
                <input type="file" class="form-control" name="files_u_admin[]" id="files_u_admin" multiple>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="cod_ocurrencia" name="cod_ocurrencia" value="<?php echo $get_id[0]['cod_ocurrencia']; ?>">
        <input type="hidden" id="id_ocurrencia" name="id_ocurrencia" value="<?php echo $get_id[0]['id_ocurrencia']; ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Edit_Ocurrencia_Tienda_Admin();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Tipo_Piochae();
    });

    var ss = $(".basic_update").select2({ 
        tags: true
    });

    $('.basic_update').select2({
        dropdownParent: $('#ModalUpdate')
    });

    function Tipo_Piochae(){
        $(document)
        .ajaxStart(function() {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function() {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var id_tipo = $('#id_tipoe').val();
        var url = "<?php echo site_url(); ?>Corporacion/Tipo_Piocha";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_tipo':id_tipo},
            success: function(resp) {
                if(resp=="Si"){
                    $('.ocultar_tipo_piocha_u').show();
                }else{
                    $('.ocultar_tipo_piocha_u').hide();
                    $('#id_zona_u').val(0);
                    $('#id_estilo_u').val(0);
                }
            }
        });
    }

    $(".img_post").click(function() {
        window.open($(this).attr("src"), 'popUpWindow',
            "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file', function() {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Corporacion/Descargar_Archivo_Ocurrencia/" + image_id);
    });

    $(document).on('click', '#delete_file', function() {
        image_id = $(this).data('image_id');
        file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Corporacion/Delete_Archivo_Ocurrencia',
            data: {
                image_id: image_id
            },
            success: function(data) {
                file_col.remove();
            }
        });
    });

    $('#files_u_admin').fileinput({
        theme: 'fas',
        uploadUrl: '#',
        language: 'es',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['jpg','png','jpeg'],
    });
</script>