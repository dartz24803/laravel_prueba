<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="id_gerencia">Gerencia</label>
                <div>
                    <label for="" style="color:black"><b><?php echo $get_id[0]['nom_gerencia'] ?></b></label>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="id_gerencia">Departamento/Sub-Gerencia</label>
                <div>
                    <label for="" style="color:black"><b><?= $get_id[0]['nom_sub_gerencia']; ?></b></label>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group" >
                <label for="id_area">Área</label>
                <div id="marea">
                    <label for="" style="color:black"><b><?php echo $get_id[0]['nom_area'] ?></b></label>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="id_puesto">Puesto</label>
                <div id="mpuesto">
                    <label for="" style="color:black"><b><?php echo $get_id[0]['nom_puesto'] ?></b></label>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorController/Modal_Update_Historico_Puesto/'. $get_id[0]['id_usuario']) }}" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <div>
                        <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('ColaboradorController/Modal_Detalle_Historico_Colaborador/'. $get_id[0]['id_usuario'].'/1') }}" style="color:#1b55e2">Ver historial de puestos (<?php echo $get_id[0]['cant_historico_puesto'] ?>)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="id_base">Ubicación</label>
                <div>
                    <label for="" style="color:black"><b><?php echo $get_id[0]['centro_labores'] ?></b></label>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorController/Modal_Update_Historico_Base_Colaborador/' .$get_id[0]['id_usuario']) }}" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <div>
                        <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('ColaboradorController/Modal_Detalle_Historico_Colaborador/' .$get_id[0]['id_usuario'].'/2') }}" style="color:#1b55e2">Ver historial (<?php echo $get_id[0]['cant_historico_base'] ?>)</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="id_base">Modalidad Laboral</label>
                <div>
                    <label for="" style="color:black"><b><?php echo $get_id[0]['nom_modalidad_laboral'] ?></b></label>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorController/Modal_Update_Historico_Modalidad_Colaborador/' .$get_id[0]['id_usuario']) }}" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <div>
                        <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('ColaboradorController/Modal_Detalle_Historico_Colaborador/' .$get_id[0]['id_usuario'].'/3') }}" style="color:#1b55e2">Ver historial (<?php echo $get_id[0]['cant_historico_modalidad'] ?>)</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="id_base">Horario</label>
                <div>
                    <label for="" style="color:black"><b><?php echo $get_id[0]['nom_horario'] ?></b></label>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorController/Modal_Update_Historico_Horario_Colaborador/' .$get_id[0]['id_usuario']) }}" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <div>
                        <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('ColaboradorController/Modal_Detalle_Historico_Colaborador/' .$get_id[0]['id_usuario']. '/4') }}" style="color:#1b55e2">Ver historial (<?php echo $get_id[0]['cant_historico_horario'] ?>)</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="id_base">Horas semanales</label>
                <div>
                    <label for="" style="color:black"><b><?php echo $get_id[0]['horas_semanales']; ?></b></label>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= url('ColaboradorController/Modal_Update_Historico_Horas_Semanales_Colaborador') ?>/<?php echo $get_id[0]['id_usuario']; ?>" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <div>
                        <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="<?= url('ColaboradorController/Modal_Detalle_Historico_Colaborador') ?>/<?php echo $get_id[0]['id_usuario']; ?>/5" style="color:#1b55e2">Ver historial (<?php echo $get_id[0]['cant_historico_horas_semanales'] ?>)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>