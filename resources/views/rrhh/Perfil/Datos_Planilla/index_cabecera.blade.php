<div class="col-md-12">
    <div class="col-md-12 row">
        <div class="col-md-1">
            <div class="form-group">
                <label for="estado">Estado</label></br>
                <?php if(count($list_datos_planilla)>0){?>
                    <label style="color:black"><b><?php echo $list_datos_planilla[0]['estado_colaborador'];?></b></label>
                <?php }  ?>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="id_situacion_laboral">Situación&nbsp;Laboral</label></br>
                <?php if(count($list_datos_planilla)>0){
                    foreach($list_situacion_laboral as $list){
                        if($get_id[0]['id_situacion_laboral'] == $list['id_situacion_laboral']){ ?>
                        <label nowrap style="color:black"><b><?php echo $list['nom_situacion_laboral'];?></b></label>
                <?php } } } ?>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Fecha Inicio:</label></br>
                <label style="color:black"><b><?php if($get_id[0]['ini_funciones']!="0000-00-00" && count($list_datos_planilla)>0){ echo $get_id[0]['inicio_funciones'];}; ?></b></label>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group" id="memprepl">
                <?php if($get_id[0]['id_situacion_laboral']==2 && count($list_datos_planilla)>0){ ?>
                <label>Empresa</label></br>
                <?php foreach($list_empresa as $list){
                if($get_id[0]['id_empresapl'] == $list['id_empresa']){ ?>

                <label style="color:black"><b><?php echo $list['nom_empresa'];?></b></label>
                <?php } } ?>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group" id="memprepl">
                <?php if(isset($get_id[0]['id_situacion_laboral']) && $get_id[0]['id_situacion_laboral']==2 && count($list_datos_planilla)>0){ ?>
                <label>Régimen</label></br>
                <?php foreach($list_regimen as $list){
                if($get_id[0]['id_regimen'] == $list['id_regimen']){ ?>

                <label style="color:black"><b><?php echo $list['nom_regimen'];?></b></label>
                <?php } } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>