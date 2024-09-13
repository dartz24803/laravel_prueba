<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar cambio de prenda sin boleta:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        @if (session('usuario')->id_nivel=="1")
            <div class="row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Base:</label>
                </div>
                <div class="form-group col-lg-4">
                    <select class="form-control" name="basee" id="basee">
                        <option value="0">Seleccione</option>
                        @foreach ($list_base as $list)
                            <option value="{{ $list->cod_base }}"
                            @if ($list->cod_base==$get_id->base) selected @endif>
                                {{ $list->cod_base }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <input type="hidden" name="basee" value="{{ session('usuario')->centro_labores }}">
        @endif

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Código de producto:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_codi_artie" id="n_codi_artie" 
                placeholder="Ingresar código de producto" value="{{ $get_id->n_codi_arti }}">
            </div>
            <div class="form-group col-lg-2">
                <a class="btn btn-primary" onclick="Buscar_Producto('e')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </a>
            </div>
        </div>

        <div class="row" id="div_detalle">
            <table class="table mb-5" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>Código Producto</th>
                        <th>Descripción</th>
                        <th>Color</th>
                        <th>Talla</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_detalle as $list)
                        <tr class="text-center">
                            <td>{{ $list->n_codi_arti }}</td>
                            <td class="text-left">{{ $list->c_arti_desc }}</td>
                            <td>{{ $list->color }}</td>
                            <td>{{ $list->talla }}</td>
                        </tr>
                    @endforeach                                       
                </tbody>
            </table>
            @php
                $get_detalle = $list_detalle[0];
            @endphp
            <input type="hidden" name="art_codigoe" value="{{ $get_detalle->n_codi_arti }}">
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cantidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="n_cant_vente" id="n_cant_vente">
                    <option value="0">Seleccione</option>
                    <option value="1" @if ($get_id->n_cant_vent=="1") selected @endif>1</option>
                    <option value="2" @if ($get_id->n_cant_vent=="2") selected @endif>2</option>
                    <option value="3" @if ($get_id->n_cant_vent=="3") selected @endif>3</option>
                    <option value="4" @if ($get_id->n_cant_vent=="4") selected @endif>4</option>
                    <option value="5" @if ($get_id->n_cant_vent=="5") selected @endif>5</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="nom_clientee" id="nom_clientee" 
                placeholder="Ingresar nombre" value="{{ $get_id->nom_cliente }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Teléfono:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="telefonoe" id="telefonoe" 
                placeholder="Ingresar teléfono" onkeypress="return solo_Numeros(event);" 
                value="{{ $get_id->telefono }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Vendedor:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="vendedore" id="vendedore" 
                placeholder="Ingresar vendedor" value="{{ $get_id->vendedor }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Número de caja:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="num_cajae" id="num_cajae" 
                placeholder="Ingresar número de caja" onkeypress="return solo_Numeros(event);"
                value="{{ $get_id->num_caja }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fechae" id="fechae" value="{{ $get_id->fecha }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Hora:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="time" class="form-control" name="horae" id="horae" value="{{ $get_id->hora }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Motivo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_motivoe" id="id_motivoe" onchange="Mostrar_Otro('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_motivo as $list)
                        <option value="{{ $list->id_motivo }}"
                        @if ($get_id->id_motivo==$list->id_motivo) selected @endif>
                            {{ $list->nom_motivo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 mostrare" @if ($get_id->otro=="") style="display: none;" @endif>
                <label class="control-label text-bold">Otro:</label>
            </div>
            <div class="form-group col-lg-4 mostrare" @if ($get_id->otro=="") style="display: none;" @endif>
                <input type="text" class="form-control" name="otroe" id="otroe" placeholder="Ingresar otro"
                value="{{ $get_id->otro }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Cambio_Prenda();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Cambio_Prenda() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('cambio_prenda_sin.update', $get_id->id_cambio_prenda) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                swal.fire(
                    'Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Cambio_Prenda();
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
