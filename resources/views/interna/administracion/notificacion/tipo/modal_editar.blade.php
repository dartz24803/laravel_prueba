<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar tipo:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Nombre:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="descrip_confige" name="descrip_confige" 
                placeholder="Ingresar nombre" value="{{ $get_id->descrip_config }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Mensaje:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="mensajee" name="mensajee" 
                placeholder="Ingresar mensaje" value="{{ $get_id->mensaje }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Ícono:</label>
            </div>
            <div class="form-group col-lg-10">
                <textarea class="form-control" name="iconoe" id="iconoe" rows="10" 
                placeholder="Ingresar ícono">{{ $get_id->icono }}</textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Tipo();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Tipo() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('notificacion_conf_ti.update', $get_id->id_config) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Tipo();
                        $("#ModalUpdate .close").click();
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
    }
</script>