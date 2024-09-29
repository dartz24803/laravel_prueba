<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar requisición tienda:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            @if (session('usuario')->id_nivel == "1" ||
            session('usuario')->id_puesto == "128")
                <div class="form-group col-lg-2">
                    <label>Coordinador:</label>
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
            @else
                <input type="hidden" name="id_usuarioe" value="{{ $get_id->id_usuario }}">
            @endif                
        </div>

        <div class="row">
            @if (session('usuario')->id_nivel == "1")
                <div class="form-group col-lg-2">
                    <label>Fecha:</label>
                </div>
                <div class="form-group col-lg-4">
                    <input type="date" class="form-control" name="fechae" id="fechae" 
                    value="{{ $get_id->fecha }}">
                </div>
            @else
                <input type="hidden" name="fechae" value="{{ $get_id->fecha }}">
            @endif
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Requisicion_Tienda();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Requisicion_Tienda() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('requisicion_tienda.update', $get_id->id_requisicion) }}";

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
                        text: "¡Ya existe un registro para el mes y base seleccionado!",
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
                        Lista_Requisicion_Tienda();
                        $("#ModalUpdate .close").click();
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
