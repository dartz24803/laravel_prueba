<style>
    .vibrate {
        animation: vibrate 0.1s infinite;
    }

    @keyframes vibrate {
        0% { transform: translate(0, 0); }
        25% { transform: translate(1px, 0); }
        50% { transform: translate(0, 1px); }
        75% { transform: translate(-1px, 0); }
        100% { transform: translate(0, -1px); }
    }
</style>

<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th class="no-content"></th>
            <th>N° requerimiento</th>
            <th>Desde</th>
            <th>Hacia</th>
            <th>Proceso</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($list_tracking as $list)
            <tr class="text-center">
                <td>
                    @if ($list->id_estado == 2)
                        <a href="javascript:void(0);" title="Salida de mercadería" onclick="Insert_Salida_Mercaderia('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle text-dark">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 16 16 12 12 8"></polyline>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==3)
                        <a href="{{ route('tracking.detalle_transporte', $list->id) }}" title="Detalle de transporte">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==4)
                        <a href="javascript:void(0);" title="Llegada a tienda" onclick="Insert_Llegada_Tienda('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle text-dark">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 16 16 12 12 8"></polyline>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==5)
                        <a href="javascript:void(0);" title="Confirmación de llegada" onclick="Insert_Confirmacion_Llegada('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle text-dark">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 16 16 12 12 8"></polyline>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==7)
                        <a href="javascript:void(0);" title="Verificación de fardos" onclick="Verificacion_Fardos('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==8)
                        <a href="javascript:void(0);" title="Cierre inspección de fardos" onclick="Insert_Cierre_Inspeccion_Fardos('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-success">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </a>
                    @elseif($list->id_estado==9)
                        <a href="{{ route('tracking.pago_transporte', $list->id) }}" title="Pago de transporte">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card text-primary">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==12)
                        <a href="javascript:void(0);" title="Conteo de mercadería" onclick="Insert_Conteo_Mercaderia('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-success">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </a>
                    @elseif($list->id_estado==13)
                        <a href="javascript:void(0);" title="Reporte de mercadería" onclick="Reporte_Mercaderia('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==14)
                        <a href="{{ route('tracking.cuadre_diferencia', $list->id) }}" title="Cuadre de diferencias">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-dark">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </a>
                    @elseif($list->id_estado==15)
                        <a href="{{ route('tracking.detalle_operacion_diferencia', $list->id) }}" title="Detalle de operaciones de diferencias">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==17)
                        <a href="{{ route('tracking.solicitud_devolucion', $list->id) }}" title="Solicitud de devolución">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-dark">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </a>
                    @elseif($list->id_estado==18)
                        <a href="{{ route('tracking.evaluacion_devolucion', $list->id) }}" title="Evaluación de devolución">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @endif
                </td>
                <td>{{ $list->n_requerimiento }}</td>
                <td>{{ $list->desde }}</td>
                <td>{{ $list->hacia }}</td>
                <td class="text-left">{{ $list->proceso }}</td>
                <td>{{ $list->fecha }}</td>
                <td>{{ $list->hora }}</td>
                <td class="text-left">{{ $list->estado }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tabla_js').DataTable({
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
    });

    function Insert_Salida_Mercaderia(id) {
        Cargando();

        var url = "{{ route('tracking.salida_mercaderia', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea cambiar el estado?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }
        })
    }

    function Insert_Llegada_Tienda(id) {
        Cargando();

        var url = "{{ route('tracking.llegada_tienda', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea cambiar el estado?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }
        })
    }

    function Insert_Confirmacion_Llegada(id) {
        Cargando();

        var url = "{{ route('tracking.confirmacion_llegada', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea cambiar el estado?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }
        })
    }

    function Verificacion_Fardos(id) {
        Cargando();

        var url = "{{ route('tracking.cierre_inspeccion_fardos', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿El fardo llegó en buenas condiciones?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }else{
                window.location = "{{ route('tracking.verificacion_fardos', ':id') }}".replace(':id', id);
            }
        })
    }

    function Insert_Cierre_Inspeccion_Fardos(id) {
        Cargando();

        var url = "{{ route('tracking.cierre_inspeccion_fardos', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea cambiar el estado?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'validacion':1},
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }
        })
    }

    function Insert_Conteo_Mercaderia(id) {
        Cargando();

        var url = "{{ route('tracking.conteo_mercaderia', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea cambiar el estado?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }
        })
    }

    function Reporte_Mercaderia(id) {
        Cargando();

        var url = "{{ route('tracking.mercaderia_entregada', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿La mercadería llegó en buenas condiciones?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }else{
                window.location = "{{ route('tracking.reporte_mercaderia', ':id') }}".replace(':id', id);
            }
        })
    }
</script>