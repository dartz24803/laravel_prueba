<!-- CSS -->
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
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

    <div class="modal-body" style=" max-height:450px; overflow:auto;">
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

                        </div>

                        <div class="row">



                            <div class=" form-group col-md-3">
                                <label>N° Documento: </label>
                                <select class="form-control" id="estado" name="estado">
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
                                <label>Estado: </label>
                                <input type="text" class="form-control" id="numeroe" name="numeroe" value="{{ $get_id->numero }}">
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
                                <a href="{{ $get_id->archivo ? 'https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/' . $get_id->archivo : '#' }}"
                                    title="Ver Contenido"
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
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control-file" name="imagene" id="imagene" onchange="Valida_Archivo('imagene');">
                                </div>
                            </div>

                            <!-- <div class="form-group col-md-6">
                                <label>Archivo 2:</label>
                                <a href="{{ $get_id->archivo2 ? 'https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/' . $get_id->archivo2 : '#' }}"
                                    title="Ver Contenido"
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
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control-file" name="imagene" id="imagene" onchange="Valida_Archivo('imagene');">
                                </div>
                            </div> -->
                        </div>



                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="accesos" role="tabpanel" aria-labelledby="accesos-tab">

                <div class="row d-flex col-md-12 my-2">
                    @if($div_puesto == 1)
                    <!-- Bloque cuando div_puesto = 1 -->
                    <div class="col-md-12 my-2 text-center">
                        <div>
                            <label class="control-label text-bold">Todos</label>

                            <label class="switch">
                                <input type="checkbox" id="acceso_todo" name="acceso_todo" onclick="Acceso_Todo()">
                                <span class="slider"></span>
                            </label>
                        </div>

                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label text-bold">Acceso Área: </label>
                        <select class="form-control multivalue" name="id_areae[]" id="id_areae" multiple="multiple">
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
                        <select class="form-control multivalue" name="tipo_acceso_p[]" id="tipo_acceso_p" multiple="multiple">
                            @foreach ($list_responsable as $puesto)
                            <option value="{{ $puesto->id_puesto }}"
                                @if(in_array($puesto->id_puesto, $selected_puesto_ids)) selected @endif>
                                {{ $puesto->nom_puesto }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    @else
                    <!-- Bloque alternativo cuando div_puesto != 1 -->
                    <div class="row d-flex">
                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Contenido Alternativo</label>
                            <p>Este es el contenido alternativo que se muestra cuando div_puesto no es 1.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="versiones" role="tabpanel" aria-labelledby="versiones-tab">
                <!-- Contenido de la pestaña Otra Sección -->
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <input type="hidden" id="capturae" name="capturae">
        <button id="boton_disablede" class="btn btn-primary" type="button" disabled>Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalRegistro')
    });
</script>