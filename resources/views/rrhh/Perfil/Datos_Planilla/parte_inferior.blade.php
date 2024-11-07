<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table" id="tabla_js_planilla" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>Orden</th>
                    <th>Estado</th>
                    <th>Situacion Laboral</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Empresa</th>
                    <th>Días Laborados</th>
                    <th>Sueldo</th>
                    <th>Bono</th>
                    <th>Total</th>
                    <th>Observaciones</th>
                    <th>Motivo Cese</th>
                    <th class="no-content"></th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($list_planilla as $list)
                    <tr class="text-center">
                        <td>{{ $list->orden }}</td>
                        <td>{{ $list->nom_estado }}</td>
                        <td class="text-left">{{ $list->nom_situacion_laboral }}</td>
                        <td>{{ $list->fec_inicio }}</td>
                        <td>{{ $list->fec_fin }}</td>
                        <td class="text-left">{{ $list->nom_empresa }}</td>
                        <td><span class="badge badge-success">{{ $list->dias_laborados }}</span></td>
                        <td class="text-right">{{ $list->sueldo }}</td>
                        <td class="text-right">{{ $list->bono }}</td>
                        <td class="text-right">{{ $list->total }}</td>
                        <td class="text-left">{{ $list->observacion }}</td>
                        <td>{{ $list->nom_motivo }}</td>
                        <td></td>
                    </tr>
                @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tabla_js_planilla').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
            order: [[0,"desc"]],
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
            "pageLength": 10,
            "aoColumnDefs" : [ 
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    });
</script>