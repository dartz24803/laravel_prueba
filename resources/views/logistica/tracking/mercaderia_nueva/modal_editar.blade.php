<form id="formulariod" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Ingreso de detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">SKU: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" placeholder="SKU" value="{{ $id }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cantidad Surtido: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad Surtido"
                value="{{ $get_id->cantidad ?? '' }}" onkeypress="return solo_Numeros(event);">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <!--<button class="btn btn-primary" type="button" onclick="Insert_Devolucion_Temporal();">Guardar</button>-->
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Devolucion_Temporal(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulariod'));
        var url = "{{ route('tracking.insert_devolucion_temporal', $id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡Debe ingresar cantidad disponible!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
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