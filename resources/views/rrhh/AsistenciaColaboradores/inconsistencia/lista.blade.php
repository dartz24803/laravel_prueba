<table id="zero-configgge" class="table table-hover non-hover" style="width:100%">
    <thead>
        <tr>
            <th>Colaborador</th>
            <th>DNI</th>
            <th>Base</th>
            <th>Fecha</th>
            <th>Turno</th>
            <th>Entrada</th>
            <th>SALIDA&nbsp;A REFRIGERIO</th>
            <th>ENTRADA&nbsp;DE REFRIGERIO</th>
            <th>SALIDA</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_asistenciai as $list): ?>
            <tr>
                <td><?php echo $list->colaborador; ?></td>
                <td><?php echo $list->num_doc; ?></td>
                <td><?php echo $list->centro_labores; ?></td>
                <td><?php echo $list->fecha; ?></td>
                <td><?php echo $list->turno; ?></td>

                <?php
                // Marcaciones de entrada
                $marcacionesEntrada = explode(', ', $list->entrada); // Corrected with -> for object property
                $isEntradaEmpty = (count($marcacionesEntrada) == 1 && $marcacionesEntrada[0] == "");
                ?>
                <td class="<?php echo $isEntradaEmpty ? 'iconEditGray1' : ''; ?>">
                    <?php if (!$isEntradaEmpty): ?>
                        <?php if (count($marcacionesEntrada) > 0 && $marcacionesEntrada[0] != ""): ?>
                            <ul>
                                <?php foreach ($marcacionesEntrada as $marcacion): ?>
                                    <li><?php echo $marcacion; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <span>--:--</span>
                            <?php if ($list->tipo_inconsistencia == 3): ?>
                                <svg id="btn_edit" onclick="Sin_Horario()" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.3791 18.0001H3.99809C2.89762 18.0001 2 17.1115 2 16.0222V5.84165C2 4.75231 2.89762 3.86377 3.99809 3.86377H11.5949V4.86777H3.99809C3.45546 4.86777 3.01426 5.30451 3.01426 5.84165V16.0172C3.01426 16.5543 3.45546 16.9911 3.99809 16.9911H14.3791C14.9217 16.9911 15.3629 16.5543 15.3629 16.0172V8.05045H16.3772V16.0172C16.3772 17.1115 15.4796 18.0001 14.3791 18.0001Z" fill="#323232" />
                                    <path d="M7.29449 13.4167C7.06628 13.4167 6.84821 13.3264 6.68593 13.1657C6.49829 12.975 6.41208 12.7189 6.44251 12.4529L6.73157 10.2692C6.74679 10.1588 6.7975 10.0583 6.87357 9.97803L14.298 2.62875C15.1449 1.79042 16.5243 1.79042 17.3712 2.62875C17.7769 3.03035 18 3.56247 18 4.12973C18 4.69699 17.7769 5.22911 17.3712 5.63071L9.92651 13.0051C9.84536 13.0854 9.73887 13.1356 9.6273 13.1507L7.39592 13.4167C7.36549 13.4117 7.32999 13.4167 7.29449 13.4167ZM7.72049 10.5654L7.47706 12.3876L9.33823 12.1667L16.6612 4.91787C16.8742 4.70703 16.9909 4.42591 16.9909 4.12973C16.9909 3.83355 16.8742 3.55243 16.6612 3.34159C16.2099 2.89481 15.4745 2.89481 15.0232 3.34159L7.72049 10.5654Z" fill="#323232" />
                                </svg>
                            <?php else: ?>
                                <svg id="btn_edit" data-toggle="modal" data-target="#ModalUpdate" data-id="<?php echo $list->id_asistencia_inconsistencia; ?>/1" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.3791 18.0001H3.99809C2.89762 18.0001 2 17.1115 2 16.0222V5.84165C2 4.75231 2.89762 3.86377 3.99809 3.86377H11.5949V4.86777H3.99809C3.45546 4.86777 3.01426 5.30451 3.01426 5.84165V16.0172C3.01426 16.5543 3.45546 16.9911 3.99809 16.9911H14.3791C14.9217 16.9911 15.3629 16.5543 15.3629 16.0172V8.05045H16.3772V16.0172C16.3772 17.1115 15.4796 18.0001 14.3791 18.0001Z" fill="#323232" />
                                    <path d="M7.29449 13.4167C7.06628 13.4167 6.84821 13.3264 6.68593 13.1657C6.49829 12.975 6.41208 12.7189 6.44251 12.4529L6.73157 10.2692C6.74679 10.1588 6.7975 10.0583 6.87357 9.97803L14.298 2.62875C15.1449 1.79042 16.5243 1.79042 17.3712 2.62875C17.7769 3.03035 18 3.56247 18 4.12973C18 4.69699 17.7769 5.22911 17.3712 5.63071L9.92651 13.0051C9.84536 13.0854 9.73887 13.1356 9.6273 13.1507L7.39592 13.4167C7.36549 13.4117 7.32999 13.4167 7.29449 13.4167ZM7.72049 10.5654L7.47706 12.3876L9.33823 12.1667L16.6612 4.91787C16.8742 4.70703 16.9909 4.42591 16.9909 4.12973C16.9909 3.83355 16.8742 3.55243 16.6612 3.34159C16.2099 2.89481 15.4745 2.89481 15.0232 3.34159L7.72049 10.5654Z" fill="#323232" />
                                </svg>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('#zero-configgge').DataTable({
            responsive: true,
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
            "lengthMenu": [50, 70, 100],
            "pageLength": 50
        });
    });
</script>