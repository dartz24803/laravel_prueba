<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo servicio:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-3">
                <label>Base:</label>
                <select class="form-control" name="cod_base" id="cod_base" onchange="Traer_Lugar('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Lugar:</label>
                <select class="form-control" name="id_lugar_servicio" id="id_lugar_servicio" 
                onchange="Traer_Servicio('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Servicio:</label>
                <select class="form-control" name="id_servicio" id="id_servicio" 
                onchange="Traer_Proveedor(''); Traer_Lectura('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Proveedor:</label>
                <select class="form-control" name="id_proveedor_servicio" id="id_proveedor_servicio"
                onchange="Traer_Suministro('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3 div_suministro">
                <label>Suministro:</label>
                <select class="form-control" name="suministro" id="suministro">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Doc serie:</label>
                <input type="text" class="form-control" name="documento_serie" id="documento_serie" 
                placeholder="Doc serie">
            </div>

            <div class="form-group col-lg-3">
                <label>Doc número:</label>
                <input type="text" class="form-control" name="documento_numero" id="documento_numero" 
                placeholder="Doc número">
            </div>

            <div class="form-group col-lg-3">
                <label>Período:</label>
                <div class="input-group">
                    <select class="form-control" name="mes" id="mes">
                        @foreach ($list_mes as $list)
                            <option value="{{ $list->cod_mes }}" 
                            @if ($list->cod_mes==date('m')) selected @endif>
                                {{ $list->abr_mes }}
                            </option>
                        @endforeach
                    </select>
                    <select class="form-control" name="anio" id="anio">
                        @foreach ($list_anio as $list)
                            <option value="{{ $list->cod_anio }}"
                            @if ($list->cod_anio==date('Y')) selected @endif>
                                {{ $list->cod_anio }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label>Fecha emisión:</label>
                <input type="date" class="form-control" name="fec_emision" id="fec_emision" 
                value="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group col-lg-3">
                <label>Fecha vencimiento:</label>
                <input type="date" class="form-control" name="fec_vencimiento" id="fec_vencimiento">
            </div>

            <div class="form-group col-lg-3">
                <label>Importe:</label>
                <input type="text" class="form-control" name="importe" id="importe" 
                placeholder="Importe" onkeypress="return solo_Numeros_Punto(event);" 
                onpaste="return false;">
            </div>
        </div>

        <div id="div_lectura">
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">Recibo: </label>
                <div class="drop-zone" id="drop-zone">
                    <span>Arrastra y suelta el archivo aquí o haz clic para seleccionarlo</span>
                    <input type="file" id="documento" name="documento" accept=".jpg, .jpeg, .png, .pdf"
                    onchange="Valida_Archivo('documento');">
                </div>
            </div>

            <div id="div_doc" class="form-group col-lg-9 preview">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Registro_Servicio();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Funciones para manejar arrastrar y soltar
        const dropZone = document.getElementById('drop-zone');
        const inputElement = document.getElementById('documento');

        dropZone.addEventListener('click', () => inputElement.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drop-zone--over');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drop-zone--over');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drop-zone--over');

            if (e.dataTransfer.files.length) {
                const files = Array.from(e.dataTransfer.files);
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
                const isFileTypeValid = files.every(file => {
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    return allowedExtensions.includes(fileExtension);
                });

                if (isFileTypeValid) {
                    inputElement.files = e.dataTransfer.files;
                    validarArchivoImgPrevisualizar('documento', 'div_doc');
                } else {
                    Swal({
                        title: 'Error',
                        text: "Por favor, suba archivos con las siguientes extensiones: .jpg, .jpeg, .png, .pdf",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }
            }
        });

        inputElement.addEventListener('change', () => {
            validarArchivoImgPrevisualizar('documento', 'div_doc');
        });
    });

    function Insert_Registro_Servicio() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('registro_servicio.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Registro_Servicio();
                        $("#ModalRegistroGrande .close").click();
                    })
                }
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
