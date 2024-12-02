<?php if($id_motivo==3){ ?>
    <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="text" class="form-control" id="destino" name="destino" value="" placeholder="Ingresar destino" autofocus>
<?php }else{ ?>
    <select class="form-control" id="destino" name="destino" onchange="Traer_Tramite();">
        <option value="0">Seleccione</option>
        <?php foreach($list_destino as $list){ ?>
            <option value="<?php echo $list['id_destino']; ?>"><?php echo $list['nom_destino']; ?></option>
        <?php } ?>
    </select>
<?php } ?>