<style>
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

<form id="formularior" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Monitoreo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row p-2">
            <textarea id="paste_arear" class="textarea_paste" placeholder="Pega aquí la imagen" style="width: 100%" rows="1" disabled></textarea>
            <div id="imageViewerr">
                @if (isset($get_id->archivo))
                    <img src="{{ $get_id->archivo }}" style="margin-top: 10px; max-width: 100%;">
                @endif
            </div>
        </div>

        @if (count($list_ronda)>0)
            <div class="row mt-3">
                <div class="form-group col-lg-12">
                    <h5 class="modal-title">RONDA {{ $get_sede->nombre_sede }}</h5>
                </div>
            </div>

            @foreach ($list_ronda as $list)
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label class="control-label text-bold">{{ $list->descripcion }}:</label>
                        <textarea id="paste_arear_{{ $list->id }}" class="textarea_paste" placeholder="Pega aquí la imagen" style="width: 100%" rows="1" disabled></textarea>
                        <div id="imageViewerr_{{ $list->id }}">
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="modal-footer">
        @csrf
        <input type="file" id="archivo_ronda" name="archivo_ronda" style="display: none;">
        @foreach ($list_ronda as $list)
            <input type="file" id="archivo_ronda_{{ $list->id }}" name="archivo_ronda_{{ $list->id }}" style="display: none;">
        @endforeach
        <button class="btn btn-primary" type="button" onclick="Insert_Ronda_Temporal();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
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
    @endforeach

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

    function Insert_Ronda_Temporal(){
        Cargando();

        var dataString = new FormData(document.getElementById('formularior'));
        var url = "{{ route('control_camara_reg.insert_ronda', $id_tienda) }}";

        Swal({
            title: '¿Realmente desea registrar estás imágenes?',
            text: "El registro no podrá ser editado",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
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
                            Habilitar_Boton({{ $id_tienda }});
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
        })
    }
</script>