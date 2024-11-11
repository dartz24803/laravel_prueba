<div class="modal-header">
    <h5 class="modal-title"><b>Actualizar Estado de Asistencia</b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<div class="modal-body" style="max-height:500px; overflow:auto;">
    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Estado:</label>
        </div>
        <div class="form-group col-md-4">
            <select name="estadoau" id="estadoau" class="form-control">
                <option value="0">Seleccione</option>
                <?php foreach ($list_estado as $list) { ?>
                    <option value="<?php echo $list['id_estado_asistencia']; ?>"><?php echo $list['nom_estado']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-12">
            <label class="control-label text-bold">Observación: </label>
            <div class="">
                <textarea name="observacionau" id="observacionau" rows="3" class="form-control"><?php echo $get_id[0]['observacion']; ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <!-- Laravel genera el token automáticamente con @csrf -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button class="btn btn-info" type="button" onclick="Update_Ausencia_Inconsistencia('{{ $get_id[0]['id_asistencia_inconsistencia'] }}');">Inconsistencia</button>
    <button class="btn btn-primary" type="button" onclick="Update_Estado_Ausencia('{{ $get_id[0]['id_asistencia_inconsistencia'] }}');">Guardar</button>
    <button class="btn" data-dismiss="modal" onclick="Buscar_Ausencia_Colaborador()"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>

<script>
    function Update_Ausencia_Inconsistencia(id_asistencia_inconsistencia) {
        Cargando();

        var url = "{{ route('ausencia_colaborador.update') }}";
        var csrfToken = $('input[name="_token"]').val(); // Obtener token CSRF

        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success btn-rounded',
            cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
            buttonsStyling: false,
        });

        swalWithBootstrapButtons({
            title: '¿Estas seguro de pasar a Inconsistencia?',
            text: '¡No podrás revertir esta acción!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '¡Sí, registrar!',
            cancelButtonText: '¡No, cancelar!',
            reverseButtons: true,
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        'id_asistencia_inconsistencia': id_asistencia_inconsistencia,
                        '_token': csrfToken // Incluye el token CSRF en los datos de la solicitud
                    },
                    success: function(data) {
                        swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $("#ModalUpdate .close").click();
                            Buscar_Ausencia_Colaborador();
                        });
                    }
                });
            }
        });
    }

    function Update_Estado_Ausencia(id_asistencia_inconsistencia) {
        Cargando();
        var estado = $('#estadoau').val();
        var observacion = $('#observacionau').val();
        var url = "{{ route('ausencia_colaborador.updateestadoausencia') }}";
        var csrfToken = $('input[name="_token"]').val(); // Obtener token CSRF

        if (Valida_Update_Estado_Ausencia()) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success btn-rounded',
                cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
                buttonsStyling: false,
            });

            swalWithBootstrapButtons({
                title: '¿Estas seguro de validar y registrar marcación?',
                text: '¡No podrás revertir esta acción!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '¡Sí, registrar!',
                cancelButtonText: '¡No, cancelar!',
                reverseButtons: true,
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            'estado': estado,
                            'observacion': observacion,
                            'id_asistencia_inconsistencia': id_asistencia_inconsistencia,
                            '_token': csrfToken // Incluye el token CSRF en los datos de la solicitud
                        },
                        success: function(data) {
                            swal.fire(
                                'Registro Exitoso!',
                                '',
                                'success'
                            ).then(function() {
                                $("#ModalUpdate .close").click();
                                Buscar_Ausencia_Colaborador();
                            });
                        }
                    });
                }
            });
        } else {
            bootbox.alert(msgDate);
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Valida_Update_Estado_Ausencia() {
        if ($('#estadoau').val() === '0') {
            msgDate = 'Debe seleccionar Estado';
            inputFocus = '#hora_marcacion_nr';
            return false;
        }
        return true;
    }
</script>