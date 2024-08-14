<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('precio_sugerido_conf_un.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>

@csrf
<div class="table-responsive mb-4 mt-4" id="lista_precio_uno">
</div>

<script>
    Lista_Precio_Uno();

    function Lista_Precio_Uno(){
        Cargando();

        var url = "{{ route('precio_sugerido_conf_un.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_precio_uno').html(resp);  
            }
        });
    }

    function solo_Numeros_Punto(e) {
        var key = event.which || event.keyCode;
        if ((key >= 48 && key <= 57) || key == 46) {
            if (key == 46 && event.target.value.indexOf('.') !== -1) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    function Delete_Precio_Uno(id) {
        Cargando();

        var url = "{{ route('precio_sugerido_conf_un.destroy', ':id') }}".replace(':id', id);
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
                            Lista_Precio_Uno();
                        });    
                    }
                });
            }
        })
    }
</script>