
            <!-- Formulario Mantenimiento -->
            <form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
                <div class="modal-header">
                    <h5 class="modal-title">Editar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label for="my-input">Codigo : <span class="text-danger">*</span></label>
                        <select class="form-control basic_i" name="codigo_e" id="codigo_e">
                            <option value="0">Seleccionar</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <input name="id" id="id" type="hidden" value="<?//= $get_id[0]['id']; ?>">
                    <button class="btn btn-primary mt-3" onclick="Update_Registro_Fotografico();" type="button">Guardar</button>
                    <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                </div>
            </form>

<script>
    /*$(document).ready(function() {
        cargarImagenes();
    });*/
    function Update_Registro_Fotografico() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ url('Update_Registro_Fotografico') }}";

        if (Valida_Registrar()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Reporte_Fotografico_Listar();
                        $("#ModalUpdated .close").click()
                    });
                }
            });
        }
    }

    function Valida_Registrar() {
        if ($('#codigo_e').val() == '') {
            swal.fire(
                'Ups!',
                'Debe ingresar codigo.',
                'warning'
            ).then(function() {});
            return false
        }
        return true;
    }

    $('.basic_i').select2({
        dropdownParent: $('#ModalUpdated')
    });
</script>