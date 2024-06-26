<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo puesto:</h5>
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
                <select class="form-control" name="id_direccion" id="id_direccion" onchange="Traer_Gerencia('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_direccion as $list)
                        <option value="{{ $list->id_direccion }}">{{ $list->direccion }}</option>
                    @endforeach
                </select>
            </div>
        </div>  

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Gerencia:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_gerencia" id="id_gerencia" onchange="Traer_Sub_Gerencia('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>  

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Departamento:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_sub_gerencia" id="id_sub_gerencia" onchange="Traer_Area('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Área:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_area" id="id_area">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Nivel Jerárquico:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_nivel" id="id_nivel">
                    <option value="0">Seleccione</option>
                    @foreach ($list_nivel as $list)
                        <option value="{{ $list->id_nivel }}">{{ $list->nom_nivel }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Sede Laboral:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_sede_laboral" id="id_sede_laboral">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sede_laboral as $list)
                        <option value="{{ $list->id }}">{{ $list->descripcion }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cantidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Ingresar Cantidad" onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="nom_puesto" name="nom_puesto" placeholder="Ingresar Descripción">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Puesto();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Puesto() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('colaborador_conf_pu.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Puesto();
                        $("#ModalRegistro .close").click();
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