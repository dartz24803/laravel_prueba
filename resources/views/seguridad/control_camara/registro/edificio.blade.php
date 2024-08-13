@if (count($list_tienda_base)>0)
    @if (count($list_tienda_sede)>0)
        <div class="form-group col-lg-12">
            <label class="control-label text-bold">Sede a Monitorear:</label>
        </div>

        @foreach ($list_tienda_sede as $list)
            <div class="col-lg-12 row justify-content-center">
                <div class="form-group col-lg-10 d-flex justify-content-center">
                    <h5 class="modal-title text-bold">{{ $list->descripcion }}</h5>
                </div>
            </div>
        @endforeach
    @endif

    <div class="row col-lg-12 ml-1">
        <div class="form-group">
            <h5 class="modal-title">MONITOREO</h5>
        </div>
    </div>

    <div class="row p-2 col-lg-12 ml-1">
        <textarea id="paste_arear" class="textarea_paste" placeholder="Haz click aquí para pegar la imagen" style="width: 100%" rows="1" disabled></textarea>
        <input type="text" class="form-control" id="archivo_rond_desc_0" name="archivo_ronda_desc_0" placeholder="Observaciones">
        <button onclick="LimpiarImage()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </button>
        <div id="imageViewerr">
        </div>
    </div>
    @if (count($list_ronda)>0)
    <div class="row mt-3 ml-1">
        <div class="form-group col-lg-12">
            <h5 class="modal-title">RONDA {{ $get_sede->nombre_sede }}</h5>
        </div>
    </div>
    <br>
    @foreach ($list_ronda as $list)
        <div class="row col-lg-12">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">{{ $list->descripcion }}:</label>
                <textarea id="paste_arear_{{ $list->id }}" class="textarea_paste" placeholder="Haz click aquí para pegar la imagen" style="width: 100%" rows="1" disabled></textarea>
                <input type="text" class="form-control" id="archivo_ronda_desc_{{$list->id}}" name="archivo_ronda_desc_{{$list->id}}" placeholder="Observaciones">
                <div id="imageViewerr_{{ $list->id }}">
                </div>
            </div>
        </div>
    @endforeach
    @endif
    <input type="file" id="archivo_rond" name="archivo_rond" style="display: none;">
    @foreach ($list_ronda as $list)
        <input type="file" id="archivo_ronda_{{ $list->id }}" name="archivo_ronda_{{ $list->id }}" style="display: none;">
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

    document.getElementById('paste_arear').addEventListener('paste', function(e) {
        if (e.clipboardData && e.clipboardData.items) {
            var items = e.clipboardData.items;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") !== -1) {
                    var blob = items[i].getAsFile();

                    // Display image in viewer div
                    displayImage(blob);

                    // Set the image blob as form data
                    var fileInput = document.getElementById('archivo_rond');
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

    // Function to display image in viewer div
    function displayImager(blob,id) {
        var reader = new FileReader();

        reader.onload = function(event) {
            var img = new Image();
            img.src = event.target.result;
            img.style.maxWidth = "100%";
            img.style.marginTop = "10px"; // Adjust styling as needed

            // Clear previous content
            var imageViewer = document.getElementById('imageViewerr_'+id);
            imageViewer.innerHTML = '';

            // Append new image to viewer div
            imageViewer.appendChild(img);
        };

        reader.readAsDataURL(blob);
    }

    function LimpiarImage(){
        event.preventDefault(); // Prevenir la acción por defecto, que podría ser recargar la página
        // Clear previous content
        var imageViewer = document.getElementById('imageViewerr');
        imageViewer.innerHTML = '';
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
    @endforeach
</script>
