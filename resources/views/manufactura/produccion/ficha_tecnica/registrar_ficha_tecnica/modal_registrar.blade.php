<!-- CSS -->
<style>
    /* Asegúrate de que el dropdown de Select2 tenga un z-index más bajo */
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }

    /* Estilo para el campo de búsqueda dentro del select2 */
    /* Estilo para el campo de búsqueda dentro del select2 cuando está deshabilitado */
    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field:disabled {
        background-color: transparent !important;
    }


    /* Añadir un contenedor para manejar el overflow de la tabla */
    .table-responsive {
        overflow-x: auto;
        /* Habilita el scroll horizontal si es necesario */
        max-width: 100%;
        /* Asegura que la tabla no se desborde más allá de su contenedor */
    }

    .table {
        width: 100%;
        /* Asegura que la tabla use el 100% del espacio disponible */
    }


    .form-group {
        margin: 0px;
        /* Ajusta este valor según tus necesidades */
    }

    .small-text {
        color: black;
        font-size: 12px;
        /* Ajusta el tamaño según tus necesidades */
    }

    .centered-label {
        text-align: center;
        margin-bottom: 1rem;
        /* Espacio inferior */
        background-color: #f8f9fa;
        /* Color de fondo distinto para el label */
        padding: 10px;
        /* Espaciado interno */
        border-radius: 5px;
        /* Bordes redondeados */
        border: 1px solid #dee2e6;
        /* Borde */
    }

    .divider {
        border-bottom: 1px solid #dee2e6;
        /* Color y estilo del divisor */
        margin-bottom: 1rem;
        /* Espacio debajo del divisor */
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
<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">

    <div class=" modal-header">
        <h5 class="modal-title">Registrar Nueva Ficha Técnica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">


        <div class="row my-4">
            <div class="form-group col-lg-6">
                <label id="modelo" class="control-label text-bold">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo">
            </div>


            <div class="form-group col-lg-6">

                <label>Ficha:</label>
                <input type="file" class="form-control-file" name="archivo1" id="archivo1" onchange="Valida_Archivo('archivo1');">

            </div>

        </div>

    </div>
    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Funcion_Temporal();">Guardar</button>
        <button class=" btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>

</form>

<script>
    $('.multivalue').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalRegistro')
    });

    $(document).ready(function() {
        // Evento click del botón "+"

        // Evento click del botón "+"
        $('#btn-add-row').on('click', function() {
            // Obtener los valores seleccionados (IDs)
            let partida = $('#id_ptpartida').val() || [];
            let llegada = $('#id_ptllegada').val() || [];
            let modelo = $('#id_modelo').val() || [];
            let proceso = $('#id_proceso').val() || [];

            // Convertir a arrays si no lo son
            partida = Array.isArray(partida) ? partida : [partida];
            llegada = Array.isArray(llegada) ? llegada : [llegada];
            modelo = Array.isArray(modelo) ? modelo : [modelo];
            proceso = Array.isArray(proceso) ? proceso : [proceso];

            // Obtener los textos seleccionados (nombres en lugar de IDs)
            let partidaText = partida.map(id => $('#id_ptpartida option[value="' + id + '"]').text()).join(', ');
            let llegadaText = llegada.map(id => $('#id_ptllegada option[value="' + id + '"]').text()).join(', ');
            let modeloText = modelo.map(id => $('#id_modelo option[value="' + id + '"]').text()).join(', ');
            let procesoText = proceso.map(id => $('#id_proceso option[value="' + id + '"]').text()).join(', ');

            // Validar que todos los selects estén seleccionados
            if (partida.length > 0 && llegada.length > 0 && modelo.length > 0 && proceso.length > 0) {
                // Mostrar la tabla si está oculta
                $('#selected-data-table').show();

                // Crear una nueva fila para la tabla con los nombres y los IDs en data-attributes
                let newRow = `
                <tr>
                    <td><button class="btn btn-danger btn-delete-row" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </button></td>
                    <td data-id="${partida.join(',')}">${partidaText}</td>
                    <td data-id="${llegada.join(',')}">${llegadaText}</td>
                    <td data-id="${modelo.join(',')}">${modeloText}</td>
                    <td data-id="${proceso.join(',')}">${procesoText}</td>
                </tr>
            `;
                $('#selected-data-table tbody').append(newRow);
            } else {
                alert('Por favor, selecciona todos los campos.');
            }
        });

        // Evento para eliminar una fila
        $(document).on('click', '.btn-delete-row', function() {
            $(this).closest('tr').remove();
            // Ocultar la tabla si no hay filas
            if ($('#selected-data-table tbody tr').length === 0) {
                $('#selected-data-table').hide();
            }
        });

        // Evento para eliminar una fila
        $(document).on('click', '.btn-delete-row', function() {
            $(this).closest('tr').remove();
            if ($('#selected-data-table tbody tr').length === 0) {
                $('#selected-data-table').hide();
            }
        });
    });

    function Insert_Funcion_Temporal() {
        Cargando();
        // Crear un nuevo FormData a partir del formulario
        var formData = new FormData(document.getElementById('formulario_insert'));
        // Recolectar los datos de la tabla (IDs)
        let tableData = [];
        $('#selected-data-table tbody tr').each(function() {
            let row = {
                partida: $(this).find('td').eq(1).data('id'), // Obtener el ID desde data-id
                llegada: $(this).find('td').eq(2).data('id'), // Obtener el ID desde data-id
                modelo: $(this).find('td').eq(3).data('id'), // Obtener el ID desde data-id
                proceso: $(this).find('td').eq(4).data('id') // Obtener el ID desde data-id
            };
            tableData.push(row);
        });

        // Añadir los datos de la tabla al FormData
        formData.append('tableData', JSON.stringify(tableData));

        // URL de tu endpoint
        var url = "{{ route('produccion_ft.store') }}";

        // Enviar los datos al servidor con AJAX
        $.ajax({
            url: url,
            data: formData,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    'Registro Exitoso!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Ficha_Tecnica();
                    $("#ModalRegistro .close").click();
                });
            },
            error: function(xhr, status, error) {
                swal.fire(
                    'Error!',
                    'Hubo un problema al registrar.',
                    'error'
                );
            }
        });
    }
</script>