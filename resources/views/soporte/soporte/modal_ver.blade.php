<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Ver soporte: <span id="codigo_texto" class="ml-2">{{ $get_id->codigo }}</span></h5>

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
                            <div class="form-group col-md-2 mb-0" id="id_responsableever-label">
                                <label class="control-label text-bold" ">Responsable:</label>
                            </div>
                            <div class=" form-group col-md-10 mb-0" id="id_responsableever-field">
                                    <span class="form-control border-0">{{ $get_id->nombre_responsable_asignado }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0" id="estado-containerver-label">
                                <label class="control-label text-bold">Estado:</label>
                            </div>
                            <div class=" form-group col-md-4 mb-0" id="estado-containerver-field">
                                <span class="form-control border-0" id="estado_registro" name="estado_registro">
                                    @if ($get_id->estado_registro == 1)
                                    Por Iniciar
                                    @elseif($get_id->estado_registro == 2)
                                    En Proceso
                                    @elseif($get_id->estado_registro == 3)
                                    Completado
                                    @elseif($get_id->estado_registro == 4)
                                    Stand By
                                    @elseif($get_id->estado_registro == 5)
                                    Cancelado
                                    @else
                                    Estado Desconocido
                                    @endif
                                </span>
                            </div>

                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" id="cierre-labelver"
                                    style="display: none;">Cierre:</label>
                            </div>
                            <div class=" form-group col-md-4 mb-0" id="cierre-fieldver" style="display: none;">
                                <span
                                    class="form-control border-0">{{ \Carbon\Carbon::parse($get_id->fec_cierre)->locale('es')->translatedFormat('D d M y') }}</span>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" ">Sede Laboral:</label>
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
                                    <span class="form-control border-0">
                                        {{ $get_id->nombre_ubicacion }} - {{ $get_id->nombre_area_especifica }}
                                    </span>
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
                <div class="row" id="cancel-row">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold">Descripción:</label>
                            </div>
                            <div class="form-group col-md-10 mb-0">
                                <span class="form-control border-0" style="max-width: 380px; word-wrap: break-word;">
                                    {{ $get_id->descripcion }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="tab-pane fade" id="ejecutor" role="tabpanel" aria-labelledby="ejecutor-tab">


                <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">


                        <div id="area-involucradaver">
                            @foreach ($list_areas_involucradas as $index => $area_involucrada)
                            <!-- Sección para mostrar Responsable -->
                            <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="row align-items-center">
                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">
                                                Responsable:
                                                <span style="display: block; width: 130px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $area_involucrada['area_responsable'] }}">
                                                    {{ $area_involucrada['cod_area_responsable'] }}
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-group col-md-10">
                                            <!-- Aumento del ancho máximo para el responsable -->
                                            <p>{{ $area_involucrada['nom_responsable'] ? $area_involucrada['nom_responsable'] : 'SIN DESIGNAR' }}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección para mostrar Estado y Cierre en la misma fila -->
                            <div class="row" id="cancel-row" style="flex: 1;">
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="row align-items-center">
                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">Estado:</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <p>
                                                @switch($area_involucrada['estado_registro'])
                                                @case(1)
                                                Por Iniciar
                                                @break
                                                @case(2)
                                                En Proceso
                                                @break
                                                @case(3)
                                                Completado
                                                @break
                                                @case(4)
                                                Stand By
                                                @break
                                                @default
                                                Desconocido
                                                @endswitch
                                            </p>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">Cierre:</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <p>{{ $area_involucrada['fec_cierre'] ? \Carbon\Carbon::parse($area_involucrada['fec_cierre'])->format('d-m-Y') : 'No especificado' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>




                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold">Ejecutor:</label>
                            </div>
                            <div class="form-group col-md-10 mb-0">
                                <span class="form-control border-0">{{ $get_id->nombre_ejecutor_responsable }}</span>
                                <input type="text" class="form-control" id="ejecutor_responsablever" name="ejecutor_responsablever" value="{{ $get_id->idejecutor_responsable }}" style="display: none;">
                            </div>

                        </div>

                        <div class="row align-items-center">
                            <div class="form-group col-md-2" id="nom_proyecto-labelver">
                                <label class="control-label text-bold">Nombre del Proyecto:</label>
                            </div>
                            <div class="form-group col-md-4" id="nom_proyecto-fieldver">
                                <span class="form-control border-0">{{ $get_id->nombre_proyecto }}</span>
                            </div>

                            <div class="form-group col-md-3" id="fec_ini_proyecto-labelver">
                                <label class="control-label text-bold">Fecha de Inicio del Proyecto:</label>
                            </div>
                            <div class="form-group col-md-3" id="fec_ini_proyecto-fieldver">
                                <span class="form-control border-0">
                                    {{ \Carbon\Carbon::parse($get_id->fec_inicio_proyecto)->locale('es')->translatedFormat('D d M y') }}
                                </span>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="form-group col-md-2" id="proveedor-labelver">
                                <label class="control-label text-bold">Proveedor:</label>
                            </div>
                            <div class="form-group col-md-10" id="proveedor-fieldver">
                                <span class="form-control border-0">{{ $get_id->proveedor }}</span>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="form-group col-md-2" id="nom_contratista-labelver">
                                <label class="control-label text-bold">Nombre del Contratista:</label>
                            </div>
                            <div class="form-group col-md-10" id="nom_contratista-fieldver">
                                <span class="form-control border-0">{{ $get_id->nombre_contratista }}</span>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="form-group col-md-2" id="dni_prestador-labelver">
                                <label class="control-label text-bold">DNI del prestador de Servicio:</label>
                            </div>
                            <div class="form-group col-md-4" id="dni_prestador-fieldver">
                                <span class="form-control border-0">{{ $get_id->dni_prestador_servicio }}</span>
                            </div>

                            <div class="form-group col-md-2" id="ruc-labelver">
                                <label class="control-label text-bold">Ruc:</label>
                            </div>
                            <div class="form-group col-md-4" id="ruc-fieldver">
                                <span class="form-control border-0">{{ $get_id->ruc }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="solucion" role="tabpanel" aria-labelledby="solucion-tab">


                <!-- Nueva sección para listar comentarios -->
                <div class="row" id="comment-section" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <h5 class="text-bold">Solucion Aplicada:</h5>
                        @foreach ($comentarios as $comentario)
                        <div class="comment-box" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                            <div class="row align-items-center">
                                <div class="form-group col-md-2 text-center">
                                    <img src="{{ $comentario->foto ? $comentario->foto : asset('img/user-default.jpg') }}"
                                        alt="User Image" class="img-fluid rounded-circle">
                                </div>
                                <div class="form-group col-md-10">
                                    <p><strong>Fecha:</strong> {{ $comentario->fec_comentario }}</p>
                                    <p><strong>Responsable:</strong> {{ $comentario->nombre_responsable_solucion ?: 'No designado' }}</p>
                                    <p style="max-width: 380px; word-wrap: break-word;" strong>Comentario:</strong> {{ $comentario->comentario ?: 'No hay comentario' }}</p>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <input type="hidden" id="capturae" name="capturae">
        <button class="btn btn-primary" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
    </div>
</form>


<script type="text/javascript">
    var ejecutoresMultiples = @json($ejecutoresMultiples);


    function toggleCierre() {
        var estado = document.getElementById('estado_registro').innerText.trim(); // Usamos innerText o textContent
        var cierreLabel = document.getElementById('cierre-labelver');
        var cierreField = document.getElementById('cierre-fieldver');

        if (estado === "Completado" || estado === "Stand By") {
            cierreLabel.style.display = 'block';
            cierreField.style.display = 'block';

        } else {
            cierreLabel.style.display = 'none';
            cierreField.style.display = 'none';

        }
    }


    function toggleCierreMultiplesResponsables() {
        const estadoElements = document.querySelectorAll('[id^="estado_registroe_"]');
        estadoElements.forEach((element) => {
            // Extrae el índice del ID
            const index = element.id.split('_')[2];
            $('#responsable_indice').val(`${index}`);
            // Obtener el estado del elemento
            const estado = element.value;
            // Obtener los elementos correspondientes usando el índice extraído
            const cierreLabel = document.getElementById(`cierre-labelver-${parseInt(index) + 1}`);
            const cierreField = document.getElementById(`cierre-fieldver-${parseInt(index) + 1}`);
            const estadoContainer = document.getElementById(`estado-containerver-${parseInt(index) + 1}`);

            // Verificar si los elementos existen antes de manipularlos
            if (cierreLabel && cierreField && estadoContainer) {
                if (estado == 3 || estado == 4) {
                    cierreLabel.style.display = 'block';
                    cierreField.style.display = 'block';
                    estadoContainer.classList.remove('col-md-10');
                    estadoContainer.classList.add('col-md-4');
                } else {
                    cierreLabel.style.display = 'none';
                    cierreField.style.display = 'none';
                    estadoContainer.classList.remove('col-md-4');
                    estadoContainer.classList.add('col-md-10');
                }
            } else {
                console.warn(`Elementos no encontrados para el índice ${parseInt(index) + 1}`);
            }
        });
    }

    function toggleEjecutor() {
        var ejecutor_responsable = document.getElementById('ejecutor_responsablever').value; // Usa .value aquí
        var nomproyectoLabel = document.getElementById('nom_proyecto-labelver');
        var nomproyectoField = document.getElementById('nom_proyecto-fieldver');
        var fecIniProLabel = document.getElementById('fec_ini_proyecto-labelver');
        var fecIniProField = document.getElementById('fec_ini_proyecto-fieldver');
        var proveedorLabel = document.getElementById('proveedor-labelver');
        var proveedorField = document.getElementById('proveedor-fieldver');
        var nomContratistaLabel = document.getElementById('nom_contratista-labelver');
        var nomContratistaField = document.getElementById('nom_contratista-fieldver');
        var dniPrestadorLabel = document.getElementById('dni_prestador-labelver');
        var dniPrestadorField = document.getElementById('dni_prestador-fieldver');
        var rucLabel = document.getElementById('ruc-labelver');
        var rucField = document.getElementById('ruc-fieldver');


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

    // Llamada a la función cuando el DOM está listo
    $(document).ready(function() {
        toggleCierre();
        toggleEjecutor();
        toggleCierreMultiplesResponsables();
        var idResponsableLabel = document.getElementById('id_responsableever-label');
        var idResponsableField = document.getElementById('id_responsableever-field');
        var estadoContainer = document.getElementById('estado-containerver-field');
        var estadoLabel = document.getElementById('estado-containerver-label');

        var areaInvolucrada = document.getElementById('area-involucradaver');
        if (!ejecutoresMultiples) {
            idResponsableLabel.style.display = 'block';
            idResponsableField.style.display = 'block';
            estadoContainer.style.display = 'block';
            estadoLabel.style.display = 'block';
            areaInvolucrada.style.display = 'none';

        } else {
            idResponsableLabel.style.display = 'none';
            idResponsableField.style.display = 'none';
            estadoContainer.style.display = 'none';
            estadoLabel.style.display = 'none';
            areaInvolucrada.style.display = 'block';


        }
    });
</script>