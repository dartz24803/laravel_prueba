<!-- CSS -->
<style>
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }

    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field:disabled {
        background-color: transparent !important;

    }

    .select2-container {
        margin-bottom: 0rem !important;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }


    #tabla_js2 td {
        max-width: 180px;
        /* Controla el ancho máximo */
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
        overflow: hidden;
        /* Oculta el contenido que se desborda */
        text-overflow: ellipsis;
        /* Añade puntos suspensivos (...) */
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
        <h5 class="modal-title">Editar Asignación Visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style=" max-height:450px;  overflow:auto;">
        <div class="row my-4">
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Inspector: </label>
                <select class="form-control" name="id_inspectore" id="id_inspectore">
                    @foreach ($list_inspector as $list)
                    <option value="{{ $list->id_usuario }}"
                        {{ $list->id_usuario == $get_id->id_inspector ? 'selected' : '' }}>
                        {{ $list->nombre_completo }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Fecha: </label>
                <input class="form-control" type="date" name="fechae" id="fechae" value="{{ isset($get_id->fecha) ? date('Y-m-d', strtotime($get_id->fecha)) : date('Y-m-d') }}">

            </div>
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Punto de Partida: </label>
                <select class="form-control multivalue2" name="id_ptpartidae" id="id_ptpartidae">
                    <option value="9999">Domicilio</option>
                    @foreach ($list_proveedor as $list)
                    <option value="{{ $list->id_proveedor }}"
                        {{ $list->id_proveedor == $get_id->punto_partida ? 'selected' : '' }}>
                        {{ $list->nombre_proveedor_completo }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Punto de Llegada: </label>
                <select class="form-control multivalue2" name="id_ptllegadae" id="id_ptllegadae">
                    <option value="9999">Domicilio</option>
                    @foreach ($list_proveedor as $list)
                    <option value="{{ $list->id_proveedor }}"
                        {{ $list->id_proveedor == $get_id->punto_llegada ? 'selected' : '' }}>
                        {{ $list->nombre_proveedor_completo }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Modelo: </label>
                <select class="form-control multivalue2" name="id_modeloe" id="id_modeloe">
                    @foreach ($list_ficha_tecnica as $list)
                    <option value="{{ $list->id_ft_produccion }}"
                        {{ $list->id_ft_produccion == $get_id->id_modelo ? 'selected' : '' }}>
                        {{ $list->modelo }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Proceso: </label>
                <select class="form-control" name="id_procesoe" id="id_procesoe">
                    @foreach ($list_proceso_visita as $list)
                    <option value="{{ $list->id_procesov }}"
                        {{ $list->id_procesov == $get_id->id_proceso ? 'selected' : '' }}>
                        {{ $list->nom_proceso }}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>


    <div class="modal-footer">
        @csrf
        <!-- @method('PUT') -->
        <input type="hidden" id="capturae" name="capturae">
        <button id="boton_disablede" class="btn btn-primary" type="button" onclick="Update_Asignacion();">Guardar</button>
        <button class=" btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>


<script>
    $('.multivalue2').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Asignacion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));

        var url = "{{ route('produccion_av.update', $get_id->id_asignacion_visita) }}";

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
                        Lista_Asig_Visitas();
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




    var tabla = $('#tabla_js2').DataTable({
        "columnDefs": [{
                "width": "180px",
                "targets": 3
            } // Aplica a la columna de Área (índice 3)
        ],
        "autoWidth": false, // Desactiva el auto ajuste de ancho de DataTables
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10
    });
    $('#toggle').change(function() {
        var visible = this.checked;
        tabla.column(6).visible(visible);
        tabla.column(10).visible(visible);
        tabla.column(14).visible(visible);
        tabla.column(18).visible(visible);
    });
</script>