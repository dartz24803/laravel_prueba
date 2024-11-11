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
    .input-group > .input-group-append > .btn, .input-group > .input-group-append > .input-group-text, .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child), .input-group > .input-group-prepend:not(:first-child) > .btn, .input-group > .input-group-prepend:not(:first-child) > .input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        padding-top: 11px;
    }

    .kv-file-upload{
        display:none!important;
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

    .clasificacion {
        direction: rtl;
        unicode-bidi: bidi-override;
    }

    .radio_color{
        display: none;
    }

    .clasificacion label{
        font-size: 25px;
    }

    .label_color:hover,
    .label_color:hover ~ .label_color {
        color: orange;
    }

    .radio_color:checked ~ .label_color{
        color: orange;
    }
</style>

<form id="formulario_gpendiente_editar" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Tarea: <b><?php echo $get_id[0]['cod_pendiente']; ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="simple-tab" style="margin-top: -20px;">
            <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="documento-tab" data-toggle="tab" href="#tab-documento" role="tab" aria-controls="tab-documento" aria-selected="true">Tarea</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="accesos-tab" data-toggle="tab" href="#tab-accesos" role="tab" aria-controls="tab-accesos" aria-selected="false">Adjuntos y comentarios</a>
                </li>
            </ul>
            <div class="tab-content" id="simpletabContent">
                <div class="tab-pane fade show active" id="tab-documento" role="tabpanel" aria-labelledby="documento-tab">
                    <div class="col-md-12 row">
                        <div class="form-group col-md-12">
                            <p style="color: black;font-size: 16px;"><b><?php echo $get_id[0]['titulo']; ?></b></p>
                        </div>      

                        <div class="form-group col-md-12 margen">
                            <label class="control-label text-bold">Solicitante: <?php echo ucwords($get_id[0]['solicitante']); ?></label> 
                        </div>     
                        
                        <div class="form-group col-md-12 margen">
                            <label class="control-label text-bold">Tipo: <?php echo $get_id[0]['nom_tipo_tickets']; ?></label>
                        </div>            

                        <div class="form-group col-md-12 margen">
                            <label class="control-label text-bold">Área: <?php echo $get_id[0]['nom_area']; ?></label>
                        </div>        
                        
                        <?php if($get_id[0]['id_area']=="10" || $get_id[0]['id_area']=="41"){ ?>
                            <div class="form-group col-md-12 margen">
                                <label class="control-label text-bold">Costos: <?php echo $get_id[0]['costo']; ?></label> 
                            </div>   
                        <?php } ?>

                        <div class="form-group col-md-12 margen">
                            <label class="control-label text-bold">Descripción: <?php echo $get_id[0]['descripcion']; ?></label>
                        </div>   
                
                        <?php if($mostrar==1){ ?>
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Etiqueta: </label>
                            </div>   
                            <div class="form-group col-md-10">         
                                <select class="form-control basic_1u" name="id_subitem" id="id_subitem">
                                    <option value="0">Seleccionar</option>
                                    <?php foreach($list_subitem as $list){ ?>
                                        <option value="<?php echo $list['id_subitem']; ?>" <?php if($list['id_subitem']==$get_id[0]['id_subitem']){ echo "selected"; } ?>>
                                            <?php echo $list['nom_subitem']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>

                        <?php /*if($get_id[0]['id_area']==18){ ?>
                            <div class="form-group col-md-12">
                                <label class="control-label text-bold">Dificultad: <?php echo $get_id[0]['nom_dificultad']; ?></label> 
                            </div>   
                        <?php }*/ ?>

                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Asignado a: </label>
                        </div>            
                        <div class="form-group col-md-10">
                            <select class="form-control basic_2u" id="id_responsable" name="id_responsable">
                                <option value="0">Seleccionar</option>
                                <?php foreach($list_responsable as $list){ ?>
                                    <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_responsable']){ echo "selected"; } ?>>
                                        <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Fecha de vencimiento: </label>
                        </div>            
                        <div class="form-group col-md-4">
                            <input type="date" class="form-control" id="f_inicio" name="f_inicio" value="<?php echo $get_id[0]['f_inicio'] ?>">
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Estado: </label>
                        </div>            
                        <div class="form-group col-md-4"> 
                            <select class="form-control" name="estado" id="estado" onchange="Estado_Pendiente();">
                                <option value="0">Seleccionar</option>
                                <?php foreach($list_estado as $list){ ?>
                                    <option value="<?php echo $list['id_estado_tickets']; ?>" <?php if($list['id_estado_tickets']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                        <?php echo $list['nom_estado_tickets']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-2 ocultar_termino">
                            <label class="control-label text-bold">Fecha de termino: </label>
                        </div>             
                        <div class="form-group col-md-4 ocultar_termino">
                            <input type="date" class="form-control" id="f_entrega" name="f_entrega" value="<?php echo $get_id[0]['f_entrega'] ?>">
                        </div>

                        <?php if($get_id[0]['id_area']==18){ ?>
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Dificultad: </label>
                            </div>            
                            <div class="form-group col-md-4">
                                <select class="form-control" name="dificultad" id="dificultad">
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
                </div>
                <div class="tab-pane fade" id="tab-accesos" role="tabpanel" aria-labelledby="accesos-tab">
                    <div class="col-md-12 row">
                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Los Archivos Actuales del Pendiente: <a href="#" title="Estos archivos sirven para entender mejor del problema a tratar" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a></label>
                        </div>
                        <?php foreach($list_archivo as $list) {  ?>
                            <?php if(substr($list['archivo'],-3) === "jpg" || substr($list['archivo'],-3) === "JPG"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "png" || substr($list['archivo'],-3) === "PNG"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                                    ?> 
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-4) === "jpeg" || substr($list['archivo'],-4) === "JPEG"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "pdf"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><embed src="'. $url[0]['url_config'] . $list['archivo'] . '" width="100%" height="200px" /></div>';
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-4) === "xlsx"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] ."/assets/especiales/excel_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "xls"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] ."/assets/especiales/excel_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-4) === "pptx"){ ?> 
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] ."/assets/especiales/ppt_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "ppt"){ ?> 
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] ."/assets/especiales/ppt_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-4) === "docx"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3"> 
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] ."/assets/especiales/word_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "doc"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3"> 
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] ."/assets/especiales/word_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>                    
                            <?php }elseif (substr($list['archivo'],-3) === "txt"){ ?> 
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3"> 
                                    <?php 
                                    echo'<div id="lista_escogida"><embed  src="' . $url[0]['url_config'] . $list['archivo'] . '" width="100%" height="200px" /></div>';
                                    ?>
                                    <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                                <?php }else{ echo ""; } ?>
                        <?php } ?>

                        <div class="form-group col-md-12">
                            <br>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Agregar archivos de sustento de la solución<a href="#" title="Puede subir máximo 5 a la vez" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a> </label>
                        </div>  

                        <div class="form-group col-sm-12">
                            <input type="file" class="form-control" name="files_u[]" id="files_u" multiple>
                        </div>

                        <div class="form-group col-md-12">
                            <br>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Los Archivos de solución del Pendiente : <a href="#" title="Estos archivos sirven para que el solicitante pueda entender la solución dada" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a></label>
                        </div>
                        <?php foreach($list_gestion_archivo as $list) {  ?>
                            <?php if(substr($list['archivo'],-3) === "jpg" || substr($list['archivo'],-3) === "JPG"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "png" || substr($list['archivo'],-3) === "PNG"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                                    ?> 
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-4) === "jpeg" || substr($list['archivo'],-4) === "JPEG"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "pdf"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><embed src="'. $url[0]['url_config'] . $list['archivo'] . '" width="100%" height="200px" /></div>';
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-4) === "xlsx"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] ."/assets/especiales/excel_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "xls"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] ."/assets/especiales/excel_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-4) === "pptx"){ ?> 
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] ."/assets/especiales/ppt_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "ppt"){ ?> 
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] ."/assets/especiales/ppt_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-4) === "docx"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3"> 
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] ."/assets/especiales/word_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php }elseif (substr($list['archivo'],-3) === "doc"){ ?>
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3"> 
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] ."/assets/especiales/word_example.png". '"></div>'; 
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>                    
                            <?php }elseif (substr($list['archivo'],-3) === "txt"){ ?> 
                                <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3"> 
                                    <?php 
                                    echo'<div id="lista_escogida"><embed  src="' . $url[0]['url_config'] . $list['archivo'] . '" width="100%" height="200px" /></div>';
                                    ?>
                                    <button class="download" type="button" id="download_file_gestion" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                    <button class="delete" type="button" id="delete_file_gestion" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                </div>
                                <?php }else{ echo ""; } ?>
                        <?php } ?>

                        <div class="form-group col-md-12">
                            <br>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Comentarios: </label>
                            <textarea class="form-control" id="comentario" name="comentario" rows="5" placeholder="Ingresar Comentario"></textarea>
                        </div>

                        <?php foreach($historial_comentarios as $hist){ ?>
                            <div class="form-group col-md-2 text-center">
                                <img src="<?php if(isset($hist['foto_nombre'])){ echo $_SESSION['usuario'][0]['url_foto'].$hist['foto_nombre']; }else{ echo base_url()."template/assets/img/avatar.jpg"; } ?>" 
                                width="55" height="55" class="img-fluid" alt="Foto">
                            </div>
                            <div class="form-group col-md-10">
                                <div class="col-md-12 row" style="margin:0;padding:0;">
                                    <div class="col-md-6" style="text-align:left;margin:0;padding:0;">
                                        <label class="control-label text-bold"><?php echo ucwords($hist['usuario_comentario']); ?></label>
                                    </div>
                                    <div class="col-md-6" style="text-align:right;margin:0;padding:0;">
                                        <label class="control-label text-bold"><?php echo $hist['fecha_comentario']; ?></label>
                                    </div>
                                </div>
                                <label class="control-label text-bold"><?php echo $hist['comentario']; ?></label>
                                <!--<label class="control-label text-bold" style="background-color:red;display:block;"><?php //echo ucwords($hist['usuario_comentario'])."&nbsp;".$hist['fecha_comentario'] ?>: </label>-->
                            </div>
                        <?php }?>

                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <div class="modal-footer">
        <input name="id_pendiente" type="hidden" class="form-control" id="id_pendiente" value="<?php echo $get_id[0]['id_pendiente']; ?>">
        <input type="hidden" id="nivel_busqueda" name="nivel_busqueda" value="<?php echo $_SESSION['usuario'][0]['id_nivel']; ?>">
        <button class="btn btn-primary mt-3" onclick="Update_Gestion_Pendiente();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Estado_Pendiente();
    });

    var ss = $(".basic_1u").select2({
        tags: true,
    });

    $('.basic_1u').select2({
        dropdownParent: $('#ModalUpdate')
    });

    var ss = $(".basic_2u").select2({
        tags: true,
    });

    $('.basic_2u').select2({
        dropdownParent: $('#ModalUpdate')
    });

    function Estado_Pendiente(){
        var estado=$('#estado').val();

        if(estado==3){
            $('.ocultar_termino').show();
        }else{
            $('.ocultar_termino').hide();
            $('#f_entrega').val('');
        }
    }

    $('#files_u').fileinput({
        theme: 'fas',
        uploadUrl: '#',
        language: 'es',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['jpg', 'png','txt','pdf','xlsx','pptx','docx','jpeg','xls','ppt','doc'],
    });

    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Corporacion/Descargar_Archivo_Pendiente/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Corporacion/Delete_Archivo_Pendiente',
            data: {'image_id':image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    $(document).on('click', '#download_file_gestion', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Corporacion/Descargar_Archivo_Gestion_Pendiente/" + image_id);
    });

    $(document).on('click', '#delete_file_gestion', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Corporacion/Delete_Archivo_Gestion_Pendiente',
            data: {'image_id':image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    function Update_Gestion_Pendiente() { 
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_gpendiente_editar'));
        var url = "<?php echo site_url(); ?>Corporacion/Update_Gestion_Pendiente";
        var id_nivel = $("#nivel_busqueda").val();

        if (Valida_Update_Gestion_Pendiente()) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Mis_Tareas();
                        $("#ModalUpdate .close").click()
                    });
                }
            });
        } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Valida_Update_Gestion_Pendiente() {
        if ($('#id_responsable').val() == '0') {
            msgDate = 'Debe seleccionar Asignado a.';
            inputFocus = '#id_responsable';
            return false;
        }
        if ($('#estado').val() == '0') {
            msgDate = 'Debe seleccionar Estado.';
            inputFocus = '#estado';
            return false;
        }
        if($('#estado').val() == '3'){
            if ($('#f_entrega').val() == '') {
                msgDate = 'Debe ingresar Fecha de termino.';
                inputFocus = '#f_entrega';
                return false;
            }
        }
        if ($('#comentario').val() != '') {
            if ($('#id_responsable').val() == '0') {
                msgDate = 'Debe seleccionar Asignado a para poder ingresar comentarios.';
                inputFocus = '#id_responsable';
                return false;
            }
        }
        return true;
    }
</script>
