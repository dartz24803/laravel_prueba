<div class="modal-header">
    <h5 class="modal-title">Detalle caja chica - Movilidad</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div>
            
<div class="modal-body" style="max-height:700px; overflow:auto;">
    <div class="row justify-content-end">
        <div class="col-lg-2">
            <label>Total:</label>
        </div>
        <div class="col-lg-4 input-group">
            <input type="text" class="form-control" placeholder="Total" 
            value="{{ $get_id->total_concatenado }}" disabled>
        </div>
    </div>

    <div class="row">
        <table id="tabla_jsd" class="table" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>N° personas</th>
                    <th>Punto salida</th>
                    <th>Punto llegada</th>
                    <th>Transporte</th>
                    <th>Motivo</th>
                    <th>Costo</th>
                    <th class="no-content"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list_ruta as $list)
                    <tr class="text-center">
                        <td>{{ $list->personas }}</td>
                        <td class="text-left">{{ $list->punto_salida }}</td>
                        <td class="text-left">{{ $list->punto_llegada }}</td>
                        <td class="text-left">{{ $list->transporte }}</td>
                        <td class="text-left">{{ $list->motivo }}</td>
                        <td>{{ $list->costo }}</td>
                        <td>
                            <a href="javascript:void(0);" data-toggle="modal" 
                            data-target="#ModalDetail" 
                            app_detalle="{{ route('caja_chica.modal_detalle_mo', $list->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                        </td>
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
    $(document).ready(function() {
        $('#tabla_jsd').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
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
    });
</script>