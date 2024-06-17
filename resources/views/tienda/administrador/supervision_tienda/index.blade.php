<div class="toolbar d-flex">
    <div class="col-lg-2">
        @if (session('usuario')->id_nivel==1 || session('usuario')->id_puesto==6 || 
        session('usuario')->id_puesto==12 || session('usuario')->id_puesto==19 || 
        session('usuario')->id_puesto==21 || session('usuario')->id_puesto==23 || 
        session('usuario')->id_puesto==38 || session('usuario')->id_puesto==81 || 
        session('usuario')->id_puesto==111 || session('usuario')->id_puesto==122 || 
        session('usuario')->id_puesto==137 || session('usuario')->id_puesto==164 || 
        session('usuario')->id_puesto==158 || session('usuario')->id_puesto==9 || 
        session('usuario')->id_puesto==128 || session('usuario')->id_puesto==27 || 
        session('usuario')->id_puesto==10)
            <label>Base:</label>
            <select class="form-control" id="base_ct" name="base_ct" onchange="Lista_Supervision_Tienda();">
                <option value="0">Todos</option>
                @foreach ($list_base as $list)
                    <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                @endforeach
            </select>
        @else
            <input type="hidden" id="base_ct" value="{{ session('usuario')->centro_labores }}">
        @endif
    </div>

    <div class="col-lg-10 d-flex justify-content-end align-items-center">
        @if (session('usuario')->id_puesto==161 || session('usuario')->id_puesto==197 || 
        session('usuario')->id_puesto==29 || session('usuario')->id_puesto==311)
            <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="<?= site_url('Tienda/Modal_Supervision_Tienda') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                Registrar
            </button>
        @elseif (session('usuario')->id_nivel==1 || session('usuario')->id_puesto==6 || 
        session('usuario')->id_puesto==12 || session('usuario')->id_puesto==19 || 
        session('usuario')->id_puesto==21 || session('usuario')->id_puesto==23 || 
        session('usuario')->id_puesto==38 || session('usuario')->id_puesto==81 || 
        session('usuario')->id_puesto==111 || session('usuario')->id_puesto==122 || 
        session('usuario')->id_puesto==137 || session('usuario')->id_puesto==164 || 
        session('usuario')->id_puesto==158 || session('usuario')->id_puesto==9 || 
        session('usuario')->id_puesto==128 || session('usuario')->id_puesto==27 || 
        session('usuario')->id_puesto==10)
            <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('administrador_conf_st.create', 1) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                Registrar
            </button>
        @endif
    </div>
</div>

@csrf
<div class="table-responsive mb-4 mt-4" id="lista_supervision_tienda">
</div>

<script>
    Lista_Supervision_Tienda();

    function Lista_Supervision_Tienda(){
        Cargando();

        var base = $("#base_ct").val();
        var url = "{{ route('administrador_st.list') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'base': base},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#lista_supervision_tienda').html(resp);  
            }
        });
    }

    function Delete_C_Supervision_Tienda(id) {
        Cargando();

        var url = "{{ route('administrador_conf_st.destroy', ':id') }}".replace(':id', id);
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
                    data: {'id':id},
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_C_Supervision_Tienda();
                        });    
                    }
                });
            }
        })
    }
</script>