<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar entrada de insumo:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Insumo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_insumoe" id="id_insumoe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_insumo as $list)
                        <option value="{{ $list->id_insumo }}"
                        @if ($list->id_insumo==$get_id->id_insumo) selected @endif>
                            {{ $list->nom_insumo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Proveedor:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_proveedore" id="id_proveedore">
                    <option value="0">Seleccione</option>
                    @foreach ($list_proveedor as $list)
                        <option value="{{ $list->id_proveedor }}"
                        @if ($list->id_proveedor==$get_id->id_proveedor) selected @endif>
                            {{ $list->nombre_proveedor }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cantidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cantidade" id="cantidade" 
                placeholder="Cantidad" onkeypress="return solo_Numeros(event);" 
                value="{{ $get_id->cantidad }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fecha_contometroe" id="fecha_contometroe"
                value="{{ $get_id->fecha_contometro }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">N° factura:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_facturae" id="n_facturae" 
                placeholder="N° factura" value="{{ $get_id->n_factura }}">
            </div>

            <div class="form-group col-lg-2">
                <label>Factura:</label>
                @if ($get_id->factura!="")
                    <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Archivo({{ $get_id->id_contometro }},1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                            <polyline points="8 17 12 21 16 17"></polyline>
                            <line x1="12" y1="12" x2="12" y2="21"></line>
                            <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                        </svg>
                    </a>
                @endif
            </div>
            <div class="form-group col-lg-4">
                <input type="file" class="form-control-file" name="facturae" id="facturae" 
                onchange="Valida_Archivo('facturae');">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">N° guía:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_guiae" id="n_guiae" 
                placeholder="N° guía" value="{{ $get_id->n_guia }}">
            </div>

            <div class="form-group col-lg-2">
                <label>N° guía:</label>
                @if ($get_id->guia!="")
                    <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Archivo({{ $get_id->id_contometro }},2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                            <polyline points="8 17 12 21 16 17"></polyline>
                            <line x1="12" y1="12" x2="12" y2="21"></line>
                            <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                        </svg>
                    </a>
                @endif
            </div>
            <div class="form-group col-lg-4">
                <input type="file" class="form-control-file" name="guiae" id="guiae" 
                onchange="Valida_Archivo('guiae');">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Entrada_Insumo();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Entrada_Insumo() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('insumo_en.update', $get_id->id_contometro) }}";

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
                    Lista_Entrada_Insumo();
                    $("#ModalUpdate .close").click();
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