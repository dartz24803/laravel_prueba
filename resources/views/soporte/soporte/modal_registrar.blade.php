<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registro de Soporte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="especialidad" name="especialidad">
                    <option value="0">Seleccione</option>
                    <option value="otros">Otros</option>
                    @foreach ($list_especialidad as $list)
                    <option value="{{ $list->id }}">{{ $list->nombre }}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group col-lg-2" id="elemento-cont">
                <label class="control-label text-bold">Elemento:</label>
            </div>
            <div class="form-group col-lg-4" id="elemento-container">
                <select class="form-control" id="elemento" name="elemento">
                    <option value="0">Seleccione</option>
                    @foreach ($list_elemento as $list)
                    <option value="{{ $list->idsoporte_elemento }}">{{ $list->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row" id="area-row" style="display: none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Área:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="area" name="area">
                    <option value="0">Seleccione</option>
                    <option value="1">Área 1</option>
                    <option value="2">Área 2</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2" id="asunto-cont">
                <label class="control-label text-bold">Asunto:</label>
            </div>
            <div class="form-group col-lg-10" id="asunto-container">
                <select class="form-control" id="asunto" name="asunto">
                    <option value="0">Seleccione</option>
                    @foreach ($list_asunto as $list)
                    <option value="{{ $list->idsoporte_asunto }}">{{ $list->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Ubicación:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="sede" name="sede">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sede as $list)
                    <option value="{{ $list->id }}">{{ $list->descripcion }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Vencimiento: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fecha" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Observación"></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Error_Picking();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Error_Picking() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ route('errorespicking.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    'Registro Exitoso!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_ErroresPicking();
                    $("#ModalRegistro .close").click();
                });
            },
            error: function(xhr) {
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

    const especialidadSelect = document.getElementById('especialidad');
    const elementoSelect = document.getElementById('elemento');
    const elementCont = document.getElementById('elemento-cont');
    const asuntoCont = document.getElementById(' asunto-con');

    const asuntoSelect = document.getElementById('asunto');

    const areaRow = document.getElementById('area-row');
    const elementoContainer = document.getElementById('elemento-container');
    const asuntoContainer = document.getElementById('asunto-container');

    especialidadSelect.addEventListener('change', function() {
        if (this.value === 'otros') {
            // Ocultar selects de elemento y asunto y eliminar su espacio
            elementoContainer.style.display = 'none';
            elementCont.style.display = 'none';
            asuntoContainer.style.display = 'none';
            // Mostrar select de área y asegurarse de que su espacio sea visible
            areaRow.style.display = 'block'; // Cambia esto a 'block' para que ocupe espacio
        } else {
            // Mostrar selects de elemento y asunto y asegurarse de que ocupen espacio
            elementoContainer.style.display = 'block'; // Ocupar espacio
            elementCont.style.display = 'block'; // Ocupar espacio
            asuntoContainer.style.display = 'block'; // Ocupar espacio
            // Ocultar select de área y eliminar su espacio
            areaRow.style.display = 'none'; // Ocultar completamente
        }
    });
</script>