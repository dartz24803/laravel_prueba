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
<script src="{{ asset('js/cartera.js') }}"></script>
<script src="{{ asset('js/jquery-easing/jquery.easing.min.js') }}"></script>
<!--Datatables-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
