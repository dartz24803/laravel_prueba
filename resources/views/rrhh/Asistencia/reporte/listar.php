<?php
    $sesion =  Session('usuario');
    $id_nivel = Session('usuario')->id_nivel;
    $id_puesto = Session('usuario')->id_puesto;

?>
<table id="multi-column-orderingg" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Centro de Labores</th>
            <th>DNI</th>
            <th>Colaborador</th>
            <th>Fecha</th>
            <th>Ingreso</th>
            <th>Inicio Descanso</th>
            <th>Fin Descanso</th>
            <th>Salida</th>

            <th>Día Laborado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $p=1;$d=0;
            for($i=$fecha_inicio; $i<=$fecha_fin; $i+=86400){
                $no=$p;  $n=count($list_colaborador);
                foreach($list_colaborador as $list){
                    $busq_modulo = in_array($list['num_doc']."-".date("d-m-Y",$i), array_column($list_asistencia, 'validador'));
                    $posicion = array_search($list['num_doc']."-".date("d-m-Y",$i), array_column($list_asistencia, 'validador'));
                    $cadenaConvert = str_replace(" ", "-", $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']);
                    ?><tr><?php
                            $fecha = date("d-m-Y",$i);
                            $numeroDia = date('d', strtotime($fecha));
                            $dia = date('l', strtotime($fecha));
                            $mes = date('F', strtotime($fecha));
                            $anio = date('Y', strtotime($fecha));
                            $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                            $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                            $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                            $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                            $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                            $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                    if ($busq_modulo == true) {
                        if($nombredia=="Sábado"){?>
                            <td><?php echo $no; ?></td>
                            <td> <?php echo $list['centro_labores']; ?> </td>
                            <td> <?php echo $list['num_doc']; ?> </td>
                            <td> <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?></td>
                            <td> <?PHP  echo $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
                             ?> </td>
                            <td> <?php if($list_asistencia[$posicion]['ingreso']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['ingreso']);
                                echo $parte[0];
                                ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia/' .$parte[1]/ .$cadenaConvert) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                                <?php
                                }else{?>
                                    <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia/' echo date('d-m-Y',$i);/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </a>
                                <?php } ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td> <?php if($list_asistencia[$posicion]['salidasabado']!=null){
                                    $parte = explode("--", $list_asistencia[$posicion]['salidasabado']);
                                    echo $parte[0];
                                    ?><a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia/' .$parte[1]/ .$cadenaConvert) }}" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </a><?php
                                }else{?>
                                    <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Modal_Reg_Asistencia/' .date('d-m-Y',$i);/ .$list['num_doc'];/ .$cadenaConvert/1) }}" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </a>
                                <?php } ?>
                            </td>
                            <td> <?php if($list_asistencia[$posicion]['ingreso']!=null && $list_asistencia[$posicion]['salidasabado']!=null){ if($n_documento!=0){$d=$d+1;}  echo "1"; }else{echo "0"; } ?> </td>
                            <td>
                                <a href="javascript:void(0);" title="Detalle" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="{{ url('Modal_Marcaciones_Todo/'.date('d-m-Y',$i); / .$list['num_doc']; / .$cadenaConvert) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
                            </td>
                        <?php }else{?>
                            <td><?php echo $no; ?></td>
                            <td> <?php echo $list['centro_labores']; ?> </td>
                            <td> <?php echo $list['num_doc']; ?> </td>
                            <td> <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?></td>
                            <td> <?PHP  echo $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
                             ?> </td>
                            <td> <?php if($list_asistencia[$posicion]['ingreso']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['ingreso']);
                                echo $parte[0];
                                ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia') ?>/ .$parte[1]/ .$cadenaConvert) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                                <?php
                                }else{?>
                                    <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistenci/' .date('d-m-Y',$i)/ .$list['num_doc']/<?php echo $cadenaConvert; ?>/1" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </a>
                                <?php } ?>
                            </td>
                            <td> <?php if($list_asistencia[$posicion]['idescanso']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['idescanso']);
                                echo $parte[0];
                                ?><a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia') ?>/<?php echo $parte[1]; ?>/<?php echo $cadenaConvert; ?>" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a><?php
                            }else{?>
                                <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                                <?php } ?>
                            </td>
                            <td> <?php if($list_asistencia[$posicion]['fdescanso']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['fdescanso']);
                                echo $parte[0];
                                ?><a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia') ?>/<?php echo $parte[1]; ?>/<?php echo $cadenaConvert; ?>" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a><?php
                            }else{?>
                                <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                                <?php } ?>
                            </td>
                            <td> <?php if($list_asistencia[$posicion]['salida']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['salida']);
                                echo $parte[0];
                                ?><a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia') ?>/<?php echo $parte[1]; ?>/<?php echo $cadenaConvert; ?>" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a><?php
                            }else{?>
                                <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                                <?php } ?>
                            </td>

                            <td> <?php if($list_asistencia[$posicion]['ingreso']!=null && $list_asistencia[$posicion]['idescanso']!=null &&
                            $list_asistencia[$posicion]['fdescanso']!=null && $list_asistencia[$posicion]['salida']!=null || $nombredia=="Domingo"){
                                if(date("Y-m-d",$i)>=$list['fec_inicio']){$d=$d+1; echo "1";}else{echo "0";}   }else{echo "0"; } ?> </td>
                            <td>
                                <a href="javascript:void(0);" title="Detalle" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="{{ url('Asistencia/Modal_Marcaciones_Todo') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
                            </td>
                        <?php } ?>

                    <?php }
                    else{
                        if($nombredia=="Sábado"){?>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $list['centro_labores'] ?></td>
                            <td> <?php echo $list['num_doc']; ?> </td>
                            <td> <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?></td>
                            <td> <?PHP  echo $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio; ?> </td>
                            <td>
                                <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                                <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            </td>
                            <td>0</td>
                            <td>
                                <a href="javascript:void(0);" title="Detalle" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="{{ url('Asistencia/Modal_Marcaciones_Todo') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
                            </td>
                        <?php }else{?>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $list['centro_labores'] ?></td>
                            <td> <?php echo $list['num_doc']; ?> </td>
                            <td> <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?></td>
                            <td> <?PHP  echo $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio; ?> </td>
                            <td>
                                <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0);"  title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Reg_Asistencia') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>/1" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            </td>
                            <td><?php if($nombredia=="Domingo"){
                                if(date("Y-m-d",$i)>=$list['fec_inicio']){$d=$d+1; echo "1";}else{echo "0";}  }else{echo "0"; } ?></td>
                            <td>
                                <a href="javascript:void(0);" title="Detalle" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="{{ url('Asistencia/Modal_Marcaciones_Todo') ?>/<?php echo date("d-m-Y",$i); ?>/<?php echo $list['num_doc']; ?>/<?php echo $cadenaConvert; ?>" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
                            </td>
                        <?php } }
                    ?>

                </tr><?php $no=$no+1; $n=$n-1;
                    if($n==0){
                        $p=$no;
                    }
                }
            }
            if($n_documento!=0){
                ?><script>
                    $('#dias_l').html('<label class="control-label text-bold"><b>Dias Laborados: <?php echo $d; ?> </b></label>');
                </script><?php
            }else{ ?>
            <script>
                $('#dias_l').html('');
            </script><?php } ?>
    </tbody>
</table>

<script>
$('#multi-column-orderingg').DataTable({
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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
</script>
