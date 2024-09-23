<style>
    .toggle-switch {
        position: relative;
        display: inline-block;
        height: 24px;
        margin: 10px;
    }

    .toggle-switch .toggle-input {
        display: none;
    }

    .toggle-switch .toggle-label {
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 24px;
        background-color: gray;
        border-radius: 34px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .toggle-switch .toggle-label::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        background-color: #fff;
        box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s;
    }

    .toggle-switch .toggle-input:checked+.toggle-label {
        background-color: #4CAF50;
    }

    .toggle-switch .toggle-input:checked+.toggle-label::before {
        transform: translateX(16px);
    }

    input[disabled] {
        background-color: white !important;
        color: black;
    }
</style>

<div class="toolbar d-md-flex align-items-md-center mt-3">



    <div class="toolbar col-md-12 row">
        <div class="form-group col-md-2">
            <label for="" class="control-label text-bold">F.Inicio</label>
            <input type="date" name="fini" id="fini" value="<?php echo date('Y-m-01') ?>" class="form-control">
        </div>
        <div class="form-group col-md-2">
            <label for="" class="control-label text-bold">F.Fin</label>
            <input type="date" name="ffin" id="ffin" value="<?php echo date('Y-m-d') ?>" class="form-control">
        </div>
        <div class="form-group col-md-1">
            <label for="" class="control-label text-bold">&nbsp;</label>

            <button class="btn btn-primary mb-2 mr-2 form-control" type="button" onclick="Buscar_Asignacion_Visita()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </div>



    </div>
</div>

@csrf
<div class="table-responsive mt-4" id="lista_registros_visitas">
</div>

<script>
    Lista_Reg_Visitas();

    function Lista_Reg_Visitas() {
        Cargando();

        var url = "{{ route('produccion_rv.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#lista_registros_visitas').html(resp);
            }
        });
    }



    function Delete_Proceso(id) {
        Cargando();

        var url = "{{ route('portalprocesos_cap.destroy', ':id') }}".replace(':id', id);
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
                            Lista_Reg_Visitas();
                        });
                    }
                });
            }
        })
    }



    function Buscar_Asignacion_Visita() {
        var csrfToken = $('input[name="_token"]').val();
        var fecha_inicio = $('#fini').val();
        var fecha_fin = $('#ffin').val();
        var url = "{{ url('Produccion/ListaAsignacionVisitas') }}/" + fecha_inicio + "/" + fecha_fin;

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#lista_asignacion_visita').html(data);
            }
        });
    }
</script>