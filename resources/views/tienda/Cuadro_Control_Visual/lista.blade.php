<?php
$id_puesto = Session::get('usuario')->id_puesto;
$id_usuario = Session::get('usuario')->id_usuario;
//0btener fecha actual para comparar con horario de los trabajadores
date_default_timezone_set('America/Lima');
$fecha_actual = new DateTime();
$hora_actual = $fecha_actual->format('H:i');

?>
<div class="toolbar d-flex mt-4">
    <div class="row col-md-12">
        <div class="col-md-2 card h-50 justify-content-center">
            <span class="d-flex justify-content-center" id="fechaActual"></span>
        </div>
        <div class="col-md-10 mb-5">
            <?php if ($contador_vendedores) : ?>
                <?php foreach ($contador_vendedores ?? [] as $row) : ?>
                    <div class="row">
                        <div class="col-md-3 ml-4">N° de vendedores (CAP):</div>
                        <div class="card row">
                            <div class="col-md-12 d-flex align-items-center"><?php echo intval($row['cap_aprobado'] ?? 0) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="row">
                        <div class="col-md-3 ml-4">N° vendedores (CAP):</div>
                        <div class="card row">
                            <div class="col-md-12 d-flex align-items-center"> 0</div>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($contador_presentes ?? [] as $row) : ?>
                        <div class="col-md-3 ml-4">N° de vendedores presentes: </div>
                        <div class="card row">
                            <div class="col-md-12 d-flex align-items-center"><?php echo intval($row['contador_presentes_ccv'] ?? 0) ?></div>
                        </div>
                    <?php endforeach; ?>
                    <?php foreach ($contador_total_x_bases ?? [] as $row) : ?>
                        <div class="col-md-3 ml-4">N° total:</div>
                        <div class="card row">
                            <div class="col-md-12 d-flex align-items-center"><?php echo intval($row['contador_total_x_bases'] ?? 0) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                    </div>
        </div>
    </div>


    <table id="tabla_js" class="table" style="width:100%">
        <thead>
            <tr class="text-center">
                <th scope="col" class="col-2">Puesto</th>
                <th scope="col" class="col-5">Horario</th>
                <th scope="col" class="col-2">Estado</th>
                <th scope="col" class="col-1">Ícono</th>
                <th>Contacto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuadro_control_visual as $list) { ?>
                <tr>
                    <td class="text-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <span class="mytooltip tooltip-effect-1">
                                        <span class="tooltip-item"><?php echo $list['nom_puesto']; ?></span>
                                        <span class="tooltip-content clearfix d-flex align-items-center justify-content-center">
                                            <?php
                                            if (empty($list['foto']) || is_null($list['foto'])) {
                                                // Mostrar la imagen por defecto si la foto está vacía o nula
                                                $imagenPorDefecto = 'template\assets\img\avatar.jpg';
                                                echo '<img style="width: 60px; height: 60px; margin-left:10%" src="' . $imagenPorDefecto . '" alt="Foto">';
                                            } else {
                                                echo '<img style="width: 60px; height: 60px; margin-left:10%" src="' . $list['foto'] . '" alt="Foto">';
                                            }
                                            ?>
                                            <span class="tooltip-text"><?php echo $list['usuario_nombres'] . ' ' . $list['usuario_apater'] . ' - ' . $list['usuario_codigo'] ?></span>
                                        </span>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <?php if ($list['ini_refri'] == '00:00:00' && $list['fin_refri'] && $list['ini_refri2'] == '00:00:00' && $list['fin_refri2'] == '00:00:00') {
                            $horario = $list['hora_entrada'] . ' ' . $list['hora_salida'];
                        } else if ($list['ini_refri2'] == '00:00:00' && $list['fin_refri2'] == '00:00:00') {
                            $horario = $list['hora_entrada'] . ' ' . $list['ini_refri'] . ' ' . $list['fin_refri'] . ' ' . $list['hora_salida'];
                        } else {
                            $horario = $list['hora_entrada'] . ' ' . $list['ini_refri'] . ' ' . $list['fin_refri'] . ' ' . $list['ini_refri2'] . ' ' . $list['fin_refri2'] . ' ' . $list['hora_salida'] . ' ';
                        } 
                        echo $horario;
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if ($list['hora_entrada'] < $hora_actual && $hora_actual < $list['hora_salida']) {
                            if ($list['estado'] == 1) {
                                $color = '#68f76d';
                                $texto = 'white';
                                $estilo = 'style="background-color: #68f76d; color: white"';
                                $badge = 'PRESENTE';
                            } else if ($list['estado'] == 3) {
                                $color = '#fc0303';
                                $texto = 'white';
                                $estilo = 'style="background-color: #fc0303; color: white"';
                                $badge = 'FALTÓ';
                            } else if ($list['estado'] == 4) {
                                $color = '#6376ff';
                                $texto = 'white';
                                $estilo = 'style="background-color: #6376ff; color: white"';
                                $badge = 'LIBRE';
                            } else if ($list['estado'] == 5) {
                                $color = 'gray';
                                $texto = 'black';
                                $estilo = 'style="background-color: gray; color: white;"';
                                $badge = 'VACANTE';
                            } else if ($list['estado'] == 6) {
                                $color = '#00b1f4';
                                $texto = 'black';
                                $estilo = 'style="background-color: #00b1f4; color: white"';
                                $badge = 'PERMISO';
                            } else if ($list['estado'] == 7) {
                                $color = '#FFA700';
                                $texto = 'white';
                                $estilo = 'style="background-color: #FFA700; color: white"';
                                $badge = 'ALMUERZO';
                            } else {
                                $color = 'gray';
                                $texto = 'black';
                                $estilo = 'style="background-color: gray; color: white;"';
                                $badge = 'VACANTE';
                            }
                            if ($list['hora_salida'] > $hora_actual && $hora_actual > $list['hora_entrada']) {
                                $color = '#68f76d';
                                $texto = 'white';
                                $estilo = 'style="background-color: #68f76d; color: white"';
                                $badge = 'PRESENTE'; ?>
                                <script>
                                    function Asignar_Estado1(id_usuario, ejecutarLlamadaAjax = true) {
                                        var select = $('#estado_' + id_usuario);

                                        if (ejecutarLlamadaAjax) {
                                            //Cargando();
                                            var estado = $('#estado_' + id_usuario).val();
                                            var url = "{{ url('Insert_Cuadro_Control_Visual_Estado1') }}";
                                            var csrfToken = $('input[name="_token"]').val();

                                            $.ajax({
                                                url: url,
                                                data: {
                                                    'id_usuario': id_usuario,
                                                    'estado': 1,
                                                },
                                                type: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': csrfToken
                                                },
                                            });
                                        }

                                    }
                                    Asignar_Estado1({{ $list['id_usuario'] }});
                                    // Lista_Cuadro_Control_Visual();
                                </script>
                                <?php
                            }
                            if ($list['ini_refri'] < $hora_actual && $hora_actual < $list['fin_refri']) {
                                $color = '#ffa700';
                                $texto = 'black';
                                $estilo = 'style="background-color: #ffa700; color: white"';
                                $badge = 'ALMUERZO';
                            }
                        } else {
                            if ($list['estado'] == 1) {
                                $color = '#68f76d';
                                $texto = 'white';
                                $estilo = 'style="background-color: #68f76d; color: white"';
                                $badge = 'PRESENTE';
                                if ($list['ini_refri'] < $hora_actual && $hora_actual < $list['fin_refri']) {
                                    $color = '#ffa700';
                                    $texto = 'black';
                                    $estilo = 'style="background-color: #ffa700; color: white"';
                                    $badge = 'ALMUERZO';
                                }
                            } else if ($list['estado'] == 2 || ($list['ini_refri2'] < $hora_actual && $hora_actual < $list['fin_refri2'])) {
                                $color = '#f7cd11';
                                $texto = 'black';
                                $estilo = 'style="background-color: #f7cd11; color: white"';
                                $badge = 'BREAK';
                            } else if ($list['estado'] == 3) {
                                $color = '#fa5c5c';
                                $texto = 'white';
                                $estilo = 'style="background-color: #fa5c5c; color: white"';
                                $badge = 'FALTÓ';
                            } else if ($list['estado'] == 4) {
                                $color = '#6376ff';
                                $texto = 'white';
                                $estilo = 'style="background-color: #6376ff; color: white"';
                                $badge = 'LIBRE';
                            } else if ($list['estado'] == 5) {
                                $color = 'gray';
                                $texto = 'black';
                                $estilo = 'style="background-color: gray; color: white;"';
                                $badge = 'VACANTE';
                            } else if ($list['estado'] == 6) {
                                $color = '#00b1f4';
                                $texto = 'black';
                                $estilo = 'style="background-color: #00b1f4; color: white"';
                                $badge = 'PERMISO';
                            } else if ($list['estado'] == 7) {
                                $color = '#FFA700';
                                $texto = '#FFA700';
                                $estilo = 'style="background-color: #FFA700; color: white"';
                                $badge = 'ALMUERZO';
                            } else {
                                if ($list['hora_entrada'] == null || $list['hora_entrada'] == '00:00:00') {
                                    $color = 'gray';
                                    $texto = 'black';
                                    $estilo = 'style="background-color: gray; color: white;"';
                                    $badge = 'VACANTE';
                                }else{
                                    $color = 'none';
                                    $texto = 'none';
                                    $estilo = 'style="color: none"';
                                    $badge = 'SELECCIONE';
                                }
                            }
                        }
                        if ($list['ini_refri2'] < $hora_actual && $hora_actual < $list['fin_refri2']) {
                            $color = '#f7cd11';
                            $texto = 'black';
                            $estilo = 'style="background-color: #f7cd11; color: white"';
                            $badge = 'BREAK';
                        }
                        if ($list['estado'] == 1) {
                            $color = '#68f76d';
                            $texto = 'white';
                            $estilo = 'style="background-color: #68f76d; color: white"';
                            $badge = 'PRESENTE';
                        } else if ($list['estado'] == 3) {
                            $color = '#fc0303';
                            $texto = 'white';
                            $estilo = 'style="background-color: #fc0303; color: white"';
                            $badge = 'FALTÓ';
                        } else if ($list['estado'] == 4) {
                            $color = '#6376ff';
                            $texto = 'white';
                            $estilo = 'style="background-color: #6376ff; color: white"';
                            $badge = 'LIBRE';
                        } else if ($list['estado'] == 5) {
                            $color = 'gray';
                            $texto = 'black';
                            $estilo = 'style="background-color: gray; color: white;"';
                            $badge = 'VACANTE';
                        } else if ($list['estado'] == 6) {
                            $color = '#00b1f4';
                            $texto = 'black';
                            $estilo = 'style="background-color: #00b1f4; color: white"';
                            $badge = 'PERMISO';
                        } else if ($list['estado'] == 7) {
                            $color = '#FFA700';
                            $texto = 'white';
                            $estilo = 'style="background-color: #FFA700; color: white"';
                            $badge = 'ALMUERZO';
                        }
                        //para administrador y coordinador de tienda
                        if ($id_puesto == 29 || $id_puesto == 161 || $id_puesto == 197 || $id_usuario == 139) { ?>
                        <select <?php echo $estilo; ?> class="form-control mt-0" id="estado_<?php echo $list['id_usuario']; ?>" name="estado" onchange="Asignar_Estado(<?php echo $list['id_usuario']; ?>);">
                            <option <?php if ($badge == 'ALMUERZO') {
                                    echo $estilo;
                                } else { ?>style="background-color: white; color: #f29b05" <?php }; ?> value="0" <?php if ($list['estado'] == null) { echo 'selected'; } ?>>Seleccionar</option>
                            <option <?php if ($badge == 'PRESENTE') {
                                    echo $estilo;
                                } else { ?>style="background-color: white; color: #f29b05" <?php }; ?> class="text-success" value="1" <?php if ($badge == 'PRESENTE') { echo 'selected'; } ?>>Presente</option>
                            <option <?php if ($badge == 'BREAK') {
                                    echo $estilo;
                                } else { ?>style="background-color: white; color: #f29b05" <?php }; ?> class="text-warning" value="2" <?php if ($badge == 'BREAK') { echo 'selected'; } ?>>Break</option>
                            <option <?php if ($badge == 'FALTÓ') {
                                    echo $estilo;
                                } else { ?>style="background-color: white; color: #f29b05" <?php }; ?> class="text-danger" value="3" <?php if ($badge == 'FALTÓ') { echo 'selected'; } ?>>Faltó</option>
                            <option <?php if ($badge == 'LIBRE') {
                                    echo $estilo;
                                } else { ?>style="background-color: white; color: #f29b05" <?php }; ?> class="text-primary" value="4" <?php if ($badge == 'LIBRE') { echo 'selected'; } ?>>Libre</option>
                            <option <?php if ($badge == 'VACANTE') {
                                    echo $estilo;
                                } else { ?>style="background-color: gray; color: white" <?php }; ?> class="text-light" value="5" <?php if ($badge == 'VACANTE') { echo 'selected'; } ?>>Vacante</option>
                            <option <?php if ($badge == 'PERMISO') {
                                    echo $estilo;
                                } else { ?>style="background-color: white; color: #f29b05" <?php }; ?> class="text-info" value="6" <?php if ($badge == 'PERMISO') { echo 'selected'; } ?>>Permiso</option>
                            <option <?php if ($badge == 'ALMUERZO') {
                                    echo $estilo;
                                } else { ?>style="background-color: white; color: #f29b05" <?php }; ?> style style="color: #FFA700" value="7" <?php if ($badge == 'ALMUERZO') { echo 'selected'; } ?>>Almuerzo</option>
                        </select>
                        <?php } else {
                        ?>
                            <div class="rounded-circular-borders" <?= $estilo ?>>
                                <span><?= $badge ?></span>
                            </div>
                        <?php } ?>
                    </td>
                    <td id="iconoEstado_<?php echo $list['id_usuario']; ?>" class="text-center">
                        <svg id="icono_<?php echo $list['id_usuario']; ?>" style="color: <?= $color ?>" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 24 24" fill="<?= $color ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </td>
                    <td><a href="tel:+51<?php echo $list['num_celp'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="<?= $color ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-outgoing">
                                <polyline points="23 7 23 1 17 1"></polyline>
                                <line x1="16" y1="8" x2="23" y2="1"></line>
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg></a>
                        <a href="https://api.whatsapp.com/send?phone=51<?php echo $list['num_celp'] ?>&text=hola,%20<?php echo $list['usuario_nombres']; ?>" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-outgoing text-success">
                                <polyline points="23 7 23 1 17 1"></polyline>
                                <line x1="16" y1="8" x2="23" y2="1"></line>
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </a>
                        <?php echo $list['num_celp']; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#tabla_js').DataTable({
                "oLanguage": {
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
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
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "Todos"]
                ],
                "pageLength": -1
            });
            mostrarHora();
        });

        function Asignar_Estado(id_usuario, ejecutarLlamadaAjax = true) {
            var seleccion = $('#estado_' + id_usuario).val();
            var icono = $('#icono_' + id_usuario);
            var select = $('#estado_' + id_usuario);
            // var id_horario = $('#horario_' + id_usuario).val();

            switch (seleccion) {
                case '1':
                    select.css({
                        'border-color': '#31a626',
                        'background-color': '#31a626'
                    }).addClass('text-white');
                    icono.css({
                        'fill': '#31a626',
                        'color': '#31a626'
                    });
                    break;
                case '2':
                    select.css({
                        'border-color': '#FFE881',
                        'background-color': '#FFE881'
                    }).addClass('text-dark');
                    icono.css({
                        'fill': '#FFE881',
                        'color': '#FFE881'
                    });
                    break;
                case '3':
                    select.css({
                        'border-color': '#fc0303',
                        'background-color': '#fc0303'
                    }).addClass('text-white');
                    icono.css({
                        'fill': '#fc0303',
                        'color': '#fc0303'
                    });
                    break;
                case '4':
                    select.css({
                        'border-color': '#0f26d4',
                        'background-color': '#0f26d4'
                    }).addClass('text-white');
                    icono.css({
                        'fill': '#0f26d4',
                        'color': '#0f26d4'
                    });
                    break;
                case '5':
                    select.css({
                        'border-color': 'black',
                        'background-color': 'black'
                    }).addClass('text-light');
                    icono.css({
                        'fill': 'black',
                        'color': 'black'
                    });
                    break;
                case '6':
                    select.css({
                        'border-color': '#83f2f0',
                        'background-color': '#83f2f0'
                    }).addClass('text-black');
                    icono.css({
                        'fill': '#83f2f0',
                        'color': '#83f2f0'
                    });
                    break;
                case '7':
                    select.css({
                        'border-color': '#f29b05',
                        'background-color': '#f29b05'
                    }).addClass('text-black');
                    icono.css({
                        'fill': '#f29b05',
                        'color': '#f29b05'
                    });
                    break;
            }
            // if (id_horario == 0) {
            //     select.val('0');
            //     Swal(
            //         'Ups!',
            //         'Debe seleccionar horario.',
            //         'warning'
            //     ).then(function() {});
            //     return false;
            // } else {
            if (ejecutarLlamadaAjax) {
                //no cargar al momento de iniciar
                Cargando();
                var estado = $('#estado_' + id_usuario).val();
                var url = "<?= url('Insert_Cuadro_Control_Visual_Estado') ?>";
                var csrfToken = $('input[name="_token"]').val();

                $.ajax({
                    url: url,
                    data: {
                        'id_usuario': id_usuario,
                        'estado': estado,
                    },
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(data) {
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        )
                    }
                });
            }
            Lista_Cuadro_Control_Visual();
            // }
        }

        function Asignar_Horario(id_usuario) {
            Cargando();
            var id_horario = $('#horario_' + id_usuario).val();
            var url = "<?= url('Insert_Cuadro_Control_Visual_Horario') ?>";
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                data: {
                    'id_horario': id_horario,
                    'id_usuario': id_usuario
                },
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data) {
                    if (data == 'a') {
                        $('#estado_' + id_usuario).val('1');
                        $('#estado_' + id_usuario).css({
                            'background-color': '#31a626',
                            'color': 'white'
                        });
                        $('#icono_' + id_usuario).css({
                            'color': '#31a626',
                            'fill': '#31a626'
                        });
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        )
                    } else if (data == 'ab') {
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        )
                        $('#estado_' + id_usuario).val('7');
                        $('#estado_' + id_usuario).css({
                            'background-color': '#FFA700',
                            'color': 'black'
                        });
                        $('#icono_' + id_usuario).css({
                            'color': '#FFA700',
                            'fill': '#FFA700'
                        });
                    } else if (data == 'ac') {
                        console.log('break');
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        )
                        $('#estado_' + id_usuario).val('2');
                        $('#estado_' + id_usuario).css({
                            'background-color': '#FFE881',
                            'color': 'black'
                        });
                        $('#icono_' + id_usuario).css({
                            'color': '#FFE881',
                            'fill': '#FFE881'
                        });
                    } else {
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        )
                    }
                }
            });
            setTimeout(function() {
                // Lista_Cuadro_Control_Visual();
                $('#tabla_js').DataTable().ajax.reload();
            }, 200);
        }

        function mostrarHora() {
            var fechaActual = new Date();

            var horas = fechaActual.getHours();
            var minutos = fechaActual.getMinutes();
            var segundos = fechaActual.getSeconds();
            var dia = fechaActual.getDate();
            var mes = fechaActual.getMonth() + 1; // Sumar 1 porque los meses comienzan desde 0
            var anio = fechaActual.getFullYear();

            horas = (horas < 10) ? "0" + horas : horas;
            minutos = (minutos < 10) ? "0" + minutos : minutos;
            dia = (dia < 10) ? "0" + dia : dia;
            mes = (mes < 10) ? "0" + mes : mes;

            var horaFormateada = horas + ":" + minutos;
            var fechaFormateada = dia + "/" + mes + "/" + anio;

            document.getElementById("fechaActual").textContent = fechaFormateada + ' ' + horaFormateada;

            // Actualizar la hora y fecha cada segundo
            setTimeout(mostrarHora, 1000);
        }
    </script>

    <style>
        body {
            background-color: #E0E0E0
        }

        h5 {
            color: #fff
        }

        .mytooltip {
            display: inline;
            position: relative;
            z-index: 999
        }

        .mytooltip .tooltip-item {
            cursor: pointer;
            display: inline-block;
            font-weight: 500;
            padding: 0 10px
        }

        .mytooltip .tooltip-content {
            position: absolute;
            z-index: 9999;
            width: 355px;
            left: 80%;
            margin: 0 0 20px -180px;
            bottom: 100%;
            text-align: left;
            font-size: medium;
            line-height: 30px;
            -webkit-box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
            box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
            background: #2b2b2b;
            opacity: 0;
            cursor: default;
            pointer-events: none;
        }

        .mytooltip .tooltip-content::after {
            content: '';
            top: 100%;
            left: 50%;
            border: solid transparent;
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-color: #2a3035 transparent transparent;
            border-width: 10px;
            margin-left: -10px
        }

        .mytooltip .tooltip-content img {
            position: relative;
            height: 140px;
            display: block;
            float: left;
            margin-right: 1em
        }

        .mytooltip .tooltip-item::after {
            content: '';
            position: absolute;
            width: 360px;
            height: 20px;
            bottom: 100%;
            left: 50%;
            pointer-events: none;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%)
        }

        .mytooltip:hover .tooltip-item::after {
            pointer-events: auto
        }

        .mytooltip:hover .tooltip-content {
            pointer-events: auto;
            opacity: 1;
            -webkit-transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg);
            transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg)
        }

        .mytooltip:hover .tooltip-content2 {
            opacity: 1;
            font-size: 18px
        }

        .mytooltip .tooltip-text {
            font-size: small;
            line-height: 24px;
            display: block;
            padding: 1.31em 1.21em 1.21em 0;
            color: #fff
        }

        .rounded-circular-borders {
            border-top-left-radius: 11px;
            border-top-right-radius: 11px;
            border-bottom-left-radius: 11px;
            border-bottom-right-radius: 11px;
        }
    </style>