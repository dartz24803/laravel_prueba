<form id="formularioi" method="POST" enctype="multipart/form-data" class="needs-validation">
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
                <div class="col"> <label>{{ $get_id->nombre }}:</label>
                    @if ($imageUrl)
                </div>
                @php
                $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
                @endphp

                @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                <!-- Mostrar imagen -->
                <img src="{{ $imageUrl }}" alt="Imagen" style="max-width: 100%; max-height: 400px;" />
                @elseif (strtolower($extension) == 'pdf')
                <!-- Mostrar PDF -->
                <embed src="{{ $imageUrl }}" type="application/pdf" width="100%" height="500px" />
                <!-- Si prefieres usar un iframe en lugar de embed, usa la siguiente línea: -->
                <!-- <iframe src="{{ $imageUrl }}" width="100%" height="500px"></iframe> -->
                @else
                <!-- Otro tipo de archivo -->
                <p>No se puede mostrar el archivo: {{ $extension }}</p>
                @endif
                @else
                <p>No hay archivo disponible</p>
                @endif
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary" type="button" data-dismiss="modal">Aceptar</button>
    </div>
</form>