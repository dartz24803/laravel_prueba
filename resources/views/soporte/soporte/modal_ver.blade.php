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
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold" ">Responsable:</label>
                            </div>
                            <div class=" form-group col-md-10 mb-0"> <!-- Ajustar la columna a col-md-10 -->
                                    <span class="form-control border-0">{{ $get_id->nombre_responsable_asignado }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0">
                                <label class="control-label text-bold">Estado:</label>
                            </div>
                            <div class=" form-group col-md-4 mb-0">
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
                                    <span class="form-control border-0 text-truncate" style="width: 230px;"
                                        title="{{ $get_id->nombre_ubicacion }} - {{ $get_id->nombre_area_especifica }}">
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
                <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-8 mb-0">
                                <label class="control-label text-bold" ">Solucion Aplicada:</label>
                            </div>
                            <div class=" form-group col-md-4 mb-0"> <!-- Ajustar la columna a col-md-10 -->
                                    <span class="form-control border-0">{{ $get_id->fecha_comentario }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-2 mb-0 text-center">
                                <img src="{{ $get_id->foto_responsable_solucion ? $get_id->foto_responsable_solucion : asset('img/user-default.jpg') }}"
                                    alt="User Image" class="img-fluid rounded-circle" style="max-width: 100px;">
                            </div>

                            <div class="form-group col-md-8 mb-0">
                                <p>{{ $get_id->nombre_responsable_solucion }}</p>
                                <p style="max-width: 100%; word-wrap: break-word; white-space: normal;">
                                    {{ $get_id->descripcion_solucion }}
                                </p>
                            </div>
                        </div>
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

<script>
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

        console.log(ejecutor_responsable); // Imprime el valor del input

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
    });
</script>