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

<form id="formulario_i" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo Ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <?php if(session('usuario')->id_nivel==1 || session('usuario')->id_puesto==27 || session('usuario')->id_puesto==148){ ?>
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Colaborador: </label>
                </div>
                <div class="form-group col-md-10">
                    <select class="form-control basic_i" name="id_colaborador_i" id="id_colaborador_i">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>">
                                <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php }else{ ?>
                <input type="hidden" id="id_colaborador_i" name="id_colaborador_i" value="<?php echo session('usuario')->id_usuario; ?>">
            <?php } ?>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_tipo_tickets_i" id="id_tipo_tickets_i">
                    <option value="0" >Seleccionar</option>
                    <?php foreach($list_tipo_tickets as $list){ if($list['id_tipo_tickets']!=3 && $list['id_tipo_tickets']!=4){  ?>
                        <option value="<?php echo $list['id_tipo_tickets']; ?>"><?php echo $list['nom_tipo_tickets']; ?></option>
                    <?php } } ?>
                </select>
            </div>

            <?php if(session('usuario')->id_puesto==27){ ?>
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Plataforma: </label>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control" name="plataforma_i" id="plataforma_i">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_plataforma as $list){
                                if($list['id_plataforma']==3){ ?>
                                    <option value="<?php echo $list['id_plataforma']; ?>"><?php echo $list['nom_plataforma']; ?></option>
                                <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            <?php }else{ ?>
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Plataforma: </label>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control" name="plataforma_i" id="plataforma_i">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_plataforma as $list){ ?>
                            <option value="<?php echo $list['id_plataforma']; ?>"><?php echo $list['nom_plataforma'];?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Título: </label>
                <input type="text" class="form-control" id="titulo_tickets_i" name="titulo_tickets_i" placeholder="Ingresar título">
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Descripción: </label>
                <textarea class="form-control" id="descrip_ticket_i" name="descrip_ticket_i" rows="5" placeholder="Ingresar descripción"></textarea>
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Archivos: </label>
            </div>
            <div class="form-group col-md-12">
                <!-- <textarea id="paste_area" placeholder="Pega aquí la imagen" style="width: 100%"></textarea> -->
                <input type="file" class="form-control" name="files_i[]" id="files_i" multiple>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Tickets();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    /*document.getElementById('paste_area').addEventListener('paste', function (e) {
        if (e.clipboardData && e.clipboardData.items) {
            var items = e.clipboardData.items;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") !== -1) {
                    var blob = items[i].getAsFile();
                    var fileInput = document.getElementById('files_i');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(blob);

                    fileInput.files = dataTransfer.files;

                    // Trigger file input change event to refresh fileinput library UI
                    $('#files_i').fileinput('refresh', {
                        initialPreview: [],
                        initialPreviewConfig: []
                    });

                    // Clear the paste area after processing the image
                    e.target.value = '';
                    $('.file-drop-zone-title').hide();
                    break;
                }
            }
        }
    });
*/
    var ss = $(".basic_i").select2({
        tags: true
    });

    $('.basic_i').select2({
        dropdownParent: $('#ModalRegistro')
    });

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

    function Insert_Tickets() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_i'));
        var url = "{{ url('Tickets/Insert_Tickets') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Insert_Tickets()) {
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
                    if (data == "error") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
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
                            $("#ModalRegistro .close").click()
                            var nivel = "<?php echo session('usuario')->id_nivel; ?>";
                            var puesto = "<?php echo session('usuario')->id_puesto; ?>";

                            if(nivel==1 || puesto==27 || puesto==148){
                                Cambiar_Tickets_Admin();
                            }else{
                                Cambiar_Tickets();
                            }
                        });
                    }
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

    function Valida_Insert_Tickets() {
        var nivel = "<?php echo session('usuario')->id_nivel; ?>";
        var puesto = "<?php echo session('usuario')->id_puesto; ?>";

        if(nivel==1 || puesto==27 || puesto==148){
            if ($('#id_colaborador_i').val() == '0') {
                msgDate = 'Debe seleccionar colaborador.';
                inputFocus = '#id_colaborador_i';
                return false;
            }
        }
        if ($('#id_tipo_tickets_i').val() == '0') {
            msgDate = 'Debe seleccionar tipo.';
            inputFocus = '#id_tipo_tickets_i';
            return false;
        }
        if ($('#plataforma_i').val() == '0') {
            msgDate = 'Debe seleccionar plataforma.';
            inputFocus = '#plataforma_i';
            return false;
        }
        if ($('#titulo_tickets_i').val().trim() === '') {
            msgDate = 'Debe ingresar título.';
            inputFocus = '#titulo_tickets_i';
            return false;
        }
        if ($('#descrip_ticket_i').val().trim() === '') {
            msgDate = 'Debe ingresar una descripción ';
            inputFocus = '#descrip_ticket_i';
            return false;
        }
        return true;
    }
</script>
