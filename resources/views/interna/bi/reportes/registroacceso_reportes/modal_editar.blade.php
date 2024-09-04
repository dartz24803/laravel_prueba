<!-- CSS -->
<style>
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }

    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field:disabled {
        background-color: transparent !important;

    }


    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }



    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4f46e5;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }
</style>
<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">

    <div class="modal-header">
        <h5 class="modal-title">Editar Accesos de Reporte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style=" max-height:450px;  overflow:auto;">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="documento-tab" data-toggle="tab" href="#documento" role="tab" aria-controls="documento" aria-selected="true">Documento</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="accesos-tab" data-toggle="tab" href="#accesos" role="tab" aria-controls="accesos" aria-selected="false">Accesos</a>
            </li>

        </ul>

        <!-- Tab content -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="documento" role="tabpanel" aria-labelledby="documento-tab">
                <div class="row" id="cancel-row" style="flex: 1;">
                    <div class="col-xl-12 col-lg-12 p-3 col-sm-12 layout-spacing">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Reporte Nombre: </label>
                                <input type="text" class="form-control" id="nombrea" name="nombrea" value="{{ $get_id->nom_reporte }}">
                            </div>

                            <div class="form-group col-lg-8">
                                <label>Iframe:</label>
                                <textarea name="iframea" id="iframea" cols="1" rows="5" class="form-control">{{ $get_id->iframe }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="accesos" role="tabpanel" aria-labelledby="accesos-tab">

                <div class="row d-flex col-md-12 my-2">

                    <div class="form-group col-md-12">

                        <div class="col-12 text-center">
                            <label class="control-label text-bold centered-label"> Accesos</label>
                            <!-- <div>
                                <label class="control-label text-bold">Todos</label>

                                <label class="switch">
                                    <input type="checkbox" id="acceso_todo" name="acceso_todo"  checked>
                                    <span class="slider"></span>
                                </label>
                            </div> -->
                            <div class="divider"></div>

                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Acceso Área: </label>
                            <select class="form-control multivalue" name="id_area_p[]" id="id_area_p" multiple="multiple" disabled>
                                @foreach ($list_area as $area)
                                <option value="{{ $area->id_area }}"
                                    {{ in_array($area->id_area, $selected_area_ids) ? 'selected' : '' }}>
                                    {{ $area->nom_area }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Acceso Puesto: </label>
                            <select class="form-control multivalue" name="tipo_acceso_p[]" id="tipo_acceso_p" multiple="multiple" disabled>
                                @foreach ($list_responsable as $puesto)
                                <option value="{{ $puesto->id_puesto }}"
                                    @if(in_array($puesto->id_puesto, $selected_puesto_ids)) selected @endif>
                                    {{ $puesto->nom_puesto }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>


            </div>

        </div>

    </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <input type="hidden" id="capturae" name="capturae">
        <button id="boton_disablede" class="btn btn-primary" type="button" onclick="Update_ReporteBI();">Guardar</button>
        <button class=" btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>


<script>
    $('#id_area_p').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownParent: $('#ModalUpdate')
    });
    $('#tipo_acceso_p').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownParent: $('#ModalUpdate')
    });
    $('#id_area_acceso_e').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownParent: $('#ModalUpdate')
    });
    $('#tipo_acceso_e').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownParent: $('#ModalUpdate')
    });
    $(document).ready(function() {

        $('#id_area_acceso_e').on('change', function() {
            const selectedAreas = $(this).val();
            var url = "{{ route('puestos_por_areas') }}";
            console.log('Selected Areas:', selectedAreas); // Para verificar que los valores se están obteniendo correctamente

            // Hacer una solicitud AJAX para obtener los puestos basados en las áreas seleccionadas
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    areas: selectedAreas
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#tipo_acceso_e').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, puesto) {
                        $('#tipo_acceso_e').append(
                            `<option value="${puesto.id_puesto}">${puesto.nom_puesto}</option>`
                        );
                    });

                    // Reinitialize select2 if needed
                    $('#tipo_acceso_e').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });
    });


    function Update_ReporteBI() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('bireporte_ra.update', $get_id->id_acceso_bi_reporte) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Maestra();
                        $("#ModalUpdate .close").click();
                    });
                }
            },
            error: function(xhr) {
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
</script>