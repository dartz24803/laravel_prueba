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

    .center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #div_imagenes {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }


    .text-center {
        display: inline-block;
        /* Permite que los elementos se alineen horizontalmente */
        margin-right: 10px;
        /* Espacio entre las imágenes */
    }

    #imagenes_container {
        width: 600px;
        /* Cambia este valor según tus necesidades */
        white-space: nowrap;
        /* Asegura que los elementos en línea no se rompan */
        overflow-x: auto;
        /* Habilita el scroll horizontal */
        border: 1px solid #ccc;
        /* Opcional: Añade un borde para visualizar mejor el contenedor */
        padding: 10px;
        /* Opcional: Añade algo de padding para un mejor aspecto */
    }

    #imagenes_container img {
        width: 150px;
        /* Ancho fijo para todas las imágenes */
        height: 150px;
        /* Altura fija para todas las imágenes */
        border-radius: 5px;
        /* Bordes redondeados */
        cursor: pointer;
        /* Cambia el cursor al pasar por encima */
        flex-shrink: 0;
        /* Evita que las imágenes se encojan */
    }

    /* Ajuste específico para la cuarta y quinta imagen */
    #imagenes_container img:nth-child(n+4) {
        margin-left: 50px;
        /* Aumenta el margen izquierdo para la cuarta imagen y superiores */
    }
</style>
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
    <!-- k -->
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
                            <div class="form-group col-md-2" id="id_responsablee-label">
                                <label class="control-label text-bold" ">Responsable:</label>
                            </div>
                            <div class=" form-group col-md-10" id="id_responsablee-field">
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
                            <div class="form-group col-md-2" id="estado-registro-label">
                                <label class="control-label text-bold">Estado:</label>
                            </div>
                            <div class="form-group col-md-4" id="estado-container">
                                @if ( $get_id->estado_registro != 3)
                                <select class="form-control" id="estado_registroe" name="estado_registroe">
                                    <option value="2" {{ $get_id->estado_registro == 2 ? 'selected' : '' }}>En Proceso</option>
                                    <option value="3" {{ $get_id->estado_registro == 3 ? 'selected' : '' }}>Completado</option>
                                    <option value="4" {{ $get_id->estado_registro == 4 ? 'selected' : '' }}>Stand By</option>
                                </select>
                                @else
                                <p style="font-size: 18px;">Completado</p>
                                @endif
                            </div>
                            <div class="form-group col-md-2" id="cierre-label">
                                <label class="control-label text-bold">Cierre:</label>
                            </div>
                            <div class="form-group col-md-4" id="cierre-field">
                                @if ( $get_id->estado_registro != 3)
                                <input type="date" class="form-control" id="fec_cierree" name="fec_cierree"
                                    value="{{ $get_id->fec_cierre ? \Carbon\Carbon::parse($get_id->fec_cierre)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                @else
                                <span
                                    class="form-control border-0">{{ \Carbon\Carbon::parse($get_id->fec_cierre)->locale('es')->translatedFormat('D d M y') }}</span>
                                @endif
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
                                <label class="control-label text-bold">Tipo:</label>
                            </div>
                            <div class="form-group col-md-4 mb-0">
                                @if($get_id->tipo_otros == 0 && $get_id->activo_tipo == 1)
                                <select class="form-control border-0" name="nombre_tipo" required>
                                    <option value="" disabled selected>Seleccione un tipo</option>
                                    <option value="1">Requerimiento</option>
                                    <option value="2">Incidente</option>
                                </select>

                                @else
                                <input type="hidden" name="nombre_tipo" value="{{ $get_id->nombre_tipo }}">
                                <span class="form-control border-0">{{ $get_id->nombre_tipo }}</span>
                                @endif
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

                        <div id="area-involucrada">
                            @foreach ($list_areas_involucradas as $index => $area_involucrada)
                            <!-- Usamos $index para obtener el número de iteración -->
                            <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="row align-items-center">
                                        <div class="form-group col-md-2">
                                            <!-- Aquí definimos el label con el estilo deseado -->
                                            <label class="control-label text-bold">
                                                Responsable:
                                                <span style="display: block; width: 130px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $area_involucrada['area_responsable'] }}">
                                                    {{ $area_involucrada['cod_area_responsable'] }}
                                                </span>
                                            </label>
                                        </div>


                                        <div class="form-group col-md-10">
                                            @if ($id_subgerencia == $area_involucrada['id_departamento'])
                                            <!-- Mostrar el select si coinciden -->
                                            <select class="form-control" id="id_responsablee_{{ $index }}" name="id_responsablee_{{ $index }}">
                                                <!-- Si id_responsable es null, seleccionamos SIN DESIGNAR -->
                                                <option value="0" {{ is_null($area_involucrada['id_responsable']) ? 'selected' : '' }}>
                                                    SIN DESIGNAR
                                                </option>
                                                @foreach ($list_responsable as $list)
                                                <!-- Si id_responsable coincide con el id_usuario del listado, lo seleccionamos -->
                                                <option value="{{ $list->id_usuario }}"
                                                    {{ $area_involucrada['id_responsable'] == $list->id_usuario ? 'selected' : '' }}>
                                                    {{ $list->nombre_completo }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @else
                                            <!-- Mostrar texto sin select si no coinciden -->
                                            <p>{{ $area_involucrada['nom_responsable'] ? $area_involucrada['nom_responsable'] : 'SIN DESIGNAR' }}</p>
                                            @endif
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

                                        <div class="form-group col-md-4" id="estado-container-{{ $index + 1 }}">
                                            @if ($id_subgerencia == $area_involucrada['id_departamento'])
                                            @if ($area_involucrada['estado_registro'] != 3)
                                            <select class="form-control" id="estado_registroe_{{ $index }}" name="estado_registroe_{{ $index }}">
                                                <option value="1" {{ $area_involucrada['estado_registro'] == 1 ? 'selected' : '' }}>Por Iniciar</option>
                                                <option value="2" {{ $area_involucrada['estado_registro'] == 2 ? 'selected' : '' }}>En Proceso</option>
                                                <option value="3" {{ $area_involucrada['estado_registro'] == 3 ? 'selected' : '' }}>Completado</option>
                                                <option value="4" {{ $area_involucrada['estado_registro'] == 4 ? 'selected' : '' }}>Stand By</option>
                                            </select>
                                            @else
                                            <p>Completado</p>
                                            @endif
                                            @else
                                            <p>
                                                @if ($area_involucrada['estado_registro'] == 3)
                                                Completado
                                                @elseif ($area_involucrada['estado_registro'] == 1)
                                                Por Iniciar
                                                @elseif ($area_involucrada['estado_registro'] == 2)
                                                En Proceso
                                                @elseif ($area_involucrada['estado_registro'] == 4)
                                                Stand By
                                                @else
                                                Desconocido
                                                @endif
                                            </p>
                                            @endif
                                        </div>

                                        <!-- Campos Cierre, mostrando texto o campo de entrada -->
                                        @if ($id_subgerencia == $area_involucrada['id_departamento'])
                                        <div class="form-group col-md-2" id="cierre-label-{{ $index + 1 }}">
                                            <label class="control-label text-bold">Cierre:</label>
                                        </div>
                                        <div class="form-group col-md-4" id="cierre-field-{{ $index + 1 }}">
                                            @if ($area_involucrada['estado_registro'] != 3)
                                            <input type="date" class="form-control" id="fec_cierree_{{ $index }}" name="fec_cierree_{{ $index }}"
                                                value="{{ $area_involucrada['fec_cierre'] ? \Carbon\Carbon::parse($area_involucrada['fec_cierre'])->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                                            @else
                                            <span class="form-control border-0">{{ \Carbon\Carbon::parse($area_involucrada['fec_cierre'])->locale('es')->translatedFormat('D d M y') }}</span>
                                            @endif
                                        </div>
                                        @else
                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">Cierre:</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <p>{{ $area_involucrada['fec_cierre'] ? \Carbon\Carbon::parse($area_involucrada['fec_cierre'])->locale('es')->translatedFormat('D d M y') : 'No especificado' }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            @endforeach
                        </div>




                        <div class="row align-items-center">
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Ejecutor:</label>
                            </div>
                            <div class="form-group col-md-10">
                                <select class="form-control" id="ejecutor_responsable" name="ejecutor_responsable">
                                    <!-- Verificar si idejecutor_responsable es "-1" o contiene una coma, indicando múltiples IDs -->
                                    <option value="-1"
                                        {{ ($get_id->idejecutor_responsable === "-1" || strpos($get_id->idejecutor_responsable, ',') !== false) ? 'selected' : '' }}>
                                        SELECCIONAR
                                    </option>
                                    @foreach ($list_ejecutores_responsables as $list)
                                    <!-- Seleccionar opción según idejecutor_responsable -->
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
                                <input type="tel" class="form-control" id="dni_prestador" name="dni_prestador"
                                    value="{{ $get_id->dni_prestador_servicio }}"
                                    inputmode="numeric" pattern="[0-9]*" maxlength="8">
                            </div>

                            <div class="form-group col-md-2" id="ruc-label">
                                <label class="control-label text-bold">Ruc:</label>
                            </div>
                            <div class="form-group col-md-4" id="ruc-field">
                                <input type="tel" class="form-control" id="ruc" name="ruc"
                                    value="{{ $get_id->ruc }}"
                                    inputmode="numeric" pattern="[0-9]*" maxlength="12">
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

                <div class="row" id="cancel-row" style="flex: 1; padding-top: 1rem;">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        @foreach ($comentarios_user as $comentario)
                        <div class="comment-box" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                            <div class="d-flex align-items-center">
                                <div class="form-group text-center mx-3">
                                    <img src="{{ $comentario->foto ? $comentario->foto : asset('img/user-default.jpg') }}"
                                        alt="User Image" class="img-fluid rounded-circle img-user" style="max-width: 90px; height: 90px;">
                                </div>
                                <div class="form-group mx-3">
                                    <p><strong>Fecha:</strong> {{ $comentario->fec_comentario }}</p>
                                    <p><strong>Responsable:</strong> {{ $comentario->nombre_responsable_solucion ?: 'No designado' }}</p>
                                    <!-- Comentario actual, que se convertirá en input cuando se edite -->
                                    <p id="comentario-{{ $comentario->idsoporte_comentarios }}"
                                        style="max-width: 480px; word-wrap: break-word;">
                                        <strong>Comentario:</strong>
                                        <span id="comentario-texto-{{ $comentario->idsoporte_comentarios }}">
                                            {{ $comentario->comentario ?: 'No hay comentario' }}
                                        </span>
                                    </p>
                                    <!-- Textarea oculto, para editar comentario -->
                                    <textarea class="form-control" id="comentario-input-{{ $comentario->idsoporte_comentarios }}"
                                        style="display: none;"
                                        rows="3" maxlength="250"></textarea>


                                </div>
                                <div class="form-group ml-3">
                                    <!-- Botón de editar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit" style="cursor: pointer;" onclick="editarComentario('{{ $comentario->idsoporte_comentarios }}')" id="editar-icon-{{ $comentario->idsoporte_comentarios }}">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>

                                    <!-- Botón de eliminar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2" style="cursor: pointer;" onclick="eliminarComentario('{{ $comentario->idsoporte_comentarios }}')">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="row align-items-center">
                            <div class="form-group col-md-12 mb-0">
                                <textarea class="form-control" id="descripcione_solucion" name="descripcione_solucion" rows="3" placeholder="Ingresar solución">{{ $get_id->descripcion_solucion }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row" style="padding-top: 1rem;">
                    <div class="form-group col-md-4">
                        <label>Imágenes:</label><br>
                        <button type="button" class="btn btn-secondary" id="boton_camara" onclick="Activar_Camara();">Activar cámara</button>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Documentos:</label>
                        <div id="documento-list">
                            <!-- Los enlaces de descarga se agregarán aquí dinámicamente -->
                            @if (!$get_id->documento1)
                            <p>No hay documentos seleccionados.</p>
                            @endif
                        </div>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control-file" name="documentoa1[]" id="documentoa1" multiple onchange="handleFileSelection(event)">
                        </div>
                    </div>



                    <div class="form-group col-lg-12 d-flex justify-content-center" id="div_camara" style="display: none;">
                        <video id="video" autoplay style="max-width: 95%; display: none;"></video>
                    </div>

                    <div class="form-group col-lg-12 text-center" id="div_tomar_foto" style="display:none !important;">
                        <button type="button" class="btn btn-info" onclick="Tomar_Foto();">Tomar foto</button>
                    </div>

                    <div class="d-flex justify-content-center" style="display:none !important;" id="div_canvas">
                        <canvas id="canvas" width="640" height="480" style="max-width:95%;"></canvas>
                    </div>
                    <div class="d-flex justify-content-center" style="max-width: 100%; overflow-x: auto;" id="div_imagenes">
                        <input type="hidden" id="imagenes_input" name="imagenes" value="">
                        <div id="imagenes_container" class="carousel-container">
                            <!-- Las imágenes se añadirán aquí dinámicamente -->
                            @if ($get_id->archivo1 || $get_id->archivo2 || $get_id->archivo3 || $get_id->archivo4 || $get_id->archivo5)
                            @for ($i = 1; $i <= 5; $i++)
                                @php
                                $imgUrl=$get_id->{'archivo' . $i};
                                @endphp
                                @if ($imgUrl)
                                <div class="text-center my-2" id="contenedor-imagen-{{ $i }}">
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

                                    <!-- Botón para eliminar la imagen -->
                                    <button class="btn btn-danger mt-2" onclick="eliminarImagen(event, {{ $i }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>

                                    </button>
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
        <input type="hidden" id="responsable_indice" name="responsable_indice" value="0">
        <button class="btn btn-primary" type="button" onclick="Update_Soporte_Master();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>


<script type="text/javascript">
    var ejecutoresMultiples = @json($ejecutoresMultiples);
    $(document).ready(function() {

        toggleCierreMultiplesResponsables();
        toggleEjecutor();
        toggleCierreUnResponsable();
        simulateFileSelection();


    });
    document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.getElementById('documentoa1');
        if (fileInput) {
            fileInput.addEventListener('change', handleFileSelection);
        }
        // Llama a simulateFileSelection después de asegurar que el DOM está listo
        simulateFileSelection();
    });
    $('#estado_registroe').on('change', function() {
        toggleCierreUnResponsable();
    });
    $('#estado_registroe_0').on('change', function() {
        toggleCierreMultiplesResponsables();
    });
    $('#estado_registroe_1').on('change', function() {
        toggleCierreMultiplesResponsables();
    });

    $('#ejecutor_responsable').on('change', function() {
        toggleEjecutor();
    });
    var idResponsableLabel = document.getElementById('id_responsablee-label');
    var idResponsableField = document.getElementById('id_responsablee-field');
    var estadoContainer = document.getElementById('estado-container');
    var estadoLabel = document.getElementById('estado-registro-label');
    var areaInvolucrada = document.getElementById('area-involucrada');
    var cierreLabelT = document.getElementById('cierre-label');
    var cierreFieldT = document.getElementById('cierre-field');

    if (!ejecutoresMultiples) {
        idResponsableLabel.style.display = 'block';
        idResponsableField.style.display = 'block';
        estadoContainer.style.display = 'block';
        estadoLabel.style.display = 'block';
        cierreLabelT.style.display = 'block';
        cierreFieldT.style.display = 'block';
        areaInvolucrada.style.display = 'none';

    } else {
        idResponsableLabel.style.display = 'none';
        idResponsableField.style.display = 'none';
        estadoContainer.style.display = 'none';
        estadoLabel.style.display = 'none';
        cierreLabelT.style.display = 'none';
        cierreFieldT.style.display = 'none';
        areaInvolucrada.style.display = 'block';


    }

    function toggleCierreUnResponsable() {
        var estadoElement = document.getElementById('estado_registroe');
        var estadoContainer = document.getElementById('estado-container');
        var cierreLabel = document.getElementById('cierre-label');
        var cierreField = document.getElementById('cierre-field');

        // Verificar que el elemento de estado exista
        if (!estadoElement) {
            console.error('El elemento estado_registroe no se encontró en el DOM.');
            return; // Salir de la función si el elemento no existe
        }

        var estado = estadoElement.value;

        // Mostrar u ocultar los campos de cierre basado en el estado
        var mostrarCamposCierre = (estado == 3 || estado == 4) && !ejecutoresMultiples;

        cierreLabel.style.display = mostrarCamposCierre ? 'block' : 'none';
        cierreField.style.display = mostrarCamposCierre ? 'block' : 'none';
        estadoContainer.classList.toggle('col-md-4', mostrarCamposCierre);
        estadoContainer.classList.toggle('col-md-10', !mostrarCamposCierre);
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
            const cierreLabel = document.getElementById(`cierre-label-${parseInt(index) + 1}`);
            const cierreField = document.getElementById(`cierre-field-${parseInt(index) + 1}`);
            const estadoContainer = document.getElementById(`estado-container-${parseInt(index) + 1}`);

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
                if (xhr.status === 400) {
                    // Si es un error 400, mostramos el mensaje del servidor
                    Swal.fire(
                        '¡Error!',
                        xhr.responseJSON.error || 'Error en la solicitud.',
                        'warning'
                    );
                } else {
                    // Si es otro tipo de error, manejamos los errores en el formulario
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    Swal.fire(
                        '¡Ups!',
                        firstError,
                        'warning'
                    );
                }
            }
        });
    }

    document.getElementById('dni_prestador').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, ''); // Solo permite números
    });

    document.getElementById('ruc').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, ''); // Solo permite números
    });







    // ACTIVACIÓN DE CÁMARA

    var isCameraOn = false;
    var stream = null;

    function Activar_Camara() {
        var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        var video = document.getElementById('video');
        var boton = document.getElementById('boton_camara');
        var div_tomar_foto = document.getElementById('div_tomar_foto');
        var div = document.getElementById('div_camara');

        if (screenWidth < 1000) {
            if (!isCameraOn) {
                //Pedir permiso para acceder a la cámara
                navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: {
                                exact: "environment"
                            }
                        }
                    })
                    .then(function(newStream) {
                        stream = newStream;
                        // Mostrar el stream de la cámara en el elemento de video
                        video.srcObject = stream;
                        video.style.display = "block"; // Mostrar el video
                        video.play();
                        isCameraOn = true;
                        boton.textContent = "Desactivar cámara";
                        div_tomar_foto.style.cssText = "display: block;";
                        div.style.cssText = "display: block;";
                    })
                    .catch(function(error) {
                        console.error('Error al acceder a la cámara:', error);
                    });
            } else {
                //Detener la reproducción  del stream y liberar la cámara
                if (stream) {
                    stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                    video.srcObject = null;
                    video.style.display = "none";
                    isCameraOn = false;
                    boton.textContent = "Activar cámara";
                    div_tomar_foto.style.cssText = "display: none !important;";
                    div.style.cssText = "display: none !important;";
                }
            }
        } else {
            if (!isCameraOn) {
                //Pedir permiso para acceder a la cámara
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(newStream) {
                        stream = newStream;
                        video.srcObject = stream;
                        video.style.display = "block"; // Mostrar el video
                        video.play();
                        isCameraOn = true;
                        boton.textContent = "Desactivar cámara";
                        div_tomar_foto.style.display = "block";
                        div.style.display = "block";
                    })
                    .catch(function(error) {
                        console.error('Error al acceder a la cámara:', error);
                    });
            } else {
                //Detener la reproducción  del stream y liberar la cámara
                if (stream) {
                    stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                    video.srcObject = null;
                    video.style.display = "none"; // Ocultar el video
                    isCameraOn = false;
                    boton.textContent = "Activar cámara";
                    div_tomar_foto.style.display = "none";
                    div.style.display = "none";
                }
            }
        }
    }

    function Tomar_Foto() {
        // Verifica cuántas imágenes ya se han subido
        var divImagenes = document.getElementById('imagenes_container');
        var imagenes = divImagenes.getElementsByTagName('img');

        if (imagenes.length >= 5) {
            Swal({
                title: '¡Carga Denegada!',
                text: "¡No se puede tomar más de 5 capturas!",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            return; // Salir de la función si ya hay 3 imágenes
        }

        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ route('previsualizacion_captura_soporte') }}";
        var video = document.getElementById('video');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');

        // Ajusta el tamaño del canvas al tamaño del video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function(blob) {
            // Crea un formulario para enviar la imagen al servidor
            dataString.append('photo', blob, 'photo.jpg');
            dataString.append('tipo', 2);

            // Realiza la solicitud AJAX
            $.ajax({
                url: url,
                data: dataString,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response == "error") {
                        Swal({
                            title: '¡Carga Denegada!',
                            text: "¡No se puede tomar más de 3 capturas!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        var ftpUrl = response.url_ftp;
                        MostrarFoto(ftpUrl);
                    }
                }
            });
        }, 'image/jpeg');
    }


    function MostrarFoto(url) {
        var divImagenes = document.getElementById('imagenes_container'); // Contenedor de imágenes
        var contenedorImagen = document.createElement('div'); // Crea el contenedor para la imagen y los botones
        contenedorImagen.className = 'text-center my-2'; // Centrar y agregar margen vertical
        contenedorImagen.style.position = 'relative'; // Permite posicionar los botones dentro de este contenedor

        // Crear la imagen
        var nuevaImagen = document.createElement('img');
        nuevaImagen.src = url;
        nuevaImagen.alt = 'Captura de soporte';
        nuevaImagen.style.width = '150px';
        nuevaImagen.style.height = '150px';
        nuevaImagen.style.display = 'block';
        nuevaImagen.className = 'img-thumbnail';

        // Crear botón para eliminar
        var botonEliminar = document.createElement('button');
        botonEliminar.className = 'btn btn-danger mt-2'; // Estilo del botón
        botonEliminar.onclick = function() {
            divImagenes.removeChild(contenedorImagen); // Elimina el contenedor de imagen y botones
            actualizarInput(); // Actualiza el input
        };
        // SVG del botón de eliminar
        botonEliminar.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            <line x1="10" y1="11" x2="10" y2="17"></line>
            <line x1="14" y1="11" x2="14" y2="17"></line>
        </svg>
    `;

        // Crear botón para abrir en nueva pestaña
        var botonAbrir = document.createElement('button');
        botonAbrir.className = 'btn btn-primary mt-2 ms-2'; // Estilo del botón de abrir
        botonAbrir.onclick = function(event) {
            event.preventDefault(); // Evita que se recargue la página
            window.open(url, '_blank'); // Abre en una nueva pestaña
        };

        botonAbrir.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
            <polyline points="15 3 21 3 21 9"></polyline>
            <line x1="10" y1="14" x2="21" y2="3"></line>
        </svg> Ver
    `;

        // Agregar imagen y botones al contenedor
        contenedorImagen.appendChild(nuevaImagen);
        contenedorImagen.appendChild(botonEliminar);
        contenedorImagen.appendChild(botonAbrir);

        // Añadir el contenedor principal al div de imágenes
        divImagenes.appendChild(contenedorImagen);

        // Actualiza el input oculto con la lista de URLs
        actualizarInput();
        // Verificar si el contenedor debe tener scroll
    }



    function actualizarInput() {
        var divImagenes = document.getElementById('imagenes_container');
        var imagenesInput = document.getElementById('imagenes_input');

        // Obtener todas las imágenes en el contenedor
        var imagenes = divImagenes.getElementsByTagName('img');
        var urls = [];

        // Recorrer todas las imágenes y almacenar sus URLs
        for (var i = 0; i < imagenes.length; i++) {
            urls.push(imagenes[i].src);
        }


        // Almacenar las URLs como un array en formato JSON en el input
        imagenesInput.value = JSON.stringify(urls);
    }


    function abrirEnNuevaPestana(event, url) {
        event.preventDefault(); // Evita que se recargue la página
        window.open(url, '_blank'); // Abre la URL en una nueva pestaña
    }

    function eliminarImagen(event, index) {
        event.preventDefault(); // Previene el envío del formulario
        // Imprime el índice para verificar que se está pasando correctamente
        const contenedorImagen = document.getElementById('contenedor-imagen-' + index);

        if (contenedorImagen) {
            contenedorImagen.remove(); // Elimina el contenedor de imagen
            actualizarInput(); // Llama a una función para actualizar el input si es necesario
        } else {
            console.error("No se pudo encontrar el contenedor de imagen con ID:", 'contenedor-imagen-' + index);
        }
    }

    function editarComentario(comentarioId) {
        console.log(comentarioId);
        // Obtén el texto del comentario y el textarea
        var comentarioTexto = document.getElementById('comentario-texto-' + comentarioId);
        var comentarioInput = document.getElementById('comentario-input-' + comentarioId);
        var svgEditar = document.getElementById('editar-icon-' + comentarioId);

        // Si el comentario está siendo editado, muestra el textarea y oculta el texto
        if (comentarioInput.style.display === "none" || comentarioInput.style.display === "") {
            comentarioInput.style.display = "block"; // Muestra el textarea
            comentarioTexto.style.display = "none"; // Oculta el texto
            // Rellena el textarea con el comentario actual
            comentarioInput.value = comentarioTexto.innerHTML.trim();
            // Cambiar el ícono a "guardar"
            svgEditar.setAttribute("onclick", "guardarComentario('" + comentarioId + "')");
            svgEditar.innerHTML = `
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
        `;
        }
    }

    function guardarComentario(comentarioId) {
        var comentarioInput = document.getElementById('comentario-input-' + comentarioId);
        var comentarioTexto = document.getElementById('comentario-texto-' + comentarioId);
        var nuevoComentario = comentarioInput.value;
        Swal.fire({
            title: '¿Realmente desea editar el registro?',
            text: "El registro será editado",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: `/soporte_comentarios_master/edit/${comentarioId}`,
                    method: 'POST',
                    data: {
                        comentario: nuevoComentario,
                        _token: '{{ csrf_token() }}' // Incluir token CSRF
                    },
                    success: function(response) {
                        if (response.success) {
                            comentarioTexto.innerHTML = nuevoComentario;
                            comentarioInput.style.display = "none";
                            comentarioTexto.style.display = "block";
                            var svgEditar = document.getElementById('editar-icon-' + comentarioId);
                            svgEditar.setAttribute("onclick", "editarComentario('" + comentarioId + "')");
                            svgEditar.innerHTML = `
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        `;
                            Swal.fire(
                                'Guardado!',
                                'El comentario ha sido actualizado.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error',
                                'No se pudo guardar el comentario. Intenta de nuevo.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al guardar el comentario.',
                            'error'
                        );
                    }
                });
            }
        });
    }




    function eliminarComentario(id) {
        // Utiliza SweetAlert para la confirmación
        Swal.fire({
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
                    url: `/soporte_delete_comentarios/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // Incluye el token CSRF
                    },
                    success: function(response) {
                        if (response.success) {
                            document.getElementById('comentario-' + id).parentElement.parentElement.remove();
                            Swal.fire(
                                'Eliminado!',
                                'Tu comentario ha sido eliminado.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error',
                                'No se pudo eliminar el comentario. Intenta de nuevo.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar el comentario.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    $('#documentoa1').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        showPreview: false, // Desactiva la vista previa de archivos
        showRemove: false, // Desactiva el botón para remover archivos
        allowedFileExtensions: ['jpg', 'png', 'txt', 'pdf', 'xlsx', 'pptx', 'docx', 'jpeg', 'xls', 'ppt', 'doc'],
        browseOnZoneClick: true, // Hace que el botón de selección sea el único activo
        dragDrop: false // Desactiva la funcionalidad de arrastrar y soltar
    });



    function simulateFileSelection() {
        const initialFiles = "{{ $get_id->documento1 }}".split(',');

        if (initialFiles.length > 0 && initialFiles[0] !== "") {
            // Creamos un objeto FileList falso (para simular archivos seleccionados)
            const fileInput = document.getElementById('documentoa1');
            const fakeEvent = new Event('change', {
                bubbles: true,
                cancelable: true
            });

            // Simulamos un objeto `files` en el evento
            const fakeFiles = initialFiles.map(fileName => {
                const blob = new Blob([], {
                    type: 'application/octet-stream'
                });
                blob.name = fileName.trim();
                return blob;
            });

            // Creamos una propiedad `files` en el evento falso
            Object.defineProperty(fakeEvent, 'target', {
                value: {
                    files: fakeFiles
                },
                writable: false
            });

            // Llamamos a la función `handleFileSelection` pasando el evento simulado
            handleFileSelection(fakeEvent);
        }
    }




    // Función para manejar los archivos seleccionados en el input de archivo
    function handleFileSelection(event) {
        const documento1 = "{{ $get_id->documento1 }}";
        const idsoporte_solucion = "{{ $get_id->idsoporte_solucion }}";
        const fileInput = event.target;
        const fileListContainer = document.getElementById('documento-list');
        // Verifica que el contenedor exista
        if (!fileListContainer) {
            console.error('El contenedor de la lista de documentos no se encontró en el DOM.');
            return;
        }
        // Convertimos FileList a un array para manipularlo
        let files = Array.from(fileInput.files);
        fileListContainer.innerHTML = ''; // Limpiar enlaces existentes

        files.forEach((file, index) => {
            const fileName = file.name;
            const fileLink = document.createElement('a');
            fileLink.href = URL.createObjectURL(file);
            fileLink.download = fileName;
            fileLink.textContent = fileName;
            fileLink.classList.add('btn', 'btn-link');

            const fileLinkWrapper = document.createElement('div');
            fileLinkWrapper.classList.add('d-flex', 'align-items-center', 'my-2');
            fileLinkWrapper.appendChild(fileLink);

            fileListContainer.appendChild(fileLinkWrapper);
        });
    }




    function deleteFileOnServer(fileName, documento1, id_soportesolucion) {
        // Aquí asumimos que `documento1` es un array de nombres de archivos y necesitamos eliminar `fileName` de él
        const updatedDocumentos = documento1.filter(file => file !== fileName); // Elimina el archivo de la lista
        // Actualiza el array documento1 con el nuevo array sin el archivo eliminado
        // Esto lo puedes enviar en una solicitud posterior para actualizar el estado del servidor, si lo necesitas
        documento1 = updatedDocumentos;
        // Eliminar el archivo visualmente (suponiendo que el archivo tiene un ID o clase específica)
        $(`#file-${fileName}`).remove(); // Esto eliminará el archivo de la lista en el DOM (ajusta el selector si es necesario)
        // Actualiza el documento1 antes de enviarlo (si es necesario)
        console.log("Documento actualizado:", documento1);
        // Si deseas hacer algo adicional, como mostrar una notificación:
        Swal(
            '¡Eliminado!',
            'El archivo ha sido eliminado de la lista.',
            'success'
        );
    }
</script>