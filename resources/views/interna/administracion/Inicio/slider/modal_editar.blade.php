<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Horario:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-lg-12 row">
            <div class="form-group col-lg-2">
                <label>Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" name="categoria" id="categoria" class="form-control" value="<?php echo $get_id[0]['categoria']; ?>" disabled>
            </div>
            <div class="form-group col-lg-2">
                <label>Titulo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo $get_id[0]['titulo']; ?>">
            </div>
            <div class="form-group col-lg-2">
                <label>Descripcion:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $get_id[0]['descripcion']; ?>">
            </div>
            <div class="form-group col-lg-2">
                <label>Link:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" name="link" id="link" class="form-control" value="<?php echo $get_id[0]['link']; ?>" >
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id" value="<?php echo $get_id[0]['id']; ?>">
        <button class="btn btn-primary" type="button" onclick="Update_Slider_Inicio();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>


    function Update_Slider_Inicio() {
        Cargando();

        var dataString = $("#formulario_update").serialize();
        var url = "{{ url('Inicio/Update_Slider_Inicio') }}";
        var csrfToken = $('input[name="_token"]').val();

        //if (Valida_Slider_Inicio('e')) {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: dataString,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Slider_Inicio_Listar();
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
        //}
    }

    function Valida_Slider_Inicio(v) {
        if ($('#titulo').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar titulo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#descripcion').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar descripcion.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
