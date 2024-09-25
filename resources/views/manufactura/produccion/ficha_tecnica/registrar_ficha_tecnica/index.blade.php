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
            <label for="" class="control-label text-bold">&nbsp;</label>
            <button type="button" class="btn btn-primary mb-2 mr-2 form-control" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('produccion_ft.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                Registrar
            </button>
        </div>


    </div>
</div>

@csrf
<div class="table-responsive mt-4" id="lista_asignacion_visita">
</div>

<script>
    Lista_Ficha_Tecnica();

    function Lista_Ficha_Tecnica() {
        Cargando();

        var url = "{{ route('produccion_ft.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#lista_asignacion_visita').html(resp);
            }
        });
    }



    function Delete_Ficha_Tecnica(id) {
        Cargando();

        var url = "{{ route('produccion_ft.destroy', ':id') }}".replace(':id', id);
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
                            Lista_Ficha_Tecnica();
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
        var url = "{{ url('Produccion/ListaRegistroVisitas') }}/" + fecha_inicio + "/" + fecha_fin;

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

    function Delete_Asignacion(id) {
        Cargando();

        var url = "{{ route('produccion_av.destroy', ':id') }}".replace(':id', id);
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
                            Lista_Ficha_Tecnica();
                        });
                    }
                });
            }
        })
    }
</script>