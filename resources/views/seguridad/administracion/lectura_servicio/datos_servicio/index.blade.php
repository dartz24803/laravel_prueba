<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('lectura_servicio_conf_da.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>

@csrf
<div class="table-responsive mb-4 mt-4" id="lista_datos_servicio">
</div>

<script>
    Lista_Datos_Servicio();

    function Lista_Datos_Servicio(){
        Cargando();

        var url = "{{ route('lectura_servicio_conf_da.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_datos_servicio').html(resp);  
            }
        });
    }

    function Traer_Servicio(v){
        Cargando();

        var url = "{{ route('lectura_servicio_conf_da.traer_servicio') }}";
        var cod_base = $('#cod_base'+v).val();
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'cod_base':cod_base},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#id_servicio'+v).html(resp);
                $('#id_proveedor_servicio'+v).html('<option value="0">Seleccione</option>'); 
            }
        });
    }

    function Traer_Proveedor_Servicio(v){
        Cargando();

        var url = "{{ route('lectura_servicio_conf_da.traer_proveedor_servicio') }}";
        var cod_base = $('#cod_base'+v).val();
        var id_servicio = $('#id_servicio'+v).val();
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'cod_base':cod_base,'id_servicio':id_servicio},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#id_proveedor_servicio'+v).html(resp);
            }
        });
    }

    function solo_Numeros(e) {
        var key = event.which || event.keyCode;
        if (key >= 48 && key <= 57) {
            return true;
        } else {
            return false;
        }
    }

    function Delete_Datos_Servicio(id) {
        Cargando();

        var url = "{{ route('lectura_servicio_conf_da.destroy', ':id') }}".replace(':id', id);
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
                            Lista_Datos_Servicio();
                        });    
                    }
                });
            }
        })
    }
</script>