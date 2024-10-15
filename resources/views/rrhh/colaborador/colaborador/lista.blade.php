<style>
    .tooltip-link {
        position: relative;
        z-index: 2;
    }

    .tooltip-link::before {
        content: attr(data-tooltip);
        position: absolute;
        color: #37342f;
        padding: 5px;
        border-radius: 5px;
        font-size: 14px;
        white-space: pre-line;
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.3s;
        top: -100%;
        left: 400%;
        transform: translateX(-50%);
        z-index: 3;
        width: 250px;
    }

    .BB::before {
        background-color: #d6ccc2;
    }

    .X::before {
        background-color: #e4d5dc;
    }

    .Y::before {
        background-color: #d6e7f1;
    }

    .Z::before {
        background-color: #d8f0d0;
    }

    .tooltip-link:hover::before {
        visibility: visible;
        opacity: 1;
    }
</style>

<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th class="no-content">Generación</th>
            <th>Sede Laboral</th>
            <th>Centro de labores</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Nombres</th>
            <th>Puesto</th>
            <th>Área</th>
            <th>Departamento/Sub Gerencia</th>
            <th>Gerencia</th>
            <th>F. Inicio Labores</th>
            <th>Tipo Documento</th>
            <th>N° Documento</th>
            <th>Teléfono Celular</th>
            <th>Bajo Jefatura</th>
            <th>Progreso</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_colaborador as $list)
        <tr class="text-center">
            <td>{{ $list->orden }}</td>
            <td>
                @if ($list->generacion!="")
                <div class="d-flex">
                    <a href="javascript:void(0)" class="tooltip-link {{ $list->generacion }}"
                        data-tooltip="@php
                                if($list->generacion==" BB"){echo "Baby Boomers&#10;-Conservadores y ordenados&#10;-Experiencia análoga&#10;-Tecnología en el hogar&#10;-Grandes lectores" ;}
                        if($list->generacion=="X"){echo "Generación X&#10;-Enfoque en preparación académica&#10;-Niñez análoga y adultez digital&#10;-Fácil adaptación a los cambios tecnológicos&#10;-Gustos por manifestaciones culturales";}
                        if($list->generacion=="Y"){echo "Generación Y (Millenials)&#10;-Emprendedores&#10;-Alto uso de dispositivos móviles&#10;-Alto manejo de las TIC&#10;-Rechazo a los medios tradicionales";}
                        if($list->generacion=="Z"){echo "Generación Z&#10;-Multitareas&#10;-Acceso a internet&#10;-Alto manejo de las TIC&#10;-Generan nuevos contenidos&#10;-Redes sociales, principal medio de comunicación";} @endphp"
                        data-html="true" class="anchor-tooltip tooltiped">
                        <div class="divdea">
                            @if ($list->generacion=="BB")
                            <img src="{{ asset('template/assets/img/bb.png') }}" class="img-fluid rounded-circle">
                            @endif
                            @if ($list->generacion=="X")
                            <img src="{{ asset('template/assets/img/x.png') }}" class="img-fluid rounded-circle">
                            @endif
                            @if ($list->generacion=="Y")
                            <img src="{{ asset('template/assets/img/y.png') }}" class="img-fluid rounded-circle">
                            @endif
                            @if ($list->generacion=="Z")
                            <img src="{{ asset('template/assets/img/z.png') }}" class="img-fluid rounded-circle">
                            @endif
                        </div>
                    </a>
                </div>
                @endif
            </td>
            <td>{{ $list->sede_laboral }}</td>
            <td>{{ $list->ubicacion }}</td>
            <td class="text-left">{{ $list->usuario_apater }}</td>
            <td class="text-left">{{ $list->usuario_amater }}</td>
            <td class="text-left">{{ $list->usuario_nombres }}</td>
            <td class="text-left">{{ $list->nom_puesto }}</td>
            <td class="text-left">{{ $list->nom_area }}</td>
            <td class="text-left">{{ $list->nom_sub_gerencia }}</td>
            <td class="text-left">{{ $list->nom_gerencia }}</td>
            <td class="text-left">{{ $list->fecha_ingreso }}</td>
            <td>{{ $list->cod_tipo_documento }}</td>
            <td>{{ $list->num_doc }}</td>
            <td>
                <a href="tel:+51{{ $list->num_celp }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-outgoing">
                        <polyline points="23 7 23 1 17 1"></polyline>
                        <line x1="16" y1="8" x2="23" y2="1"></line>
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </a>
                <a href="https://api.whatsapp.com/send?phone=51{{ $list->num_celp }}&text=hola,%20{{ $list->usuario_nombres }}" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="24px" height="24px" fill-rule="evenodd" clip-rule="evenodd">
                        <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z" />
                        <path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z" />
                        <path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z" />
                        <path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z" />
                        <path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd" />
                    </svg>
                </a>
                {{ $list->num_celp }}
            </td>
            <td>
                @if ($list->fecha_baja!="" && $list->fecha_baja!="0000-00-00")
                {{ $list->fecha_baja }}
                <br>
                {{ $list->nom_motivo }}
                @if ($list->doc_baja!="")
                <a style="cursor:pointer;display: -webkit-inline-box;" title="Carta" href="{{ $list->doc_baja }}">
                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                    </svg>
                </a>
                @endif
                @endif
            </td>
            <td></td>
            <td class="text-center">
                @if (session('usuario')->id_puesto=="27" && $list->id_usuario>0)
                    <a class="efectob" title="Ver Perfil" href="{{ url('ColaboradorController/Mi_Perfil/' .$list['id_usuario']) }}>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle></svg>
                    </a>
                @else
                @if ($list->id_usuario>0)
                @if ($list->verif_email=="2")
                <a href="javascript:void(0);" title="Mail">
                    <svg style="width: 20px !important;height: 20px !important;" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g fill="blue">
                            <path fill="blue" d="M491,176.2L261.3,334.6c-1.6,1.1-3.5,1.7-5.3,1.7s-3.7-0.6-5.3-1.7L21,176.2c-9.1,7.2-15,18.3-15,30.9v239.7   c0,21.7,17.6,39.3,39.3,39.3h421.3c21.7,0,39.3-17.6,39.3-39.3V207C506,194.5,500.1,183.4,491,176.2z M187.1,330.2L71,446.3   c-0.9,0.9-2.1,1.4-3.3,1.4c-1.2,0-2.4-0.5-3.3-1.4c-1.8-1.8-1.8-4.8,0-6.6l116.1-116.1c1.8-1.8,4.8-1.8,6.6,0   C189,325.4,189,328.4,187.1,330.2z M447.6,446.3c-0.9,0.9-2.1,1.4-3.3,1.4s-2.4-0.5-3.3-1.4L324.9,330.2c-1.8-1.8-1.8-4.8,0-6.6   s4.8-1.8,6.6,0l116.1,116.1C449.4,441.5,449.4,444.5,447.6,446.3z" />
                            <g>
                                <rect height="14" width="216" x="148" y="209.2" fill="blue" id="XMLID_6_" />
                                <polygon points="148,241 162.3,250.9 349.7,250.9 364,241 364,236.9 148,236.9" fill="blue" id="XMLID_5_" />
                                <rect height="14" width="216" x="148" y="181.5" style="color: blue;" id="XMLID_4_" fill="blue" />
                                <path d="M464,163.8L271,30.6c-9.1-6.2-21-6.2-30.1,0L48,163.8c-2.9,2-2.9,6.2,0,8.2l64,44.2v-77.8h288v77.8l64-44.2    C466.9,170,466.9,165.8,464,163.8z" id="XMLID_3_" />
                                <polygon points="182.1,264.5 202.4,278.5 309.6,278.5 329.9,264.5" fill="blue" id="XMLID_2_" />
                                <path d="M289.8,292.2h-67.5l18.7,12.9c0.6,0.4,1.1,0.7,1.7,1.1h26.7c0.6-0.3,1.1-0.7,1.7-1.1L289.8,292.2z" fill="blue" id="XMLID_1_" />
                            </g>
                        </g>
                    </svg>
                </a>
                @elseif ($list->verif_email=="1")
                <a href="javascript:void(0);" title="Mail">
                    <svg width="20" height="20" style="enable-background:new 0 0 56.7 56.7;" version="1.1" viewBox="0 0 56.7 56.7" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g>
                            <path fill="green" d="M23.0224,17.7972c-0.1953-0.1953-0.5117-0.1953-0.707,0l-3.0322,3.0317c-0.0938,0.0938-0.1465,0.2207-0.1465,0.3535   s0.0527,0.2598,0.1465,0.3535l8.8838,8.8833c0.0977,0.0977,0.2256,0.1465,0.3535,0.1465s0.2559-0.0488,0.3535-0.1465   l17.7549-17.7549c0.1953-0.1953,0.1953-0.5117,0-0.707l-3.0317-3.0322c-0.0938-0.0938-0.2207-0.1465-0.3535-0.1465   S42.9838,8.8314,42.89,8.9251L28.5204,23.2952L23.0224,17.7972z" />
                            <path fill="green" d="M53.0978,23.701c-0.0001-0.0004-0.0005-0.0007-0.0007-0.0011c-0.2549-0.7663-0.7205-1.4108-1.348-1.8636l-7.4805-5.3976   l-1.4325,1.4325l7.6515,5.5209l0.0911,0.0657c0.0811,0.0586,0.1426,0.1412,0.2119,0.2148c0.0166,0.0176,0.035,0.033,0.0508,0.0515   c0.0707,0.2159-0.0034,0.4578-0.2056,0.5809L5.6591,51.6898c0.4562,0.1978,0.9576,0.31,1.4856,0.31h42.4102   c2.0679,0,3.7505-1.6821,3.7505-3.75V24.8773C53.3053,24.5067,53.2374,24.1219,53.0978,23.701z" />
                            <path fill="green" d="M5.9092,23.6724c0.069-0.0732,0.1304-0.1557,0.2111-0.2141L27.3253,8.1575c0.6133-0.4424,1.4355-0.4424,2.0488,0   l7.4755,5.394l1.4325-1.4326l-7.738-5.5835c-1.3125-0.9473-3.0762-0.9473-4.3887,0L4.9499,21.8367   c-0.6257,0.452-1.0917,1.0956-1.3472,1.8622c-0.0002,0.0005-0.0007,0.001-0.0009,0.0015c-0.1392,0.4199-0.207,0.8047-0.207,1.1768   v23.3726c0,1.1402,0.5223,2.1506,1.3278,2.8389L27.83,37.0193L5.9092,23.6724z" />
                        </g>
                    </svg>
                </a>
                @else
                <a title="Mail" href="javascript:void(0);" onclick="Envio_Email('{{ $list->id_usuario }}')">
                    <svg style="width: 20px !important;height: 20px !important;" data-name="Layer 1" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <style>
                                .cls-1 {
                                    fill: none;
                                    stroke: #d13d61;
                                    stroke-linecap: round;
                                    stroke-linejoin: round;
                                    stroke-width: 2px;
                                }
                            </style>
                        </defs>
                        <rect class="cls-1" height="47" rx="2" ry="2" transform="translate(0 64) rotate(-90)" width="33" x="15.5" y="8.5" />
                        <polyline class="cls-1" points="9 17 32 33 55 17.5" />
                    </svg>
                </a>
                @endif

                <a class="efectob" title="Ver Perfil" href="{{ url('ColaboradorController/Mi_Perfil/' .$list->id_usuario) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </a>

                @if ($list->foto!="")
                <a href="{{ route('colaborador_co.download', $list->id_usuario) }}" title="Descargar Foto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </a>
                @endif

                <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('colaborador_co.edit', $list->id_usuario) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                </a>

                {{--
                                <a href="{{ route('colaborador_co.pdf_perfil', $list->id_usuario) }}" target="_blank" title="pdf">
                <svg id="Capa_1" enable-background="new 0 0 512 512" height="20" viewBox="0 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <g>
                            <path d="m459.265 466.286c0 25.248-20.508 45.714-45.806 45.714h-314.918c-25.298 0-45.806-20.467-45.806-45.714v-420.572c0-25.247 20.508-45.714 45.806-45.714h196.047c9.124 0 17.874 3.622 24.318 10.068l130.323 130.34c6.427 6.427 10.036 15.137 10.036 24.217z" fill="#f9f8f9" />
                            <path d="m129.442 512h-30.905c-25.291 0-45.802-20.47-45.802-45.719v-420.562c0-25.249 20.511-45.719 45.802-45.719h30.905c-25.291 0-45.802 20.47-45.802 45.719v420.561c0 25.25 20.511 45.72 45.802 45.72z" fill="#e3e0e4" />
                            <path d="m459.265 164.623v16.73h-119.46c-34.12 0-61.873-27.763-61.873-61.883v-119.47h16.658c9.117 0 17.874 3.626 24.312 10.065l130.328 130.339c6.429 6.428 10.035 15.143 10.035 24.219z" fill="#e3e0e4" />
                            <path d="m456.185 qu150.448h-116.38c-17.101 0-30.967-13.866-30.967-30.978v-116.369c3.719 1.679 7.129 4.028 10.065 6.964l130.328 130.339c2.936 2.935 5.275 6.335 6.954 10.044z" fill="#dc4955" />
                            <path d="m440.402 444.008h-368.804c-22.758 0-41.207-18.45-41.207-41.207v-150.407c0-22.758 18.45-41.207 41.207-41.207h368.805c22.758 0 41.207 18.45 41.207 41.207v150.406c0 22.759-18.45 41.208-41.208 41.208z" fill="#dc4955" />
                            <path d="m97.352 444.008h-25.754c-22.757 0-41.207-18.451-41.207-41.207v-150.407c0-22.757 18.451-41.207 41.207-41.207h25.755c-22.757 0-41.207 18.451-41.207 41.207v150.406c-.001 22.757 18.449 41.208 41.206 41.208z" fill="#c42430" />
                            <g fill="#f9f8f9">
                                <path d="m388.072 277.037c4.267 0 7.726-3.458 7.726-7.726s-3.459-7.726-7.726-7.726h-47.247c-4.267 0-7.726 3.458-7.726 7.726v116.573c0 4.268 3.459 7.726 7.726 7.726s7.726-3.458 7.726-7.726v-51.664h35.768c4.267 0 7.726-3.458 7.726-7.726s-3.459-7.726-7.726-7.726h-35.768v-41.731z" />
                                <path d="m258.747 262.891h-32.276c-2.052 0-4.019.816-5.468 2.268s-2.262 3.42-2.258 5.472v.101.004 111.99c0 .637.085 1.252.231 1.844v.035c.007 2.049.829 4.012 2.283 5.456 1.447 1.437 3.405 2.243 5.443 2.243h.029c.974-.004 23.943-.093 33.096-.251 15.515-.272 29.33-7.303 38.904-19.798 8.875-11.583 13.763-27.443 13.763-44.657 0-38.703-21.599-64.707-53.747-64.707zm.811 113.71c-5.75.1-17.382.173-25.155.213-.043-12.743-.122-37.877-.122-49.343 0-9.584-.044-35.933-.068-49.127h24.535c28.234 0 38.294 25.442 38.294 49.254-.001 28.467-15.415 48.617-37.484 49.003z" />
                            </g>
                        </g>
                        <path d="m146.336 261.444h-32.967c-6.746 0-7.102 2.938-7.102 7.099v118.397c0 3.921 3.178 7.099 7.099 7.099 3.92 0 7.099-3.177 7.099-7.099v-44.368c7.698-.044 19.916-.107 25.868-.107 22.698 0 41.165-18.173 41.165-40.511-.001-22.337-18.464-40.51-41.162-40.51zm0 66.824c-5.913 0-17.952.061-25.679.106-.044-7.914-.107-20.39-.107-26.419 0-5.066-.036-18.095-.061-26.313h25.846c14.618 0 26.967 12.049 26.967 26.313.001 14.264-12.349 26.313-26.966 26.313z" fill="#f9f8f9" />
                    </g>
                </svg>
                </a>
                --}}

                @if ($list->documento!="" || $list->documento!=null)
                <a href="https://lanumerounocloud.com/intranet/MiEquipo_ComunicarBaja/{{ $list->documento }}" target="_blank" title="Motivo Renuncia">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </a>
                @endif
                @endif
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#tabla_js').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
        order: [
            [0, "desc"]
        ],
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
        "pageLength": 10,
        "aoColumnDefs": [{
            'targets': [0],
            'visible': false
        }]
    });
</script>
