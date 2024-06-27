<form id="formulariod" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar propósito, funciones y competencias:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Próposito: </label>
                <button class="btn btn-primary btn-sm" onclick="Update_Proposito();" type="button">Actualizar</button>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-12">
                <textarea name="propositod" rows="4" class="form-control" id="propositod" maxlength="250" placeholder="Ingresar propósito">{{ $get_id->proposito }}</textarea>
            </div>
        </div>

        <div class="row mt-4">
            <div class="form-group col-lg-12" id="boton_funcion">
                <label class="control-label text-bold">Funciones: </label>
                <button class="btn btn-danger btn-sm" onclick="Insert_Funcion();" type="button">Agregar</button>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-12" id="editar_funcion">
                <input type="text" class="form-control" id="nom_funciond" name="nom_funciond" placeholder="Ingresar función">
            </div>
        </div>
        <div class="row">
            <div class="table-responsive" id="lista_funcion">
            </div>
        </div>

        <div class="row mt-4">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Competencias:</label>
                <button class="btn btn-danger btn-sm" onclick="Insert_Competencia();" type="button">Agregar</button>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-12">
                <select class="form-control" id="id_competenciad" name="id_competenciad">
                    <option value="0">Seleccione</option>
                    @foreach ($list_competencia as $list)
                        <option value="{{ $list->id_competencia }}">{{ $list->nom_competencia }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive" id="lista_competencia">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    Lista_Funcion();
    Lista_Competencia();

    function Lista_Funcion(){
        Cargando();

        var id_puesto = {{ $get_id->id_puesto }}
        var url = "{{ route('colaborador_conf_pu.list_funcion') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {'id_puesto':id_puesto},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#lista_funcion').html(data);
            }
        });
    }
    
    function Lista_Competencia() {
        Cargando();

        var id_puesto = {{ $get_id->id_puesto }}
        var url = "{{ route('colaborador_conf_pu.list_competencia') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {'id_puesto':id_puesto},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },            
            success: function(data) {
                $('#lista_competencia').html(data);
            }
        });
    }

    function Update_Proposito() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulariod'));
        var url = "{{ route('colaborador_conf_pu.update_proposito', $get_id->id_puesto) }}";

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
                    console.log('Propósito actualizado');
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

    function Insert_Funcion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulariod'));
        var url = "{{ route('colaborador_conf_pu.insert_funcion', $get_id->id_puesto) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    '¡Registro Exitoso!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Funcion();
                    $('#nom_funciond').val('');
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

    function Editar_Funcion(id) {
        Cargando();

        var url = "{{ route('colaborador_conf_pu.edit_funcion', ':id') }}".replace(':id', id);

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                $('#editar_funcion').html(data);
                $('#boton_funcion').html('<label class="control-label text-bold">Funciones:</label><button class="btn btn-primary btn-sm" onclick="Update_Funcion();" type="button">Actualizar</button>');
            }
        });
    }

    function Update_Funcion(){
        Cargando();

        var id_funcion = $('#id_funcion').val();
        var dataString = new FormData(document.getElementById('formulariod'));
        var url = "{{ route('colaborador_conf_pu.update_funcion', ':id') }}".replace(':id', id_funcion);

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
                    Lista_Funcion();
                    $('#nom_funciond').val('');
                    $('#boton_funcion').html('<label class="control-label text-bold">Funciones:</label><button class="btn btn-danger btn-sm" onclick="Insert_Funcion();" type="button">Agregar</button>');
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

    function Delete_Funcion(id) {
        Cargando();

        var url = "{{ route('colaborador_conf_pu.delete_funcion', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Funcion();
                        });
                    }
                });
            }
        })
    }

    function Insert_Competencia() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulariod'));
        var url = "{{ route('colaborador_conf_pu.insert_competencia', $get_id->id_puesto) }}";

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
                        Lista_Competencia();
                        $('#id_competenciad').val('0');
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

    function Delete_Competencia(id) {
        Cargando();

        var url = "{{ route('colaborador_conf_pu.delete_competencia', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Competencia();
                        });
                    }
                });
            }
        })
    }
</script>