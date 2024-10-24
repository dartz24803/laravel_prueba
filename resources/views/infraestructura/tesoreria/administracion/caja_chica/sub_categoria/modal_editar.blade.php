<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar sub-categoría:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Ubicación:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_ubicacione" id="id_ubicacione" onchange="Traer_Categoria('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_ubicacion as $list)
                        <option value="{{ $list->id_ubicacion }}"
                        @if ($list->id_ubicacion==$get_id->id_ubicacion) selected @endif>
                            {{ $list->cod_ubi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_categoriae" id="id_categoriae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_categoria as $list)
                        <option value="{{ $list->id_categoria }}"
                        @if ($list->id_categoria==$get_id->id_categoria) selected @endif>
                            {{ $list->nom_categoria }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="nombree" id="nombree" placeholder="Nombre" value="{{ $get_id->nombre }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Sub_Categoria();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Sub_Categoria() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('caja_chica_conf_sc.update', $get_id->id) }}";

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
                        Lista_Sub_Categoria();
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