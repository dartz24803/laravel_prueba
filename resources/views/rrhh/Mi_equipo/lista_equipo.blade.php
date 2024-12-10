<div class="table-responsive mb-4 mt-4" id="lista_colaborador" style="max-width:100%; overflow:auto;">
    <table id="tabla_js" class="table table-hover non-hover" style="width:100%">
        <thead>
            <tr>
                <th>Centro de Labores</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombres</th>
                <th>Tipo Documento</th>
                <th>N° Documento</th>
                <th>Cumpleaños</th>
                <th>Generación</th>
                <th>Teléfono Celular</th>
                <th>Puesto</th>
                <th>Área</th>
                <th>Fec. Ingreso</th>
                <th>Fec. Baja por Jefatura</th>
                <th>Progreso</th>
                <th class="no-content"></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($colaborador_porcentaje as $list) {  ?>
            <tr>
                <td>
                    <?php if(session('usuario')->id_puesto==23) { ?>
                        <a class="efectob" title="Ver Perfil" href="{{ url('ColaboradorController/Mi_Perfil/'. $list['id_usuario']) }}" target="_blank" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                    <?php } ?>
                    <?php echo $list['centro_labores']; ?>
                </td>
                <td><?php echo $list['usuario_apater']; ?></td>
                <td><?php echo $list['usuario_amater']; ?></td>
                <td><?php echo $list['usuario_nombres']; ?></td>
                <td><?php echo $list['cod_tipo_documento']; ?></td>
                <td><?php echo $list['num_doc']; ?></td>
                <td><?php echo $list['dia']." de ".$list['mes']; ?></td>
                <td><?php echo $list['generacion']; ?></td>
                <td><?php echo $list['num_celp']; ?></td>
                <td><?php echo $list['nom_puesto']; ?></td>
                <td><?php echo $list['nom_area']; ?></td>
                <td data-order="{{ $list['ini_funciones'] }}"><?php echo $list['fecha_ingreso']; ?></td>
                <td><?php if($list['fecha_baja']!="00-00-0000"){echo $list['fecha_baja'];} ?></td>
                <td>
                    <div class="progress br-30">
                        <div class="progress-bar br-30 bg-primary" role="progressbar" style="width: <?php
                        $porcentaje=round((($list['datos_personales']+$list['gustos_preferencias']+$list['domicilio_user']+$list['referencia']+
                        $list['cont_hijos']+$list['contactoe']+$list['estudiosg']+$list['office']+$list['idiomas']+$list['experiencial']+
                        $list['cont_enfermedades']+$list['gestacion']+$list['cont_alergia']+$list['con_otros']+$list['ref_convoc']+$list['documentacion']+
                        $list['talla_usuario']+$list['sistema_pension']+ $list['cuenta_bancaria']+$list['cont_terminos'])/20)*100,2);
                        echo $porcentaje."%"; ?>" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <?php echo $porcentaje."%"; ?>
                </td>
                <td class="text-center">
                    <div class="btn-group dropleft" role="group">
                        <a id="btnDropLeft" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="btnDropLeft" style="padding:0;">
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Update_ListaMiequipo/'. $list["id_usuario"]) }}">Resetear Contraseña</a>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Update_Baja/'. $list["id_usuario"]) }}">Comunicar Baja</a>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Update_CoordinadorJr/'. $list["id_usuario"]) }}">Asignar como Responsable</a>

                            <?php if($list['id_puesto']==36){ ?>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="Solicitud_Puesto('<?php echo $list['id_usuario']; ?>',1);">Solicitar Vendedor</a>
                                <a id="apertura_vendedor_<?= $list['id_usuario']; ?>" class="dropdown-item d-none" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Solicitud_Puesto/'. $list['id_usuario'].'/1') }}">Solicitar Vendedor Cajero Modal</a>
                            <?php } ?>
                            <?php if($list['id_puesto']==33 || $list['id_puesto']==34 || $list['id_puesto']==168){ ?>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="Solicitud_Puesto('<?php echo $list['id_usuario']; ?>',2);">Solicitar Almacenero</a>
                                <a id="apertura_almacenero_<?= $list['id_usuario']; ?>" class="dropdown-item d-none" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Solicitud_Puesto/'. $list['id_usuario'].'/2') }}">Solicitar Auxiliar de Caja Modal</a>
                            <?php } ?>
                            <?php if($list['id_puesto']==33 || $list['id_puesto']==34 || $list['id_puesto']==35 || $list['id_puesto']==168){ ?>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="Solicitud_Puesto('<?php echo $list['id_usuario']; ?>',3);">Solicitar Vendedor Cajero</a>
                                <a id="apertura_vendedor_cajero_<?= $list['id_usuario']; ?>" class="dropdown-item d-none" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Solicitud_Puesto/'. $list['id_usuario'].'/3') }}">Solicitar Vendedor Cajero Modal</a>
                            <?php } ?>
                            <?php if($list['id_puesto']==167){ ?>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="Solicitud_Puesto('<?php echo $list['id_usuario']; ?>',4);">Solicitar Auxiliar de Caja</a>
                                <a id="apertura_auxiliar_caja_<?= $list['id_usuario']; ?>" class="dropdown-item d-none" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Solicitud_Puesto/'. $list['id_usuario'].'/4') }}">Solicitar Auxiliar de Caja Modal</a>
                            <?php } ?>
                            <?php if($list['id_puesto']==32){ ?>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="Solicitud_Puesto('<?php echo $list['id_usuario']; ?>',5);">Solicitar Cajero Principal</a>
                                <a id="apertura_cajero_principal_<?= $list['id_usuario']; ?>" class="dropdown-item d-none" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Solicitud_Puesto/'. $list['id_usuario'].'/5') }}">Solicitar Cajero Principal Modal</a>
                            <?php } ?>
                            <?php if($list['id_puesto']==31){ ?>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="Solicitud_Puesto('<?php echo $list['id_usuario']; ?>',6);">Solicitar Auxiliar de Coordinador</a>
                                <a id="apertura_auxiliar_coordinador_<?= $list['id_usuario']; ?>" class="dropdown-item d-none" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Solicitud_Puesto/'. $list['id_usuario'].'/6') }}">Solicitar Auxiliar de Caja Modal</a>
                            <?php } ?>
                            <?php if($list['id_puesto']==30){ ?>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="Solicitud_Puesto('<?php echo $list['id_usuario']; ?>',7);">Solicitar Coordinador</a>
                                <a id="apertura_coordinador_<?= $list['id_usuario']; ?>" class="dropdown-item d-none" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('MiEquipo/Modal_Solicitud_Puesto/'. $list['id_usuario'].'/7') }}">Solicitar Cajero Principal Modal</a>
                            <?php } ?>

                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('MiEquipo/Modal_Horario_Mi_Equipo/'. $list["id_usuario"]) }}">Ver Horario</a>
                            <?php if(session('usuario')->id_puesto!=29 /*&& session('usuario')->id_puesto!=161*/ && session('usuario')->id_puesto!=197 && session('usuario')->id_puesto!=30 && session('usuario')->id_puesto!=314){ ?>
                                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('MiEquipo/Modal_Marcacion_Mi_Equipo/'. $list['id_usuario']) }}">Ver marcaciones</a>
                            <?php } ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $('#tabla_js').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive:true,
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

    function Solicitud_Puesto(id_usuario,tipo){
        Cargando();

        if(tipo==1){
            var puesto = "Vendedor";
        }else if(tipo==2){
            var puesto = "Almacenero";
        }else if(tipo==3){
            var puesto = "Vendedor Cajero";
        }else if(tipo==4){
            var puesto = "Auxiliar de Caja";
        }else if(tipo==5){
            var puesto = "Cajero Principal";
        }else if(tipo==6){
            var puesto = "Auxiliar de Coordinador";
        }else if(tipo==7){
            var puesto = "Coordinador";
        }

        var url="{{ url('MiEquipo/Solicitud_Puesto') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type:"POST",
            data: {'id_usuario':id_usuario,'tipo':tipo},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (data) {
                if(data=="error_organigrama"){
                    Swal({
                        title: '¡Solicitud Denegada!',
                        text: "¡No hay puesto disponible en el organigrama!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="permanencia"){
                    Swal({
                        title: 'Solicitud Denegada',
                        text: 'Para postular como '+puesto+', como mínimo tiene que cumplir 1 mes de permanencia',
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="evaluacion"){
                    Swal({
                        title: 'Solicitud Denegada',
                        text: 'El colaborador está en proceso de evaluación',
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    if(tipo==1){
                        $("#apertura_vendedor_"+id_usuario).click();
                    }else if(tipo==2){
                        $("#apertura_almacenero_"+id_usuario).click();
                    }else if(tipo==3){
                        $("#apertura_vendedor_cajero_"+id_usuario).click();
                    }else if(tipo==4){
                        $("#apertura_auxiliar_caja_"+id_usuario).click();
                    }else if(tipo==5){
                        $("#apertura_cajero_principal_"+id_usuario).click();
                    }else if(tipo==6){
                        $("#apertura_auxiliar_coordinador_"+id_usuario).click();
                    }else if(tipo==7){
                        $("#apertura_coordinador_"+id_usuario).click();
                    }
                }
            }
        });
    }
</script>
