@extends('layouts.plantilla_new')

@section('navbar')
    @include('logistica.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Detalle de Operación de Diferencias</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row"> 
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">Ingrese el nro de la Guía de Remisión con la que se ha regularizado la mercadería:</label>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Nro. GR: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="guia_diferencia" id="guia_diferencia" placeholder="Nro. GR">
                                </div>
                            </div>
    
                            <div class="modal-footer mt-3">
                                @csrf
                                <button class="btn btn-primary" type="button" onclick="Insert_Diferencia_Regularizada();">Guardar</button>
                                <a class="btn" href="{{ route('tracking') }}">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#logisticas").addClass('active');
            $("#hlogisticas").attr('aria-expanded', 'true');
            $("#trackings").addClass('active');
        });

        function Insert_Diferencia_Regularizada() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.insert_diferencia_regularizada', $get_id->id) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "{{ route('tracking') }}";
                    });
                },
                error:function(xhr) {
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
@endsection