@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Detalle de transporte</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row"> 
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">SEMANA {{ $get_id->semana }}</label>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="control-label text-bold">Nro. Req.: {{ $get_id->n_requerimiento }}</label>
                                </div>
    
                                <div class="form-group col-lg-6">
                                    <label class="control-label text-bold">Nro. GR: {{ $get_id->n_guia_remision }}</label>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Nro. GR Transporte: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="guia_transporte" id="guia_transporte" placeholder="Nro. GR Transporte">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Peso: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="peso" id="peso" placeholder="Peso" onkeypress="return solo_Numeros_Punto(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Paquetes: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="paquetes" id="paquetes" placeholder="Paquetes" onkeypress="return solo_Numeros(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Sobres: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="sobres" id="sobres" placeholder="Sobres" onkeypress="return solo_Numeros(event);">
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Fardos: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="fardos" id="fardos" placeholder="Fardos" onkeypress="return solo_Numeros(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Caja: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="caja" id="caja" placeholder="Caja" onkeypress="return solo_Numeros(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Transporte: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <select class="form-control" name="transporte" id="transporte" onchange="Tipo_Transporte();">
                                        <option value="0">Seleccione</option>
                                        <option value="1">Agencia</option>
                                        <option value="2">Propio</option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="row agencia">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Nombre de empresa: </label>
                                </div>
                                <div class="form-group col-lg-5">
                                    <input type="text" class="form-control" name="nombre_transporte" id="nombre_transporte" placeholder="Nombre de empresa">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Importe a pagar: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="importe_transporte" id="importe_transporte" placeholder="Importe a pagar" onkeypress="return solo_Numeros_Punto(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">N° Factura: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="factura_transporte" id="factura_transporte" placeholder="N° Factura">
                                </div>
                            </div>
    
                            <div class="row agencia">
                                <div class="form-group col-lg-2">
                                    <label class="control-label text-bold">PDF de factura (pago adelantado): </label>
                                </div>
                                <div class="form-group ml-3 ml-lg-0 d-flex align-items-center">
                                    <input type="file" class="form-control-file" name="archivo_transporte" id="archivo_transporte" onchange="Valida_Factura_Transporte();">
                                    <a onclick="Limpiar_Ifile();" style="cursor: pointer" title="Borrar archivo seleccionado">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x text-danger">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </a>
                                </div>
                            </div>
    
                            <div class="modal-footer mt-3">
                                @csrf
                                <input type="hidden" name="id" value="{{ $get_id->id }}">
                                <button class="btn btn-primary" type="button" onclick="Insert_Mercaderia_Transito();">Guardar</button>
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

            Tipo_Transporte();
        });

        function Limpiar_Ifile(){
            $('#archivo_transporte').val('');
        }

        function solo_Numeros(e) {
            var key = event.which || event.keyCode;
            if (key >= 48 && key <= 57) {
                return true;
            } else {
                return false;
            }
        }

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
        
        function Tipo_Transporte() {
            Cargando();

            var transporte = $('#transporte').val();

            if (transporte=="1") {
                $('.agencia').show();
            }else{
                $('.agencia').hide();
                $('#nombre_transporte').val('');
                $('#importe_transporte').val('');
                $('#factura_transporte').val('');
                $('#archivo_transporte').val('');
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

        function Insert_Mercaderia_Transito() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.mercaderia_transito', $get_id->id) }}";

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