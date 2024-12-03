<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar puesto:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Área:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basice" name="id_areae" id="id_areae" 
                onchange="Traer_Puesto('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                        <option value="{{ $list->id_area }}"
                        @if ($list->id_area==$get_id->id_area) selected @endif>
                            {{ $list->nom_area }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Puesto:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basice" name="id_puestoe" id="id_puestoe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_puesto as $list)
                        <option value="{{ $list->id_puesto }}"
                        @if ($list->id_puesto==$get_id->id_puesto) selected @endif>
                            {{ $list->nom_puesto }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Centro de labor:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_centro_labore" id="id_centro_labore">
                    <option value="0">Seleccione</option>
                    @foreach ($list_ubicacion as $list)
                        <option value="{{ $list->id_ubicacion }}"
                        @if ($list->id_ubicacion==$get_id->id_centro_labor) selected @endif>
                            {{ $list->cod_ubi }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>	 	           	                	        
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Organigrama();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basice").select2({
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Organigrama() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('colaborador_conf_or.update', $get_id->id) }}";

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
                    Lista_Organigrama();
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