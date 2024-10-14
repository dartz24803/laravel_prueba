@extends('layouts.plantilla')

@section('navbar')
@include('logistica.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Carga de Inventario
                </h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-2">
                    <div class="toolbar d-flex p-4">

                        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('cargainventario.create') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Registrar
                        </button>
                    </div>
                    @csrf
                    <div class="table-responsive mb-4 mt-4" id="lista_reproceso">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $("#logisticas").addClass('active');
        $("#hlogisticas").attr('aria-expanded', 'true');
        $("#cargainventario").addClass('active');

        Lista_CargaInventario();
    });

    function Lista_CargaInventario() {
        Cargando();

        var url = "{{ route('cargainventario.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#lista_reproceso').html(resp);
            }
        });
    }


    function Delete_CargaInventario(id) {
        Cargando();

        var url = "{{ route('cargainventario.destroy', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar todos los registros?',
            text: "Los registros serán eliminados permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    processData: false,
                    contentType: false,
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_CargaInventario();
                        });
                    }
                });
            }
        })
    }

    function Validar_Archivo(v) {
        var archivoInput = document.getElementById(v);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.xlsx)$/i;
        if (!extPermitidas.exec(archivoRuta)) {
            swal.fire(
                '!Archivo no permitido!',
                'El archivo debe ser xlsx',
                'error'
            )
            archivoInput.value = '';
            return false;
        }
    }

    function Update_Carga_Inventario() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('cargainventario.update', ':id') }}"
        if (Valida_Carga_Inventario('2')) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    var cadena = data.trim();
                    validacion = cadena.substr(0, 1);
                    mensaje = cadena.substr(1);
                    if (validacion == 1) {
                        swal.fire(
                            'Actualización Denegada!',
                            mensaje,
                            'error'
                        ).then(function() {

                        });
                    } else if (validacion == 2) {
                        swal.fire(
                            'Archivo no subido por errores en el mismo archivo: ',
                            mensaje,
                            'warning'
                        ).then(function() {

                        });
                    } else if (validacion == 3) {
                        swal.fire(
                            'Actualización Exitosa',
                            mensaje,
                            'success'
                        ).then(function() {
                            $('#ModalUpdate .close').click();
                            Buscar_Carga_Inventario();
                        });
                    }
                }
            });
        } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }
</script>

@endsection