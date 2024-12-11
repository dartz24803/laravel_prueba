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

<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Ticket: <b><?php echo $get_id[0]['cod_tickets']; ?></b></h5>
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
                <label class="control-label text-bold">Descripción: <?php echo $get_id[0]['descrip_ticket']; ?></label> 
            </div>   

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Soporte: </label>
            </div>            
            <div class="form-group col-md-10">
                <select class="form-control" disabled>
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
                <input type="date" class="form-control" value="<?php echo $get_id[0]['f_fin'] ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>            
            <div class="form-group col-md-4">
                <select class="form-control" disabled>
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
                <input type="date" class="form-control" value="<?php echo $get_id[0]['f_fin_real'] ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Dificultad: </label>
            </div>            
            <div class="form-group col-md-4">
                <select class="form-control" disabled>
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
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "png"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img  loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?> 
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "jpeg"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "pdf"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy"  src="'. $list['archivos'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "xlsx"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . asset('template/assets/especiales/excel_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "xls"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . asset('template/assets/especiales/excel_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "pptx"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="'. asset('template/assets/especiales/ppt_example.png') .'"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "ppt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . asset('template/assets/especiales/ppt_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "docx"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . asset('template/assets/especiales/word_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "doc"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . asset('template/assets/especiales/word_example.png') . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>                    
                <?php }elseif (substr($list['archivos'],-3) === "txt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy"  src="' . $list['archivos'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }else { echo ""; } ?>
            <?php } ?>

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
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "png"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?> 
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "jpeg"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . $list['archivos'] . '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "pdf"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy" src="'. $list['archivos'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "xlsx"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . base_url() ."/assets/especiales/excel_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "xls"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . base_url() ."/assets/especiales/excel_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "pptx"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . base_url() ."/assets/especiales/ppt_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "ppt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . base_url() ."/assets/especiales/ppt_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "docx"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . base_url() ."/assets/especiales/word_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "doc"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . base_url() ."/assets/especiales/word_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
                    </div>                    
                <?php }elseif (substr($list['archivos'],-3) === "txt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets_soporte']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy"  src="' . base_url() . $list['archivos'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <button class="download" type="button" id="download_filesupport" data-image_id="<?php echo $list['id_archivos_tickets_soporte']?>"><i class="fas fa-cloud-download-alt"></i></button>
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
                <textarea  class="form-control" rows="5" placeholder="Comentario de Solución" disabled><?php echo $get_id[0]['coment_ticket']; ?></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Estado_Pendiente();
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
        window.location.replace("{{ url('Tickets/Descargar_Archivo_Ticket')}}/" + image_id);
    });

    $(document).on('click', '#download_filesupport', function () {
        image_id = $(this).data('image_id');
        window.location.replace("{{ url('Tickets/Descargar_Archivo_Ticket')}}/" + image_id);
    });
</script>