@extends('layouts.plantilla')

@section('navbar')
    @include('logistica.navbar')
@endsection

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
                                @include('logistica.tracking.tracking.cabecera')
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Nro. GR Transporte: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="guia_transporte" 
                                    id="guia_transporte" placeholder="Nro. GR Transporte">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Peso: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="peso" id="peso" 
                                    placeholder="Peso" onkeypress="return solo_Numeros_Punto(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Paquetes: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="paquetes" id="paquetes" 
                                    placeholder="Paquetes" onkeypress="return solo_Numeros(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Sobres: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="sobres" id="sobres" 
                                    placeholder="Sobres" onkeypress="return solo_Numeros(event);">
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Fardos: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="fardos" id="fardos" 
                                    placeholder="Fardos" onkeypress="return solo_Numeros(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Caja: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="caja" id="caja" 
                                    placeholder="Caja" onkeypress="return solo_Numeros(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Transporte: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <select class="form-control" name="transporte" id="transporte" 
                                    onchange="Tipo_Transporte();">
                                        <option value="1" selected>Agencia - Terrestre</option>
                                        <option value="2">Agencia - Aérea</option>
                                        <option value="3">Propio</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Tiempo llegada: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="tiempo_llegada" 
                                    id="tiempo_llegada" placeholder="Tiempo llegada" 
                                    onkeypress="return solo_Numeros(event);">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Recepción: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <select class="form-control" name="recepcion" id="recepcion">
                                        <option value="0">Seleccione</option>
                                        <option value="1">Agencia</option>
                                        <option value="2">Domicilio</option>
                                    </select>
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Merc. total: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="mercaderia_total" id="mercaderia_total" 
                                    placeholder="Merc. total" onkeypress="return solo_Numeros(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">F x prenda: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="flete_prenda" id="flete_prenda" 
                                    placeholder="F x prenda" onkeypress="return solo_Numeros_Punto(event);">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Receptor: </label>
                                </div>
                                <div class="form-group col-lg-5">
                                    <input type="text" class="form-control" name="receptor" id="receptor" placeholder="Receptor">
                                </div>
                            </div>
    
                            <div class="row agencia">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Tipo pago: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <select class="form-control" name="tipo_pago" id="tipo_pago" 
                                    onchange="Tipo_Pago();">
                                        <option value="1">Si pago</option>
                                        <option value="2" selected>Por pagar</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Nombre de empresa: </label>
                                </div>
                                <div class="form-group col-lg-5">
                                    <input type="text" class="form-control" name="nombre_transporte" 
                                    id="nombre_transporte" placeholder="Nombre de empresa">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Importe a pagar: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="importe_transporte" 
                                    id="importe_transporte" placeholder="Importe a pagar" 
                                    onkeypress="return solo_Numeros_Punto(event);">
                                </div>
                            </div>
    
                            <div class="row agencia pagado" style="display: none;">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">N° Factura: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="factura_transporte" 
                                    id="factura_transporte" placeholder="N° Factura">
                                </div>

                                <div class="form-group col-lg-2">
                                    <label class="control-label text-bold">PDF de factura (pago adelantado): </label>
                                </div>
                                <div class="form-group ml-3 ml-lg-0 d-flex align-items-center">
                                    <input type="file" class="form-control-file" 
                                    name="archivo_transporte" id="archivo_transporte" 
                                    onchange="Valida_Factura_Transporte();">
                                    <a onclick="Limpiar_Ifile();" style="cursor: pointer" 
                                    title="Borrar archivo seleccionado">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x text-danger">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Comentario: </label>
                                </div>
                                <div class="form-group col-lg-11">
                                    <textarea class="form-control" name="comentario" 
                                    id="comentario" placeholder="Comentario" rows="3"></textarea>
                                </div>
                            </div>
    
                            <div class="modal-footer mt-3">
                                @csrf
                                <input type="hidden" name="id" value="{{ $get_id->id }}">
                                <button class="btn btn-primary" type="button" onclick="Insert_Detalle_Transporte();">Guardar</button>
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
            var tipo_pago = $('#tipo_pago').val();

            if (transporte=="1" || transporte=="2") {
                $('.agencia').show();
                $('#tipo_pago').val(tipo_pago);
                Tipo_Pago();
            }else{
                $('.agencia').hide();
                $('#tipo_pago').val('2');
                $('#nombre_transporte').val('');
                $('#importe_transporte').val('');
                $('#factura_transporte').val('');
                $('#archivo_transporte').val('');
            }
        }

        function Tipo_Pago() {
            Cargando();

            var tipo_pago = $('#tipo_pago').val();

            if (tipo_pago=="1") {
                $('.pagado').show();
            }else{
                $('.pagado').hide();
                $('#factura_transporte').val('');
                $('#archivo_transporte').val('');
            }
        }

        function Valida_Factura_Transporte(){
            var archivoInput = document.getElementById('archivo_transporte');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivo con extensión .pdf|.jpg|.png|.jpeg",
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

        function Insert_Detalle_Transporte() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.insert_detalle_transporte', $get_id->id) }}";

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