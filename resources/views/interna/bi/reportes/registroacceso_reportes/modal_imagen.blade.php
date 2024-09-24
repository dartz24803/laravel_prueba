<form id="formularioimage2" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Visualización de Archivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-12 text-center">
                <div class="col">
                    <!-- Texto o nombre de la imagen actual -->
                    <p id="imageName">{{ !empty($imageUrls) ? $imageUrls[0]['name'] : 'No hay imágenes disponibles' }}</p>
                </div>
                <div id="image-carousel" class="text-center">
                    <!-- Si hay imágenes, mostrar la primera -->
                    @if (!empty($imageUrls))
                    <img id="modalImage" src="{{ $imageUrls[0]['url'] }}" alt="Imagen" style="max-width: 100%; max-height: 400px;" />
                    <div class="m-4">
                        <button type="button" id="prevImage" class="btn btn-secondary">Anterior</button>
                        <button type="button" id="nextImage" class="btn btn-secondary">Siguiente</button>
                    </div>
                    @else
                    <!-- Si no hay imágenes, mostrar un mensaje -->
                    <p>No hay archivos disponibles</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary" type="button" data-dismiss="modal">Aceptar</button>
    </div>
</form>

<script>
    let imageIndex = 0;
    const imageUrls = @json($imageUrls); // Asegúrate de que esto sea un array válido

    const modalImage = document.getElementById('modalImage');
    const imageName = document.getElementById('imageName');
    const prevButton = document.getElementById('prevImage');
    const nextButton = document.getElementById('nextImage');

    function updateImage() {
        if (imageUrls.length > 0) {
            modalImage.src = imageUrls[imageIndex].url;
            imageName.textContent = imageUrls[imageIndex].name; // Actualiza el nombre de la imagen
        } else {
            imageName.textContent = 'No hay imágenes disponibles';
            modalImage.style.display = 'none'; // Ocultar la imagen si no hay ninguna
            prevButton.style.display = 'none'; // Ocultar los botones de navegación
            nextButton.style.display = 'none';
        }
    }

    prevButton.addEventListener('click', function() {
        imageIndex = (imageIndex > 0) ? imageIndex - 1 : imageUrls.length - 1;
        updateImage();
    });

    nextButton.addEventListener('click', function() {
        imageIndex = (imageIndex < imageUrls.length - 1) ? imageIndex + 1 : 0;
        updateImage();
    });

    // Inicializa la imagen al cargar
    updateImage();
</script>