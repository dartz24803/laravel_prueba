<link href="{{ asset('template/inputfiles/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="{{ asset('template/inputfiles/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<script src="{{ asset('template/inputfiles/js/plugins/piexif.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/plugins/sortable.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/fileinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/locales/es.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/fas/theme.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/explorer-fas/theme.js') }}" type="text/javascript"></script>

<style>
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
    $menu_gestion_pendiente=explode(",", session('usuario')->grupo_puestos);
    $mostrar_menu=in_array( session('usuario')->id_puesto,$menu_gestion_pendiente);

    $id_nivel= session('usuario')->id_nivel;
    $id_puesto= session('usuario')->id_puesto;
?>

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar tarea: <b><?php echo $get_id[0]['cod_pendiente']; ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-lg-12 row">
            <?php if($mostrar_menu==true || $id_nivel==1 || $id_puesto==29 || $id_puesto==16 || 
                    $id_puesto==20 || $id_puesto==26 || $id_puesto==27 || $id_puesto==98 ||
                    $id_puesto==128){ ?>
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Tipo: </label>
                </div>            
                <div class="form-group col-lg-4">
                    <select class="form-control" name="id_tipo_u" id="id_tipo_u">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_tipo_tickets as $list){ ?>
                            <option value="<?php echo $list['id_tipo_tickets']; ?>" <?php if($list['id_tipo_tickets']==$get_id[0]['id_tipo']){ echo "selected"; } ?>>
                                <?php echo $list['nom_tipo_tickets'];?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php }else{ ?>
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Tipo: </label>
                </div>            
                <div class="form-group col-lg-4">
                    <select class="form-control" name="id_tipo_u" id="id_tipo_u">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_tipo_tickets as $list){ if($list['id_tipo_tickets']!=4){ ?>
                            <option value="<?php echo $list['id_tipo_tickets']; ?>" <?php if($list['id_tipo_tickets']==$get_id[0]['id_tipo']){ echo "selected"; } ?>>
                                <?php echo $list['nom_tipo_tickets'];?>
                            </option>
                        <?php } } ?>
                    </select>
                </div>
            <?php } ?>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Area: </label>
            </div>            
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_area_u" id="id_area_u" onchange="Responsable_Pendiente_U(); Area_Infraestructura_U();">
                    <option value="0">Seleccionar</option>
                    <?php foreach($list_area as $list){ ?>
                        <option value="<?php echo $list['id_area']; ?>" <?php if($list['id_area']==$get_id[0]['id_area']){ echo "selected"; } ?>>
                            <?php echo $list['nom_area']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-lg-12 row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Asignado a: </label>
            </div>            
            <div class="form-group col-lg-10">
                <select class="form-control basic_u" id="id_responsable_u" name="id_responsable_u">
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
                <select class="form-control" name="id_mantenimientoe" id="id_mantenimientoe" onchange="Mantenimiento_Otros_U();">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_mantenimiento']==1){ echo "selected"; } ?>>Recurrente</option>
                    <option value="2" <?php if($get_id[0]['id_mantenimiento']==2){ echo "selected"; } ?>>Emergencia</option>
                    <option value="3" <?php if($get_id[0]['id_mantenimiento']==3){ echo "selected"; } ?>>Otros</option>
                </select>
            </div>

            @if(!empty($list_especialidad))
                <div class="form-group col-lg-6 ver_especialidad_u">
                    <label class="control-label text-bold">Especialidad: </label>
                    <select class="form-control" name="id_especialidade" id="id_especialidade" onchange="Titulo_Pendientee();">
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
                <input type="text" class="form-control" id="equipo_i" name="equipo_i" placeholder="Ingresar Equipo" value="<?php echo $get_id[0]['equipo_i']; ?>">
            </div>
        </div>

        <div class="col-lg-12 row">
            <div id="titulo_tareae" class="form-group col-lg-12">
                <?php if(($get_id[0]['id_area']=="10" || $get_id[0]['id_area']=="41") && ($get_id[0]['id_mantenimiento']=="1" || $get_id[0]['id_mantenimiento']=="2")){ ?>
                    <label class="control-label text-bold">Título:</label>
                    <select class="form-control" id="titulo_u" name="titulo_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_titulo as $list){ ?>
                            <option value="<?= $list['id']; ?>" <?php if($list['id']==$get_id[0]['titulo']){ echo "selected"; } ?>><?= $list['nombre']; ?></option>
                        <?php } ?>
                    </select>
                <?php }else{ ?>
                    <label class="control-label text-bold">Título: </label>
                    <input type="text" class="form-control" id="titulo_u" name="titulo_u" placeholder="Ingresar título" value="<?php echo $get_id[0]['titulo']; ?>">
                <?php } ?>
            </div>

            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Descripción: </label>
                <textarea class="form-control" id="descripcion_u" name="descripcion_u" rows="5" placeholder="Ingresar descripción"><?php echo $get_id[0]['descripcion']; ?></textarea>
            </div>

            @if(!empty($list_especialidad))
                <div class="form-group col-lg-2 ver_etiqueta_u">
                    <label class="control-label text-bold">Etiqueta: </label>
                </div>   
                <div id="select_subitem_u" class="form-group col-lg-10 ver_etiqueta_u">         
                    <select class="form-control basic_u" name="id_subitem_u" id="id_subitem_u">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_subitem as $list){ ?>
                            <option value="<?php echo $list['id_subitem']; ?>" <?php if($list['id_subitem']==$get_id[0]['id_subitem']){ echo "selected"; } ?>>
                                <?php echo $list['nom_subitem']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            @endif
        </div>
            
        <div class="col-lg-12 row">
            <?php if(count($list_archivo)>0){ ?>
                <div class="form-group col-lg-12">
                    <label class="control-label text-bold">Tus Archivos Actuales: <a href="#" title="Puedes descargarlos o eliminarlos según lo decidas" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a></label>
                </div>

                <div class="form-group col-lg-12 row">
                    <?php foreach($list_archivo as $list) {  ?>
                        <?php if(substr($list['archivo'],-3) === "jpg" || substr($list['archivo'],-3) === "JPG"){ ?>
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php } ?>
                                
                            </div>
                        <?php }elseif (substr($list['archivo'],-3) === "png" || substr($list['archivo'],-3) === "PNG"){ ?>
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                                ?> 
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?> 
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                                
                            </div>
                        <?php }elseif (substr($list['archivo'],-4) === "jpeg" || substr($list['archivo'],-4) === "JPEG"){ ?>
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] . $list['archivo'] . '"></div>'; 
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?> 
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                                
                            </div>
                        <?php }elseif (substr($list['archivo'],-3) === "pdf"){ ?>
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><embed src="'. $url[0]['url_config'] . $list['archivo'] . '" width="100%" height="200px" /></div>';
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?> 
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                            </div>
                        <?php }elseif (substr($list['archivo'],-4) === "xlsx"){ ?>
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?> 
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                            </div>
                        <?php }elseif (substr($list['archivo'],-3) === "xls"){ ?>
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?> 
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                            </div>
                        <?php }elseif (substr($list['archivo'],-4) === "pptx"){ ?> 
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?> 
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                            </div>
                        <?php }elseif (substr($list['archivo'],-3) === "ppt"){ ?> 
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?> 
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                            </div>
                        <?php }elseif (substr($list['archivo'],-4) === "docx"){ ?>
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3"> 
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-28) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?>
                                    <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                            </div>
                        <?php }elseif (substr($list['archivo'],-3) === "doc"){ ?>
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3"> 
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" alt="'.substr($list['archivo'],-27) .'" src="' . $url[0]['url_config'] .$list['archivo']. '"></div>'; 
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?>
                                <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                            </div>                    
                        <?php }elseif (substr($list['archivo'],-3) === "txt"){ ?> 
                            <div id="i_<?php echo  $list['id_archivo']?>" class="form-group col-sm-3"> 
                                <?php 
                                echo'<div id="lista_escogida"><embed  src="' . $url[0]['url_config'] . $list['archivo'] . '" width="100%" height="200px" /></div>';
                                ?>
                                <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivo']?>"><i class="fas fa-cloud-download-alt"></i></button>
                                <?php if($get_id[0]['estado']==1){?>
                                <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivo']?>"><i class="fas fa-trash"></i></button>
                                <?php }?>
                            </div>
                            <?php }else{ echo ""; } ?>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if($get_id[0]['estado']==1){?>
                <div class="form-group col-lg-12">
                    <label class="control-label text-bold">Archivos: </label>
                </div>

                <div class="form-group col-sm-12">
                    <input type="file" class="form-control" name="files_u[]" id="files_u" multiple>
                </div>
            <?php }?>

            <!-- <div class="row d-flex justify-content-center mb-2 mt-2">
                <button type="button" class="btn btn-secondary" id="boton_camara" onclick="Activar_Camara();">Activar cámara</button>
            </div>
            <div class="row d-flex justify-content-center mb-2" id="div_camara" style="display:none !important;">
                <video id="video" autoplay style="max-width: 95%;"></video>
            </div>
            <div class="row d-flex justify-content-center mb-2 mt-2" id="div_tomar_foto">
                <button type="button" class="btn btn-info" onclick="Tomar_Foto();">Tomar foto</button>
            </div>
            <div class="row d-flex justify-content-center text-center" id="div_canvas" style="display:none !important;">
                <canvas id="canvas" width="640" height="480" style="max-width:95%;"></canvas>
            </div>
            
            <div id="imagen-container" class="d-flex justify-content-center p-2">
            </div> -->
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id_pendiente" value="<?php echo $get_id[0]['id_pendiente']; ?>">
        <button class="btn btn-primary mt-3" onclick="Update_Pendiente();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() { 
        var id_area = $('#id_area_u').val();
        var id_mantenimiento = $('#id_mantenimientoe').val();

        if(id_area == "10" || id_area == "41"){
            $('.ver_infraestructura_u').show();
            $('.ver_etiqueta_u').hide();
            $('.ver_equipo_i').hide();

            if(id_mantenimiento=="3"){
                $('.ver_especialidad_u').hide();
                $('#id_especialidade').val(0);
            }
        }else{
            $('.ver_infraestructura_u').hide();
            if(<?= $get_id[0]['area_usuario']; ?>!="14"){
                $('.ver_etiqueta_u').hide();
            }
        }
    });

    $('.basic_u').select2({
        dropdownParent: $('#ModalUpdate')
    });

    function Responsable_Pendiente_U(){
        Cargando();

        var id_area = $('#id_area_u').val();

        if(id_area=="0"){
            $('#id_responsable_u').html('<option value="0">Seleccionar</option>');
        }else{
            var url="{{ url('Tareas/Responsable_Pendiente') }}";

            $.ajax({    
                type:"POST",
                url:url,
                data:{'id_area':id_area},
                success:function (resp) {
                    $('#id_responsable_u').html(resp);
                }
            });
        }
    }

    function Area_Infraestructura_U(){
        Cargando();

        var id_area = $('#id_area_u').val();
        var url = "{{ url('Tareas/Area_Infraestructura') }}"; 

        $.ajax({    
            type:"POST",
            url:url,
            data:{'id_area':id_area},
            success:function (resp) {
                if(id_area=="0"){
                    $('.ver_equipo_i').hide();
                    $('.ver_etiqueta_u').hide();
                    $('#id_subitem_u').html('<option value="0">Seleccionar</option>');
                    $(".ver_infraestructura_u").hide();
                    $('#id_mantenimientoe').val(0);
                    $('#id_especialidade').val(0);
                    $('#titulo_tareae').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_u" name="titulo_u" placeholder="Ingresar título">');
                }else if(id_area=="10" || id_area=="41"){
                    $('.ver_equipo_i').hide();
                    $('.ver_etiqueta_u').hide();
                    $('#id_subitem_u').html('<option value="0">Seleccionar</option>');

                    $(".ver_infraestructura_u").show();
                    $('#id_especialidade').html(resp);
                    $('#titulo_tareae').html('<label class="control-label text-bold">Título:</label><select class="form-control" id="titulo_u" name="titulo_u"><option value="0">Seleccione</option></select>');
                }else if(id_area=="13"){
                    $('.ver_equipo_i').show();
                    $('#id_subitem_i').html('<option value="0">Seleccionar</option>');
                    $(".ver_infraestructura_i").hide();
                    $('#id_mantenimiento').val(0);
                    $('#id_especialidad').val(0);
                    $('#titulo_tarea').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Ingresar título">');
                    $(".ver_cotizacion_i").hide();
                }else{
                    var area_usuario = <?= $get_id[0]['area_usuario']; ?>;

                    if(area_usuario=="14"){
                        $('.ver_etiqueta_u').show();
                        $('#id_subitem_u').html(resp);
                    }else{
                        $('.ver_etiqueta_u').hide();
                        $('#id_subitem_u').html('<option value="0">Seleccionar</option>');
                    }

                    $('.ver_equipo_i').hide();
                    $(".ver_infraestructura_u").hide();
                    $('#id_mantenimientoe').val(0);
                    $('#id_especialidade').val(0);
                    $('#titulo_tareae').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_u" name="titulo_u" placeholder="Ingresar título">');
                }
            }
        });
    }

    function Mantenimiento_Otros_U(){
        Cargando();

        var id_mantenimiento = $('#id_mantenimientoe').val();

        if(id_mantenimiento=="3"){
            $('.ver_especialidad_u').hide();
            $('#titulo_tareae').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_u" name="titulo_u" placeholder="Ingresar título">');
        }else{
            $('.ver_especialidad_u').show();
            $('#titulo_tareae').html('<label class="control-label text-bold">Título:</label><select class="form-control" id="titulo_u" name="titulo_u"><option value="0">Seleccione</option></select>');
        }
        $('#id_especialidade').val(0);
    }

    function Titulo_Pendientee(){
        Cargando();

        var id_especialidad = $('#id_especialidade').val();
        var url = "{{ url('Tareas/Titulo_Pendiente') }}";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_especialidad':id_especialidad},
            success:function (resp){
                $('#titulo_u').html(resp);
            }
        });
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
        window.location.replace("{{ url('Tareas/Descargar_Archivo_Pendiente') }}/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: "{{ url('Tareas/Delete_Archivo_Pendiente') }}", 
            data: {'image_id':image_id}, 
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    function Update_Pendiente() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ url('Tareas/Update_Pendiente') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Update_Pendiente()) {
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
                        Lista_Tareas_Solicitadas();
                        $("#ModalUpdate .close").click()
                    });
                }
            });
        }
    }

    function Valida_Update_Pendiente() {
        if ($('#id_tipo_u').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_area_u').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar area.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_responsable_u').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Asignado a.',
                'warning'
            ).then(function() { });
            return false;
        }
        if (($('#id_area_u').val() == '10' || $('#id_area_u').val() == '41') && ($('#id_mantenimiento').val() == '1' || $('#id_mantenimiento').val() == '2')) {
            if ($('#id_mantenimientoe').val() == '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar mantenimiento.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if ($('#id_especialidade').val() == '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar especialidad.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if ($('#titulo_u').val() == '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar título.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }else{
            if ($('#titulo_u').val() == '') {
                Swal(
                    'Ups!',
                    'Debe ingresar título.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if ($('#descripcion_u').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>