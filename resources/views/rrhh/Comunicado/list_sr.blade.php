<table id="tabla_js" class="table table-hover ordenar" style="width:100%">
    <thead>
        <tr>
            <th>Creado date</th>
            <th>Orden</th>
            <th>Tipo de slide</th>
            <th>Duración</th>
            <th>Título</th>
            <th>Descripción</th>
            <th id="ordenar-fechas" onclick="OrdenarFechas()" style="cursor: pointer;">
                <div class="row p-0" style="width: 155%">
                    <div class="offset-1 col-md-6">
                        Creado
                    </div>
                    <div class="offset-1 col-md-2">
                        <div class="d-flex flex-column orden-icono">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                    </div>
                </div>
            </th>
            <th>Archivo</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_slider_rrhh as $list) {  ?>   
            <tr>
                <td>{{ $list['fec_reg'] }}</td>
                <td><?= $list['orden']; ?></td>
                <td><?= $list['tipo_slide']; ?></td>
                <td><?= $list['duracion']; ?></td>
                <td><?= $list['titulo']; ?></td>
                <td><?= $list['descripcion']; ?></td>
                <td><?= $list['creado']; ?></td>
                <td>
                    <?php if(substr($list['archivoslide'],-3) === "mp4"){ ?>
                        <video loading="lazy" class="img-thumbnail img-presentation-small" controls >
                            <source class="img_post img-thumbnail img-presentation-small" src="<?= $list['archivoslide']; ?>" type="video/mp4">
                        </video>
                    <?php } else { ?>
                        <img loading="lazy" class="img_post img-thumbnail img-presentation-small" style="max-width:100px" src="<?= $list['archivoslide']; ?>">
                    <?php } ?>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" title="Editar" 
                    data-toggle="modal" data-target="#ModalUpdateSlide" 
                    app_upd_slide="{{ url('Modal_Update_Slider_Rrhh/' . $list['id_slide'])  }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="" title="Eliminar" onclick="Delete_Slider_Rrhh('<?= $list['id_slide']; ?>')" id="delete" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        if('<?= $tipo ?>'=="2"){
            <?php $encryptedString = base64_encode('Slider_Vista_Tienda'); ?>
            $("#btn_slide").html('<a id="hslider" target="_blank" class="btn btn-primary mb-2 mr-2" title="Registrar" href="{{ url('Slider/'.$encryptedString) }}">Visualizar Slide Tienda</a>');
        }else{
            <?php
            $funcion = base64_encode('Slider_Vista_RRHH');
            $base = base64_encode($tipo);
            ?>
            $("#btn_slide").html('<a id="hslider" target="_blank" class="btn btn-primary mb-2 mr-2" title="Registrar" href="{{ url('Slider/'.$funcion.'__'.$base) }}">Visualizar Slide de Base <?php echo $tipo ?></a> ');
        }

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
            },
            responsive: true,
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10,
            order: [[1, "asc"]],
            "columnDefs": [
                {
                    'targets': 6,
                    'orderable': false
                },
                {
                    'targets': 0, // Índice de la columna que quieres ocultar
                    'visible': false // Oculta la columna
                }
            ],
        });
    });
    
    $('#tabla_js thead').on('click', 'th', function() {
        if ($(this).attr('id') !== 'ordenar-fechas') {
            $('#tabla_js thead th .orden-icono').html(`
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
            `);
        }
    });

    function OrdenarFechas() {
        var tabla = $('#tabla_js').DataTable();
        var currentOrder = tabla.order(); // Obtiene el orden actual

        var header = $('#ordenar-fechas'); // Selecciona el encabezado
        var icono = header.find('.orden-icono'); // Selecciona el ícono de la flecha

        // Alterna entre ascendente y descendente
        if (currentOrder[0][0] === 0) { // Si la columna 0 está ordenada
            var newOrder = (currentOrder[0][1] === 'asc') ? 'desc' : 'asc';
            tabla.order([0, newOrder]).draw();

            // Cambia la clase del ícono según el nuevo orden
            if (newOrder === 'asc') {
                icono.removeClass('desc').addClass('asc').html(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        `);
            } else {
                icono.removeClass('asc').addClass('desc').html(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        `);
            }
        } else {
            // Si no está ordenada, establece como ascendente por defecto
            tabla.order([0, 'asc']).draw();
            icono.removeClass('desc').addClass('asc').html(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        `);
        }
    }
</script>