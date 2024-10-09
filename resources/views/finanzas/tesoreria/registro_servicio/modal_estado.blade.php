<form id="formularios" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registar pago:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Fecha pago:</label>
                <input type="date" class="form-control" name="fec_pagos" id="fec_pagos"
                value="{{ $get_id->fec_pago }}">
            </div>

            <div class="form-group col-lg-6">
                <label>N° operación:</label>
                <input type="text" class="form-control" name="num_operacions" id="num_operacions"
                placeholder="N° operación" onkeypress="return solo_Numeros(event);" 
                value="{{ $get_id->num_operacion }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">Comprobante: </label>
                @if ($get_id->comprobante!="")
                    <a href="{{ $get_id->comprobante }}" title="Comprobante" target="_blank">
                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                        </svg>
                    </a>
                @endif
                <div class="drop-zone" id="drop-zones">
                    <span>Arrastra y suelta el archivo aquí o haz clic para seleccionarlo</span>
                    <input type="file" id="comprobantes" name="comprobantes" accept=".jpg, .jpeg, .png, .pdf"
                    onchange="Valida_Archivo('comprobantes');">
                </div>
            </div>

            <div id="div_docs" class="form-group col-lg-9 preview">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Estado();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Funciones para manejar arrastrar y soltar
        const dropZone = document.getElementById('drop-zones');
        const inputElement = document.getElementById('comprobantes');

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
                    validarArchivoImgPrevisualizar('comprobantes', 'div_docs');
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
            validarArchivoImgPrevisualizar('comprobantes', 'div_docs');
        });
    });

    function Update_Estado() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularios'));
        var url = "{{ route('registro_servicio.update_estado', $get_id->id_gasto_servicio) }}";

        if({{ $get_id->estado_servicio }}=="1"){
            Swal({
                title: '¿Realmente desea registrar pago?',
                text: "El registro será permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        data: dataString,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            swal.fire(
                                '¡Registro Exitoso!',
                                '¡Haga clic en el botón!',
                                'success'
                            ).then(function() {
                                Lista_Registro_Servicio();
                                $("#ModalUpdate .close").click();
                            })
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
        }else{
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Registro_Servicio();
                        $("#ModalUpdate .close").click();
                    })
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
    }
</script>
