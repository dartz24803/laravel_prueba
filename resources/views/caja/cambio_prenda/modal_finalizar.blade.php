<form id="formulariof" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Finalizar cambio de prenda:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Serie:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="nuevo_num_serief" id="nuevo_num_serief" placeholder="Ingresar serie">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Número de documento:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="nuevo_num_comprobantef" id="nuevo_num_comprobantef" placeholder="Ingresar número de documento" onkeypress="return solo_Numeros(event);">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Finalizar_Cambio_Prenda();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Finalizar_Cambio_Prenda() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulariof'));
        var url = "{{ route('cambio_prenda.finalizar', $id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                Swal(
                    '¡Finalización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Cambio_Prenda();
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
    }
</script>
