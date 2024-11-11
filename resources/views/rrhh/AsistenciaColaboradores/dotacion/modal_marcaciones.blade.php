<div class="modal-header">
    <h5 class="modal-title">Listado de Marcaciones en: <?php echo $centro_labores; ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<div class="modal-body" style="max-height:500px; overflow:auto;">
    <div class="col-md-12 row">
        <div class="form-group col">
            <label class="control-label text-bold">Fecha: <span style="color:black"><?php echo date("d/m/Y", strtotime($fecha)); ?></span> </label>
        </div>
    </div>

    <div class="col-md-12 row p-0 m-0">
        <div class="form-group col text-center p-0 m-0">
            <h6><b>Usuarios presentes</b></h5>
        </div>
    </div>
    <div class="col-md-12 row" id="div_marcaciones_inconsistencia">
        <table id="tabla_js_presente" class="table table-hover non-hover" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>DNI</th>
                    <th>Colaborador</th>
                    <th>Puesto</th>
                    <th>Teléfono</th>
                    <th>Marcación</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($list_marcaciones as $list) { ?>
                    <tr class="text-center">
                        <td><?php echo $list['dni']; ?></td>
                        <td class="text-left"><?php echo ucwords($list['colaborador']); ?></td>
                        <td class="text-left"><?php echo ucwords($list['puesto']); ?></td>
                        <td><?php echo $list['celular']; ?></td>
                        <td><?php echo $list['marcacion']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="col-md-12 row p-0 m-0 mt-4">
        <div class="form-group col text-center p-0 m-0">
            <h6><b>Usuarios ausentes</b></h5>
        </div>
    </div>
    <div class="col-md-12 row" id="div_marcaciones_inconsistencia">
        <table id="tabla_js_ausente" class="table table-hover non-hover" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>DNI</th>
                    <th>Colaborador</th>
                    <th>Puesto</th>
                    <th>Teléfono</th>
                    <th>Marcación</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($list_ausentes as $list) { ?>
                    <tr class="text-center">
                        <td><?php echo $list['dni']; ?></td>
                        <td class="text-left"><?php echo ucwords($list['colaborador']); ?></td>
                        <td class="text-left"><?php echo ucwords($list['puesto']); ?></td>
                        <td><?php echo $list['celular']; ?></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
</div>

<script>
    $('#tabla_js_presente').DataTable({
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
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

    $('#tabla_js_ausente').DataTable({
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
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