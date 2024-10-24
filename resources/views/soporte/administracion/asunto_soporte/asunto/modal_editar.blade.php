<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Asunto:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Elemento:</label>
                <select class="form-control" name="id_elementoe" id="id_elementoe">
                    @foreach ($list_elementos as $list)
                    <option value="{{ $list->idsoporte_elemento }}" {{ $list->idsoporte_elemento == $get_id->idsoporte_elemento ? 'selected' : '' }}>
                        {{ $list->nombre }}
                    </option>
                    @endforeach
                </select>

            </div>
            <div class="form-group col-lg-6">
                <label>Tipo de Soporte:</label>
                <select class="form-control" name="tipo_soportee" id="tipo_soportee">
                    @foreach ($list_tipo as $list)
                    <option value="{{ $list->idsoporte_tipo }}" {{ $list->idsoporte_tipo == $get_id->idsoporte_tipo ? 'selected' : '' }}>
                        {{ $list->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-12">
                <label>Área Responsable:</label>
                <select class="form-control multivalue" name="id_areaee[]" id="id_areaee" multiple="multiple">
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id_area }}"
                        @if(in_array($list->id_area, explode(',', $get_id->id_area))) selected @endif>
                        {{ $list->nom_area }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-12">
                <label for="nom_asunte">Nombre Asunto:</label>
                <input type="text" class="form-control" id="nom_asunte" name="nom_asunte"
                    value="{{ $get_id->nombre }}">
            </div>

            <div class="form-group col-lg-12">
                <label for="descripcione">Descripción:</label>
                <textarea name="descripcione" id="descripcione" cols="1" rows="2" class="form-control">{{ $get_id->descripcion }}</textarea>

            </div>
        </div>

    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Update_Asunto();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Asunto() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('soporte_asunto_conf.update', $get_id->idsoporte_asunto) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Asuntos();
                        $("#ModalUpdate .close").click();
                    });
                }
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