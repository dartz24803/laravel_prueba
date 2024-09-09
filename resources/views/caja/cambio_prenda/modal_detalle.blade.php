
<div class="modal-header">
    <h5 class="modal-title">Detalle cambio de prenda:</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div>
            
<div class="modal-body" style="max-height:700px; overflow:auto;">
    @if ($get_id->tipo_boleta=="1")
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo comprobante:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    <option value="08" @if ($get_id->tipo_comprobante=="08") selected @endif>Boleta</option>
                    <option value="09" @if ($get_id->tipo_comprobante=="09") selected @endif>Factura</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Serie:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" disabled placeholder="Ingresar serie" value="{{ $get_id->serie }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Número de documento:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" disabled placeholder="Ingresar número de documento" onkeypress="return solo_Numeros(event);" value="{{ $get_id->n_documento }}">
            </div>
        </div>
    @endif

    <div class="row">
        <div class="form-group col-lg-2">
            <label class="control-label text-bold">Motivo:</label>
        </div>
        <div class="form-group col-lg-4">
            <select class="form-control" disabled>
                <option value="0">Seleccione</option>
                @foreach ($list_motivo as $list)
                    <option value="{{ $list->id_motivo }}"
                    @if ($get_id->id_motivo==$list->id_motivo) selected @endif>
                        {{ $list->nom_motivo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-2" @if ($get_id->otro=="") style="display: none;" @endif>
            <label class="control-label text-bold">Otro:</label>
        </div>
        <div class="form-group col-lg-4" @if ($get_id->otro=="") style="display: none;" @endif>
            <input type="text" class="form-control" disabled placeholder="Ingresar otro" value="{{ $get_id->otro }}">
        </div>
    </div>

    <div class="row">
        <table id="tabla_detalle_d" class="table" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>Código Producto</th>
                    <th>Descripción</th>
                    @if ($get_id->tipo_boleta=="2")
                        <th>Color</th>
                        <th>Talla</th>
                    @endif
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list_detalle as $list)
                    <tr class="text-center">
                        <td>{{ $list->n_codi_arti }}</td>
                        <td class="text-left">{{ $list->c_arti_desc }}</td>
                        @if ($get_id->tipo_boleta=="2")
                            <td>{{ $list->color }}</td>
                            <td>{{ $list->talla }}</td>
                        @endif
                        <td>{{ $list->n_cant_vent }}</td>
                    </tr>
                @endforeach                                       
            </tbody>
        </table>
    </div>
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>

<script>
    $('#tabla_detalle_d').DataTable({
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
</script>
