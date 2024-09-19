<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo producto:</h5>
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
                <select class="form-control" name="id_marca" id="id_marca" onchange="Traer_Modelo('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_marca as $list)
                        <option value="{{ $list->id_marca }}">{{ $list->nom_marca }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Modelo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_modelo" id="id_modelo">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Color:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_color" id="id_color">
                    <option value="0">Seleccione</option>
                    @foreach ($list_color as $list)
                        <option value="{{ $list->id_color }}">{{ $list->nom_color }}</option>
                    @endforeach                    
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_categoria" id="id_categoria">
                    <option value="0">Seleccione</option>
                    @foreach ($list_categoria as $list)
                        <option value="{{ $list->id_categoria }}">{{ $list->nom_categoria }}</option>
                    @endforeach                       
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Unidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_unidad" id="id_unidad">
                    <option value="0">Seleccione</option>
                    @foreach ($list_unidad as $list)
                        <option value="{{ $list->id_unidad }}">{{ $list->nom_unidad }}</option>
                    @endforeach                     
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Estado:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_estado" id="id_estado">
                    <option value="0">Seleccione</option>
                    @foreach ($list_estado as $list)
                        <option value="{{ $list->id_estado }}">{{ $list->nom_estado }}</option>
                    @endforeach                       
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Nombre:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="nom_producto" id="nom_producto" 
                placeholder="Nombre">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Producto();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Producto() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('requisicion_tienda_conf_pr.store') }}";

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
                        text: "¡El registro ya existe!",
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
                        Lista_Producto();
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
