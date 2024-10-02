<div class="col-md-3">
    <div class="form-group">
        <label for="nacionalidad">¿Cuéntas con cuenta bancaria?</label>
        <select class="form-control" id="cuenta_bancaria" name="cuenta_bancaria" onchange="Validaeb();">
        <option value="0" <?php if($get_id_cuentab[0]['cuenta_bancaria'] == 0){ echo "selected";} ?>>Seleccione</option>
        <option value="1" <?php if($get_id_cuentab[0]['cuenta_bancaria'] == 1){ echo "selected";} ?>>SÍ</option>
        <option value="2" <?php if($get_id_cuentab[0]['cuenta_bancaria'] == 2){ echo "selected";} ?>>NO</option>
        </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="camisa">Indique la entidad bancaria</label>
        <select <?php if($get_id_cuentab[0]['cuenta_bancaria'] != 1){echo "disabled";}?> class="form-control" name="id_banco" id="id_banco">
            <option value="0">Seleccion</option>
            <?php foreach($list_banco as $list){
                if($get_id_cuentab[0]['id_banco'] == $list['id_banco']){ ?>
                <option selected value="<?php echo $list['id_banco']; ?>"><?php echo $list['nom_banco'];?></option> 
            <?php }else{?>
            <option value="<?php echo $list['id_banco']; ?>"><?php echo $list['nom_banco'];?></option>
            <?php } } ?>
        </select>
    </div>
</div>

        <?php for ($x = 1; $x <= count($list_banco); $x++) {?> 
            <div class="<?php echo $x; ?> GFG col-md-3">
                <div class="form-group">
                    <label for="usuario_email">Indique el número de cuenta</label>
                    <input <?php if(isset($get_id_cuentab['0']['cuenta_bancaria']) && $get_id_cuentab[0]['cuenta_bancaria'] != 1){echo "disabled";}?> type="text" class="form-control mb-4" id="num_cuenta_bancaria_<?php echo $x; ?>" name="num_cuenta_bancaria_<?php echo $x; ?>" value="<?php 
                        if($get_id_cuentab[0]['id_banco']== $x){ 
                            if(isset($get_id_cuentab['0']['num_cuenta_bancaria'])) {echo $get_id_cuentab['0']['num_cuenta_bancaria'];}
                        }else{

                        }
                    ?>">
                </div>
            </div>

            <div class="<?php echo $x; ?> GFG col-md-3">
                <div class="form-group">
                    <label for="usuario_email">Indique el código interbancario</label>
                    <input <?php if(isset($get_id_cuentab['0']['cuenta_bancaria']) && $get_id_cuentab[0]['cuenta_bancaria'] != 1){echo "disabled";}?> type="text" class="form-control mb-4" id="num_codigo_interbancario_<?php echo $x; ?>" name="num_codigo_interbancario_<?php echo $x; ?>" value="
                    <?php 
                        if($get_id_cuentab[0]['id_banco']== $x){ 
                            if(isset($get_id_cuentab['0']['num_codigo_interbancario'])) {echo $get_id_cuentab['0']['num_codigo_interbancario'];}
                        }else{

                        }
                    ?>">
                </div>
            </div> 
        <?php }  ?>  
                                                         
    <script src="{{ asset('template/plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>

    <script>

        lista_banco =<?php echo count($list_banco); ?> ;

  
        <?php $op = 0; foreach($list_banco as $list) { $op++; ?> 
        $('#num_cuenta_bancaria_<?php echo $op; ?>').inputmask("<?php for ($y = 1; $y<= $list['digitos_cuenta']; $y++) { echo "9";} ?>");
        $('#num_codigo_interbancario_<?php echo $op; ?>').inputmask("<?php for ($y = 1; $y<= $list['digitos_cci']; $y++) { echo "9";} ?>");
        <?php  } ?> 

            $(document).ready(function() {
                $("#id_banco").on('change', function() {
                    $(this).find("option:selected").each(function() {
                        var geeks = $(this).attr("value");
                        if (geeks) {
                            $(".GFG").not("." + geeks).hide();
                            for (i = 1; i <= lista_banco; i++) {
                                if(i == geeks){
                                    $('#num_cuenta_bancaria_'+i).removeAttr("disabled");
                                    $('#num_codigo_interbancario_'+i).removeAttr("disabled");
                                }else{
                                    $('#num_cuenta_bancaria_'+i).val('');
                                    $('#num_cuenta_bancaria_'+i).attr("disabled", true);
                                    $('#num_codigo_interbancario_'+i).attr("disabled", true);
                                    $('#num_codigo_interbancario_'+i).val(''); 
                                }
                            }
                            $("." + geeks).show();
                        } else {
                            $(".GFG").hide();

                            

                           // $(".GFG").not("." + geeks+" input").val("");
                        }
                    });
                }).change();
            });

    </script>
