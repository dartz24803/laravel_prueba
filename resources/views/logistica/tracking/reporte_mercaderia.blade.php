@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Reporte de mercadería</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row"> 
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">Nro. Req.: {{ $get_id->n_requerimiento }}</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="new-control new-checkbox checkbox-ln1">
                                        <input type="checkbox" class="new-control-input" name="diferencia" id="diferencia" value="1">
                                        <span class="new-control-indicator"></span>Existen diferencias
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="new-control new-checkbox checkbox-ln1">
                                      <input type="checkbox" class="new-control-input" name="devolucion" id="devolucion" value="1">
                                      <span class="new-control-indicator"></span>Mercadería para devolución
                                    </label>
                                </div>
                            </div>
    
                            <div class="modal-footer mt-3">
                                @csrf
                                <input type="hidden" name="id" value="{{ $get_id->id }}">
                                <button class="btn btn-primary" type="button" onclick="Insert_Reporte_Mercaderia();">Guardar</button>
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
            $("#li_trackings").addClass('active');
            $("#a_trackings").attr('aria-expanded','true');
        });

        function Insert_Reporte_Mercaderia() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.insert_reporte_mercaderia') }}";

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