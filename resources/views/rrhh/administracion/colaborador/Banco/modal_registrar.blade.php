<form id="formulario_registrar_banco" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Banco</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Siglas: </label>
            </div>            
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" id="cod_banco" name="cod_banco" placeholder="Siglas" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Banco:</label>
            </div>            
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id="nom_banco" name="nom_banco" placeholder="Ingresar Nombre de Banco" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Digitos Cuenta:</label>
            </div>
            <div class="form-group col-sm-3">
                <input type="number" class="form-control" id="digitos_cuenta" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
    maxlength = "2"   name="digitos_cuenta" placeholder="N° Cuenta">
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Digitos CCI:</label>
            </div>
            <div class="form-group col-sm-3">
                <input type="number" class="form-control" id="digitos_cci"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
    maxlength = "2" name="digitos_cci" placeholder="N° CCI">
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Insert_Banco();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<script>function Insert_Banco(){
    var dataString = $("#formulario_registrar_banco").serialize();
    var url="{{ url('ColaboradorConfController/Insert_Banco') }}";
    var csrfToken = $('input[name="_token"]').val();

    $.ajax({
        type:"POST",
        url:url,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data:dataString,
        success:function (data) {
            if(data=="error"){
                Swal({
                    title: 'Registro Denegado',
                    text: "¡El registro ya existe!",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
            }else{
                swal.fire(
                    'Registro Exitoso!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    $("#ModalRegistro .close").click();
                    TablaBanco();
                });
            }
        },
        error: function(xhr) {
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