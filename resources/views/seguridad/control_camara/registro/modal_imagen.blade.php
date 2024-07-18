<style>
    #paste_area {
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

<form id="formularioi" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Monitoreo (Todas las cámaras)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row p-2">
            <textarea id="paste_area" placeholder="Pega aquí la imagen" style="width: 100%" rows="1" disabled></textarea>
            <div id="imageViewer">
                @if (isset($get_id->archivo))
                    <img src="{{ $get_id->archivo }}" style="margin-top: 10px; max-width: 100%;">
                @endif
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <input type="file" id="archivo_base" name="archivo_base" style="display: none;">
        <button class="btn btn-primary" type="button" onclick="Insert_Imagen_Temporal();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    document.getElementById('paste_area').addEventListener('paste', function(e) {
        if (e.clipboardData && e.clipboardData.items) {
            var items = e.clipboardData.items;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") !== -1) {
                    var blob = items[i].getAsFile();

                    // Display image in viewer div
                    displayImage(blob);

                    // Set the image blob as form data
                    var fileInput = document.getElementById('archivo_base');
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
            var imageViewer = document.getElementById('imageViewer');
            imageViewer.innerHTML = '';
            
            // Append new image to viewer div
            imageViewer.appendChild(img);
        };

        reader.readAsDataURL(blob);
    }

    function Insert_Imagen_Temporal(){
        Cargando();

        var dataString = new FormData(document.getElementById('formularioi'));
        var url = "{{ route('control_camara_reg.insert_captura', $id_tienda) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success:function (data) {
                swal.fire(
                    '¡Registro Exitoso!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    $("#ModalUpdate .close").click();
                    $("#btn_camara_{{ $id_tienda }}").removeClass('btn-secondary');
                    $("#btn_camara_{{ $id_tienda }}").addClass('btn-dark');
                });
            },
            error:function(xhr) {
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
</script>