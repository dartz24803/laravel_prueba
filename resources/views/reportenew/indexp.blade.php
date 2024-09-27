@extends('layouts.plantilla')

@section('navbar')
@include($nominicio . '.navbar')
@endsection

@section('content')
<style>
    #cancel-row {
        height: calc(100vh - 100px);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #div_administrador {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .widget-content-area {
        height: 100%;
    }

    .nav-item .nav-link.active-li {
        font-weight: bold;
        color: #fea701;
    }

    /* Modal styles */
    .modal-content {
        text-align: center;
    }

    .modal-content img {
        max-width: 100%;
        max-height: 400px;
    }

    /* Ocultar el select inicialmente */
    #report-select {
        display: none;
    }
</style>

<div id="content" class="main-content" style="height: 100vh;">
    <div class="layout-px-spacing" style="height: 100%;">
        <div class="row layout-top-spacing" style="height: 100%;">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing" style="height: 100%;">
                <div class="statbox widget box box-shadow" style="height: 100%;">
                    <div class="widget-content widget-content-area simple-tab" style="height: 100%;">
                        @if(count($list_reportes) > 4)
                        <select class="form-control mt-4 ml-2" id="reporteSelect" onchange="showIframe(this.value, this);">
                            <option value="">Seleccione un reporte</option>
                            @foreach($list_reportes as $reporte)
                            <option value="{{ $reporte->iframe }}">{{ $reporte->nom_bi }}</option>
                            @endforeach
                        </select>

                        @else
                        <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                            @foreach($list_reportes as $index => $reporte)
                            <li class="nav-item" style="display: flex; align-items: center;">
                                <a class="nav-link" style="cursor: pointer;" onclick="showIframe('{{ $reporte->iframe }}', this);">
                                    {{ $reporte->nom_bi }}
                                </a>
                                <a title="{{ $reporte->nom_bi }}" onclick="showImageModal('{{ $reporte->img1 }}', '{{ $reporte->img2 }}', '{{ $reporte->img3 }}')" data-toggle="modal" data-target="#imageModal">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px; cursor:pointer;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                    </svg>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif



                        <div class="row" id="cancel-row">
                            <div id="div_administrador" class="widget-content widget-content-area p-3">
                                <!-- Aquí se mostrará el iframe -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para la previsualización de la imagen -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Previsualización de Reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="img-preview-modal" src="" alt="Previsualización de Reporte">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="prevBtn" class="btn btn-primary" onclick="changeImage(-1)">Atrás</button>
                <button type="button" id="nextBtn" class="btn btn-primary" onclick="changeImage(1)">Siguiente</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var idArea = "{{ $id_area }}";
        $("#reportbi_primario").addClass('active');
        $("#hreportbi_primario").attr('aria-expanded', 'true');
        $("#" + idArea).addClass('active');

        // Validar la cantidad de reportes
        const reportCount = $('#simpletab .nav-item').length;

        if (reportCount > 4) {
            $('#report-select').show(); // Mostrar el select si hay más de 4 reportes
            $('#simpletab .nav-item').hide(); // Ocultar los li
        } else if (reportCount > 0) {
            $('#report-select').hide(); // Ocultar el select si hay 4 o menos reportes
            $('#simpletab .nav-item').show(); // Mostrar los li si hay reportes
        } else {
            $('#report-select').hide(); // Ocultar el select si no hay reportes
            $('#simpletab .nav-item').hide(); // Ocultar los li si no hay reportes
        }

        // Inicializar Select2
        $('#reporteSelect').select2({
            placeholder: "Seleccione un reporte",
            allowClear: true
        });
    });



    function showIframe(iframeSrc, element) {
        // Aquí se asigna el iframe al div
        $('#div_administrador').html(iframeSrc);

        // Remover la clase active de todos los li
        $('.nav-item .nav-link').removeClass('active-li');

        // Añadir la clase active solo al li clickeado
        $(element).addClass('active-li');
    }

    function selectReport(selectElement) {
        const iframeSrc = selectElement.value;
        $('#div_administrador').html(iframeSrc);
    }

    let currentImageIndex = 0; // Índice de la imagen actual
    let images = []; // Array para almacenar las URLs de las imágenes

    function showImageModal(img1, img2, img3) {
        // Almacenar las URLs de las imágenes en un array
        images = [img1, img2, img3];

        // Filtrar imágenes vacías
        images = images.filter(image => image !== '');

        // Verificar si hay imágenes disponibles
        if (images.length === 0) {
            // No hay imágenes disponibles
            $('#img-preview-modal').hide(); // Ocultar la imagen
            $('#no-image-message').text('Sin Imagen').show(); // Mostrar mensaje
            $('#prevBtn').hide(); // Ocultar botón de atrás
            $('#nextBtn').hide(); // Ocultar botón de siguiente
        } else {
            // Mostrar la primera imagen
            $('#no-image-message').hide(); // Ocultar mensaje si hay imágenes
            $('#img-preview-modal').show(); // Mostrar imagen
            currentImageIndex = 0; // Resetear el índice a 0
            $('#img-preview-modal').attr('src', 'https://lanumerounocloud.com/intranet/REPORTE_BI/' + images[currentImageIndex]);

            // Habilitar o deshabilitar los botones según la imagen actual
            updateButtons();
            $('#prevBtn').show(); // Mostrar botón de atrás
            $('#nextBtn').show(); // Mostrar botón de siguiente
        }
    }


    function changeImage(direction) {
        // Cambiar el índice de la imagen actual
        currentImageIndex += direction;

        // Asegurarse de que el índice esté dentro de los límites
        if (currentImageIndex < 0) {
            currentImageIndex = 0;
        } else if (currentImageIndex >= images.length) {
            currentImageIndex = images.length - 1;
        }

        // Cambiar la imagen mostrada en el modal
        $('#img-preview-modal').attr('src', 'https://lanumerounocloud.com/intranet/REPORTE_BI/' + images[currentImageIndex]);

        // Actualizar los botones
        updateButtons();
    }

    function updateButtons() {
        // Deshabilitar o habilitar los botones según la imagen actual
        $('#prevBtn').prop('disabled', currentImageIndex === 0);
        $('#nextBtn').prop('disabled', currentImageIndex === images.length - 1);
    }
</script>
@endsection