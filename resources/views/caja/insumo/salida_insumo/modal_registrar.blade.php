<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar salida de insumo:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Insumo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_insumo" id="id_insumo">
                    <option value="0">Seleccione</option>
                    @foreach ($list_insumo as $list)
                        <option value="{{ $list->id_insumo }}">{{ $list->nom_insumo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cantidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cantidad_salida" id="cantidad_salida" 
                placeholder="Cantidad" onkeypress="return solo_Numeros(event);">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Salida_Insumo();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Salida_Insumo() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('insumo_sa.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡La cantidad de salida no puede ser mayor al stock actual!",
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
                        Lista_Izquierda();
                        Lista_Derecha();
                        $("#ModalRegistro .close").click();
                    })
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
