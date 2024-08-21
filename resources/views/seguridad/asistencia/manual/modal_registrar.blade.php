<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar asistencia:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">
            </div>

            @if (session('usuario')->id_puesto==23 ||
            session('usuario')->id_puesto==24 ||
            session('usuario')->id_nivel==1)
                <div class="form-group col-lg-2">
                    <label>Base:</label>
                </div>
                <div class="form-group col-lg-4">
                    <select class="form-control" name="cod_base" id="cod_base" onchange="Traer_Colaborador('');">
                        <option value="0">Seleccione</option>
                        @foreach ($list_base as $list)
                            <option value="{{ $list->cod_base }}"
                            @if ($list->cod_base==session('usuario')->centro_labores) selected @endif>
                                {{ $list->cod_base }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="cod_base" id="cod_base" value="{{ session('usuario')->centro_labores }}">
            @endif
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Colaborador:</label>
            </div>
            <div class="form-group col-lg-10">
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                        <input type="checkbox" class="new-control-input" id="todos" name="todos" value="1" onchange="Todos();">
                        <span class="new-control-indicator"></span>Seleccionar todos
                    </label>
                </div>
                <select class="form-control multivalue" name="id_colaborador[]" id="id_colaborador" multiple="multiple">
                    @foreach ($list_colaborador as $list)
                        <option value="{{ $list->id_usuario }}">{{ $list->nom_usuario }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Sede:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="cod_sede" id="cod_sede">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}"
                        @if ($list->cod_base==session('usuario')->centro_labores) selected @endif>
                            {{ $list->cod_base }}
                        </option> 
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Hora Ingreso:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="time" class="form-control" name="h_ingreso" id="h_ingreso" value="{{ date('H:i') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Observación:</label>
            </div>
            <div class="form-group col-lg-10">
                <textarea class="form-control" name="observacion" id="observacion" rows="4" placeholder="Ingresar observación"></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Manual();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Todos(){
        if ($("#todos").is(":checked")) { 
            $('#id_colaborador').prop('disabled', true);
            Traer_Colaborador('');
        }else{
            $('#id_colaborador').prop('disabled', false);
        }
    }

    function Insert_Manual() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('asistencia_seg_man.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    'Registro Exitoso!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Manual();
                    $("#ModalRegistro .close").click();
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