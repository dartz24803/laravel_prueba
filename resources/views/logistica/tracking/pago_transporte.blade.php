@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Pago de transporte</h3>
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
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Nombre de empresa: </label>
                                </div>
                                <div class="form-group col-lg-5">
                                    <input type="text" class="form-control" name="nombre_transporte" id="nombre_transporte" placeholder="Nombre de empresa" value="{{ $get_id->nombre_transporte }}">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Importe a pagar: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="importe_transporte" id="importe_transporte" placeholder="Importe a pagar" value="{{ $get_id->importe_transporte }}" onkeypress="return solo_Numeros_Punto(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">N° Factura: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="factura_transporte" id="factura_transporte" placeholder="N° Factura" value="{{ $get_id->factura_transporte }}">
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <label class="control-label text-bold">PDF de factura: </label>
                                    @if ($get_id->archivo_transporte!="")
                                        <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Pdf_Factura();">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                                                <polyline points="8 17 12 21 16 17"></polyline>
                                                <line x1="12" y1="12" x2="12" y2="21"></line>
                                                <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                                <div class="form-group col-lg-10">
                                    <input type="file" class="form-control-file" name="archivo_transporte" id="archivo_transporte" onchange="Valida_Factura_Transporte();">
                                </div>
                            </div>
    
                            <div class="modal-footer mt-3">
                                @csrf
                                <input type="hidden" name="id" value="{{ $get_id->id }}">
                                <input type="hidden" name="archivo_transporte_actual" value="{{ $get_id->archivo_transporte }}">
                                <button class="btn btn-primary" type="button" onclick="Insert_Confirmacion_Pago_Transporte();">Guardar</button>
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

        function solo_Numeros_Punto(e) {
            var key = event.which || event.keyCode;
            if ((key >= 48 && key <= 57) || key == 46) {
                if (key == 46 && event.target.value.indexOf('.') !== -1) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }

        function Valida_Factura_Transporte(){
            var archivoInput = document.getElementById('archivo_transporte');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf)$/i;

            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivos con extensiones .pdf.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = ''; 
                return false;
            }else{
                return true;         
            }
        }

        function Descargar_Pdf_Factura(id){
            window.open('{{ $get_id->archivo_transporte }}', '_blank');
        }

        function Insert_Confirmacion_Pago_Transporte() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.confirmacion_pago_transporte') }}";

            if (Valida_Insert_Confirmacion_Pago_Transporte()) {
                $.ajax({
                    url: url,
                    data: dataString,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        swal.fire(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "{{ route('tracking') }}";
                        });
                    }
                });
            }
        }

        function Valida_Insert_Confirmacion_Pago_Transporte() {
            if ($('#nombre_transporte').val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar nombre de empresa.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#importe_transporte').val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar importe a pagar.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#importe_transporte').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe ingresar importe a pagar mayor a 0.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#factura_transporte').val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar n° de factura.',
                    'warning'
                ).then(function() {});
                return false;
            }
            @if($get_id->archivo_transporte=="")
                if ($('#archivo_transporte').val() === '') {
                    Swal(
                        'Ups!',
                        'Debe ingresar PDF de factura.',
                        'warning'
                    ).then(function() {});
                    return false;
                }
            @endif
            return true;
        }
    </script>
@endsection