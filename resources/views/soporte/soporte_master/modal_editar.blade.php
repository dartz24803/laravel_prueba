<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar soporte: <span id="codigo_texto" class="ml-2">{{ $get_id->codigo }}</span></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tarea-tab" data-toggle="tab" href="#tarea" role="tab"
                    aria-controls="tarea" aria-selected="true">Tarea</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="ejecutor-tab" data-toggle="tab" href="#ejecutor" role="tab"
                    aria-controls="ejecutor" aria-selected="false">Ejecutor</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="solucion-tab" data-toggle="tab" href="#solucion" role="tab"
                    aria-controls="solucion" aria-selected="false">Solución</a>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content" id="myTabContent2">
            <div class="tab-pane fade show active" id="tarea" role="tabpanel" aria-labelledby="tarea-tab">

                <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold" ">Responsable:</label>
                            </div>
                            <div class=" form-group col-md-10">
                                    <select class="form-control" id="id_responsablee" name="id_responsablee">
                                        <!-- Si id_responsable es null, seleccionamos SIN DESIGNAR -->
                                        <option value="0" {{ is_null($get_id->id_responsable) ? 'selected' : '' }}>SIN DESIGNAR</option>
                                              @foreach ($list_responsable as $list)
                                    <!-- Si id_responsable coincide con el id_usuario del listado, lo seleccionamos -->
                                    <option value="{{ $list->id_usuario }}"
                                        {{ $get_id->id_responsable == $list->id_usuario ? 'selected' : '' }}>
                                        {{ $list->nombre_completo }}
                                    </option>
                                    @endforeach
                                    </select>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <!-- Campo Estado -->
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Estado:</label>
                            </div>
                            <div class="form-group col-md-4" id="estado-container">
                                <select class="form-control" id="estado_registroe" name="estado_registroe">
                                    <option value="1" {{ $get_id->estado_registro == 1 ? 'selected' : '' }}>Por
                                        Iniciar</option>
                                    <option value="2" {{ $get_id->estado_registro == 2 ? 'selected' : '' }}>En
                                        Proceso</option>
                                    <option value="3" {{ $get_id->estado_registro == 3 ? 'selected' : '' }}>
                                        Completado</option>
                                    <option value="4" {{ $get_id->estado_registro == 4 ? 'selected' : '' }}>Stand
                                        By</option>
                                </select>
                            </div>

                            <!-- Campos Cierre, inicialmente ocultos -->
                            <div class="form-group col-md-2" id="cierre-label" style="display: none;">
                                <label class="control-label text-bold">Cierre:</label>
                            </div>
                            <div class="form-group col-md-4" id="cierre-field" style="display: none;">
                                <input type="date" class="form-control" id="fec_cierree" name="fec_cierree"
                                    value="{{ $get_id->fec_cierre ? \Carbon\Carbon::parse($get_id->fec_cierre)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>

                        </div>
                    </div>
                </div>



                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" ">Base:</label>
                            </div>
                            <div class=" form-group col-md-4 mb-0">
                                    <span class="form-control border-0">{{ $get_id->base }}</span>
                            </div>
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" ">Tipo:</label>
                            </div>
                            <div class=" form-group col-md-4 mb-0">
                                <span class="form-control border-0">{{ $get_id->nombre_tipo }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" ">Usuario:</label>
                            </div>
                            <div class=" form-group col-md-10 mb-0"> <!-- Ajustar la columna a col-md-10 -->
                                    <span class="form-control border-0">{{ $get_id->usuario_nombre }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold" ">Especialidad:</label>
                            </div>
                            <div class=" form-group col-md-4">
                                <span class="form-control border-0">{{ $get_id->nombre_especialidad }}</span>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold" ">Elemento:</label>
                            </div>
                            <div class=" form-group col-md-4">
                                    <span class="form-control border-0">{{ $get_id->nombre_elemento }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" ">Asunto:</label>
                            </div>
                            <div class=" form-group col-md-10 mb-0"> <!-- Ajustar la columna a col-md-10 -->
                                <span class="form-control border-0">{{ $get_id->nombre_asunto }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" ">Ubicación:</label>
                            </div>
                            <div class=" form-group col-md-4 mb-0">
                                    <span class="form-control border-0">{{ $get_id->nombre_ubicacion }}</span>
                            </div>
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" ">Vencimiento:</label>
                            </div>
                            <div class=" form-group col-md-4 mb-0">
                                <span class="form-control border-0">{{ $get_id->fec_vencimiento }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" ">Descripción:</label>
                            </div>
                            <div class=" form-group col-md-10 mb-0"> <!-- Ajustar la columna a col-md-10 -->
                                    <span class="form-control border-0">{{ $get_id->descripcion }}</span>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="tab-pane fade" id="ejecutor" role="tabpanel" aria-labelledby="ejecutor-tab">
                <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold" ">Ejecutor:</label>
                            </div>
                            <div class=" form-group col-md-10"> <!-- Ajustar la columna a col-md-10 -->

                                <select class="form-control" id="ejecutor_responsable" name="ejecutor_responsable">
                                    <!-- Si id_responsable es null, seleccionamos SIN DESIGNAR -->
                                    <option value="0"
                                        {{ is_null($get_id->idejecutor_responsable) ? 'selected' : '' }}>SELECCIONAR
                                    </option>
                                    @foreach ($list_ejecutores_responsables as $list)
                                        <!-- Si id_responsable coincide con el id_usuario del listado, lo seleccionamos -->
                                        <option value="{{ $list->idejecutor_responsable }}"
                                            {{ $get_id->idejecutor_responsable == $list->idejecutor_responsable ? 'selected' : '' }}>
                                            {{ $list->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="form-group col-md-2" id="nom_proyecto-label">
                                <label class="control-label text-bold">Nombre del Proyecto:</label>
                            </div>
                            <div class="form-group col-md-4" id="nom_proyecto-field">
                                <input type="text" class="form-control" id="nom_proyecto" name="nom_proyecto"
                                    value="{{ $get_id->nombre_proyecto }}">

                            </div>

                            <div class="form-group col-md-3" id="fec_ini_proyecto-label">
                                <label class="control-label text-bold">Fecha de Inicio del Proyecto:</label>
                            </div>
                            <div class="form-group col-md-3" id="fec_ini_proyecto-field">
                                <input type="date" class="form-control" id="fec_ini_proyecto"
                                    name="fec_ini_proyecto"
                                    value="{{ $get_id->fec_inicio_proyecto ? \Carbon\Carbon::parse($get_id->fec_inicio_proyecto)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="form-group col-md-2" id="proveedor-label">
                                <label class="control-label text-bold">Proveedor:</label>
                            </div>
                            <div class="form-group col-md-10" id="proveedor-field">
                                <input type="text" class="form-control" id="proveedor" name="proveedor"
                                    value="{{ $get_id->proveedor }}">
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="form-group col-md-2" id="nom_contratista-label">
                                <label class="control-label text-bold">Nombre del Contratista:</label>
                            </div>
                            <div class="form-group col-md-10" id="nom_contratista-field">
                                <input type="text" class="form-control" id="nom_contratista"
                                    name="nom_contratista" value="{{ $get_id->nombre_contratista }}">
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="form-group col-md-2" id="dni_prestador-label">
                                <label class="control-label text-bold">DNI del prestador de Servicio:</label>
                            </div>
                            <div class="form-group col-md-4" id="dni_prestador-field">
                                <input type="text" class="form-control" id="dni_prestador" name="dni_prestador"
                                    value="{{ $get_id->dni_prestador_servicio }}">
                            </div>

                            <div class="form-group col-md-2" id="ruc-label">
                                <label class="control-label text-bold">Ruc:</label>
                            </div>
                            <div class="form-group col-md-4" id="ruc-field">
                                <input type="text" class="form-control" id="ruc" name="ruc"
                                    value="{{ $get_id->ruc }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="solucion" role="tabpanel" aria-labelledby="solucion-tab">
                <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-12 mb-0">
                                <label class="control-label text-bold" ">Solucion Aplicada:</label>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class=" row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                                    <div class="col-xl-12 col-lg-12 col-sm-12">
                                        <div class="row align-items-center">
                                            <div class=" form-group col-md-12 mb-0"> <!-- Ajustar la columna a col-md-10 -->
                                                <textarea class="form-control" id="descripcione_solucion" name="descripcione_solucion" rows="5"
                                                    placeholder="Ingresar descripción">{{ $get_id->descripcion_solucion }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    @csrf
                    <button class="btn btn-primary" type="button" onclick="Update_Soporte_Master();">Guardar</button>
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                </div>
</form>

<script>
    $(document).ready(function() {
        toggleCierre();
        toggleEjecutor();

        $('#estado_registroe').on('change', function() {
            toggleCierre();
        });

        $('#ejecutor_responsable').on('change', function() {
            toggleEjecutor();
        });
    });

    function toggleCierre() {
        var estado = document.getElementById('estado_registroe').value;
        var cierreLabel = document.getElementById('cierre-label');
        var cierreField = document.getElementById('cierre-field');
        var estadoContainer = document.getElementById('estado-container');

        if (estado == 3 || estado == 4) {
            // Mostrar los campos de Cierre
            cierreLabel.style.display = 'block';
            cierreField.style.display = 'block';
            estadoContainer.classList.remove('col-md-10');
            estadoContainer.classList.add('col-md-4');
        } else {
            // Ocultar los campos de Cierre
            cierreLabel.style.display = 'none';
            cierreField.style.display = 'none';
            estadoContainer.classList.remove('col-md-4');
            estadoContainer.classList.add('col-md-10');
        }
    }

    function toggleEjecutor() {
        var ejecutor_responsable = document.getElementById('ejecutor_responsable').value;
        var nomproyectoLabel = document.getElementById('nom_proyecto-label');
        var nomproyectoField = document.getElementById('nom_proyecto-field');
        var fecIniProLabel = document.getElementById('fec_ini_proyecto-label');
        var fecIniProField = document.getElementById('fec_ini_proyecto-field');
        var proveedorLabel = document.getElementById('proveedor-label');
        var proveedorField = document.getElementById('proveedor-field');
        var nomContratistaLabel = document.getElementById('nom_contratista-label');
        var nomContratistaField = document.getElementById('nom_contratista-field');
        var dniPrestadorLabel = document.getElementById('dni_prestador-label');
        var dniPrestadorField = document.getElementById('dni_prestador-field');
        var rucLabel = document.getElementById('ruc-label');
        var rucField = document.getElementById('ruc-field');

        if (ejecutor_responsable == 2) {
            // Mostrar los campos de Proyecto
            nomproyectoLabel.style.display = 'block';
            nomproyectoField.style.display = 'block';
            fecIniProLabel.style.display = 'block';
            fecIniProField.style.display = 'block';
            proveedorLabel.style.display = 'block';
            proveedorField.style.display = 'block';
            nomContratistaLabel.style.display = 'block';
            nomContratistaField.style.display = 'block';
            dniPrestadorLabel.style.display = 'block';
            dniPrestadorField.style.display = 'block';
            rucLabel.style.display = 'block';
            rucField.style.display = 'block';
        } else {
            // Ocultar los campos de Proyecto
            nomproyectoLabel.style.display = 'none';
            nomproyectoField.style.display = 'none';
            fecIniProLabel.style.display = 'none';
            fecIniProField.style.display = 'none';
            proveedorLabel.style.display = 'none';
            proveedorField.style.display = 'none';
            nomContratistaLabel.style.display = 'none';
            nomContratistaField.style.display = 'none';
            dniPrestadorLabel.style.display = 'none';
            dniPrestadorField.style.display = 'none';
            rucLabel.style.display = 'none';
            rucField.style.display = 'none';
        }
    }


    function Update_Soporte_Master() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ route('soporte_ticket_master.update', $get_id->id_soporte) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Tickets_Soporte();
                        $("#ModalUpdate .close").click();
                    });
                }
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
</script>
