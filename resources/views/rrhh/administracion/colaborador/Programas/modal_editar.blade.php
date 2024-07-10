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
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label for="control-label text-bold">Area : <span class="text-danger">*</span></label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_area_e" id="id_area_e" onchange="Traer_Puesto()">
                    <option value="0">Seleccionar</option>
                    <?php foreach($list_area as $list){ ?>
                        <option value="<?php echo $list['id_area']; ?>" <?php if($get_id[0]['area'] == $list['id_area']){ echo 'selected';} ?>><?php echo $list['nom_area'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Puesto:</label>
            </div>
            <div class="form-group col-lg-4" id="mpuesto">
                <select class="form-control" name="id_puesto_e" id="id_puesto_e">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_puesto as $list){ ?>
                        <option value="<?php echo $list['id_puesto']; ?>" <?php if($get_id[0]['puesto'] == $list['id_puesto']){ echo 'selected';} ?>><?php echo $list['nom_puesto'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Programa:</label>
            </div>
            <div class="form-group col-lg-10">
                <input class="form-control" type="text" id="programa_e" name="programa_e" value="<?= $get_id[0]['programa']; ?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input name="id" id="id" type="hidden" value="<?= $get_id[0]['id']; ?>">
        <button class="btn btn-primary mt-3" onclick="Update_Programa();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Programa() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ url('Update_Programa') }}";
        var csrfToken = $('input[name="_token"]').val();

        //if (Valida_Registrar()) {
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
                    if(data=="error"){
                        swal.fire(
                            'Actualización Denegada!',
                            'Existe un registro con los mismos datos!',
                            'error'
                        ).then(function() {
                        }); 
                    }else{
                        swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Listar_Accesos_Programas();
                            $("#ModalUpdate .close").click()
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
        if ($('#id_area_e').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar area.',
                'warning'
            ).then(function() { });
            return false
        }
        if ($('#id_puesto_e').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar puesto.',
                'warning'
            ).then(function() { });
            return false
        }
        if ($('#programa_e').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar programa.',
                'warning'
            ).then(function() { });
            return false
        }
        return true;
    }*/
     
    function Traer_Puesto() {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var id_area = $('#id_area_e').val();
        var url = "{{ url('Traer_Puesto_Cargo_Colaborador') }}";

        $.ajax({
            type: "GET",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'id_area':id_area},
            success: function(data) {
                $('#id_puesto_e').html(data);
            }
        });
    }
</script>