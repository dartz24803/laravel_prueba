<!-- Formulario Mantenimiento -->
<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Acceso Página</h5>
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
                <label for="control-label text-bold">Area : <span class="text-danger">*</span></label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_area" id="id_area" onchange="Traer_Puesto()">
                    <option value="0">Seleccionar</option>
                    <?php foreach($list_area as $list){ ?>
                        <option value="<?php echo $list['id_area']; ?>"><?php echo $list['nom_area'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Puesto:</label>
            </div>
            <div class="form-group col-lg-4" id="mpuesto">
                <select class="form-control" name="id_puesto" id="id_puesto">
                    <option value="0">Seleccione</option>
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Accesos:</label>
            </div>
            <div class="form-group col-lg-10">
                <input class="form-control" type="text" id="pagina_acceso" name="pagina_acceso">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary mt-3" onclick="Registrar_Pagina();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Registrar_Pagina() {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ url('Registrar_Pagina') }}";

        //if (Valida_Registrar()) {
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
                    if(data=="error"){
                        swal.fire(
                            'Registro Denegado!',
                            'Existe un registro con los mismos datos!',
                            'error'
                        ).then(function() {
                        }); 
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Listar_Accesos_Paginas();
                            $("#ModalRegistro .close").click()
                        });
                    }
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
/*
    function Valida_Registrar() {
        if ($('#id_area').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar area.',
                'warning'
            ).then(function() { });
            return false
        }
        if ($('#id_puesto').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar puesto.',
                'warning'
            ).then(function() { });
            return false
        }
        if ($('#pagina_acceso').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar pagina de acceso.',
                'warning'
            ).then(function() { });
            return false
        }
        return true;
    }*/
    
    function Traer_Puesto() {
        Cargando();
        
        var id_area = $('#id_area').val();
        var url = "{{ url('Traer_Puesto_Cargo_Colaborador') }}";

        $.ajax({
            type: "GET",
            url: url,
            data: {'id_area':id_area},
            success: function(data) {
                $('#id_puesto').html(data);
            }
        });
    }
</script>