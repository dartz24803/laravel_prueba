<form id="formulario_asistencia_diariareg" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Marcación</b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="">Colaborador:</label>
                <select id="num_doc" name="num_doc" class="form-control basic">
                    <option value="0">TODOS</option>
                    <?php foreach($list_colaborador as $list){?>
                        <option value="<?php echo $list['num_doc']; ?>"> <?php echo $list['usuario_apater']." ".$list['usuario_amater'].", ".$list['usuario_nombres'];?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="fechar">Fecha: </label>
                <input type="date" id="fechar" name="fechar" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Hora: </label>
                <input type="time"  class="form-control group2" id="horar" name="horar" value="" placeholder="Ingresar hora de salida" autofocus>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Reg_asistencia_diaria();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
