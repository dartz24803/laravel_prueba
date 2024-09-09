<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar cambio de prenda con boleta:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
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

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo comprobante:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="tipo_comprobante" id="tipo_comprobante">
                    <option value="0">Seleccione</option>
                    <option value="08">Boleta</option>
                    <option value="09">Factura</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Serie:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="serie" id="serie" placeholder="Ingresar serie">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Número de documento:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_documento" id="n_documento" placeholder="Ingresar número de documento" onkeypress="return solo_Numeros(event);">
            </div>
            <div class="form-group col-lg-2">
                <a class="btn btn-primary" onclick="Buscar_Comprobante('')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </a>
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

        <div class="row" id="div_detalle">
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
        var url = "{{ route('cambio_prenda_con.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,,
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
