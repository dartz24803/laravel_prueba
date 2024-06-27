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
                <label>Dirección:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_direccione" id="id_direccione" onchange="Traer_Gerencia('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_direccion as $list)
                        <option value="{{ $list->id_direccion }}" @if ($list->id_direccion==$get_id->id_direccion) selected @endif>{{ $list->direccion }}</option>
                    @endforeach
                </select>
            </div>
        </div>  

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Gerencia:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_gerenciae" id="id_gerenciae" onchange="Traer_Sub_Gerencia('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_gerencia as $list)
                        <option value="{{ $list->id_gerencia }}" @if ($list->id_gerencia==$get_id->id_gerencia) selected @endif>{{ $list->nom_gerencia }}</option>
                    @endforeach
                </select>
            </div>
        </div>  

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Departamento:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_sub_gerenciae" id="id_sub_gerenciae" onchange="Traer_Area('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sub_gerencia as $list)
                        <option value="{{ $list->id_sub_gerencia }}" @if ($list->id_sub_gerencia==$get_id->id_departamento) selected @endif>{{ $list->nom_sub_gerencia }}</option>
                    @endforeach
                </select>
            </div>
        </div>  

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Área:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_areae" id="id_areae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                        <option value="{{ $list->id_area }}" @if ($list->id_area==$get_id->id_area) selected @endif>{{ $list->nom_area }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Nivel Jerárquico:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_nivele" id="id_nivele">
                    <option value="0">Seleccione</option>
                    @foreach ($list_nivel as $list)
                        <option value="{{ $list->id_nivel }}" @if ($list->id_nivel==$get_id->id_nivel) selected @endif>{{ $list->nom_nivel }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Sede Laboral:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_sede_laborale" id="id_sede_laborale">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sede_laboral as $list)
                        <option value="{{ $list->id }}" @if ($list->id==$get_id->id_sede_laboral) selected @endif>{{ $list->descripcion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="nom_puestoe" name="nom_puestoe" placeholder="Ingresar Descripción" value="{{ $get_id->nom_puesto }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Puesto();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Puesto() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('colaborador_conf_pu.update', $get_id->id_puesto) }}";

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
                        Lista_Puesto();
                        $("#ModalUpdate .close").click();
                    });  
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