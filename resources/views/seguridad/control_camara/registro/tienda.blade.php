@if (count($list_tienda_base)>0)
    <div class="form-group col-lg-12">
        <label class="control-label text-bold">Bases a Monitorear:</label>
    </div>

    @foreach ($list_tienda_base as $list)
        <div class="col-lg-12 row justify-content-center">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">{{ $list->descripcion }}:</label>
            </div>
            <div class="form-group row col-lg-4">
                <select class="form-control basic_i" size="1" id="id_ocurrencia_{{ $list->id_tienda }}" name="id_ocurrencia_{{ $list->id_tienda }}[]" multiple>
                    @foreach ($list_ocurrencia as $ocurrencia)
                        <option value="{{ $ocurrencia->id_ocurrencias_camaras }}">
                            {{ $ocurrencia->descripcion }}
                        </option>
                    @endforeach
                </select>
                <input type="text" class="form-control" id="desc_{{$list->id_tienda}}" name="desc_{{$list->id_tienda}}" placeholder="Problemas">
            </div>
            <div class="d-flex align-items-center justify-content-center col-lg-1 ml-3 mb-3">
                <button type="button" class="btn btn-secondary" id="btn_camara_{{ $list->id_tienda }}" title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('control_camara_reg.modal_imagen', $list->id_tienda) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera text-light">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </button>
            </div>
        </div>
    @endforeach
@endif


<style>
    .select2-selection{
        height: 3rem;
        overflow-y: scroll;
    }
    .select2-search{
        display: none;
    }

    .textarea_paste {
        width: 100%; /* Ancho completo */
        padding: 10px; /* Espaciado interno para separar el contenido del borde */
        font-size: 16px; /* Tamaño de fuente adecuado */
        border: 1px solid #ccc; /* Borde del textarea */
        resize: none; /* Permitir redimensionamiento vertical */
        box-sizing: border-box; /* Incluir padding y border en el ancho total */
        cursor: text; /* Cursor de texto para indicar área de entrada */
        border-color: #3366ff; /* Cambiar color del borde al enfocarse */
        box-shadow: 0 0 5px rgba(51, 102, 255, 0.5); /* Sombra al enfocarse */
    }
</style>
<script>
    $('.basic_i').select2({
        dropdownParent: $('#ModalRegistro')
    });
    /*
    document.getElementById('paste_arear').addEventListener('paste', function(e) {
        if (e.clipboardData && e.clipboardData.items) {
            var items = e.clipboardData.items;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") !== -1) {
                    var blob = items[i].getAsFile();

                    // Display image in viewer div
                    displayImage(blob);

                    // Set the image blob as form data
                    var fileInput = document.getElementById('archivo_ronda');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(blob);
                    fileInput.files = dataTransfer.files;

                    break;
                }
            }
        }
    });
    // Function to display image in viewer div
    function displayImage(blob) {
        var reader = new FileReader();

        reader.onload = function(event) {
            var img = new Image();
            img.src = event.target.result;
            img.style.maxWidth = "100%";
            img.style.marginTop = "10px"; // Adjust styling as needed

            // Clear previous content
            var imageViewer = document.getElementById('imageViewerr');
            imageViewer.innerHTML = '';

            // Append new image to viewer div
            imageViewer.appendChild(img);
        };

        reader.readAsDataURL(blob);
    }

    @foreach ($list_ronda as $list)
        document.getElementById('paste_arear_{{ $list->id }}').addEventListener('paste', function(e) {
            if (e.clipboardData && e.clipboardData.items) {
                var items = e.clipboardData.items;
                for (var i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf("image") !== -1) {
                        var blob = items[i].getAsFile();

                        // Display image in viewer div
                        displayImager(blob, {{ $list->id }});

                        // Set the image blob as form data
                        var fileInput = document.getElementById('archivo_ronda_{{ $list->id }}');
                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(blob);
                        fileInput.files = dataTransfer.files;

                        break;
                    }
                }
            }
        });
    @endforeach*/
</script>
