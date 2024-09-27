<form id="formulariod" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Detalle de requisición tienda:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        @if ($get_id->estado_registro=="1" ||
        session('usuario')->id_nivel == "1" ||
        session('usuario')->id_puesto == "128")
            <div id="detalle" class="row">
            </div>
        @endif

        <div id="lista_detalle" class="row">
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    Lista_Detalle();
    Cancelar_Detalle();

    function Lista_Detalle(){
        Cargando();

        var url = "{{ route('requisicion_tienda.list_detalle', $get_id->id_requisicion) }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_detalle').html(resp);  
            }
        });
    }

    function Insert_Detalle(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulariod'));
        var url = "{{ route('requisicion_tienda.store_detalle', $get_id->id_requisicion) }}";

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
                        $('#stockd').val('');
                        $('#cantidadd').val('');
                        $('#id_productod').val('0');
                        $('#preciod').val('');
                        $('#archivod').val('');
                        $(".basic").select2({
                            dropdownParent: $('#ModalRegistroGrande')
                        });
                        Lista_Detalle();
                        Lista_Requisicion_Tienda();
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

    function Editar_Detalle(id){
        Cargando();

        var url = "{{ route('requisicion_tienda.edit_detalle', ':id') }}".replace(':id', id);

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#detalle').html(resp);  
            }
        });
    }

    function Cancelar_Detalle(){
        Cargando();

        var url = "{{ route('requisicion_tienda.cancelar_detalle') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#detalle').html(resp);  
            }
        });
    }

    function Update_Detalle(id){
        Cargando();

        var dataString = new FormData(document.getElementById('formulariod'));
        var url = "{{ route('requisicion_tienda.update_detalle', ':id') }}".replace(':id', id);

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
                        Lista_Detalle();
                        Cancelar_Detalle();
                        Lista_Requisicion_Tienda();
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

    function Delete_Detalle(id) {
        Cargando();

        var url = "{{ route('requisicion_tienda.destroy_detalle', ':id') }}".replace(':id', id);

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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if(data=="error"){
                            Swal({
                                title: '¡Eliminación Denegada!',
                                text: "¡No puede eliminar todos los productos!",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            });
                        }else{
                            Swal(
                                '¡Eliminado!',
                                'El registro ha sido eliminado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                Lista_Detalle();
                                Lista_Requisicion_Tienda();
                            });  
                        }  
                    }
                });
            }
        })
    }
</script>
