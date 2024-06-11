<div class="d-flex justify-content-between align-items-center mt-2">
    <div class="form-group col-lg-2">
        <label>Base: </label>
        <select class="form-control basic" id="base" name="base" onchange="Lista_Horarios_Cuadro_Control();">
            <option value="0" selected>Todas</option>
            <?php foreach ($list_bases as $list) { ?>
                <option value="<?php echo $list['cod_base']; ?>">
                    <?php echo $list['cod_base']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-lg-10 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Modal_Horarios_Cuadro_Control') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Registrar
        </button>
    </div>
</div>
@csrf
<div class="table-responsive mb-4 mt-4" id="lista_horarios_cuadro_control">
</div>

<script>
    Lista_Horarios_Cuadro_Control();

    function Lista_Horarios_Cuadro_Control() {
        Cargando();

        var base = $('#base').val();
        var url = "{{ url('Lista_Horarios_Cuadro_Control') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'base': base
            },
            success: function(resp) {
                $('#lista_horarios_cuadro_control').html(resp);
            }
        });
    }

    function Delete_Horarios_Cuadro_Control(id) {
        Cargando();

        var csrfToken = $('input[name="_token"]').val();
        var url = "{{ url('Delete_Horarios_Cuadro_Control') }}";

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id': id
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Horarios_Cuadro_Control();
                        });
                    }
                });
            }
        })
    }
</script>
<style>
    #zero-config_length, #zero-config_info{
        padding: 1rem;
    }
</style>
