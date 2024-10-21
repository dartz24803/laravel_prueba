<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nueva caja chica - Movilidad:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="datos_mo-tab" data-toggle="tab" href="#datos_mo" role="tab" aria-controls="datos_mo" aria-selected="true">Datos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="detalles_mo-tab" data-toggle="tab" href="#detalles_mo" role="tab" aria-controls="detalles_mo" aria-selected="false">Detalle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="rutas_mo-tab" data-toggle="tab" href="#rutas_mo" role="tab" aria-controls="rutas_mo" aria-selected="false">Ruta</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="datos_mo" role="tabpanel" aria-labelledby="datos_mo-tab">
                <div class="row mt-4">
                    <div class="form-group col-lg-2">
                        <label>Tipo de movimiento:</label>
                    </div>
                    <div class="form-group col-lg-5">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="tipo_movimiento" name="tipo_movimiento" class="custom-control-input" value="2" checked>
                            <label class="custom-control-label" for="tipo_movimiento">Salida</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Ubicación:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control" name="id_ubicacion" id="id_ubicacion" onchange="Traer_Sub_Categoria('');">
                            <option value="0">Seleccione</option>
                            @foreach ($list_ubicacion as $list)
                                <option value="{{ $list->id_ubicacion }}">{{ $list->cod_ubi }}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>Categoría:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="MOVILIDAD" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Empresa:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control basic" name="id_empresa" id="id_empresa">
                            <option value="0">Seleccione</option>
                            @foreach ($list_empresa as $list)
                                <option value="{{ $list->id_empresa }}">{{ $list->nom_empresa }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label>Sub-Categoría:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control" name="id_sub_categoria" id="id_sub_categoria">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Solicitante:</label>
                    </div>
                    <div class="form-group col-lg-10">
                        <select class="form-control basic" name="id_usuario" id="id_usuario">
                            <option value="0">Seleccione</option>
                            @foreach ($list_usuario as $list)
                                <option value="{{ $list->id_usuario }}">{{ $list->nom_usuario }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="detalles_mo" role="tabpanel" aria-labelledby="detalles_mo-tab">
                <div class="row mt-4">
                    <div class="form-group col-lg-2">
                        <label>T. comprobante:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="TICKET" disabled>
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>N° comprobante:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="0000001" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Pago:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="CONTADO" disabled>
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>Tipo pago:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="EFECTIVO" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Fecha solicitud:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="date" class="form-control" name="fecha" id="fecha" 
                        value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="rutas_mo" role="tabpanel" aria-labelledby="rutas_mo-tab">
                <div class="row mt-4">
                    <div class="form-group col-lg-2">
                        <label>Descripción:</label>
                    </div>
                    <div class="form-group col-lg-10">
                        <input type="text" class="form-control" name="descripcion" id="descripcion" 
                        placeholder="Descripción">
                    </div>
                </div>

                <hr class="bg-primary" style="height: 0.1px;">

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Personas:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control multivalue" name="personas[]" id="personas" multiple="multiple">
                            @foreach ($list_usuario as $list)
                                <option value="{{ $list->id_usuario }}">{{ $list->nom_usuario }}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>Punto salida:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" name="punto_salida" id="punto_salida" 
                        placeholder="Punto salida">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Punto llegada:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" name="punto_llegada" id="punto_llegada" 
                        placeholder="Punto llegada">
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>Transporte:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control" name="transporte" id="transporte">
                            <option value="0">Seleccione</option>
                            <option value="1">A PIE</option>
                            <option value="2">BUS</option>
                            <option value="3">COLECTIVO</option>
                            <option value="4">METRO</option>
                            <option value="5">TAXI</option>
                            <option value="6">TREN</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Motivo:</label>
                    </div>
                    <div class="form-group col-lg-10">
                        <input type="text" class="form-control" name="motivo" id="motivo" 
                        placeholder="Motivo">
                    </div>
                </div>
        
                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Costo:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" name="costo" id="costo" 
                        placeholder="Costo" onkeypress="return solo_Numeros_Punto(event);">
                    </div>
                    <div class="form-group col-lg-1">
                        <button class="btn btn-primary" type="button" onclick="Insert_Temporal();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-lg-2">
                        <label>Total:</label>
                    </div>
                    <div class="col-lg-4 input-group">
                        <div class="input-group-prepend">
                            <select class="form-control" name="id_tipo_moneda" id="id_tipo_moneda">
                                @foreach ($list_tipo_moneda as $list)
                                    <option value="{{ $list->id_moneda }}">{{ $list->cod_moneda }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" class="form-control" name="total" id="total" placeholder="Total" 
                        disabled>
                    </div>
                </div>

                <div id="lista_temporal" class="row">
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Caja_Chica_Mo();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalRegistro')
    });

    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistro')
    });

    Lista_Temporal();
    Total_Temporal();

    function Lista_Temporal(){
        Cargando();

        var url = "{{ route('caja_chica.list_tmp_mo') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_temporal').html(resp);  
            }
        });
    }

    function Total_Temporal(){
        Cargando();

        var url = "{{ route('caja_chica.total_tmp_mo') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#total').val(resp);  
            }
        });
    }

    function Insert_Temporal(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('caja_chica.store_tmp_mo') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                $('#personas').val('');
                $('#punto_salida').val('');
                $('#punto_llegada').val('');
                $('#transporte').val('0');
                $('#motivo').val('');
                $('#costo').val('');
                $('.multivalue').select2({
                    dropdownParent: $('#ModalRegistro')
                });
                Lista_Temporal();
                Total_Temporal();
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

    function Delete_Temporal(id) {
        Cargando();

        var url = "{{ route('caja_chica.destroy_tmp_mo', ':id') }}".replace(':id', id);

        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function() {
                Lista_Temporal();
                Total_Temporal();
            }
        });
    }

    function Insert_Caja_Chica_Mo() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('caja_chica.store_mo') }}";

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
                    Lista_Caja_Chica();
                    $("#ModalRegistro .close").click();
                })
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
