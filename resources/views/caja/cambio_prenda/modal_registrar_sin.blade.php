<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar cambio de prenda sin boleta:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        @if (session('usuario')->id_nivel=="1")
            <div class="row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Base:</label>
                </div>
                <div class="form-group col-lg-4">
                    <select class="form-control" name="base" id="base">
                        <option value="0">Seleccione</option>
                        @foreach ($list_base as $list)
                            <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <input type="hidden" name="base" value="{{ session('usuario')->centro_labores }}">
        @endif

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Código de producto:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_codi_arti" id="n_codi_arti" 
                placeholder="Ingresar código de producto">
            </div>
            <div class="form-group col-lg-2">
                <a class="btn btn-primary" onclick="Buscar_Producto('')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </a>
            </div>
        </div>

        <div class="row" id="div_detalle">
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cantidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="n_cant_vent" id="n_cant_vent">
                    <option value="0">Seleccione</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="nom_cliente" id="nom_cliente" 
                placeholder="Ingresar nombre">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Teléfono:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="telefono" id="telefono" 
                placeholder="Ingresar teléfono" onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Vendedor:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="vendedor" id="vendedor" 
                placeholder="Ingresar vendedor">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Número de caja:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="num_caja" id="num_caja" 
                placeholder="Ingresar número de caja" onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Hora:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="time" class="form-control" name="hora" id="hora" value="{{ date('H:i') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Motivo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_motivo" id="id_motivo" onchange="Mostrar_Otro('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_motivo as $list)
                        <option value="{{ $list->id_motivo }}">{{ $list->nom_motivo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 mostrar" style="display: none;">
                <label class="control-label text-bold">Otro:</label>
            </div>
            <div class="form-group col-lg-4 mostrar" style="display: none;">
                <input type="text" class="form-control" name="otro" id="otro" placeholder="Ingresar otro">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary" type="button" onclick="Insert_Cambio_Prenda();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Cambio_Prenda() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('cambio_prenda_sin.store') }}";

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
                swal.fire(
                    '¡Registro Exitoso!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Cambio_Prenda();
                    $("#ModalRegistro .close").click();
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
</script>
