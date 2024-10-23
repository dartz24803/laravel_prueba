<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Cancelar soporte: <span id="codigo_texto" class="ml-2">{{ $get_id->codigo }}</span></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">

            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Ingrese Motivo: </label>
                <select class="form-control" id="motivo" name="motivo">
                    <option value="0">Seleccione</option>
                    @foreach ($list_motivos_cancelacion as $list)
                    <option value="{{ $list->idsoporte_motivo_cancelacion }}"
                        {{ $list->idsoporte_motivo_cancelacion == $get_id->idsoporte_motivo_cancelacion ? 'selected' : '' }}>
                        {{ $list->motivo }}
                    </option>
                    @endforeach
                </select>

            </div>
        </div>


        <div class="row">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold" id="id_areac-label">Área: </label>

                <select class="form-control" id="id_areac" name="id_areac">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id_area }}"
                        {{ $list->id_area == $get_id->area_cancelacion ? 'selected' : '' }}>
                        {{ $list->nom_area }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Cancelar_Soporte();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<script>
    function Cancelar_Soporte() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ route('soporte_ticket_master.cancelupdate', $get_id->id_soporte) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Tickets_Soporte();
                        $("#ModalUpdate .close").click();
                    });
                }
            },
            error: function(xhr) {
                // Verificar si el error es debido a un responsable no asignado
                if (xhr.status === 400 && xhr.responseJSON.error === 'No hay responsable asignado.') {
                    Swal.fire(
                        '¡Error!',
                        'No hay responsable asignado. Por favor seleccione un responsable.',
                        'error'
                    );
                } else {
                    // Manejar otros errores
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    Swal.fire(
                        '¡Ups!',
                        firstError,
                        'warning'
                    );
                }
            }

        });
    }





    $(document).ready(function() {
        toggleMotivo();

        $('#motivo').on('change', function() {
            toggleMotivo();
        });


    });

    function toggleMotivo() {
        var idmotivo = document.getElementById('motivo').value;
        var cierreLabel = document.getElementById('id_areac-label');
        var cierreField = document.getElementById('id_areac');
        var estadoContainer = document.getElementById('estado-container');
        console.log(idmotivo);
        if (idmotivo == 1) {
            // Mostrar los campos de Cierre
            cierreLabel.style.display = 'block';
            cierreField.style.display = 'block';

        } else {
            // Ocultar los campos de Cierre
            cierreLabel.style.display = 'none';
            cierreField.style.display = 'none';

        }
    }
</script>