<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar función temporal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Colaborador: </label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basic" name="id_usuarioe" id="id_usuarioe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_usuario as $list)
                        <option value="{{ $list->id_usuario }}"
                        @if ($list->id_usuario==$get_id->id_usuario) selected @endif>
                            {{ $list->nom_usuario }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipoe" id="id_tipoe" onchange="Tipo_Funcion_Temporal('e');">
                    <option value="0">Seleccione</option>
                    <option value="1" @if ($get_id->id_tipo==1) selected @endif>Función</option>
                    <option value="2" @if ($get_id->id_tipo==2) selected @endif>Tarea</option>
                </select>
            </div>
        </div>

        <div class="row" id="div_tipoe">
            @if ($get_id->id_tipo=="1")
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Función: </label> 
                </div>
                <div class="form-group col-lg-10">
                    <select class="form-control basic" id="tareae" name="tareae">
                        <option value="0">Seleccione</option> 
                        @foreach ($list_puesto as $list)
                            <option value="{{ $list->id_puesto }}"
                            @if ($list->id_puesto==$get_id->tarea) selected @endif>
                                {{ $list->nom_puesto }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Tipo de tarea: </label>
                </div>
                <div class="form-group col-lg-10">
                    <select class="form-control basic" id="select_tareae" name="select_tareae" onchange="Tarea_Otros('e');">
                        <option value="0">Seleccione</option>
                        @foreach ($list_tarea as $list)
                            <option value="{{ $list->id }}"
                            @if ($list->id==$get_id->select_tarea) selected @endif>
                                {{ $list->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-2 esconder">
                    <label class="control-label text-bold">Tarea: </label>
                </div>
                <div class="form-group col-lg-10 esconder">
                    <input type="text" class="form-control" id="tareae" name="tareae" placeholder="Ingresar tarea" value="{{ $get_id->tarea }}">
                </div>
            @endif
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha: </label>
            </div>
            <div class="form-group col-lg-4">
                <input class="form-control" type="date" name="fechae" id="fechae" value="{{ $get_id->fecha }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Hora de inicio: </label>
            </div>
            <div class="form-group col-lg-4">
                <input class="form-control" type="time" name="hora_inicioe" id="hora_inicioe" value="{{ $get_id->hora_inicio }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Hora de fin: </label>
            </div>
            <div class="form-group col-lg-4">
                <input class="form-control" type="time" name="hora_fine" id="hora_fine" value="{{ $get_id->hora_fin }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Funcion_Temporal();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    var ss = $(".basic").select2({
        tags: true,
    });

    $('.basic').select2({
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Funcion_Temporal(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ route('funcion_temporal.update', $get_id->id_funcion) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success:function (data) {
                swal.fire(
                    'Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Funcion_Temporal();
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