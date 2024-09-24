<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nueva requisición tienda:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Coordinador:</label>
            </div>
            <div class="form-group col-lg-5">
                <select class="form-control basic" name="id_usuario" id="id_usuario">
                    <option value="0">Seleccione</option>
                    @foreach ($list_usuario as $list)
                        <option value="{{ $list->id_usuario }}">{{ $list->nom_usuario }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Fecha:</label>
            </div>
            <div class="form-group col-lg-3">
                <input type="date" class="form-control" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12">
                <label style="font-weight:bolder;
                color:black;">
                    Detalle:
                </label>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Stock:</label>
                <input type="text" class="form-control" name="stock" id="stock" placeholder="Stock"
                onkeypress="return solo_Numeros(event);" onpaste="return false;">
            </div>

            <div class="form-group col-lg-2">
                <label>Cantidad:</label>
                <input type="text" class="form-control" name="cantidad" id="cantidad" 
                placeholder="Cantidad" onkeypress="return solo_Numeros(event);" onpaste="return false;">
            </div>

            <div class="form-group col-lg-7">
                <label>Producto:</label>
                <select class="form-control basic" name="id_producto" id="id_producto">
                    <option value="0">Seleccione</option>
                    @foreach ($list_producto as $list)
                        <option value="{{ $list->id_producto }}">{{ $list->nom_producto }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group d-flex align-items-center col-lg-1">
                <button class="btn btn-primary" type="button" onclick="Insert_Temporal();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Precio Unitario:</label>
                <input type="text" class="form-control" name="precio" id="precio" 
                placeholder="Precio" onkeypress="return solo_Numeros_Punto(event);" 
                onpaste="return false;">
            </div>

            <div class="form-group col-lg-4">
                <label>Archivo:</label>
                <input type="file" class="form-control-file" name="archivo" id="archivo" 
                onchange="Valida_Archivo('archivo');">
            </div>
        </div>

        <div id="lista_temporal" class="row">
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Requisicion_Tienda();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalRegistroGrande')
    });

    Lista_Temporal();

    function Lista_Temporal(){
        Cargando();

        var url = "{{ route('requisicion_tienda.list_tmp') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_temporal').html(resp);  
            }
        });
    }

    function Insert_Temporal(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('requisicion_tienda.store_tmp') }}";

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
                        $('#stock').val('');
                        $('#cantidad').val('');
                        $('#id_producto').val('0');
                        $('#precio').val('');
                        $('#archivo').val('');
                        $(".basic").select2({
                            dropdownParent: $('#ModalRegistroGrande')
                        });
                        Lista_Temporal();
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

    function Delete_Temporal(id) {
        Cargando();

        var url = "{{ route('requisicion_tienda.destroy_tmp', ':id') }}".replace(':id', id);

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Temporal();
                        });    
                    }
                });
            }
        })
    }

    function Insert_Requisicion_Tienda() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('requisicion_tienda.store') }}";

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
                        text: "¡Ya existe un registro para el mes y base seleccionado!",
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
                        Lista_Requisicion_Tienda();
                        $("#ModalRegistroGrande .close").click();
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
