<style>
    .img-user {
        width: 90px;
        /* Establece un ancho fijo */
        height: 90px;
        /* Establece una altura fija para mantener la forma circular */
        object-fit: cover;
        /* Asegura que la imagen cubra el contenedor */
        border-radius: 50%;
        /* Hace la imagen redonda */
        margin-left: auto;
        /* Margen horizontal automático */
        margin-right: auto;
        /* Margen horizontal automático */
    }

    .document-link {
        color: blue;
        /* Color azul para los enlaces */
        text-decoration: none;
        /* Sin subrayado por defecto */
        font-weight: bold;
        /* Negrita para destacar */
    }

    .document-link:hover {
        text-decoration: underline;
        /* Subrayado al pasar el mouse */
        color: darkblue;
        /* Azul más oscuro en hover */
    }

    .icon-link svg {
        color: blue;
        /* Mismo color que los enlaces */
        cursor: pointer;
        /* Cambia el cursor a mano al pasar */
        transition: color 0.2s ease-in-out;
        /* Animación suave */
    }

    .icon-link svg:hover {
        color: darkblue;
        /* Azul más oscuro en hover */
    }

    #div_imagenesver {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    #imagenes_containerver {
        display: flex;
        overflow-x: auto;
        /* Habilita el desplazamiento horizontal */
        white-space: nowrap;
        /* Evita el salto de línea */
        padding: 10px;
        max-width: 100%;
        gap: 10px;
        /* Espacio entre imágenes */
        scrollbar-width: thin;
        /* Para navegadores que admiten este estilo */
    }

    #div_imagenes_ver {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    #div_documentos_ver {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    #div_imagenesver {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    #imagenes_container_ver {
        display: flex;
        flex-wrap: nowrap;
        max-width: 600px;
        /* Ancho máximo fijo para el contenedor */
        overflow-x: auto;
        /* Scroll horizontal */
        gap: 10px;
        padding: 10px;
    }

    .contenedor-imagen {
        width: 150px;
        height: 150px;
        flex-shrink: 0;
        /* Evita que el contenedor se encoja */
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .imagen-captura {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Mantiene proporciones sin distorsión */
        border-radius: 5px;
    }
</style>
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
                                    <span class="form-control border-0"> {{ $get_id->fec_vencimiento ? \Carbon\Carbon::parse($get_id->fec_vencimiento)->locale('es')->translatedFormat('D d M y') : 'No especificado' }}
                                    </span>
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

                <div class="row" id="cancel-row">
                    <div class="d-flex justify-content-center" style="max-width: 100%;" id="div_imagenesver">
                        <input type="hidden" id="imagenes_input_ver" name="imagenes_ver" value="">

                        <div id="imagenes_containerver" class="carousel-container">
                            <!-- Las imágenes se añadirán aquí dinámicamente -->
                            @if ($get_id->img1 || $get_id->img2 || $get_id->img3|| $get_id->img4 || $get_id->img5)
                            @for ($i = 1; $i <= 5; $i++)
                                @php
                                $imgUrl=$get_id->{'img' . $i}; // Accede a img1, img2, img3
                                @endphp
                                @if ($imgUrl)
                                <div class="text-center my-2" id="contenedor-imagen-{{ $i }}"> <!-- Contenedor específico para cada imagen -->
                                    <img src="{{ $imgUrl }}" alt="Captura de soporte" class="img-thumbnail" style="max-width: 95%; display: block;">

                                    <!-- Botón para abrir en nueva pestaña -->
                                    <button class="btn btn-primary mt-2" onclick="abrirEnNuevaPestana(event, '{{ $imgUrl }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                        Ver
                                    </button>
                                </div>
                                @endif
                                @endfor
                                @endif
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
                                                @case(5)
                                                Cancelado
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

                <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-12 mb-0">
                                <label class="control-label text-bold">Solución Aplicada:</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        @foreach ($comentarios as $comentario)
                        <div class="comment-box" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                            <p style="display: flex; justify-content: flex-end;margin-bottom: 0;">
                                {{ $comentario->fec_comentario }}
                            </p>
                            <div class="row align-items-center">
                                <div class="form-group text-center mx-3">
                                    <img src="{{ $comentario->foto ? $comentario->foto : asset('img/user-default.jpg') }}"
                                        alt="User Image" class="img-fluid rounded-circle img-user" style="max-width: 90px; height: 90px;">
                                </div>
                                <div class="form-group mx-3">

                                    <p>{{ $comentario->nombre_responsable_solucion ?: 'No designado' }}</p>
                                    <p id="comentario-{{ $comentario->idsoporte_comentarios }}"
                                        style="max-width: 480px; word-wrap: break-word;">

                                        <span id="comentario-texto-{{ $comentario->idsoporte_comentarios }}">
                                            {{ $comentario->comentario ?: 'No hay comentario' }}
                                        </span>
                                    </p>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <label class="d-block mb-3">Documentos Cargados:</label>

                <div class="row justify-content-center" id="documentos-cargados">
                    <div class="col-md-12 text-center" id="div_documentos_ver">
                        @if ($get_id->documento1 || $get_id->documento2 || $get_id->documento3)
                        <ul id="documentos-lista" class="list-unstyled">
                            @if ($get_id->documento1)
                            <li id="doc-item-1" class="mb-2">
                                Documento 1:
                                <a href="https://lanumerounocloud.com/intranet/SOPORTE/{{ $get_id->documento1 }}"
                                    target="_blank"
                                    class="document-link">
                                    {{ $get_id->documento1 }}
                                </a>
                                <a href="https://lanumerounocloud.com/intranet/SOPORTE/{{ $get_id->documento1 }}"
                                    target="_blank"
                                    class="icon-link ms-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud">
                                        <polyline points="8 17 12 21 16 17"></polyline>
                                        <line x1="12" y1="12" x2="12" y2="21"></line>
                                        <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                                    </svg>
                                </a>
                            </li>
                            @endif

                            @if ($get_id->documento2)
                            <li id="doc-item-2" class="mb-2">
                                Documento 2:
                                <a href="https://lanumerounocloud.com/intranet/SOPORTE/{{ $get_id->documento2 }}"
                                    target="_blank"
                                    class="document-link">
                                    {{ $get_id->documento2 }}
                                </a>
                                <a href="https://lanumerounocloud.com/intranet/SOPORTE/{{ $get_id->documento2 }}"
                                    target="_blank"
                                    class="icon-link ms-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud">
                                        <polyline points="8 17 12 21 16 17"></polyline>
                                        <line x1="12" y1="12" x2="12" y2="21"></line>
                                        <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                                    </svg>
                                </a>
                            </li>
                            @endif

                            @if ($get_id->documento3)
                            <li id="doc-item-3" class="mb-2">
                                Documento 3:
                                <a href="https://lanumerounocloud.com/intranet/SOPORTE/{{ $get_id->documento3 }}"
                                    target="_blank"
                                    class="document-link">
                                    {{ $get_id->documento3 }}
                                </a>
                                <a href="https://lanumerounocloud.com/intranet/SOPORTE/{{ $get_id->documento3 }}"
                                    target="_blank"
                                    class="icon-link ms-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud">
                                        <polyline points="8 17 12 21 16 17"></polyline>
                                        <line x1="12" y1="12" x2="12" y2="21"></line>
                                        <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                                    </svg>
                                </a>
                            </li>
                            @endif
                        </ul>
                        @else
                        <p>No se han cargado documentos.</p>
                        @endif
                    </div>
                </div>


                <label class="d-block mb-3">Imagenes Cargadas:</label>
                <div class="row" style="padding-top: 1rem;">
                    <div class="d-flex justify-content-center" style="max-width: 100%;" id="div_imagenes_ver">
                        <input type="hidden" id="imagenes_input" name="imagenes" value="">
                        <div id="imagenes_container_ver" class="carousel-container">
                            <!-- Las imágenes se añadirán aquí dinámicamente -->
                            @if ($get_id->archivo1 || $get_id->archivo2 || $get_id->archivo3 || $get_id->archivo4 || $get_id->archivo5)
                            @for ($i = 1; $i <= 5; $i++)
                                @php
                                $imgUrl=$get_id->{'archivo' . $i};
                                @endphp
                                @if ($imgUrl)
                                <div class="text-center my-2 mx-2 contenedor-imagen" id="contenedor-imagen-{{ $i }}">
                                    <img src="{{ $imgUrl }}" alt="Captura de soporte" class="img-thumbnail imagen-captura">

                                    <!-- Botón para abrir en nueva pestaña -->
                                    <button class="btn btn-primary mt-2" onclick="abrirEnNuevaPestana(event, '{{ $imgUrl }}')">Ver</button>
                                </div>
                                @endif
                                @endfor
                                @endif
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


<script type="text/javascript">
    var ejecutoresMultiples = @json($ejecutoresMultiples);

    function toggleCierre() {
        var estadoElement = document.getElementById('estado_registro');
        var cierreLabelver = document.getElementById('cierre-labelver');
        var cierreFieldver = document.getElementById('cierre-fieldver');
        if (!estadoElement) {
            console.error('El elemento estado_registro no se encontró en el DOM.');
            return;
        }
        var estado = estadoElement.innerText.trim();
        var mostrarCamposCierre = !(estado === "Completado" || estado === "Stand By") && !ejecutoresMultiples;
        cierreLabelver.style.display = mostrarCamposCierre ? 'block' : 'none';
        cierreFieldver.style.display = mostrarCamposCierre ? 'block' : 'none';
    }


    function toggleCierreMultiplesResponsables() {
        const estadoElements = document.querySelectorAll('[id^="estado_registroe_"]');


        estadoElements.forEach((element) => {
            // Extrae el índice del ID
            const index = element.id.split('_')[2];

            // enviar el indice del responsable
            $('#responsable_indice').val(`${index}`);
            // Obtener el estado del elemento
            const estado = element.value;
            // Obtener los elementos correspondientes usando el índice extraído
            const cierreLabel = document.getElementById(`cierre-labelver-${parseInt(index) + 1}`);
            const cierreField = document.getElementById(`cierre-fieldver-${parseInt(index) + 1}`);
            const estadoContainer = document.getElementById(`estado-containerver-${parseInt(index) + 1}`);

            // Verificar si los elementos existen antes de manipularlos
            if (cierreLabel && cierreField && estadoContainer) {
                console.log("######0000")

                if (estado == 3 || estado == 4) {
                    cierreLabel.style.display = 'block';
                    cierreField.style.display = 'block';
                    estadoContainer.classList.remove('col-md-10');
                    estadoContainer.classList.add('col-md-4');
                } else {
                    console.log("#####22222")
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

    function abrirEnNuevaPestana(event, url) {
        event.preventDefault(); // Evita que se recargue la página
        window.open(url, '_blank'); // Abre la URL en una nueva pestaña
    }
</script>