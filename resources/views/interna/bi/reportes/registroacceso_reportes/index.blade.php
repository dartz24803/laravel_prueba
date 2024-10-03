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
    <div class="col-lg-4 col-xl-6">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('bireporte_ra.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Registrar
        </button>
        <label for="excelInput" style="cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
            Carga Masiva
            <input type="file" id="excelInput" style="display:none;" accept=".xlsx, .xls" onchange="mostrarModalConfirmacion()" />
        </label>




    </div>
</div>

@csrf
<div class="table-responsive mt-4" id="lista_reportebi">
</div>

<script>
    List_Reporte();

    function List_Reporte() {
        Cargando();

        var url = "{{ route('bireporte_ra.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#lista_reportebi').html(resp);
            }
        });
    }


    function Excel_reporteBI() {
        var cod_base = $('#cod_baseb').val();
        var fec_ini = $('#fecha_iniciob').val();
        var fec_fin = $('#fecha_finb').val();
        window.location = "{{ route('portalprocesos_lm.excel', [':cod_base', ':fec_ini', ':fec_fin']) }}".replace(':cod_base', cod_base).replace(':fec_ini', fec_ini).replace(':fec_fin', fec_fin);
    }

    function Delete_ReporteBI(id) {
        Cargando();

        var url = "{{ route('bireporte_ra.destroy', ':id') }}".replace(':id', id);
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
                            List_Reporte();
                        });
                    }
                });
            }
        })
    }

    function Validar_Reporte(id) {
        Cargando();

        var url = "{{ route('bireporte_ra.valid', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea validar el reporte?',
            text: "El reporte será validado",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            'Aprobado!',
                            'El registro ha sido Aprobado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            List_Reporte();
                        });
                    }
                });
            }
        })
    }


    function Valida_Archivo(val) {
        Cargando();

        var archivoInput = document.getElementById(val);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;
        console.log(archivoRuta)
        if (!extPermitidas.exec(archivoRuta)) {
            Swal({
                title: 'Registro Denegado11',
                text: "Asegurese de ingresar archivo con extensión111111111 .pdf | .jpg | .png | .jpeg",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        } else {
            return true;
        }
    }

    function Validar_Archivo_Backup(v) {
        var archivoInput = document.getElementById(v);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpg|.jpeg|.png|.pdf|.mp4|.xlsx|.pptx|.docx|.bpm)$/i;
        if (!extPermitidas.exec(archivoRuta)) {
            swal.fire(
                '!Archivo no permitido!',
                'El archivo debe ser jpg, jpeg, png, pdf, mp4, pptx, docx o bpm',
                'error'
            )
            archivoInput.value = '';
            return false;
        }
    }

    function cargarArchivoExcel() {
        return new Promise((resolve, reject) => { // Inicia la promesa
            const input = document.getElementById('excelInput');
            const file = input.files[0];

            if (file) {
                var url = "{{ route('bireporte_ra_excel.excelupdate') }}";
                var formData = new FormData();
                formData.append('archivo', file);
                formData.append('_token', '{{ csrf_token() }}'); // Agregar el token CSRF

                $.ajax({
                    url: url,
                    data: formData,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        resolve(data); // Resolver la promesa en caso de éxito
                    },
                    error: function(xhr) {
                        reject(xhr); // Rechazar la promesa en caso de error
                    }
                });
                console.log("Archivo cargado:", file.name);
            } else {
                reject(new Error("No hay archivo seleccionado.")); // Rechazar si no hay archivo
            }
        });
    }

    function mostrarModalConfirmacion() {
        const input = document.getElementById('excelInput');
        const file = input.files[0];

        if (file) {
            Swal.fire({
                title: 'Confirmación',
                text: `¿Está seguro de que desea cargar el archivo ${file.name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    // Mostrar loading
                    Swal({
                        title: 'Cargando...',
                        text: 'Por favor, espere mientras se carga el archivo.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    cargarArchivoExcel().then(() => {
                        // Cerrar el loading y mostrar el mensaje de éxito
                        Swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(() => {
                            List_Reporte();
                            $("#ModalRegistro .close").click();
                        });
                    }).catch((error) => {

                        input.value = ""; // Limpiar el input
                        Swal.fire(
                            '¡Ups!',
                            'Ocurrió un error durante la carga. Intente nuevamente.',
                            'error'
                        );
                    });
                } else {
                    // Limpiar la selección de archivo si el usuario cancela
                    input.value = ""; // Limpiar el input
                }
            });
        }
    }



    function cerrarModal() {
        document.getElementById('modalConfirmacion').style.display = 'none';
    }
</script>