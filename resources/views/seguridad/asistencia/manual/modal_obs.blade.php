<form id="formularioo" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Observación:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->fecha }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->base }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Colaborador:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" value="{{ $get_id->colaborador }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Sede:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->cod_sede }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>Hora Ingreso:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->h_ingreso }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Observación:</label>
            </div>
            <div class="form-group col-lg-10">
                <textarea class="form-control" name="observaciono" id="observaciono" rows="4" placeholder="Ingresar observación">{{ $get_id->observacion }}</textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Obs_Manual();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Obs_Manual() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioo'));
        var url = "{{ route('asistencia_seg_man.update_obs', $get_id->id_seguridad_asistencia) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    '¡Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Manual();
                    $("#ModalUpdate .close").click();
                });  
            },
            error:function(xhr) {
                var errors = xhr.responseJSON.errors;
                var firstError = Object.values(errors)[0][0];
                Swal.fire(
                    '¡Ups!',
                    firstError,
                    'warning'
                );
            }
        });
    }
</script>