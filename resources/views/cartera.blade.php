<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Prueba</title>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" sizes="16x16">
    <link href="{{ asset('css/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!--Datatables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" />
    <!--datatables js y css personalizado-->
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<?php 
//echo session('usuario'); 
?>

<a href="{{ url('DestruirSesion') }}">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
        <polyline points="16 17 21 12 16 7"></polyline>
        <line x1="21" y1="12" x2="9" y2="12"></line>
    </svg> <span>Salir</span>
</a>
@include('nav')
<div class="container-fluid">
    <h6 class="text-gray-800 font-weight-bold mb-3">
        REGISTRO DE CARTERAS
    </h6>
    <!-- Collapsable Card -->
    <div class="card shadow mb-3 border-left-primary">
        <!-- Card Header - Accordion -->
        <a id="NuevaCartera" href="#collapseCardCartera" class="d-block card-header py-3 text-center bg-primary text-white" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardEC">
            <h6 class="m-0 font-weight-bold "> <span class="float-right">Nuevo Registro</span></h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse" id="collapseCardCartera">
            <div class="card-body">
                <form class="needs-validation" id="form_cartera" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id_cartera" id="id_cartera" />
                            <div class="form-group col-md-6">
                                <label class="text-dark" for="my-input">Codigo <span class="text-danger">*</span></label>
                                <input id="codigo" class="form-control" type="text" name="codigo" minlength="2" required>
                                <div class="invalid-feedback">
                                    Debe contener como minimo 2 caracteres.
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark" for="my-input">RUC <span class="text-danger">*</span></label>
                                <input id="ruc" class="form-control" type="number" name="ruc" minlength="10" required>
                                <div class="invalid-feedback">
                                    Debe contener como minimo 10 caracteres.
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-dark" for="my-input">Razon social <span class="text-danger">*</span></label>
                                <input id="razon_social" class="form-control" type="text" name="razon_social" minlength="2" required>
                                <div class="invalid-feedback">
                                    Debe contener como minimo 2 caracteres.
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-dark" for="my-input">Nombre comercial <span class="text-danger">*</span></label>
                                <input id="nombre_comercial" class="form-control" type="text" name="nombre_comercial" minlength="2" required>
                                <div class="invalid-feedback">
                                    Debe contener como minimo 2 caracteres.
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="action" value="add" class="btn btn-outline-danger tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"><i class="fa fa-check"></i> Guardar</button>
                        <button type="button" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-toggle="collapse" data-target="#collapseCardCartera" aria-expanded="true" aria-controls="collapseCardCartera">
                            <i class="fa fa-close"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page Heading -->
    <div class="card card-style border border-danger rounded">
        <div class="card-header">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table_carteras" class="table table-bordered" style="width: 100%;">
                        <caption>Listado de cartera</caption>
                        <thead class="table-dark">
                            <tr class="bg-info text-light">
                                <th scope="col">#</th>
                                <th scope="col">Código</th>
                                <th scope="col">RUC</th>
                                <th scope="col">Razon social</th>
                                <th scope="col">Nombre comercial</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-bordered">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
const form_registrar = $('#form_cartera');
$('#NuevaCartera').on('click', function() {
    form_registrar[0].reset();
});
/**EDITAR */
function editar(id_cartera) {
    $.get( "{{ url('buscarCartera') }}", { id: id_cartera },
        function (data) {
            $('#collapseCardCartera').collapse('show');
            $('#id_cartera').val(data.data[0].id_cartera);
            $('#codigo').val(data.data[0].codigo);
            $('#ruc').val(data.data[0].ruc);
            $('#razon_social').val(data.data[0].razon_social);
            $('#nombre_comercial').val(data.data[0].nombre_comercial);
        },
        "json"
    );
}
//CRUD
/* REGISTRAR Y EDITAR */
$(form_registrar).submit(function (e) {
    e.preventDefault();
    const dato = new FormData(form_registrar[0]);
    $.ajax({
        type: "post",
        url: "{{ url('registraryeditarCartera') }}",
        data: dato,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.error == "") {
                $('#table_carteras').DataTable().ajax.reload();
                form_registrar[0].reset();
                swal.fire({
                    title: response.ok,
                    html: "¡Correcto!",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false,
                });
                $('#collapseCardCartera').collapse('hide');
                return false;
            } else {
                swal.fire({
                    title: "¡Cuidado con ingresar datos erroneos!",
                    html: response.error,
                    icon: "error",
                    showConfirmButton: true,
                });
            }
        }
    });
});


/**Listar */
$(document).ready(function () {
    listar();
});
function listar() {
    $('#table_carteras').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
        "ajax": {
            url: "{{ url('Carteralistar') }}",
            type: "post"
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 5,
        "order": [[0, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "pagingType": "simple_numbers",
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    });
}

/**ELIMINAR */
function eliminar(id_cartera) {
    swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.get("{{ url('eliminarCartera') }}", { id: id_cartera },
                function (data, textStatus, jqXHR) {
                    console.log(data);
                    if (data.error == "") {
                        $('#table_carteras').DataTable().ajax.reload();
                        Swal.fire({
                            title: 'Correcto!',
                            text: data.ok,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.error,
                            icon: 'error',
                            showConfirmButton: true,
                        })
                    }
                },
                "json"
            );
        }
    });
}
</script>
<script src="{{ asset('js/jquery-easing/jquery.easing.min.js') }}"></script>
<!--Datatables-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
