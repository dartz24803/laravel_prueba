<style>
    /* public/css/style.css */
    body {
        font-family: Arial, sans-serif;
    }

    .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: none;
        /* Ocultar por defecto */
        position: absolute;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        min-width: 150px;
        z-index: 1;
    }

    .dropdown-btn {
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    .dropdown-list li {
        padding: 8px 12px;
    }

    .dropdown-list li:hover {
        background-color: #ddd;
        /* Color al pasar el mouse */
    }

    .submenu {
        display: none;
        /* Ocultar submenús por defecto */
        position: relative;
        left: 100%;
        /* A la derecha del elemento padre */
        top: 0;
    }

    .dropdown-list li:hover>.submenu {
        display: block;
        /* Mostrar submenú al pasar el mouse */
    }
</style>
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
            <div class="form-group col-lg-1" id="elemento-area" style="display: none;">
                <label class="control-label text-bold">Area:</label>
            </div>
            <div class="form-group col-lg-5" id="area-row" style="display: none;">
                <select class="form-control" id="area" name="area">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                    @endforeach
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
            <!-- Primera fila: Ubicación y sublist-container -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Label de "Ubicación" -->
                    <div class="form-group col-lg-2">
                        <label class="control-label text-bold">Ubicación:</label>
                    </div>

                    <!-- Primer select "Sede" -->
                    <div class="form-group col-lg-4">
                        <select class="form-control" id="sede">
                            <option value="0">Seleccione</option>
                            @foreach ($list_sede as $sede)
                            <option value="{{ $sede->id }}">{{ $sede->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-6" id="sublist-container">
                        <select class="form-control" id="sub-sede">
                            <option value="0">Seleccione Ubicación</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Segunda fila: Thirdlist-container (Sub-ubicación) -->
            <div class="col-lg-12" id="sububicacion-container" style="display: none;">
                <div class="row">
                    <!-- Tercer select (Thirdlist-container), siempre presente pero con visibilidad controlada -->
                    <div class="form-group col-lg-4 offset-lg-2" id="thirdlist-container" style="visibility: hidden;">
                        <select class="form-control" id="third-sede">
                            <option value="0">Seleccione SubUbicación</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Label de "Vencimiento" -->
                    <div class="form-group col-lg-2">
                        <label>Vencimiento:</label>
                    </div>

                    <!-- Input de fecha (Vencimiento) -->
                    <div class="form-group col-lg-4">
                        <input type="date" class="form-control" name="fecha" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Ingresar descripción"></textarea>
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
    const asuntoCont = document.getElementById('asunto-cont');
    const asuntoSelect = document.getElementById('asunto');
    const areaRow = document.getElementById('area-row');
    const elementoContainer = document.getElementById('elemento-container');
    const asuntoContainer = document.getElementById('asunto-container');
    const areaElementoRow = document.getElementById('elemento-area');


    especialidadSelect.addEventListener('change', function() {
        if (this.value === 'otros') {
            // Ocultar selects de elemento y asunto y eliminar su espacio
            elementoContainer.style.display = 'none';
            elementCont.style.display = 'none';
            asuntoCont.style.display = 'none';
            asuntoContainer.style.display = 'none';
            // Mostrar select de área y asegurarse de que su espacio sea visible
            areaRow.style.display = 'block';
            areaElementoRow.style.display = 'block';
        } else {
            // Mostrar selects de elemento y asunto y asegurarse de que ocupen espacio
            elementoContainer.style.display = 'block';
            elementCont.style.display = 'block';
            asuntoCont.style.display = 'block';
            asuntoContainer.style.display = 'block';
            // Ocultar select de área y eliminar su espacio
            areaRow.style.display = 'none';
            areaElementoRow.style.display = 'none';
        }
    });





    const sedeSelect = document.getElementById('sede');
    const subSedeSelect = document.getElementById('sub-sede');
    const thirdSedeSelect = document.getElementById('third-sede');
    const sublistContainer = document.getElementById('sublist-container');
    const thirdContainer = document.getElementById('thirdlist-container');
    const subUbicacionCont = document.getElementById('sububicacion-container');

    sedeSelect.addEventListener('change', function() {
        if (this.value === '0') {
            // Ocultar selects de elemento y asunto y eliminar su espacio
            subSedeSelect.style.display = 'none';
            thirdSedeSelect.style.display = 'none';
            sublistContainer.style.display = 'none';
            thirdContainer.style.display = 'none';

        } else {
            // Mostrar selects de elemento y asunto y asegurarse de que ocupen espacio
            subSedeSelect.style.display = 'block';
            thirdSedeSelect.style.display = 'block';
            sublistContainer.style.display = 'block';
            thirdContainer.style.display = 'block';

        }
    });


    $('#sede').on('change', function() {
        const selectedSede = $(this).val(); // Obtenemos el valor de la sede seleccionada
        var url = "{{ route('soporte_ubicacion_por_sede') }}";
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                sedes: selectedSede
            },
            success: function(response) {
                $('#sub-sede').empty().append('<option value="0">Seleccione Ubicación</option>');
                console.log(response)
                // Verificar si hay respuestas
                if (response.length > 0) {
                    $.each(response, function(index, sede) {
                        $('#sub-sede').append(
                            `<option value="${sede.idsoporte_ubicacion1}">${sede.nombre}</option>`
                        );
                    });
                    $('#sublist-container').show(); // Mostrar el contenedor de sub-sede
                } else {
                    $('#sublist-container').hide(); // Ocultar si no hay ubicaciones
                }
            },
            error: function(xhr) {
                console.error('Error al obtener ubicaciones:', xhr);
            }
        });
    });

    $('#sub-sede').on('change', function() {
        const selectedubicacion1 = $(this).val(); // Obtenemos el valor de la sede seleccionada
        var url = "{{ route('soporte_ubicacion2_por_ubicacion1') }}";
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                ubicacion1: selectedubicacion1
            },
            success: function(response) {
                $('#third-sede').empty().append('<option value="0">Seleccione SubUbicación</option>');
                // Verificar si hay respuestas
                if (response.length > 0) {
                    $('#third-sede').empty().append('<option value="0">Seleccione SubUbicación</option>');
                    $.each(response, function(index, ubicacion) {
                        $('#third-sede').append(`<option value="${ubicacion.idsoporte_ubicacion2}">${ubicacion.nombre}</option>`);
                    });
                    $('#thirdlist-container').css('visibility', 'visible');
                    subUbicacionCont.style.display = 'block';

                } else {
                    $('#thirdlist-container').css('visibility', 'hidden');
                    subUbicacionCont.style.display = 'none';

                }

            },
            error: function(xhr) {
                console.error('Error al obtener ubicaciones:', xhr);
            }
        });
    });
</script>