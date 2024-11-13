<link href="{{ asset('template/inputfiles/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="{{ asset('template/inputfiles/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<script src="{{ asset('template/inputfiles/js/plugins/piexif.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/plugins/sortable.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/fileinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/locales/es.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/fas/theme.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/explorer-fas/theme.js') }}" type="text/javascript"></script>

<?php 
    $menu_gestion_pendiente=explode(",", session('usuario')->grupo_puestos);
    $mostrar_menu=in_array( session('usuario')->id_puesto,$menu_gestion_pendiente);

    $id_nivel= session('usuario')->id_nivel;
    $id_puesto= session('usuario')->id_puesto;
?>

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Nueva tarea</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <?php if($mostrar_menu==true || $id_nivel==1 || $id_puesto==16 || 
        $id_puesto==20 || $id_puesto==26 || $id_puesto==27 || $id_puesto==98 ||
        $id_puesto==128){ ?>
            <div class="col-lg-12 row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Base: </label>
                </div>            
                <div class="form-group col-lg-4">
                    <select class="form-control" name="cod_base_i" id="cod_base_i" onchange="Base_Usuario_I(); Limpiar_Datos_I();">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_base as $list){ ?>
                            <option value="<?php echo $list['cod_base']; ?>"><?php echo $list['cod_base'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-12 row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Usuario: </label>
                </div>            
                <div id="select_usuarios_i" class="form-group col-lg-10">
                    <select class="form-control basic_i" name="id_usuario_i" id="id_usuario_i" onchange="Limpiar_Datos_I();">
                        <option value="0">Seleccionar</option>
                    </select>
                </div>

                <input type="hidden" id="valida_base_usuario" value="1">
            </div>
        <?php }else{ ?>
            <input type="hidden" id="id_usuario_i" name="id_usuario_i" value="<?php echo $_SESSION['usuario'][0]['id_usuario']."-".$_SESSION['usuario'][0]['centro_labores']."-".$_SESSION['usuario'][0]['id_area']; ?>">
            <input type="hidden" id="valida_base_usuario" value="0">
        <?php } ?>

        <div class="col-lg-12 row">
            <?php if($mostrar_menu==true || $id_nivel==1 || $id_puesto==29 || $id_puesto==16 || 
                    $id_puesto==20 || $id_puesto==26 || $id_puesto==27 || $id_puesto==98 ||
                    $id_puesto==128){ ?>
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Tipo: </label>
                </div>   
                <div class="form-group col-lg-4">         
                    <select class="form-control" name="id_tipo_i" id="id_tipo_i">
                        <option value="0" >Seleccionar</option>
                        <?php foreach($list_tipo_tickets as $list){ ?>
                            <option value="<?php echo $list['id_tipo_tickets']; ?>"><?php echo $list['nom_tipo_tickets']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php }else{ ?>
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Tipo: </label>
                </div>            
                <div class="form-group col-lg-4">
                    <select class="form-control" name="id_tipo_i" id="id_tipo_i">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_tipo_tickets as $list){ if($list['id_tipo_tickets']!=4){ ?>
                            <option value="<?php echo $list['id_tipo_tickets']; ?>"><?php echo $list['nom_tipo_tickets']; ?></option>
                        <?php } } ?>
                    </select>
                </div>
            <?php } ?>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Area: </label>
            </div>            
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_area_i" id="id_area_i" onchange="Responsable_Pendiente_I(); Area_Infraestructura_I(); Delete_Toda_Cotizacion_Pendiente_I();">
                    <option value="0" >Seleccionar</option>
                    <?php if($id_puesto==31 || $id_puesto==32){ ?>
                        <option value="15">CAJA</option>
                    <?php }else{ foreach($list_area as $list){ ?>
                        <?php //if ($list['id_area'] != 13): ?>
                            <option value="<?php echo $list['id_area']; ?>"><?php echo $list['nom_area']; ?></option>
                        <?php //endif; ?>
                    <?php } } ?>
                </select>
            </div>
        </div>

        <div class="col-lg-12 row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Asignado a: </label>
            </div>            
            <div class="form-group col-lg-10">
                <select class="form-control basic_i" id="id_responsable_i" name="id_responsable_i">
                    <option value="0">Seleccionar</option>
                </select>
            </div>
        </div>

        <div class="col-lg-12 row ver_infraestructura_i">
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Mantenimiento: </label>
                <select class="form-control" name="id_mantenimiento" id="id_mantenimiento" onchange="Mantenimiento_Otros_I();">
                    <option value="0">Seleccione</option>
                    <option value="1">Recurrente</option>
                    <option value="2">Emergencia</option>
                    <option value="3">Otros</option>
                </select>
            </div>

            <div class="form-group col-lg-6 ver_especialidad_i">
                <label class="control-label text-bold">Especialidad: </label>
                <select class="form-control" name="id_especialidad" id="id_especialidad" onchange="Titulo_Pendiente_I();">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>
        
        <div class="col-lg-12 row ver_equipo_i">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Equipo: </label>
                <input type="text" class="form-control" id="equipo_i" name="equipo_i" placeholder="Ingresar Equipo">
            </div>
        </div>

        <div class="col-lg-12 row">
            <div id="titulo_tarea" class="form-group col-lg-12">
                <label class="control-label text-bold">Título: </label>
                <input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Ingresar título">
            </div>
        </div>

        <div class="col-lg-12 row">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Descripción: </label>
                <textarea class="form-control" id="descripcion_i" name="descripcion_i" rows="5" placeholder="Ingresar descripción"></textarea>
            </div>
        </div>

        <div class="col-lg-12 row ver_etiqueta_i">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Etiqueta: </label>
            </div>   
            <div class="form-group col-lg-10">         
                <select class="form-control basic_i" name="id_subitem_i" id="id_subitem_i">
                    <option value="0">Seleccionar</option>
                </select>
            </div>
        </div>

        <div class="col-lg-12 row ver_cotizacion_i">
            <div class="form-group col-lg-2">
                <button class="btn" type="button" data-toggle="modal" data-target="#ModalUpdate" 
                app_elim="{{ url('Tareas/Modal_Cotizacion_Pendiente') }}" 
                style="background-color:#ff2956 !important;color:white;">
                    Cotizaciones
                </button>
            </div>
        </div>

        <div class="col-lg-12 row">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Archivos: </label>
            </div>
            <div class="form-group col-lg-12">
                <input type="file" class="form-control" name="files_i[]" id="files_i" multiple>
            </div>
        </div>

        <div class="row d-flex justify-content-center mb-2 mt-2">
            <button type="button" class="btn btn-secondary" id="boton_camara" onclick="Activar_Camara();">Activar cámara</button>
        </div>
        <div class="row d-flex justify-content-center mb-2" id="div_camara" style="display:none !important;">
            <video id="video" autoplay style="max-width: 95%;"></video>
        </div>
        <div class="row d-flex justify-content-center mb-2 mt-2" id="div_tomar_foto" style="display:none !important;">
            <button type="button" class="btn btn-info" onclick="Tomar_Foto();">Tomar foto</button>
        </div>
        <div class="row d-flex justify-content-center text-center" id="div_canvas" style="display:none !important;">
            <canvas id="canvas" width="640" height="480" style="max-width:95%;"></canvas>
        </div>
        
        <div id="imagen-container" class="d-flex justify-content-center ml-4">
        </div>

    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Pendiente();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() { 
        $('.ver_infraestructura_i').hide();
        $('.ver_etiqueta_i').hide();
        $('.ver_cotizacion_i').hide();
        $('.ver_equipo_i').hide();
        cargarImagenes();
    });
    
    $('.basic_i').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Base_Usuario_I(){
        Cargando();

        var cod_base=$('#cod_base_i').val();
        var url="{{ url('Tareas/Traer_Usuarios_Pendiente') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({    
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data:{'cod_base':cod_base},
            success:function (resp) {
                $('#id_usuario_i').html(resp);
            }
        });
    }

    function Limpiar_Datos_I(){
        Cargando();

        $('#id_tipo_i').val(0);
        $('#id_area_i').val(0);
        $('#id_responsable_i').html('<option value="0">Seleccionar</option>');
        $(".ver_infraestructura_i").hide();
        $('#id_mantenimiento').val(0);
        $('#id_especialidad').val(0);
        $('#titulo_tarea').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Ingresar título">');
        $('#descripcion_i').val('');
        $('.ver_etiqueta_i').hide();
        $('#id_subitem_i').html('<option value="0">Seleccionar</option>');
        $(".ver_cotizacion_i").hide();
    }

    function Responsable_Pendiente_I(){
        Cargando();

        var id_area = $('#id_area_i').val();

        if(id_area=="0"){
            $('#id_responsable_i').html('<option value="0">Seleccionar</option>');
        }else{
            var url="{{ url('Tareas/Responsable_Pendiente') }}";
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({    
                type:"POST",
                url:url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data:{'id_area':id_area},
                success:function (resp) {
                    $('#id_responsable_i').html(resp);
                }
            });
        }
    }

    function Area_Infraestructura_I(){
        Cargando();

        var id_area = $('#id_area_i').val();
        var url = "{{ url('Tareas/Area_Infraestructura') }}"; 
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({    
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data:{'id_area':id_area},
            success:function (resp) {
                if(id_area=="0"){
                    $('.ver_etiqueta_i').hide();
                    $('#id_subitem_i').html('<option value="0">Seleccionar</option>');
                    $(".ver_infraestructura_i").hide();
                    $('#id_mantenimiento').val(0);
                    $('#id_especialidad').val(0);
                    $('#titulo_tarea').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Ingresar título">');
                    $(".ver_cotizacion_i").hide();
                    $('.ver_equipo_i').hide();
                }else if(id_area=="10" || id_area=="41"){
                    $('.ver_equipo_i').hide();
                    $('.ver_etiqueta_i').hide();
                    $('#id_subitem_i').html('<option value="0">Seleccionar</option>');

                    $(".ver_infraestructura_i").show();
                    $('#id_especialidad').html(resp);
                    $('#titulo_tarea').html('<label class="control-label text-bold">Título:</label><select class="form-control" id="titulo_i" name="titulo_i"><option value="0">Seleccione</option></select>');

                    var base_usuario = $('#id_usuario_i').val().split("-")[1];
                    if(base_usuario=="AMT" || base_usuario=="CD" || base_usuario=="OFC"){
                        $(".ver_cotizacion_i").hide();
                    }else{
                        $(".ver_cotizacion_i").show();
                    }
                }else if(id_area=="13"){
                    $('.ver_equipo_i').show();
                    $('#id_subitem_i').html('<option value="0">Seleccionar</option>');
                    $(".ver_infraestructura_i").hide();
                    $('#id_mantenimiento').val(0);
                    $('#id_especialidad').val(0);
                    $('#titulo_tarea').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Ingresar título">');
                    $(".ver_cotizacion_i").hide();
                }else{
                    var area_usuario = $('#id_usuario_i').val().split("-")[2];

                    if(area_usuario=="14"){
                        $('.ver_etiqueta_i').show();
                        $('#id_subitem_i').html(resp);
                    }else{
                        $('.ver_etiqueta_i').hide();
                        $('#id_subitem_i').html('<option value="0">Seleccionar</option>');
                    }
                    $('.ver_equipo_i').hide();
                    $(".ver_infraestructura_i").hide();
                    $('#id_mantenimiento').val(0);
                    $('#id_especialidad').val(0);
                    $('#titulo_tarea').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Ingresar título">');
                    $(".ver_cotizacion_i").hide();
                }
            }
        });
    }

    function Delete_Toda_Cotizacion_Pendiente_I(){
        Cargando();

        var url="{{ url('Tareas/Delete_Toda_Cotizacion_Pendiente') }}"; 
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({    
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                console.log('Cotización Eliminada')
            }
        });
    }

    function Mantenimiento_Otros_I(){
        Cargando();

        var id_mantenimiento = $('#id_mantenimiento').val();

        if(id_mantenimiento=="3"){
            $('.ver_especialidad_i').hide();
            $('#titulo_tarea').html('<label class="control-label text-bold">Título:</label><input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Ingresar título">');
            $(".ver_cotizacion_i").hide();
        }else{
            $('.ver_especialidad_i').show();
            $('#titulo_tarea').html('<label class="control-label text-bold">Título:</label><select class="form-control" id="titulo_i" name="titulo_i"><option value="0">Seleccione</option></select>');
            var base_usuario = $('#id_usuario_i').val().split("-")[1];
            if(base_usuario=="AMT" || base_usuario=="CD" || base_usuario=="OFC"){
                $(".ver_cotizacion_i").hide();
            }else{
                $(".ver_cotizacion_i").show();
            }
        }
        $('#id_especialidad').val(0);
    }

    function Titulo_Pendiente_I(){
        Cargando();

        var id_especialidad = $('#id_especialidad').val();
        var url = "{{ url('Tareas/Titulo_Pendiente') }}";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_especialidad':id_especialidad},
            success:function (resp){
                $('#titulo_i').html(resp);
            }
        });
    }

    $('#files_i').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['jpg', 'png','txt','pdf','xlsx','pptx','docx','jpeg','xls','ppt','doc'],
    });

    function Insert_Pendiente() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ url('Tareas/Insert_Pendiente') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Insert_Pendiente()) {
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
                    if (data == "recurrente") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Debe ingresar 3 a más cotizaciones!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if (data == "emergencia") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Debe ingresar 2 a más cotizaciones!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tareas_Solicitadas();
                            $("#ModalRegistro .close").click()
                        });
                    }
                }
            });
        }
    }

    function Valida_Insert_Pendiente() {
        if($('#valida_base_usuario').val() == '1'){
            if ($('#id_usuario_i').val() == '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar usuario.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if ($('#id_tipo_i').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_area_i').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar area.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_responsable_i').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Asignado a.',
                'warning'
            ).then(function() { });
            return false;
        }
        if (($('#id_area_i').val() == '10' || $('#id_area_i').val() == '41') && ($('#id_mantenimiento').val() == '1' || $('#id_mantenimiento').val() == '2')) {
            if ($('#id_mantenimiento').val() == '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar mantenimiento.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if ($('#id_especialidad').val() == '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar especialidad.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if ($('#titulo_i').val() == '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar título.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }else{
            if ($('#titulo_i').val() == '') {
                Swal(
                    'Ups!',
                    'Debe ingresar título.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if ($('#descripcion_i').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
    
    var video = document.getElementById('video');
    var boton = document.getElementById('boton_camara');
    var div_tomar_foto = document.getElementById('div_tomar_foto'); 
    var div = document.getElementById('div_camara'); 
    var isCameraOn = false;
    var stream = null;
    function Activar_Camara(){
        var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        if(screenWidth<1000){
            if(!isCameraOn){
                //Pedir permiso para acceder a la cámara
                navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: {
                            exact: "environment"
                        }
                    }
                })
                .then(function (newStream){
                    stream = newStream;
                    // Mostrar el stream de la cámara en el elemento de video
                    video.srcObject = stream;
                    video.play();
                    isCameraOn = true;
                    boton.textContent = "Desactivar cámara";
                    div_tomar_foto.style.cssText = "display: block;";
                    div.style.cssText = "display: block;";
                })
                .catch(function (error){
                    console.error('Error al acceder a la cámara:', error);
                });
            }else{
                //Detener la reproducción  del stream y liberar la cámara
                if(stream){
                    stream.getTracks().forEach(function (track){
                        track.stop();
                    });
                    video.srcObject = null;
                    isCameraOn = false;
                    boton.textContent = "Activar cámara";
                    div_tomar_foto.style.cssText = "display: none !important;";
                    div.style.cssText = "display: none !important;";
                }
            }
        }else{
            if(!isCameraOn){
                //Pedir permiso para acceder a la cámara
                navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function (newStream){
                    stream = newStream;
                    // Mostrar el stream de la cámara en el elemento de video
                    video.srcObject = stream;
                    video.play();
                    isCameraOn = true;
                    boton.textContent = "Desactivar cámara";
                    div_tomar_foto.style.cssText = "display: block;";
                    div.style.cssText = "display: block;";
                })
                .catch(function (error){
                    console.error('Error al acceder a la cámara:', error);
                });
            }else{
                //Detener la reproducción  del stream y liberar la cámara
                if(stream){
                    stream.getTracks().forEach(function (track){
                        track.stop();
                    });
                    video.srcObject = null;
                    isCameraOn = false;
                    boton.textContent = "Activar cámara";
                    div_tomar_foto.style.cssText = "display: none !important;";
                    div.style.cssText = "display: none !important;";
                }
            }
        }
    }
    var fotos_tomadas = 0; // Contador para el número de fotos tomadas

    function Tomar_Foto() {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ url('Tareas/Previsualizacion_Captura') }}";
        var video = document.getElementById('video');
        var div_canvas = document.getElementById('div_canvas');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function(blob) {
            // Crea un formulario para enviar la imagen al servidor
            dataString.append('photo' + (fotos_tomadas + 1), blob, 'photo' + (fotos_tomadas + 1) + '.jpg');

            // Realiza la solicitud AJAX
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: dataString,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response === "error") {
                        Swal(
                            'Ups!',
                            'Máximo de fotos permitidas',
                            'warning',
                        );
                    } else {
                        $('#captura').val('1');
                        fotos_tomadas++;
                        cargarImagenes();
                    }
                }
            });
        }, 'image/jpeg');
    }
    
    function cargarImagenes() {
        $.ajax({
            url: "{{ url('Tareas/obtenerImagenes') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#imagen-container').empty();

                if (data.length > 0) {
                    $.each(data, function(index, imagen) {
                        var timestamp = new Date().getTime();
                        var imgElement = $('<img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" src="https://lanumerounocloud.com/intranet/PENDIENTES/' + imagen.ruta + '?v=' + timestamp + '" width=240" height="120" alt="Foto">');
                        var deleteButton = $('<a href="javascript:void(0);" title="Eliminar" onClick="Delete_Imagen_Temporal(' + imagen.id + ')"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>');
                        var container = $('<div class="image-item mr-4"></div>'); // Contenedor para la imagen y el botón de eliminar
                        container.append(imgElement);
                        container.append(deleteButton);

                        $('#imagen-container').append(container);
                    });
                } else {
                    $('#imagen-container').html('No hay fotos subidas.');
                }
            },
            error: function() {
                alert('Error al cargar las imágenes.');
            }
        });
    }

    function Delete_Imagen_Temporal(id) {
        var url = "{{ url('Tareas/Delete_Imagen_Temporal') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar la foto?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id': id
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'La imagen ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            cargarImagenes();
                        });
                    }
                });
            }
        })
        return false;
    }
    $(document).on("click", ".img_post", function () {
        window.open($(this).attr("src"), 'popUpWindow', "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no");
    });
</script>
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