<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar registro de servicio:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-3">
                <label>Base:</label>
                <select class="form-control" name="cod_basee" id="cod_basee" onchange="Traer_Lugar('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}"
                        @if ($list->cod_base==$get_id->cod_base) selected @endif>
                            {{ $list->cod_base }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Lugar:</label>
                <select class="form-control" name="id_lugar_servicioe" id="id_lugar_servicioe" 
                onchange="Traer_Servicio('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_lugar as $list)
                        <option value="{{ $list->id_lugar_servicio }}"
                        @if ($list->id_lugar_servicio==$get_id->id_lugar_servicio) selected @endif>
                            {{ $list->nom_lugar_servicio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Servicio:</label>
                <select class="form-control" name="id_servicioe" id="id_servicioe" 
                onchange="Traer_Proveedor('e'); Traer_Lectura('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_servicio as $list)
                        <option value="{{ $list->id_servicio }}"
                        @if ($list->id_servicio==$get_id->id_servicio) selected @endif>
                            {{ $list->nom_servicio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Proveedor:</label>
                <select class="form-control" name="id_proveedor_servicioe" id="id_proveedor_servicioe"
                onchange="Traer_Suministro('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_proveedor as $list)
                        <option value="{{ $list->id_proveedor_servicio }}"
                        @if ($list->id_proveedor_servicio==$get_id->id_proveedor_servicio) selected @endif>
                            {{ $list->nom_proveedor_servicio }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3 div_suministroe">
                <label>Suministro:</label>
                <select class="form-control" name="suministroe" id="suministroe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_suministro as $list)
                        <option value="{{ $list->id_datos_servicio }}"
                        @if ($list->id_datos_servicio==$get_id->suministro) selected @endif>
                            {{ $list->suministro }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Doc serie:</label>
                <input type="text" class="form-control" name="documento_seriee" id="documento_seriee" 
                placeholder="Doc serie" value="{{ $get_id->documento_serie }}">
            </div>

            <div class="form-group col-lg-3">
                <label>Doc número:</label>
                <input type="text" class="form-control" name="documento_numeroe" id="documento_numeroe" 
                placeholder="Doc número" value="{{ $get_id->documento_numero }}">
            </div>

            <div class="form-group col-lg-3">
                <label>Período:</label>
                <div class="input-group">
                    <select class="form-control" name="mese" id="mese">
                        @foreach ($list_mes as $list)
                            <option value="{{ $list->cod_mes }}" 
                            @if ($list->cod_mes==$get_id->mes) selected @endif>
                                {{ $list->abr_mes }}
                            </option>
                        @endforeach
                    </select>
                    <select class="form-control" name="anioe" id="anioe">
                        @foreach ($list_anio as $list)
                            <option value="{{ $list->cod_anio }}"
                            @if ($list->cod_anio==$get_id->anio) selected @endif>
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
                <input type="date" class="form-control" name="fec_emisione" id="fec_emisione" 
                value="{{ $get_id->fec_emision }}">
            </div>

            <div class="form-group col-lg-3">
                <label>Fecha vencimiento:</label>
                <input type="date" class="form-control" name="fec_vencimientoe" id="fec_vencimientoe"
                value="{{ $get_id->fec_vencimiento }}">
            </div>

            <div class="form-group col-lg-3">
                <label>Importe:</label>
                <input type="text" class="form-control" name="importee" id="importee" 
                placeholder="Importe" onkeypress="return solo_Numeros_Punto(event);" 
                onpaste="return false;" value="{{ $get_id->importe }}">
            </div>
        </div>

        <div id="div_lecturae">
            @if ($get_id->lectura=="1")
                <div class="row">     
                    <div class="form-group col-lg-12">
                        <h5 class="modal-title">Lectura</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label class=" control-label text-bold">Anterior: </label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" id="lant_datoe" name="lant_datoe" 
                        placeholder="Anterior" onkeypress="return solo_Numeros_Punto(event);"
                        value="{{ $get_id->lant_dato }}">
                    </div>

                    <div class="form-group col-lg-2">
                        <label class=" control-label text-bold">Fecha Anterior: </label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="date" class="form-control" id="lant_fechae" name="lant_fechae"
                        value="{{ $get_id->lant_fecha }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label class=" control-label text-bold">Actual: </label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" id="lact_datoe" name="lact_datoe" 
                        placeholder="Actual" onkeypress="return solo_Numeros_Punto(event);"
                        value="{{ $get_id->lact_dato }}">
                    </div> 
                    
                    <div class="form-group col-lg-2">
                        <label class=" control-label text-bold">Fecha Actual: </label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="date" class="form-control" id="lact_fechae" name="lact_fechae"
                        value="{{ $get_id->lact_fecha }}">
                    </div>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">Recibo: </label>
                @if ($get_id->documento!="")
                    <a href="{{ $get_id->documento }}" title="Recibo" target="_blank">
                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                        </svg>
                    </a>
                @endif
                <div class="drop-zone" id="drop-zonee">
                    <span>Arrastra y suelta el archivo aquí o haz clic para seleccionarlo</span>
                    <input type="file" id="documentoe" name="documentoe" accept=".jpg, .jpeg, .png, .pdf"
                    onchange="Valida_Archivo('documentoe');">
                </div>
            </div>

            <div id="div_doce" class="form-group col-lg-9 preview">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Registro_Servicio();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Funciones para manejar arrastrar y soltar
        const dropZone = document.getElementById('drop-zonee');
        const inputElement = document.getElementById('documentoe');

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
                    validarArchivoImgPrevisualizar('documentoe', 'div_doce');
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
            validarArchivoImgPrevisualizar('documentoe', 'div_doce');
        });
    });

    function Update_Registro_Servicio() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('registro_servicio.update', $get_id->id_gasto_servicio) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Registro_Servicio();
                        $("#ModalUpdateGrande .close").click();
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
