<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('colaborador_conf_ca.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>

@csrf
<div class="table-responsive mb-4 mt-4" id="lista_cargo">
</div>

<script>
    Lista_Cargo();

    function Lista_Cargo(){
        Cargando();

        var url = "{{ route('colaborador_conf_ca.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_cargo').html(resp);  
            }
        });
    }

    function Traer_Gerencia(v){
        Cargando();

        var url = "{{ route('colaborador_conf.traer_gerencia') }}";
        var id_direccion = $('#id_direccion'+v).val();
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'id_direccion':id_direccion},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#id_gerencia'+v).html(resp);
                $('#id_sub_gerencia'+v).html('<option value="0">Seleccione</option>');
                $('#id_area'+v).html('<option value="0">Seleccione</option>'); 
                $('#id_puesto'+v).html('<option value="0">Seleccione</option>'); 
            }
        });
    }

    function Traer_Sub_Gerencia(v){
        Cargando();

        var url = "{{ route('colaborador_conf.traer_sub_gerencia') }}";
        var id_gerencia = $('#id_gerencia'+v).val();
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'id_gerencia':id_gerencia},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#id_sub_gerencia'+v).html(resp);
                $('#id_area'+v).html('<option value="0">Seleccione</option>');
                $('#id_puesto'+v).html('<option value="0">Seleccione</option>'); 
            }
        });
    }

    function Traer_Area(v){
        Cargando();

        var url = "{{ route('colaborador_conf.traer_area') }}";
        var id_sub_gerencia = $('#id_sub_gerencia'+v).val();
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'id_sub_gerencia':id_sub_gerencia},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#id_area'+v).html(resp); 
                $('#id_puesto'+v).html('<option value="0">Seleccione</option>'); 
            }
        });
    }

    function Traer_Puesto(v){
        Cargando();

        var url = "{{ route('colaborador_conf.traer_puesto') }}";
        var id_area = $('#id_area'+v).val();
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'id_area':id_area},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#id_puesto'+v).html(resp); 
            }
        });
    }

    function Delete_Cargo(id) {
        Cargando();

        var url = "{{ route('colaborador_conf_ca.destroy', ':id') }}".replace(':id', id);
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
                            Lista_Cargo();
                        });    
                    }
                });
            }
        })
    }
</script>