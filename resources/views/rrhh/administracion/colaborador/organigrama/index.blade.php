<div class="row mr-1 ml-1 mt-2">
    <div class="col-lg-3 col-xl-2 mb-3">
        <label>Puesto:</label>
        <select class="form-control basicb" name="id_puestob" id="id_puestob" 
        onchange="Lista_Organigrama();">
            <option value="0">Todos</option>
            @foreach ($list_puesto as $list)
                <option value="{{ $list->id_puesto }}">{{ $list->nom_puesto }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-3 col-xl-2 mb-3">
        <label>Centro de labor:</label>
        <select class="form-control" name="id_centro_laborb" id="id_centro_laborb" 
        onchange="Lista_Organigrama();">
            <option value="0">Todos</option>
            @foreach ($list_ubicacion as $list)
                <option value="{{ $list->id_ubicacion }}">{{ $list->cod_ubi }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-6 col-xl-8 d-lg-flex align-items-center">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('colaborador_conf_or.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Registrar
        </button>
    </div>
</div>

<div class="table-responsive mb-4" id="lista_organigrama">
</div>

<script>
    $(".basicb").select2({
        tags: true
    });

    function solo_Numeros(e) {
        var key = event.which || event.keyCode;
        if (key >= 48 && key <= 57) {
            return true;
        } else {
            return false;
        }
    }

    Lista_Organigrama();

    function Lista_Organigrama(){
        Cargando();

        var url = "{{ route('colaborador_conf_or.list') }}";
        var id_puesto = $('#id_puestob').val();
        var id_centro_labor = $('#id_centro_laborb').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'id_puesto':id_puesto,'id_centro_labor':id_centro_labor},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(resp) {
                $('#lista_organigrama').html(resp);
            }
        });
    }

    function Traer_Puesto(v){
        Cargando();

        var url = "{{ route('colaborador_conf.traer_puesto') }}";
        var id_area = $('#id_area'+v).val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'id_area':id_area},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                $('#id_puesto'+v).html(resp);
                if(id_area=="14"){
                    $('.ocultar'+v).show();
                }else{
                    $('.ocultar'+v).hide();
                }
            }
        });
    }

    function Delete_Organigrama(id) {
        Cargando();

        var url = "{{ route('colaborador_conf_or.destroy', ':id') }}".replace(':id', id);

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
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Organigrama();
                        });
                    }
                });
            }
        })
    }
</script>