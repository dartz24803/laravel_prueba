<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo tracking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">N° requerimiento: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_requerimiento" id="n_requerimiento" 
                placeholder="N° requerimiento" onkeypress="return soloNumeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Semana: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="semana" id="semana" placeholder="Semana" 
                maxlength="2" onkeypress="return soloNumeros(event);">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Desde: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="desde" id="desde">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="<?= $list->cod_base; ?>"><?= $list->cod_base; ?></option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Hacia: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="hacia" id="hacia">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="<?= $list->cod_base; ?>"><?= $list->cod_base; ?></option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer"> 
        <button class="btn btn-primary" type="button" onclick="Insert_Tracking();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Tracking(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "";

        if (Valida_Insert_Tracking()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Tracking();
                        $("#ModalRegistro .close").click();
                    });
                }
            });
        }
    }

    function Valida_Insert_Tracking() {
        if ($('#n_requerimiento').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar n° de requerimiento.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#semana').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar semana.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#desde').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar desde donde se hará el envío.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#hacia').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar hacia donde se hará el envío.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
  