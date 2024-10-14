<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar caja chica - Movilidad:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="datos_mo-tabe" data-toggle="tab" href="#datos_moe" role="tab" aria-controls="datos_moe" aria-selected="true">Datos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="indicadores_mo-tabe" data-toggle="tab" href="#indicadores_moe" role="tab" aria-controls="indicadores_moe" aria-selected="false">Detalle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="rutas_mo-tabe" data-toggle="tab" href="#rutas_moe" role="tab" aria-controls="rutas_moe" aria-selected="false">Ruta</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="datos_moe" role="tabpanel" aria-labelledby="datos_mo-tabe">
                <div class="row mt-4">
                    <div class="form-group col-lg-2">
                        <label>Ubicación:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control" name="id_ubicacione" id="id_ubicacione" onchange="Traer_Sub_Categoria('e');">
                            <option value="0">Seleccione</option>
                            @foreach ($list_ubicacion as $list)
                                <option value="{{ $list->id_ubicacion }}"
                                @if ($list->id_ubicacion==$get_id->id_ubicacion) selected @endif>
                                    {{ $list->cod_ubi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>Categoría:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="{{ $get_id->nom_categoria }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Empresa:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control basice" name="id_empresae" id="id_empresae">
                            <option value="0">Seleccione</option>
                            @foreach ($list_empresa as $list)
                                <option value="{{ $list->id_empresa }}"
                                @if ($list->id_empresa==$get_id->id_empresa) selected @endif>
                                    {{ $list->nom_empresa }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label>Sub-Categoría:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control" name="id_sub_categoriae" id="id_sub_categoriae">
                            <option value="0">Seleccione</option>
                            @foreach ($list_sub_categoria as $list)
                                <option value="{{ $list->id }}"
                                @if ($list->id==$get_id->id_sub_categoria) selected @endif>
                                    {{ $list->nombre }}
                                </option> 
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Solicitante:</label>
                    </div>
                    <div class="form-group col-lg-10">
                        <select class="form-control basice" name="id_usuarioe" id="id_usuarioe">
                            <option value="0">Seleccione</option>
                            @foreach ($list_usuario as $list)
                                <option value="{{ $list->id_usuario }}"
                                @if ($list->id_usuario==$get_id->id_usuario) selected @endif                                    >
                                    {{ $list->nom_usuario }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Tipo de movimiento:</label>
                    </div>
                    <div class="form-group col-lg-5">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="tipo_movimientoe" name="tipo_movimientoe" class="custom-control-input" value="2" checked>
                            <label class="custom-control-label" for="tipo_movimientoe">Salida</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="indicadores_moe" role="tabpanel" aria-labelledby="indicadores_mo-tabe">
                <div class="row mt-4">
                    <div class="form-group col-lg-2">
                        <label>T. comprobante:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="{{ $get_id->nom_tipo_comprobante }}" disabled>
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>N° comprobante:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="{{ $get_id->n_comprobante }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Pago:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="{{ $get_id->nom_pago }}" disabled>
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>Tipo pago:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" value="{{ $get_id->nom_tipo_pago }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Fecha solicitud:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="date" class="form-control" name="fechae" id="fechae" 
                        value="{{ $get_id->fecha }}">
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="rutas_moe" role="tabpanel" aria-labelledby="rutas_mo-tabe">
                <div class="row mt-4">
                    <div class="form-group col-lg-2">
                        <label>Descripción:</label>
                    </div>
                    <div class="form-group col-lg-10">
                        <input type="text" class="form-control" name="descripcione" id="descripcione" 
                        placeholder="Descripción" value="{{ $get_id->descripcion }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>N° personas:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" name="personase" id="personase" 
                        placeholder="N° personas" onkeypress="return solo_Numeros(event);">
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>Punto salida:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" name="punto_salidae" id="punto_salidae" 
                        placeholder="Punto salida">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Punto llegada:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" name="punto_llegadae" id="punto_llegadae" 
                        placeholder="Punto llegada">
                    </div>
        
                    <div class="form-group col-lg-2">
                        <label>Transporte:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control" name="transportee" id="transportee">
                            <option value="0">Seleccione</option>
                            <option value="1">BUS</option>
                            <option value="2">TAXI</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Motivo:</label>
                    </div>
                    <div class="form-group col-lg-10">
                        <input type="text" class="form-control" name="motivoe" id="motivoe" 
                        placeholder="Motivo">
                    </div>
                </div>
        
                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Costo:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="text" class="form-control" name="costoe" id="costoe" 
                        placeholder="Costo" onkeypress="return solo_Numeros_Punto(event);">
                    </div>
                    <div class="form-group col-lg-1">
                        <button class="btn btn-primary" type="button" onclick="Insert_Ruta();">
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
                            <select class="form-control" name="id_tipo_monedae" id="id_tipo_monedae">
                                @foreach ($list_tipo_moneda as $list)
                                    <option value="{{ $list->id_moneda }}">{{ $list->cod_moneda }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" class="form-control" name="totale" id="totale" 
                        placeholder="Total" value="{{ $get_id->total }}" disabled>
                    </div>
                </div>

                <div id="lista_ruta" class="row">                  
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Caja_Chica_Mo();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basice").select2({
        tags: true,
        dropdownParent: $('#ModalUpdate')
    });

    Lista_Ruta();
    Total_Ruta();

    function Lista_Ruta(){
        Cargando();

        var url = "{{ route('caja_chica.list_ruta_mo', $get_id->id) }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_ruta').html(resp);  
            }
        });
    }

    function Total_Ruta(){
        Cargando();

        var url = "{{ route('caja_chica.total_ruta_mo', $get_id->id) }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#totale').val(resp);  
            }
        });
    }

    function Insert_Ruta(){
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('caja_chica.store_ruta_mo', $get_id->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                $('#personase').val('');
                $('#punto_salidae').val('');
                $('#punto_llegadae').val('');
                $('#transportee').val('0');
                $('#motivoe').val('');
                $('#costoe').val('');
                Lista_Ruta();
                Total_Ruta();
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

    function Delete_Ruta(id) {
        Cargando();

        var url = "{{ route('caja_chica.destroy_ruta_mo', ':id') }}".replace(':id', id);

        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function() {
                Lista_Ruta();
                Total_Ruta();
            }
        });
    }

    function Update_Caja_Chica_Mo() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('caja_chica.update_mo', $get_id->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    '¡Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Caja_Chica();
                    $("#ModalUpdate .close").click();
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
