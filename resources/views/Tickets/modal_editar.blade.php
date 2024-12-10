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
     .kv-file-upload{
        display:none!important;
    }
    .input-group > .input-group-append > .btn, .input-group > .input-group-append > .input-group-text, .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child), .input-group > .input-group-prepend:not(:first-child) > .btn, .input-group > .input-group-prepend:not(:first-child) > .input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        padding-top: 11px;
    }
</style>

<form id="formulario_u" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Ticket: <b><?php echo $get_id[0]['cod_tickets']; ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>            
            <div class="form-group col-md-4">
                <select class="form-control" name="id_tipo_tickets_u" id="id_tipo_tickets_u">
                    <option value="0" >Seleccionar</option>
                    <?php foreach($list_tipo_tickets as $list){ if($list['id_tipo_tickets']!=3 && $list['id_tipo_tickets']!=4){  ?>
                        <option value="<?php echo $list['id_tipo_tickets']; ?>" <?php if($list['id_tipo_tickets']==$get_id[0]['id_tipo_tickets']){ echo "selected"; } ?>>
                            <?php echo $list['nom_tipo_tickets']; ?>
                        </option>
                    <?php } } ?>
                </select>
            </div>

            <?php if(session('usuario')->id_puesto==27){ ?>
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Plataforma: </label>
                </div>  
                <div class="form-group col-md-4">
                    <select class="form-control" name="plataforma_u" id="plataforma_u">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_platafroma as $list){ 
                                if($list['id_plataforma']==3){ ?>
                                    <option value="<?php echo $list['id_plataforma']; ?>" <?php if($list['id_plataforma']==$get_id[0]['plataforma']){ echo "selected"; } ?>>
                                        <?php echo $list['nom_plataforma']; ?>
                                    </option>
                                <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            <?php }else{ ?>
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Plataforma: </label> 
                </div>  
                <div class="form-group col-md-4">
                    <select class="form-control" name="plataforma_u" id="plataforma_u">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_plataforma as $list){ ?> 
                            <option value="<?php echo $list['id_plataforma']; ?>" <?php if($list['id_plataforma']==$get_id[0]['plataforma']){ echo "selected"; } ?>>
                                <?php echo $list['nom_plataforma']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Título: </label>
                <input type="text" class="form-control" id="titulo_tickets_u" name="titulo_tickets_u" placeholder="Ingresar título" value="<?php echo $get_id[0]['titulo_tickets']; ?>">
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Descripción: </label>
                <textarea class="form-control" id="descrip_ticket_u" name="descrip_ticket_u" rows="5" placeholder="Ingresar descripción"><?php echo $get_id[0]['descrip_ticket']; ?></textarea>
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Archivos: </label>
            </div>
            <div class="form-group col-md-12">
                <input type="file" class="form-control" name="files_u[]" id="files_u" multiple>
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
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . base_url() ."/assets/especiales/excel_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "xls"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . base_url() ."/assets/especiales/excel_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "pptx"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . base_url() ."/assets/especiales/ppt_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "ppt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . base_url() ."/assets/especiales/ppt_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-4) === "docx"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-28) .'" src="' . base_url() ."/assets/especiales/word_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                <?php }elseif (substr($list['archivos'],-3) === "doc"){ ?>
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivos'],-27) .'" src="' . base_url() ."/assets/especiales/word_example.png". '"></div>'; 
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>                    
                <?php }elseif (substr($list['archivos'],-3) === "txt"){ ?> 
                    <div id="i_<?php echo  $list['id_archivos_tickets']?>" class="form-group col-sm-2"> 
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy"  src="' . base_url() . $list['archivos'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <button class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_archivos_tickets']?>"><i class="fas fa-cloud-download-alt"></i></button>
                        <button class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_archivos_tickets']?>"><i class="fas fa-trash"></i></button>
                    </div>
                    <?php }else { echo ""; } ?>
            <?php } ?>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_tickets" name="id_tickets" value="<?php echo $get_id[0]['id_tickets']; ?>">
        @csrf
        <button class="btn btn-primary mt-3" type="button" onclick="Update_Tickets();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('#files_u').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
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
        window.location.replace("{{ url('Tickets/Descargar_Archivo_Ticket') }}/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var csrfToken = $('input[name="_token"]').val();
        image_id = $(this).data('image_id');
        file_col = $('#i_' + image_id);

        $.ajax({
            type: 'POST',
            url: "{{ url('Tickets/Delete_Archivo_Ticket') }} ",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {image_id: image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    function Update_Tickets() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_u'));
        var url = "{{ url('Tickets/Update_Tickets') }}";
        var csrfToken = $('input[name="_token"]').val();

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
                        Cambiar_Tickets();
                    });
                }
            });
    }

    function Valida_Update_Tickets() {
        if ($('#id_tipo_tickets_u').val() == '0') {
            msgDate = 'Debe seleccionar tipo.';
            inputFocus = '#id_tipo_tickets_u';
            return false;
        }
        if ($('#plataforma_u').val() == '0') {
            msgDate = 'Debe seleccionar plataforma.';
            inputFocus = '#plataforma_u';
            return false;
        }
        if ($('#titulo_tickets_u').val().trim() === '') {
            msgDate = 'Debe ingresar título.';
            inputFocus = '#titulo_tickets_u';
            return false;
        }
        if ($('#descrip_ticket_u').val().trim() === '') {
            msgDate = 'Debe ingresar una descripción ';
            inputFocus = '#descrip_ticket_u';
            return false;
        }
        return true;
    }
</script>
