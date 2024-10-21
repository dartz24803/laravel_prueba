<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar observación:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Tipo de error:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_errore" id="id_tipo_errore" onchange="Traer_Error('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_error as $list)
                    <option value="{{ $list->id_tipo_error }}"
                        @if ($list->id_tipo_error==$get_id->id_tipo_error) selected @endif>
                        {{ $list->nom_tipo_error }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Error:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_errore" id="id_errore" onchange="Traer_Datos_Error('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_error as $list)
                    <option value="{{ $list->id_error }}"
                        @if ($list->id_error==$get_id->id_error) selected @endif>
                        {{ $list->nom_error }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="div_montoe" class="row">
            @if ($get_error->monto=="1")
            <div class="form-group col-lg-2">
                <label>Monto:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="montoe" name="montoe" placeholder="Ingresar monto" data-type="currency"
                    onkeypress="return solo_Numeros_Punto(event);" value="{{ $get_id->monto }}">
            </div>
            @endif

            @if ($get_error->archivo=="1")
            <div class="form-group col-lg-2">
                <label>Archivo:</label>
                @if ($get_id->archivo!="")
                <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Archivo({{ $get_id->id_suceso }});">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                        <polyline points="8 17 12 21 16 17"></polyline>
                        <line x1="12" y1="12" x2="12" y2="21"></line>
                        <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                    </svg>
                </a>
                @endif
            </div>
            <div class="form-group col-lg-4">
                <input type="file" class="form-control-file" name="archivoe" id="archivoe" onchange="Valida_Archivo('archivoe');">
            </div>
            @endif
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                @if (session('usuario')->id_puesto=="29" ||
                session('usuario')->id_puesto=="31" ||
                session('usuario')->id_puesto=="32" ||
                session('usuario')->id_puesto=="167" ||
                session('usuario')->id_puesto=="161" ||
                session('usuario')->id_puesto=="197")
                <input type="text" class="form-control" name="cod_basee" id="cod_basee" value="{{ $get_id->centro_labores }}" readonly>
                @else
                <select class="form-control" name="cod_basee" id="cod_basee" onchange="Traer_Responsable('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                    <option value="{{ $list->cod_base }}"
                        @if ($list->cod_base==$get_id->centro_labores) selected @endif>
                        {{ $list->cod_base }}
                    </option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Responsable: </label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control multivalue" name="responsablese[]" id="responsablese" multiple="multiple">
                    @php $base_array = explode(",",$get_id->user_suceso) @endphp
                    @foreach ($list_responsable as $list)
                    <option value="{{ $list->id_usuario }}"
                        @php if(in_array($list->id_usuario,$base_array)){ echo "selected"; } @endphp>
                        {{ $list->nom_usuario }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Suceso: </label>
            </div>
            <div class="form-group col-lg-10">
                <textarea name="nom_sucesoe" id="nom_sucesoe" class="form-control" rows="4" placeholder="Ingresar suceso">{{ $get_id->nom_suceso }}</textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Observacion();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalUpdate')
    });

    $("input[data-type='currency']").on({
        keyup: function() {
            formatCurrency($(this));
        },
        blur: function() {
            formatCurrency($(this), "blur");
        }
    });

    function formatCurrency(input, blur) {
        var input_val = input.val();
        if (input_val === "") {
            return;
        }
        var original_len = input_val.length;
        var caret_pos = input.prop("selectionStart");

        if (input_val.indexOf(".") >= 0) {
            var decimal_pos = input_val.indexOf(".");
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            left_side = formatNumber(left_side);
            right_side = formatNumber(right_side);

            if (blur === "blur") {
                right_side += "00";
            }

            right_side = right_side.substring(0, 2);
            input_val = left_side + "." + right_side;
        } else {
            input_val = formatNumber(input_val);
            input_val = input_val;

            if (blur === "blur") {
                input_val += ".00";
            }
        }

        input.val(input_val);
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    function formatNumber(n) {
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }

    function Update_Observacion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('observacion.update', $get_id->id_suceso) }}";

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
                    Lista_Observacion();
                    $("#ModalUpdate .close").click();
                });
            },
            error: function(xhr) {
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