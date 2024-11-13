<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nueva Asistencia Manual</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Colaborador: </label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basic" id="id_usuario" name="id_usuario">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_usuario as $list) { ?>
                        <option value="<?php echo $list['id_usuario']; ?>">
                            <?php echo $list['nom_usuario']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label class="control-label text-bold" for="entrada">Entrada: </label>
                <input type="checkbox" class="checkbox" id="entrada" name="entrada" value="1">
            </div>
            <div class="form-group col-md-3">
                <label class="control-label text-bold" for="salida">Salida: </label>
                <input type="checkbox" class="checkbox" id="salida" name="salida" value="1">
            </div>
            <div class="form-group col-md-3">
                <label class="control-label text-bold" for="inicio_refrigerio">Inicio refrigerio: </label>
                <input type="checkbox" class="checkbox" id="inicio_refrigerio" name="inicio_refrigerio" value="1">
            </div>
            <div class="form-group col-md-3">
                <label class="control-label text-bold" for="fin_refrigerio">Fin refrigerio: </label>
                <input type="checkbox" class="checkbox" id="fin_refrigerio" name="fin_refrigerio" value="1">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Asistencia_Manual();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    var ss = $(".basic").select2({
        tags: true,
    });

    $('.basic').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Insert_Asistencia_Manual() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ url('AsistenciaManual/Insert_Asistencia_Manual') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Insert_Asistencia_Manual()) {
            $.ajax({
                url: url,
                data: dataString,

                type: "POST",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
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
                            AsistenciaManual();
                        });
                    }
                }
            });
        }
    }

    function Valida_Insert_Asistencia_Manual() {
        if ($('#id_usuario').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar colaborador.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($(".checkbox:checked").length == 0) {
            Swal(
                'Ups!',
                'Debe seleccionar al menos un checkbox.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
</script>