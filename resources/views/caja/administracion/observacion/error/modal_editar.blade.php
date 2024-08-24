<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar error:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Tipo de error:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_errore" id="id_tipo_errore">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_error as $list)
                        <option value="{{ $list->id_tipo_error }}"
                        @if ($list->id_tipo_error==$get_id->id_tipo_error) selected @endif>
                            {{ $list->nom_tipo_error }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Nombre:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="nom_errore" name="nom_errore" placeholder="Ingresar nombre" value="{{ $get_id->nom_error }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold" for="montoe">Monto: </label>
            </div>            
            <div class="form-group col-lg-1">
                <input type="checkbox" id="montoe" name="montoe" value="1" @if ($get_id->monto=="1") checked @endif>                                        
            </div>
            
            <div class="form-group col-lg-3">
                <label class="control-label text-bold" for="automaticoe">Automatico: </label>
            </div>            
            <div class="form-group col-lg-1">
                <input type="checkbox" id="automaticoe" name="automaticoe" value="1" @if ($get_id->automatico=="1") checked @endif>                                        
            </div>

            <div class="form-group col-lg-3">
                <label class="control-label text-bold" for="archivoe">Documento: </label>
            </div>            
            <div class="form-group col-lg-1">
                <input type="checkbox" id="archivoe" name="archivoe" value="1" @if ($get_id->archivo=="1") checked @endif>                                        
            </div>
        </div>  
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Error();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Error() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('observacion_conf_err.update', $get_id->id_error) }}";

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
                        Lista_Error();
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