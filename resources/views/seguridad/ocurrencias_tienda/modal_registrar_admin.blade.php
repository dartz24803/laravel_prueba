<?php 
    $id_puesto = session('usuario')->id_puesto;
    $id_nivel = session('usuario')->id_nivel;
?>
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
     .kv-file-upload{
        display:none!important;
    }
    .input-group > .input-group-append > .btn, .input-group > .input-group-append > .input-group-text, .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child), .input-group > .input-group-prepend:not(:first-child) > .btn, .input-group > .input-group-prepend:not(:first-child) > .input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        padding-top: 11px;
    }
</style>

<form id="formulario_ocurrencia" method="POST" enctype="multipart/form-data" class="needs-validation"> 
    <div class="modal-header">
        <h5 class="modal-title">Registrar Ocurrencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Base: </label>
            </div>
            <div  class="form-group col-md-4">
                <select class="form-control" name="cod_base" id="cod_base" onchange="Buscar_Tipo_Ocu()">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_base as $list){ ?>
                        <option value="<?php echo $list->cod_base; ?>" <?php if($list->cod_base === session('usuario')->centro_labores){ echo "selected"; } ?>><?php echo $list->cod_base; ?></option> 
                    <?php } ?>
                </select>   
            </div>

            <div class="form-group col-md-2">
                <label>Tipo: </label>
            </div>
            <div class="form-group col-md-4" id="div_tipo_o">
                <select class="form-control" name="id_tipo" id="id_tipo" onchange="Tipo_Piocha()">
                    <option value="0">Seleccione</option>
                </select>   
            </div>

            <div class="form-group col-md-2 ocultar_tipo_piocha_i">
                <label>Zona: </label>
            </div>
            <div  class="form-group col-md-4 ocultar_tipo_piocha_i">
                <select class="form-control" name="id_zona_i" id="id_zona_i">
                    <option value="0">Seleccione</option>
                    <option value="1">Hombre</option>
                    <option value="2">Mujer</option>
                    <option value="3">Infantil</option>
                </select>   
            </div>

            <div class="form-group col-md-2 ocultar_tipo_piocha_i">
                <label>Estilo: </label>
            </div>
            <div  class="form-group col-md-4 ocultar_tipo_piocha_i">
                <select class="form-control" name="id_estilo_i" id="id_estilo_i">
                    <option value="0">Seleccione</option>
                    <option value="1">Lector de código de barra</option>
                </select>   
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Colaborador: </label>
            </div>            
            <div class="form-group col-md-10">
                <select class="form-control basic_insert" name="id_usuario" id="id_usuario">
                    <option value="0">Seleccionar</option>
                    <?php foreach($list_usuario as $list){ ?>
                        <option value="<?php echo $list->id_usuario; ?>">
                            <?php echo $list->usuario_nombres." ".$list->usuario_apater." ".$list->usuario_amater; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Fecha: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_ocurrencia" name="fec_ocurrencia" value="<?php echo date("Y-m-d"); ?>" >
            </div>

            <div class="form-group col-md-2">
                <label>Gestión: </label>
            </div>
            <div  class="form-group col-md-4">
                <select class="form-control" name="id_gestion" id="id_gestion">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_gestion as $list){ ?>
                            <option value="<?php echo $list->id_gestion; ?>"><?php echo $list->nom_gestion; ?></option>
                        
                    <?php } ?>
                </select>   
            </div>

            <div class="form-group col-md-2">
                <label>Cantidad: </label>
            </div>
            <div  class="form-group col-md-4">
                <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Ingresar cantidad">  
            </div>

            <div class="form-group col-md-2">
                <label>Monto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="monto" name="monto" placeholder="Ingresar monto">  
            </div>

            <div class="form-group col-md-2">
                <label>Hora: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" class="form-control" id="hora" name="hora" value="<?php echo date('H:i'); ?>">  
            </div>
        </div>

        <div class="form-group col-md-6">
        </div>
        
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Descripción: </label> 
            </div>
            <div  class="form-group col-md-10">
                <textarea class="form-control" id="descripcion" name="descripcion" id="" cols="30" rows="5" placeholder="Ingresar descripción"></textarea>
            </div>

            <div class="form-group col-md-2">
                <label>Archivos: </label>
            </div>
            <div class="form-group col-sm-12">
                <input type="file" class="form-control" name="files[]" id="files" multiple>
            </div>
        </div> 
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Ocurrencia_Tienda_Admin();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.ocultar_tipo_piocha_i').hide();
        Buscar_Tipo_Ocu();
    });

    var ss = $(".basic_insert").select2({
        tags: true
    });

    $('.basic_insert').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Tipo_Piocha(){
        Cargando();

        var id_tipo = $('#id_tipo').val();
        var url = "{{ url('OcurrenciaTienda/Tipo_Piocha')}}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data:{'id_tipo':id_tipo},
            success: function(resp) {
                if(resp=="Si"){
                    $('.ocultar_tipo_piocha_i').show();
                }else{
                    $('.ocultar_tipo_piocha_i').hide();
                    $('#id_zona_i').val(0);
                    $('#id_estilo_i').val(0);
                }
            }
        });
    }

    $('#cantidad').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#monto').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });

    $('#files').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['jpg','png','jpeg'],
    });
    
    function Insert_Ocurrencia_Tienda_Admin() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_ocurrencia'));
        var url = "{{ url('OcurrenciaTienda/Insert_Ocurrencia_Tienda_Admin') }}";
        var csrfToken = $('input[name="_token"]').val();

        //if (Valida_Ocurrencia_Tienda_Admin()) { 
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == "error") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡La Ocurrencia ya existe para el día, base e incidencia!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $('#ModalRegistro').modal('hide');
                            Cambiar_Ocurrencia_Admin();
                        });
                    }
                }
            });
        /*} else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }*/
    }
/*
    function Valida_Ocurrencia_Tienda_Admin() {
        if ($('#id_tipo').val().trim() == '') {
            msgDate = 'Debe seleccionar tipo.';
            inputFocus = '#id_tipo';
            return false;
        }
        if ($('#id_gestion').val().trim() == '') {
            msgDate = 'Debe seleccionar gestión.';
            inputFocus = '#id_gestion';
            return false;
        }
        if ($('#cod_base').val().trim() == '0') {
            msgDate = 'Debe seleccionar base.';
            inputFocus = '#cod_base';
            return false;
        }
        if ($('#descripcion').val().trim() == '') {
            msgDate = 'Debe ingresar descripción.';
            inputFocus = '#descripcion';
            return false;
        }
        return true;
    }*/
   
    function Buscar_Tipo_Ocu() {
        Cargando();
        var dataString = new FormData(document.getElementById('formulario_ocurrencia'));
        var url = "{{ url('OcurrenciaTienda/Buscar_Tipo_Ocurrencia') }}";
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
                $('#id_tipo').html(data);
            }
        });
    }
</script>