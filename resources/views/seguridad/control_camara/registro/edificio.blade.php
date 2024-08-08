@if (count($list_tienda_base)>0)
    @if (count($list_tienda_sede)>0)
        <div class="form-group col-lg-12">
            <label class="control-label text-bold">Sede a Monitorear:</label>
        </div>

        @foreach ($list_tienda_sede as $list)
            <div class="col-lg-12 row justify-content-center">
                <div class="form-group col-lg-3">
                    <label class="control-label text-bold">{{ $list->descripcion }}</label>
                </div>
            </div>
        @endforeach
    @endif
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
                <div id="imageViewerr_{{ $list->id }}">
                </div>
            </div>
        </div>
    @endforeach
    @endif
    <input type="file" id="archivo_ronda" name="archivo_ronda" style="display: none;">
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