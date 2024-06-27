<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo cargo:</h5>
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
                <select class="form-control" name="id_area" id="id_area" onchange="Traer_Puesto('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Puesto:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_puesto" id="id_puesto">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="nom_cargo" name="nom_cargo" placeholder="Ingresar Descripción">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Cargo();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Cargo() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('colaborador_conf_ca.store') }}";

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
                        Lista_Cargo();
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