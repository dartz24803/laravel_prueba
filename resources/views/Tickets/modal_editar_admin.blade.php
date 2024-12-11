<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="{{ asset('template/inputfiles/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('template/inputfiles/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<script src="{{ asset('template/inputfiles/js/plugins/piexif.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/plugins/sortable.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/fileinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/locales/es.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/fas/theme.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/explorer-fas/theme.js') }}" type="text/javascript"></script>

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
</style>

<?php
    $id_nivel = session('usuario')->id_nivel;
    $id_puesto = session('usuario')->id_puesto;
?>

<form id="formulario_admin" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Tickets: <b><?php echo $get_id[0]['cod_tickets']; ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <p style="color: black;font-size: 16px;"><b><?php echo $get_id[0]['titulo_tickets']; ?></b></p>
            </div>      

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Solicitado por: <?php echo ucwords($get_id[0]['solicitante']); ?></label> 
            </div>     
            
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Tipo: <?php echo $get_id[0]['nom_tipo_tickets']; ?></label> 
            </div>            

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Área: <?php echo $get_id[0]['nom_area']; ?></label>
            </div>                

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Descripción: <?php echo nl2br($get_id[0]['descrip_ticket']); ?></label>
            </div>   

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Soporte: </label>
            </div>            
            <div class="form-group col-md-10">
                <select class="form-control basic_u" id="finalizado_por" name="finalizado_por">
                    <option value="0">Seleccionar</option>
                    <?php foreach($list_encargado as $list){ ?>
                        <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['finalizado_por']){ echo "selected"; } ?>>
                            <?php echo $list['encargado']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Fecha de vencimiento: </label>
            </div>            
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="f_fin" name="f_fin" value="<?php echo $get_id[0]['f_fin'] ?>">
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
                <input type="date" class="form-control" id="f_fin_real" name="f_fin_real" value="<?php echo $get_id[0]['f_fin_real'] ?>">
            </div>

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

            <div class="form-group col-md-12">
                <br>
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Los Archivos Actuales del Ticket : <a href="#" title="Estos archivos sirven para entender mejor del problema a tratar" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a></label>
            </div>
            <?php foreach($get_id_files_tickets as $list) {  ?>
                <?php if(substr($list['archivos'],-3) === "jpg"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "png"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img  loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?> 
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "jpeg"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "pdf"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy"  src="'. $list['archivos'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "xlsx"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . asset('template/assets/especiales/excel_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "xls"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . asset('template/assets/especiales/excel_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "pptx"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . asset('template/assets/especiales/ppt_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "ppt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . asset('template/assets/especiales/ppt_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "docx"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . asset('template/assets/especiales/word_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "doc"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . asset('template/assets/especiales/word_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>                    
                <?php }elseif (substr($list['archivos'],-3) === "txt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy"  src="' . $list['archivos'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                    <?php }else { echo ""; } ?>
            <?php } ?>

            <div class="form-group col-md-12">
                <br>
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Agregar archivos de sustento de la solución<a href="#" title="Puede subir máximo 5 ala vez" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a> </label>
            </div>  
            <div class="form-group col-sm-12">
                <input type="file" class="form-control" name="filesoporte[]" id="filesoporte" multiple>
            </div>

            <div class="form-group col-md-12">
                <br>
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Los Archivos de solución del Ticket : <a href="#" title="Estos archivos sirven para que el solicitante pueda entender la solución dada" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a></label>
            </div>
            <?php foreach($get_id_files_tickets_soporte as $list) {  ?>
                <?php if(substr($list['archivos'],-3) === "jpg"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "png"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?> 
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "jpeg"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "pdf"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy" src="'. $list['archivos'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "xlsx"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . asset('template/assets/especiales/excel_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "xls"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . asset('template/assets/especiales/excel_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "pptx"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . asset('template/assets/especiales/ppt_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "ppt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . asset('template/assets/especiales/ppt_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "docx"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . asset('template/assets/especiales/word_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "doc"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . asset('template/assets/especiales/word_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>                    
                <?php }elseif (substr($list['archivos'],-3) === "txt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy"  src="' . $list['archivos'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_filesupport" data-image_id="<?php echo  $list['id_archivos_tickets_soporte']?>"><i class="fas fa-trash"></i></button>
                    </div>
                    <?php }else {?>  
                        <?php  echo''; 
                } ?>
            <?php } ?>

            <div class="form-group col-md-12">
                <br>
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Comentario de Solución: </label>
                <textarea  class="form-control" id="coment_ticket" name="coment_ticket" rows="5" placeholder="Comentario de Solución"><?php echo $get_id[0]['coment_ticket']; ?></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_tickets" type="hidden" class="form-control" id="id_tickets" value="<?php echo $get_id[0]['id_tickets']; ?>">
        @csrf
        <button class="btn btn-primary mt-3" onclick="Update_Tickets_Admin();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Estado_Pendiente();
    });

    var ss = $(".basic_u").select2({
        tags: true
    });

    $('.basic_u').select2({
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

    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("{{ url('Ticket/Descargar_Archivo_Ticket') }}/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        image_id = $(this).data('image_id');
        file_col = $('#i_' + image_id);
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: 'POST',
            url: "{{ url('Ticket/delete_archivos_tickets') }}",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {image_id: image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    $('#filesoporte').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['jpg', 'png','txt','pdf','xlsx','pptx','docx','jpeg','xls','ppt','doc'],
    });

    $(document).on('click', '#download_filesupport', function () {
        image_id = $(this).data('image_id');
        window.location.replace("{{ url('Ticket/download_filesupport') }}/" + image_id);
    });

    $(document).on('click', '#delete_filesupport', function () {
        image_id = $(this).data('image_id');
        file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: "{{ url('Ticket/delete_archivos_tickets_soporte') }}",
            data: {image_id: image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    function Update_Tickets_Admin(){
        Cargando()

        var dataString = new FormData(document.getElementById('formulario_admin'));
        var url = "{{ url('Tickets/Update_Tickets_Admin') }}";
        var csrfToken = $('input[name="_token"]').val();

        // if (Valida_Update_Tickets_Admin()) {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $("#ModalUpdate .close").click()
                        Cambiar_Tickets_Admin();
                    });
                }
            });
        // } else {
        //     bootbox.alert(msgDate)
        //     var input = $(inputFocus).parent();
        //     $(input).addClass("has-error");
        //     $(input).on("change", function() {
        //         if ($(input).hasClass("has-error")) {
        //             $(input).removeClass("has-error");
        //         }
        //     });
        // }
    }

    // function Valida_Update_Tickets_Admin() {
    //     if ($('#estado').val() == '0') {
    //         msgDate = 'Debe seleccionar Estado.';
    //         inputFocus = '#estado';
    //         return false;
    //     }
    //     if($('#estado').val() == '3'){
    //         if ($('#f_fin_real').val() == '') {
    //             msgDate = 'Debe ingresar Fecha de termino.';
    //             inputFocus = '#f_fin_real';
    //             return false;
    //         }
    //     }
    //     return true;
    // }
</script>