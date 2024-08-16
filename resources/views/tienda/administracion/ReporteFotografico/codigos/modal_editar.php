<?php
$base = Session('usuario')->centro_labores;
?>
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
    <div class="modal-body row" style="max-height:450px; overflow:auto;">
        <div class="form-group col-md-4">
            <label>Base: </label>
            <select class="form-control basic" id="bases_e" name="bases_e">
                <option value="0">TODOS</option>
                    <?php foreach ($list_bases as $list) { ?>
                        <option value="<?php echo $list->cod_base; ?>"
                        <?php
                        if($get_id[0]['base'] == $list->cod_base){
                            echo 'selected';
                        }
                        ?>>
                    <?php echo $list->cod_base; ?>
                </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="my-input">Codigo : <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="codigo_e" name="codigo_e" value="<?= $get_id[0]['descripcion']; ?>">
        </div>
        <div class="form-group col-md-4">
            <label>Categorias: </label>
            <select class="form-control basic_i" id="categoria_e" name="categoria_e">
                <option value="">--Seleccione--</option>
                <?php foreach($list_categorias as $list){ ?>
                    <option value="<?php echo $list['id']; ?>" <?php if($list['id'] == $get_id[0]['tipo']){ echo "selected"; } ?>>
                        <?php echo $list['categoria']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <input name="id" id="id" type="hidden" value="<?= $get_id[0]['id']; ?>">
        <button class="btn btn-primary mt-3" onclick="Update_Codigo_Registro_Fotografico_Adm();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Codigo_Registro_Fotografico_Adm() {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "Update_Codigo_Registro_Fotografico_Adm";

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
                if (data.error == ""){
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Codigos_Reporte_Fotografico_Listar();
                        $("#ModalUpdate .close").click()
                    });
                } else {
                    Swal.fire(
                        '¡Ups!',
                        data.error[0],
                        'error'
                    );
                }
                }
            });
        //}
    }
/*
    function Valida_Registrar() {
        if ($('#codigo_e').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar codigo.',
                'warning'
            ).then(function() { });
            return false
        }
        if ($('#area_e').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar area.',
                'warning'
            ).then(function() { });
            return false
        }
        return true;
    }
*/   
    $('.basic_i').select2({
        dropdownParent: $('#ModalUpdate')
    });

</script>