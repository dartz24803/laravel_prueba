<form id="formulario_asistencia_colaborador_a" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"><b>Actualizar Asistencia</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-3">
                <label class="control-label text-bold" for="flag_diatrabajado_a">Días Trabajados:</label>
            </div>
            <div class="form-group col-md-1">
                <input type="checkbox" id="flag_diatrabajado_a" name="flag_diatrabajado_a" value="1" <?php if ($get_id[0]['flag_diatrabajado'] == 1) {
                                                                                                            echo "checked";
                                                                                                        } ?>>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id_asistencia_colaborador_a" value="<?php echo $get_id[0]['id_asistencia_colaborador']; ?>">
        <button class="btn btn-primary" type="button" onclick="Update_Asistencia_Colaborador_Dia_Trabajado();">
            Guardar
        </button>
        <button class="btn" data-dismiss="modal" onclick="Buscar_Asistencia_Colaborador();">
            Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Asistencia_Colaborador_Dia_Trabajado() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_asistencia_colaborador_a'));
        var url = "{{ route('asistencia_colaborador.update') }}";
        var csrfToken = $('input[name="_token"]').val(); // Obtener token CSRF

        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                Buscar_Asistencia_Colaborador();
                $("#ModalUpdate .close").click();
            }
        });
    }
</script>