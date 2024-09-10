<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar cambio de prenda con boleta:</h5>
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
                <label class="control-label text-bold">Tipo comprobante:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="tipo_comprobantee" id="tipo_comprobantee">
                    <option value="0">Seleccione</option>
                    <option value="08" @if ($get_id->tipo_comprobante=="08") selected @endif>Boleta</option>
                    <option value="09" @if ($get_id->tipo_comprobante=="09") selected @endif>Factura</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Serie:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="seriee" id="seriee" placeholder="Ingresar serie"
                value="{{ $get_id->serie }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Número de documento:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_documentoe" id="n_documentoe" 
                placeholder="Ingresar número de documento" onkeypress="return solo_Numeros(event);" 
                value="{{ $get_id->n_documento }}">
            </div>
            <div class="form-group col-lg-2">
                <a class="btn btn-primary" onclick="Buscar_Comprobante('e')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </a>
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
                        @if ($get_id->id_motivo==$list->id_motivo) selected @endif                            >
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

        <div class="row" id="div_detallee">
            <table id="tabla_detalle_e" class="table" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>Código Producto</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Devolver</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_detalle as $list)
                        @php
                            $mostrar = in_array($list->n_codi_arti, array_column($get_detalle,'n_codi_arti'));
                            $posicion = array_search($list->n_codi_arti, array_column($get_detalle, 'n_codi_arti'));
                        @endphp
                        <tr class="text-center">
                            <td>{{ $list->n_codi_arti }}</td>
                            <td class="text-left">{{ $list->c_arti_desc }}</td>
                            <td>{{ $list->n_cant_vent }}</td>
                            <td>
                                <input type="checkbox" name="devolvere[]" id="cb_{{ $list->c_nume_docu.'_'.$list->n_codi_arti.'e' }}"
                                value="{{ $list->c_nume_docu.'_'.$list->n_codi_arti }}" 
                                onchange="Habilitar_Checkbox('{{ $list->c_nume_docu.'_'.$list->n_codi_arti }}','e');"
                                @if ($mostrar!=false) checked @endif>
                            </td>
                            <td>
                                <input type="text" class="form-control" 
                                name="cant_{{ $list->c_nume_docu.'_'.$list->n_codi_arti }}e" placeholder="#" 
                                onkeypress="return solo_Numeros(event);" 
                                value="@php if($mostrar!=false){ echo $get_detalle[$posicion]['n_cant_vent']; } @endphp">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer">
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Cambio_Prenda();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
        $('#tabla_detalle_e').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10
    });

    function Update_Cambio_Prenda() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('cambio_prenda_con.update', $get_id->id_cambio_prenda) }}";

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
                    '¡Actualización Exitosa!',
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
