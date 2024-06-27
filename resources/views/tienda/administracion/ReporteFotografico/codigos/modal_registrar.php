<?php
$base = Session('usuario')->centro_labores;
//Cada coordinador le debe aparecer su base respectivamente definido
$disabled = '';
$selected = '';
if ($base == 'OFC') {
    $disabled = '';
    $selected = 'selected';
} else {
    $disabled = 'disabled';
} 
?>
<!-- Formulario Mantenimiento -->
<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar</h5>
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
            <select class="form-control basic" id="bases" name="bases" <?= $disabled ?>>
                <option value="0" <?= $selected ?>>TODOS</option>
                    <?php foreach ($list_bases as $list) { ?>
                        <option value="<?php echo $list['cod_base']; ?>"
                        <?php
                            if ($list['cod_base'] == $base && $list['cod_base'] != 'OFC') {
                                echo "selected";
                            }
                        ?>>
                    <?php echo $list['cod_base']; ?>
                </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="my-input">Codigo : <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="codigo" name="codigo">
        </div>
        <div class="form-group col-md-4">
            <label>Categoria: </label>
            <select class="form-control basic_i" id="categoria" name="categoria">
                <option value="0">--Seleccione--</option>
                <?php foreach($list_categorias as $list){ ?>
                    <option value="<?php echo $list['id']; ?>"><?php echo $list['categoria']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary mt-3" onclick="Registrar_Codigo_Reporte_Fotografico_Adm();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Registrar_Codigo_Reporte_Fotografico_Adm() {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "Registrar_Codigo_Reporte_Fotografico_Adm";

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
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Codigos_Reporte_Fotografico_Listar();
                            $("#ModalRegistro .close").click()
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
        if ($('#codigo').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar codigo.',
                'warning'
            ).then(function() { });
            return false
        }
        if ($('#area').val() == '0') {
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
        dropdownParent: $('#ModalRegistro')
    });
</script>
<style>
    .select2-container--default .select2-results > .select2-results__options {
        height: 3rem;
    }
    .select2-results__option {
        color: red;
    }
</style>