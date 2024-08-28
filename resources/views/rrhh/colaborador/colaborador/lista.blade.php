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
        width:250px;
    }

    .BB::before{
        background-color: #d6ccc2;
    }
    .X::before{
        background-color: #e4d5dc;
    }
    .Y::before{
        background-color: #d6e7f1;
    }
    .Z::before{
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
            <th>Ubicación</th>
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
                                if($list->generacion=="BB"){echo "Baby Boomers&#10;-Conservadores y ordenados&#10;-Experiencia análoga&#10;-Tecnología en el hogar&#10;-Grandes lectores";}
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
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="24px" height="24px" fill-rule="evenodd" clip-rule="evenodd">
                            <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"/>
                            <path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"/><path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"/><path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"/><path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"/>
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
                                <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                            </a>
                        @endif
                    @endif
                </td>
                <td></td>
                <td class="text-center">
                    @if ($list->foto!="")
                        <a href="{{ route('colaborador_co.download', $list->id_usuario) }}" title="Descargar Foto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        </a>
                    @endif
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('colaborador_co.edit', $list->id_usuario) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>     
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
        order: [[0,"desc"]],
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10,
        "aoColumnDefs" : [ 
            {
                'targets' : [ 0 ],
                'visible' : false
            } 
        ]
    });
</script>