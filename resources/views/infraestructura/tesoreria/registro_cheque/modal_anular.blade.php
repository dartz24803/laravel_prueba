<form id="formularion" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Anular cheque:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Motivo:</label>
            </div>
            <div class="form-group col-lg-10">
                <textarea class="form-control" name="motivo_anuladon" id="motivo_anuladon" rows="4" placeholder="Motivo">{{ $get_id->motivo_anulado }}</textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <input type="hidden" name="estado" value="5">
        <button class="btn btn-primary" type="button" onclick="Anular_Cheque();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Anular_Cheque() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularion'));
        var url = "{{ route('registro_cheque.update_estado', $get_id->id_cheque) }}";

        Swal({
            title: '¿Realmente desea anular el registro?',
            text: "El registro será anulado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    data: dataString,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        swal.fire(
                            '¡Actualización Exitosa!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Registro_Cheque();
                            $("#ModalUpdate .close").click();
                        })
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
        })
    }
</script>