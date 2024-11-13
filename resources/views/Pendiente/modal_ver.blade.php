<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<style>
     .kv-file-upload{
        display:none!important;
    }
    .input-group > .input-group-append > .btn, .input-group > .input-group-append > .input-group-text, .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child), .input-group > .input-group-prepend:not(:first-child) > .btn, .input-group > .input-group-prepend:not(:first-child) > .input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        padding-top: 11px;
    }
</style>

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Ver tarea: <b><?php echo $get_id[0]['cod_pendiente']; ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-lg-12 row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>            
            <div class="form-group col-lg-4">
                <select class="form-control" disabled>
                    <option value="0">Seleccionar</option>
                    <?php foreach($list_tipo_tickets as $list){ ?>
                        <option value="<?php echo $list['id_tipo_tickets']; ?>" <?php if($list['id_tipo_tickets']==$get_id[0]['id_tipo']){ echo "selected"; } ?>>
                            <?php echo $list['nom_tipo_tickets']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Area: </label>
            </div>            
            <div class="form-group col-lg-4">
                <select class="form-control" disabled>
                    <option value="0">Seleccionar</option>
                    <?php foreach($list_area as $list){ ?>
                        <option value="<?php echo $list['id_area']; ?>" <?php if($list['id_area']==$get_id[0]['id_area']){ echo "selected"; } ?>>
                            <?php echo $list['nom_area']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Asignado a: </label>
            </div>            
            <div class="form-group col-md-10">
                <select class="form-control" disabled>
                    <option value="0">Seleccionar</option>
                    <?php foreach($list_responsable as $list){ ?>
                        <option value="<?php echo $list->id_usuario; ?>" <?php if($list->id_usuario==$get_id[0]['id_responsable']){ echo "selected"; } ?>>
                            <?php echo $list->usuario_nombres." ".$list->usuario_apater." ".$list->usuario_amater; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    
        <div class="col-lg-12 row ver_infraestructura_u">
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Mantenimiento: </label>
                <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_mantenimiento']==1){ echo "selected"; } ?>>Recurrente</option>
                    <option value="2" <?php if($get_id[0]['id_mantenimiento']==2){ echo "selected"; } ?>>Emergencia</option>
                    <option value="3" <?php if($get_id[0]['id_mantenimiento']==3){ echo "selected"; } ?>>Otros</option>
                </select>
            </div>
            @if(!empty($list_especialidad))
                <div class="form-group col-lg-6 ver_especialidad_u">
                    <label class="control-label text-bold">Especialidad: </label>
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_especialidad as $list){ ?>
                            <option value="<?= $list['id']; ?>" <?php if($list['id']==$get_id[0]['id_especialidad']){ echo "selected"; } ?>><?= $list['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            @endif
        </div>

        <div class="col-lg-12 row ver_equipo_i">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Equipo: </label>
                <input type="text" class="form-control" id="equipo_i" name="equipo_i" placeholder="Ingresar Equipo" value="<?php echo $get_id[0]['equipo_i']; ?>" disabled>
            </div>
        </div>
        
        <div class="col-lg-12 row">
            <div class="form-group col-lg-12">
                <?php if(($get_id[0]['id_area']=="10" || $get_id[0]['id_area']=="41") && ($get_id[0]['id_mantenimiento']=="1" || $get_id[0]['id_mantenimiento']=="2")){ ?>
                    <label class="control-label text-bold">Título:</label>
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_titulo as $list){ ?>
                            <option value="<?= $list['id']; ?>" <?php if($list['id']==$get_id[0]['titulo']){ echo "selected"; } ?>><?= $list['nombre']; ?></option>
                        <?php } ?>
                    </select>
                <?php }else{ ?>
                    <label class="control-label text-bold">Título: </label>
                    <input type="text" class="form-control" placeholder="Ingresar título" value="<?php echo $get_id[0]['titulo']; ?>" disabled>  
                <?php } ?>
            </div>
        </div>

        <div class="col-lg-12 row">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Descripción: </label>
                <textarea class="form-control" rows="5" placeholder="Ingresar descripción" disabled><?php echo $get_id[0]['descripcion']; ?></textarea>
            </div>
            @if(!empty($list_subitem))
                <div class="form-group col-lg-2 ver_etiqueta_u"> 
                    <label class="control-label text-bold">Etiqueta: </label>
                </div>   
                <div class="form-group col-lg-10 ver_etiqueta_u">         
                    <select class="form-control" disabled> 
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_subitem as $list){ ?>
                            <option value="<?php echo $list['id_subitem']; ?>" <?php if($list['id_subitem']==$get_id[0]['id_subitem']){ echo "selected"; } ?>>
                                <?php echo $list['nom_subitem']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            @endif

            <?php if($get_id[0]['id_area']==18){ ?>
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Dificultad:</label> 
                </div>
                <div class="form-group col-lg-4">
                    <select class="form-control" disabled>
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_complejidad as $list){ ?>
                            <option value="<?php echo $list['id_complejidad']; ?>" <?php if($list['id_complejidad']==$get_id[0]['dificultad']){ echo "selected"; } ?>>
                                <?php echo $list['descripcion']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>   
            <?php } ?>
        </div>

        <?php if(count($list_archivo)>0){ ?>
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Tus Archivos Actuales: <a href="#" title="Puedes descargarlos según lo decidas" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a></label>
            </div>

            <div class="form-group col-lg-12 row">
                <?php foreach($list_archivo as $list) {  ?>
                    <?php if(substr($list['archivo'],-3) === "jpg" || substr($list['archivo'],-3) === "JPG"){ ?>
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3">
                            <?php 
                            echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                            ?>
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                    <?php }elseif (substr($list['archivo'],-3) === "png" || substr($list['archivo'],-3) === "PNG"){ ?>
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3">
                            <?php 
                            echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                            ?> 
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                    <?php }elseif (substr($list['archivo'],-4) === "jpeg" || substr($list['archivo'],-4) === "JPEG"){ ?>
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3">
                            <?php 
                            echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                            ?>
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                    <?php }elseif (substr($list['archivo'],-3) === "pdf"){ ?>
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3">
                            <?php 
                            echo'<div id="lista_escogida"><embed src="'. $url[0]['url_config'] . $list['archivo'] . '" width="100%" height="200px" /></div>';
                            ?>
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                    <?php }elseif (substr($list['archivo'],-4) === "xlsx"){ ?>
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3">
                            <?php 
                            echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                            ?> 
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                    <?php }elseif (substr($list['archivo'],-3) === "xls"){ ?>
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3">
                            <?php 
                            echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                            ?>
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                    <?php }elseif (substr($list['archivo'],-4) === "pptx"){ ?> 
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3">
                            <?php 
                            echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                            ?>
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                    <?php }elseif (substr($list['archivo'],-3) === "ppt"){ ?> 
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3">
                            <?php 
                            echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                            ?>
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                    <?php }elseif (substr($list['archivo'],-4) === "docx"){ ?>
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3"> 
                            <?php 
                            echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                            ?>
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                    <?php }elseif (substr($list['archivo'],-3) === "doc"){ ?>
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3"> 
                            <?php 
                            echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                            ?>
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>                    
                    <?php }elseif (substr($list['archivo'],-3) === "txt"){ ?> 
                        <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-lg-3"> 
                            <?php 
                            echo'<div id="lista_escogida"><embed  src="' . $url[0]['url_config'] . $list['archivo'] . '" width="100%" height="200px" /></div>';
                            ?>
                            <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                        <?php }else{ echo ""; } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <div class="modal-footer">
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() { 
        var id_area = <?= $get_id[0]['id_area'] ?>;
        var id_mantenimiento = <?= $get_id[0]['id_mantenimiento'] ?>;

        if(id_area == "10" || id_area == "41"){
            $('.ver_infraestructura_u').show();
            $('.ver_etiqueta_u').hide();
            $('.ver_equipo_i').hide();

            if(id_mantenimiento=="3"){
                $('.ver_especialidad_u').hide();
                $('#id_especialidade').val(0);
            }
        }else if(id_area=="13"){
            $('.ver_equipo_i').show();
            $('#id_subitem_i').html('<option value="0">Seleccionar</option>');
            $(".ver_infraestructura_u").hide();
            $('#id_mantenimiento').val(0);
            $('#id_especialidad').val(0);
            $('#titulo_tarea').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Ingresar título">');
            $('.ver_etiqueta_u').hide();
        }else{
            $('.ver_infraestructura_u').hide();
            if(<?= $get_id[0]['area_usuario']; ?>!="14"){
                $('.ver_etiqueta_u').hide();
            }
        }
    });

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("{{ url('Tarea/Descargar_Archivo_Pendiente') }}/" + image_id);
    });
</script>
