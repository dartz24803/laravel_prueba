<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead class="text-center">
        <tr>
            @if (session('usuario')->id_nivel==1 || session('usuario')->id_puesto==23)
                <th class="no-content"></th>
            @endif
            <th>Base</th>
            <th>Fecha</th>
            <th>Ingreso P</th>
            <th>Ingreso R</th>
            <th>Diferencia</th>
            <th>Obs</th>
            <th>Apertura P</th>
            <th>Apertura R</th>
            <th>Diferencia</th>
            <th>Obs</th>
            <th>Cierre P</th>
            <th>Cierre R</th>
            <th>Diferencia</th>
            <th>Obs</th>
            <th>Salida P</th>
            <th>Salida R</th>
            <th>Diferencia</th>
            <th>Obs</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_apertura_cierre_tienda as $list)
            <tr class="text-center">
                <td>
                    @if ($list->tipo_apertura!="0")
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                        app_elim="{{ route('apertura_cierre.edit', $list->id_apertura_cierre) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </a>
                    @endif
                </td>
                <td>{{ $list->cod_base }}</td>
                <td>{{ $list->fecha }}</td>
                <?php //if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_puesto']==23){ ?>
                    <td>{{ $list->ingreso_programado }}</td>
                    <td>{{ $list->ingreso_real }}</td>
                    <td>{{ $list->ingreso_diferencia }}</td>
                    <td>{{ $list->obs_ingreso }}</td>
                    <td>{{ $list->apertura_programada }}</td>
                    <td>{{ $list->apertura_real }}</td>
                    <td>{{ $list->apertura_diferencia }}</td>
                    <td>{{ $list->obs_apertura }}</td>
                    <td>{{ $list->cierre_programado }}</td>
                    <td>{{ $list->cierre_real }}</td>
                    <td>{{ $list->cierre_diferencia }}</td>
                    <td>{{ $list->obs_cierre }}</td>
                    <td>{{ $list->salida_programada }}</td>
                    <td>{{ $list->salida_real }}</td>
                    <td>{{ $list->salida_diferencia }}</td>
                    <td>{{ $list->obs_salida }}</td>
                <?php /*}else{ ?>
                    <td><?php echo $h_ingreso ?></td> 
                    <td>
                        <?php echo $list['ingreso_vista']; ?>
                        <?php if($list['ingreso_vista']==""){ ?>
                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Update_Apertura_Cierre_Tienda') ?>/<?php echo $list['id_apertura_cierre']; ?>/1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a> 
                        <?php } ?>
                    </td>
                    <td <?php $color="";
                    if($list['ingreso_vista']!="" && $h_ingreso!=""){
                        $horaInicio = new DateTime($h_ingreso);
                        $horaTermino = new DateTime($list['ingreso_vista']);
                        $interval = $horaInicio->diff($horaTermino);
                        if($list['ingreso_vista']<=$h_ingreso){$color="green";}else{$color="red";}
                    }?> style="color:<?php echo $color; ?>">
                    <?php if($list['ingreso_vista']!="" && $h_ingreso!=""){echo $interval->format('%H:%i'); }?>
                    </td>
                    <td>
                        <?php echo $list['obs_ingreso']; ?>
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Obs_Apertura_Cierre_Tienda') ?>/<?php echo $list['id_apertura_cierre']; ?>/1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a> 
                    </td>
                    <td><?php echo $h_apertura ?></td>
                    <td>
                        <?php echo $list['apertura_vista']; ?>
                        <?php if($list['ingreso_vista']!="" && $list['apertura_vista']==""){ ?>
                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Update_Apertura_Cierre_Tienda') ?>/<?php echo $list['id_apertura_cierre']; ?>/2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a> 
                        <?php } ?>
                    </td>
                    <td <?php $color="";
                    if($list['apertura_vista']!="" && $h_apertura!=""){
                        $horaInicio = new DateTime($h_apertura);
                        $horaTermino = new DateTime($list['apertura_vista']);
                        $interval = $horaInicio->diff($horaTermino);
                        if($list['apertura_vista']<=$h_apertura){$color="green";}else{$color="red";}
                    }?> style="color:<?php echo $color; ?>"><?php if($list['apertura_vista']!="" && $h_apertura!=""){echo $interval->format('%H:%i'); }?></td>
                    <td>
                        <?php echo $list['obs_apertura']; ?>
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Obs_Apertura_Cierre_Tienda') ?>/<?php echo $list['id_apertura_cierre']; ?>/2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a> 
                    </td>
                    <td><?php echo $h_cierre ?></td>
                    <td>
                        <?php echo $list['cierre_vista']; ?>
                        <?php if($list['apertura_vista']!="" && $list['cierre_vista']==""){ ?>
                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Update_Apertura_Cierre_Tienda') ?>/<?php echo $list['id_apertura_cierre']; ?>/3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a> 
                        <?php } ?>
                    </td>
                    <td <?php $color="";
                    if($list['cierre_vista']!="" && $h_cierre!=""){
                        $horaInicio = new DateTime($h_cierre);
                        $horaTermino = new DateTime($list['cierre_vista']);
                        $interval = $horaInicio->diff($horaTermino);
                        if($list['cierre_vista']<=$h_cierre){$color="green";}else{$color="red";}
                    }?> style="color:<?php echo $color; ?>"><?php if($list['cierre_vista']!="" && $h_cierre!=""){echo $interval->format('%H:%i'); }?></td>
                    <td>
                        <?php echo $list['obs_cierre']; ?>
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Obs_Apertura_Cierre_Tienda') ?>/<?php echo $list['id_apertura_cierre']; ?>/3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a> 
                    </td>
                    <td><?php echo $h_salida ?></td>
                    <td>
                        <?php echo $list['salida_vista']; ?>
                        <?php if($list['cierre_vista']!="" && $list['salida_vista']==""){ ?>
                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Update_Apertura_Cierre_Tienda') ?>/<?php echo $list['id_apertura_cierre']; ?>/4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a> 
                        <?php } ?>
                    </td>
                    <td <?php $color="";
                    if($list['salida_vista']!="" && $h_salida!=""){
                        $horaInicio = new DateTime($h_salida);
                        $horaTermino = new DateTime($list['salida_vista']);
                        $interval = $horaInicio->diff($horaTermino);
                        if($list['salida_vista']<=$h_salida){$color="green";}else{$color="red";}
                    }?> style="color:<?php echo $color; ?>"><?php if($list['salida_vista']!="" && $h_salida!=""){echo $interval->format('%H:%i'); }?></td>
                    <td>
                        <?php echo $list['obs_salida']; ?>
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Obs_Apertura_Cierre_Tienda') ?>/<?php echo $list['id_apertura_cierre']; ?>/4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a> 
                    </td>
                <?php }*/ ?>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
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
</script>