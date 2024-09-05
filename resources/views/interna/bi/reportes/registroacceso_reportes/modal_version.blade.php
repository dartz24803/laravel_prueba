<!-- CSS -->
<style>
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }

    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field:disabled {
        background-color: transparent !important;

    }


    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }


    #tabla_js2 td {
        max-width: 180px;
        /* Controla el ancho máximo */
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
        overflow: hidden;
        /* Oculta el contenido que se desborda */
        text-overflow: ellipsis;
        /* Añade puntos suspensivos (...) */
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4f46e5;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }
</style>
<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">

    <div class="modal-header">
        <h5 class="modal-title">Actualizar Portal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style=" max-height:450px;  overflow:auto;">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="documento-tab" data-toggle="tab" href="#documento" role="tab" aria-controls="documento" aria-selected="true">Documento</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="accesos-tab" data-toggle="tab" href="#accesos" role="tab" aria-controls="accesos" aria-selected="false">Accesos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="versiones-tab" data-toggle="tab" href="#versiones" role="tab" aria-controls="versiones" aria-selected="false">Versiones</a>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="documento" role="tabpanel" aria-labelledby="documento-tab">
                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 p-3 col-sm-12 layout-spacing">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Nombre: </label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $get_id->nombre }}">
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="control-label text-bold">Tipo: </label>

                                <select class="form-control basicm" name="id_tipo" id="id_tipo">
                                    <option value="0">Seleccione</option>
                                    @foreach ($list_tipo as $list)
                                    <option value="{{ $list->id_tipo_portal }}" {{ $list->id_tipo_portal == $get_id->id_tipo ? 'selected' : '' }}>
                                        {{ $list->nom_tipo }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label text-bold">Fecha: </label>
                                <input class="form-control" type="date" name="fecha" id="fecha" value="{{ isset($get_id->fecha) ? date('Y-m-d', strtotime($get_id->fecha)) : date('Y-m-d') }}">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-8">
                                <label>Responsable: </label>
                                <select class="form-control basicm" name="id_responsablee" id="id_responsablee">
                                    <option value="0">Seleccione</option>
                                    @foreach ($list_responsable as $responsable)
                                    <option value="{{ $responsable->id_puesto }}" {{ $responsable->id_puesto == $get_id->id_responsable ? 'selected' : '' }}>
                                        {{ $responsable->nom_puesto }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Código: </label>
                                <div>
                                    <input type="hidden" name="codigo" id="codigo" value="{{ $get_id->codigo }}">
                                    <span id="miLabel" class="form-control" style="color:black">{{ $get_id->codigo }}</span>
                                </div>
                            </div>
                            <!-- <div class="form-group col-md-4">
                                <label>Código: </label>
                                <div>
                                    <input type="hidden" name="codigo" id="codigo" class="form-control">
                                    <label id="miLabel" style="color:black; font-size: 1rem;">LNU-1</label>
                                </div>
                            </div> -->
                        </div>

                        <div class="row">



                            <div class=" form-group col-md-3">
                                <label>Estado: </label>
                                <select class="form-control" id="estadoe" name="estadoe">
                                    <option value="1" {{ $get_id->estado_registro == 1 ? 'selected' : '' }}>Por aprobar</option>
                                    <option value="2" {{ $get_id->estado_registro == 2 ? 'selected' : '' }}>Publicado</option>
                                    <option value="3" {{ $get_id->estado_registro == 3 ? 'selected' : '' }}>Por actualizar</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Versión:</label>

                                <input type="hidden" name="versione" id="versione" value="{{ $get_id->version }}">
                                <span id="miLabel" class="form-control" style="color:black">{{ $get_id->version }}</span>

                            </div>

                            <div class="form-group col-md-6">
                                <label>N° Documento: </label>
                                <input type="text" class="form-control" id="ndocumento" name="ndocumento" value="{{ $get_id->numero }}">
                            </div>



                        </div>

                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label>Descripción:</label>
                                <textarea name="descripcione" id="descripcione" cols="1" rows="2" class="form-control">{{ $get_id->descripcion }}</textarea>
                            </div>


                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Archivo 1:</label>
                                @if($get_id->archivo)
                                <a href="{{ 'https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/' . $get_id->archivo }}"
                                    title="Ver Archivo"
                                    target="_blank"
                                    class="redirect-link d-inline-flex align-items-center">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81"
                                        style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                        <rect x="260.758" y="276.339"
                                            transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266"
                                            height="54.399" />
                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                        <path style="fill:#415A6B;"
                                            d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                        <path style="fill:#F05540;"
                                            d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                        <path style="fill:#F3705A;"
                                            d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                    </svg>
                                </a>
                                @endif
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control-file" name="archivo1e" id="archivo1e" onchange="Valida_Archivo('archivo1e');">
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label>Documento:</label>
                                @if($get_id->archivo4)
                                <a href="{{'https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/' . $get_id->archivo4  }}"
                                    title="Ver Documento"
                                    target="_blank"
                                    class="redirect-link d-inline-flex align-items-center ">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                    </svg>
                                </a>
                                @endif
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control-file" name="documentoae" id="documentoae" onchange="Validar_Archivo_Backup('documentoae');">
                                </div>


                            </div>

                            <div class="form-group col-md-6">
                                <label>Diagrama:</label>
                                @if($get_id->archivo5)
                                <a href="{{  'https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/' . $get_id->archivo5  }}"
                                    title="Ver Diagrama"
                                    target="_blank"
                                    class="redirect-link d-inline-flex align-items-center ">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                    </svg>
                                </a>
                                @endif
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control-file" name="diagramaae" id="diagramaae" onchange="Validar_Archivo_Backup('diagramaae');">
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="accesos" role="tabpanel" aria-labelledby="accesos-tab">

                <div class="row d-flex col-md-12 my-2">

                    <div class="form-group col-md-12">

                        <div class="col-12 text-center">
                            <label class="control-label text-bold centered-label"> Accesos</label>
                            <!-- <div>
                                <label class="control-label text-bold">Todos</label>

                                <label class="switch">
                                    <input type="checkbox" id="acceso_todo" name="acceso_todo" onclick="Acceso_Todo()" checked>
                                    <span class="slider"></span>
                                </label>
                            </div> -->
                            <div class="divider"></div>

                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Acceso Área: </label>
                            <select class="form-control multivalue" name="id_area_p[]" id="id_area_p" multiple="multiple" disabled>
                                @foreach ($list_area as $area)
                                <option value="{{ $area->id_area }}"
                                    {{ in_array($area->id_area, $selected_area_ids) ? 'selected' : '' }}>
                                    {{ $area->nom_area }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Acceso Puesto: </label>
                            <select class="form-control multivalue" name="tipo_acceso_p[]" id="tipo_acceso_p" multiple="multiple" disabled>
                                @foreach ($list_responsable as $puesto)
                                <option value="{{ $puesto->id_puesto }}"
                                    @if(in_array($puesto->id_puesto, $selected_puesto_ids)) selected @endif>
                                    {{ $puesto->nom_puesto }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>


            </div>
            <div class="tab-pane fade" id="versiones" role="tabpanel" aria-labelledby="versiones-tab">
                <!-- Contenido de la pestaña Otra Sección -->
                <div class="row d-flex col-md-12 my-2">
                    <!-- Botón para subir versión -->
                    <table id="tabla_js2" class="table table-hover" style="width:100%">
                        <thead class="text-center">
                            <tr>

                                <th>Código</th>
                                <th>Versión</th>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Área</th>
                                <th>Responsable</th>
                                <th>Fecha</th>
                                <th>Documentos</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_procesos as $proceso)
                            <tr class="text-center">
                                <td>{{ $proceso->codigo }}</td>
                                <td>{{ $proceso->version }}</td>
                                <td>{{ $proceso->nombre }}</td>
                                <td>{{ $proceso->nombre_tipo_portal }}</td>
                                <td style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $proceso->nombres_area }}
                                </td>
                                <td>{{ $proceso->nombre_responsable }}</td>
                                <td>{{ $proceso->fecha }}</td>
                                <td>
                                    @if ($proceso->archivo)
                                    <a href="https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/{{ $proceso->archivo }}"
                                        title="Ver Archivo"
                                        target="_blank"
                                        class="redirect-link d-inline-flex align-items-center">
                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                        </svg>
                                    </a>
                                    @endif
                                    @if ($proceso->archivo4)
                                    <a href="https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/{{ $proceso->archivo4 }}"
                                        title="Ver Documento"
                                        target="_blank"
                                        class="redirect-link d-inline-flex align-items-center">
                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                        </svg>
                                    </a>
                                    @endif
                                    @if ($proceso->archivo5)
                                    <a href="https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/{{ $proceso->archivo5 }}"
                                        title="Ver Diagrama"
                                        target="_blank"
                                        class="redirect-link d-inline-flex align-items-center">

                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                        </svg>


                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>


                </div>
            </div>
        </div>

    </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <input type="hidden" id="capturae" name="capturae">
        <button id="boton_disablede" class="btn btn-primary" type="button" onclick="Update_Proceso();">Guardar</button>
        <button class=" btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>


<script>
    $('#id_area_p').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownParent: $('#ModalUpdate')
    });
    $('#tipo_acceso_p').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownParent: $('#ModalUpdate')
    });
    $('#id_area_acceso_e').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownParent: $('#ModalUpdate')
    });
    $('#tipo_acceso_e').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownParent: $('#ModalUpdate')
    });
    $(document).ready(function() {

        $('#id_area_acceso_e').on('change', function() {
            const selectedAreas = $(this).val();
            var url = "{{ route('puestos_por_areas_bi') }}";
            console.log('Selected Areas:', selectedAreas); // Para verificar que los valores se están obteniendo correctamente

            // Hacer una solicitud AJAX para obtener los puestos basados en las áreas seleccionadas
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    areas: selectedAreas
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#tipo_acceso_e').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, puesto) {
                        $('#tipo_acceso_e').append(
                            `<option value="${puesto.id_puesto}">${puesto.nom_puesto}</option>`
                        );
                    });

                    // Reinitialize select2 if needed
                    $('#tipo_acceso_e').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });
    });

    function Acceso_Todo() {
        const isChecked = document.getElementById('acceso_todo').checked;

        $("#id_area_acceso_e").prop('disabled', isChecked).trigger('change');
        $("#id_area_p").prop('disabled', isChecked).trigger('change');
        $("#tipo_acceso_p").prop('disabled', isChecked).trigger('change');
        $("#tipo_acceso_e").prop('disabled', isChecked).trigger('change');

        if (isChecked) {
            $("#id_area_acceso_e").val(null).trigger('change');
            $("#id_area_p").val(null).trigger('change');
            $("#tipo_acceso_p").val(null).trigger('change');
            $("#tipo_acceso_e").val(null).trigger('change');

            $("#id_area_acceso_e").append('<option value="all" disabled selected>Seleccionado todo</option>').trigger('change');
            $("#id_area_p").append('<option value="all" disabled selected>Seleccionado todo</option>').trigger('change');
            $("#tipo_acceso_p").append('<option value="all" disabled selected>Seleccionado todo</option>').trigger('change');
            $("#tipo_acceso_e").append('<option value="all" disabled selected>Seleccionado todo</option>').trigger('change');

        } else {
            $("#id_area_acceso_e option[value='all']").remove();
            $("#id_area_p option[value='all']").remove();
            $("#tipo_acceso_p option[value='all']").remove();
            $("#tipo_acceso_e option[value='all']").remove();

        }
    }



    function Update_Proceso() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('portalprocesos_lm.update', $get_id->id_portal) }}";

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
                        Lista_Maestra();
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
    var tabla = $('#tabla_js2').DataTable({
        "columnDefs": [{
                "width": "180px",
                "targets": 3
            } // Aplica a la columna de Área (índice 3)
        ],
        "autoWidth": false, // Desactiva el auto ajuste de ancho de DataTables
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10
    });
    $('#toggle').change(function() {
        var visible = this.checked;
        tabla.column(6).visible(visible);
        tabla.column(10).visible(visible);
        tabla.column(14).visible(visible);
        tabla.column(18).visible(visible);
    });
</script>