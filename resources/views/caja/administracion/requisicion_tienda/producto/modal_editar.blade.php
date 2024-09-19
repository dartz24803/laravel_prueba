<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar producto:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Marca:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_marcae" id="id_marcae" onchange="Traer_Modelo('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_marca as $list)
                        <option value="{{ $list->id_marca }}"
                        @if ($list->id_marca==$get_id->id_marca) selected @endif>
                            {{ $list->nom_marca }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Modelo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_modeloe" id="id_modeloe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_modelo as $list)
                        <option value="{{ $list->id_modelo }}"
                        @if ($list->id_modelo==$get_id->id_modelo) selected @endif>
                            {{ $list->nom_modelo }}
                        </option>
                    @endforeach                    
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Color:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_colore" id="id_colore">
                    <option value="0">Seleccione</option>
                    @foreach ($list_color as $list)
                        <option value="{{ $list->id_color }}"
                        @if ($list->id_color==$get_id->id_color) selected @endif                            >
                            {{ $list->nom_color }}
                        </option>
                    @endforeach                    
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_categoriae" id="id_categoriae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_categoria as $list)
                        <option value="{{ $list->id_categoria }}"
                        @if ($list->id_categoria==$get_id->id_categoria) selected @endif                            >
                            {{ $list->nom_categoria }}
                        </option>
                    @endforeach                       
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Unidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_unidade" id="id_unidade">
                    <option value="0">Seleccione</option>
                    @foreach ($list_unidad as $list)
                        <option value="{{ $list->id_unidad }}"
                        @if ($list->id_unidad==$get_id->id_unidad) selected @endif                            >
                            {{ $list->nom_unidad }}
                        </option>
                    @endforeach                     
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Estado:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_estadoe" id="id_estadoe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_estado as $list)
                        <option value="{{ $list->id_estado }}"
                        @if ($list->id_estado==$get_id->id_estado) selected @endif                            >
                            {{ $list->nom_estado }}
                        </option>
                    @endforeach                       
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Nombre:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="nom_productoe" id="nom_productoe" 
                placeholder="Nombre" value="{{ $get_id->nom_producto }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Unidad_Medida();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Unidad_Medida() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('requisicion_tienda_conf_pr.update', $get_id->id_producto) }}";

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
                        Lista_Producto();
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