<style>
.img-presentation-small-actualizar {
	width: 100%;
	height: 184px;
	object-fit: cover;
	cursor: pointer;
	margin: 5px;
}
</style>
<?php
    $sesion =  $_SESSION['usuario'][0];
    $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
    $id_area=$_SESSION['usuario'][0]['id_area'];
    $usuario_codigo=$_SESSION['usuario'][0]['usuario_codigo'];

?>  

<?php echo form_open('', 'class="my_form needs-validation" enctype="multipart/form-data" id="formulario"'); ?>
    <input name="id_area" type="hidden" class="form-control" id="id_area" value="<?php echo $id_area ?>">


    <div class="modal-header">
        <h5 class="modal-title">Editar slide</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <?php
                    $label_orden = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];
                    echo form_label('Orden:', 'orden', $label_orden);
                ?>
            </div>            
            <div class="form-group col-sm-2">
                <?php
                    $text_input = array(
                        'name' => 'orden',
                        'id' => 'orden',
                        'value' => $get_id[0]['orden'],
                        'placeholder' =>'Ingresar Nª de orden',
                        'class' => 'form-control',
                        'maxlength' => '2',
                        'min' => '1',
                        'max' => '100',
                        'pattern' => '.{2,}',
                        'onkeypress' => 'return (event.charCode >= 48 && event.charCode <= 57)',
                        'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);',
                    );

                    echo form_input($text_input);
                ?>
                
                <?php echo form_error('name', '<div class="text-error">', '</div>') ?>

            </div>


            <div class="form-group col-md-2">
                <?php
                    $label_entrada_slide = [
                        'class' => 'col-sm-12 control-label text-bold',
                    // 'style' => 'color: #000;'
                    ];

                    echo form_label('Tiempo de Entrada:<a href="#" title="La aparicion del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a>', 'entrada_slide', $label_entrada_slide);
                ?>
            </div>            
            <div class="form-group col-sm-2">
                <?php
                    $text_input = array(
                        'name' => 'entrada_slide',
                        'id' => 'entrada_slide',
                        'value' => $get_id[0]['entrada_slide'],
                        'placeholder' =>'Ingresar tiempo de entrada',
                        'class' => 'form-control',
                        //'maxlength' => '3',
                        //'min' => '1',
                        //'max' => '2',
                        //'pattern' => '^\d+\.{0,1}\d{0,2}$',
                        //'onkeypress' => 'return isNumberKeysegundo(event)',
                        //'oninput' => 'isDecimalKeyunoedit(event,this)',
                    );

                    echo form_input($text_input);
                ?>
                
                <?php echo form_error('name', '<div class="text-error">', '</div>') ?>

            </div>



            <div class="form-group col-md-2">
                <?php
                    $label_salida_slide = [
                        'class' => 'col-sm-12 control-label text-bold',
                    // 'style' => 'color: #000;'
                    ];

                    echo form_label('Tiempo de Salida:<a href="#" title="La desaparción del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a>', 'salida_slide', $label_salida_slide);
                ?>
            </div>            
            <div class="form-group col-sm-2">
                <?php
                    $text_input = array(
                        'name' => 'salida_slide',
                        'id' => 'salida_slide',
                        'value' => $get_id[0]['salida_slide'],
                        'placeholder' =>'Ingresar tiempo de entrada',
                        'class' => 'form-control',
                       // 'maxlength' => '3',
                       // 'min' => '1',
                       // 'max' => '10',
                       // 'pattern' => '^\d+\.{0,1}\d{0,2}$',
                       // 'onkeypress' => 'return isNumberKeydosedit(event)',
                        //'oninput' => 'isDecimalKeydosedit(event,this)',
                    );

                    echo form_input($text_input);
                ?>
                
                <?php echo form_error('name', '<div class="text-error">', '</div>') ?>

            </div>


            <div class="form-group col-md-2">
                <?php
                    $label_duracion = [
                        'class' => 'col-sm-12 control-label text-bold',
                    // 'style' => 'color: #000;'
                    ];

                    echo form_label('Tiempo de duracion:<a href="#" title="Especificado en segundos y solo perimite nùmeros enteros" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a>', 'duracion', $label_duracion);
                ?>
            </div>

            <div class="form-group col-sm-2">
                <?php
                    $text_input = array(
                        'name' => 'duracion',
                        'id' => 'duracion',
                        'value' => $get_id[0]['duracion'],
                        'placeholder' =>'Ingresar tiempo de duración',
                        'class' => 'form-control',
                        'maxlength' => '2',
                        'min' => '1',
                        'max' => '100',
                        'pattern' => '.{1,}',
                        'onkeypress' => 'return (event.charCode >= 48 && event.charCode <= 57)',
                        'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);',
                    );

                    echo form_input($text_input);
                ?>
                
                <?php echo form_error('name', '<div class="text-error">', '</div>') ?>
            </div>

            <div class="form-group col-md-2">
                <?php
                    $label_stado = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];

                    echo form_label('Estado de imagen de Slide:', 'estado', $label_stado);
                ?>
            </div> 

            <div class="form-group col-sm-2">
                <?php
                   /* echo form_dropdown('posted', $data_posted, $posted, 'class="form-control"')*/
                    echo form_dropdown('estado', $estado_slide, $get_id[0]['estado'], 'class="form-control" id="estado"')
                ?>
            </div>

            <div class="form-group col-md-2">
                <?php
                    $label_tipo = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];
                    echo form_label('Tipo de Slide Actual:', 'tipo_slide', $label_tipo);
                ?>
            </div> 
           
            <div class="form-group col-sm-2">
                <?php
                   /* echo form_dropdown('posted', $data_posted, $posted, 'class="form-control"')*/
                 /*  if( $get_id[0]['tipo_slide']=1){
                        $label_tipoe = [
                            'class' => 'col-sm-3 control-label text-bold',
                        ];
                        echo form_label('Imagen', 'tipo_slide', $label_tipoe);

                   }elseif($get_id[0]['tipo_slide']=2){
                        $label_tipoe = [
                            'class' => 'col-sm-3 control-label text-bold',
                        ];
                        echo form_label('Video', 'tipo_slide', $label_tipoe);

                   }
                   */
                   
                    echo form_dropdown('tipo_slide', $tipo_slide, $get_id[0]['tipo_slide'], 'class="form-control" id="tipo_slide" onChange="mostrardos(this.value);"')
                    
                   // echo form_dropdown('tipo_slide', $tipo_slide, 'Seleccione', 'class="form-control" id="tipo_slide" onChange="mostrardos(this.value);" ')

                ?>
            </div>

            <div class="form-group col-md-2">
                <?php
                    $label_titulo = [
                        'class' => 'col-sm-3 control-label text-bold',
                    ];

                    echo form_label('Título:', 'titulo', $label_titulo);
                ?>
            </div>            
            <div class="form-group col-sm-10">
                
                <?php
                    $text_input = array(
                        'name' => 'titulo',
                        'id' => 'titulo',
                        'value' => $get_id[0]['titulo'],
                        'placeholder' =>'Ingresar Titulo de slide',
                        'class' => 'form-control',
                    );

                    echo form_input($text_input);
                ?>

                <?php echo form_error('name', '<div class="text-error">', '</div>') ?>

            </div>


            <div class="form-group col-md-2">
                <?php
                    $label_titulo = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];
                    echo form_label('Base:', 'titulo', $label_titulo);
                ?>
            </div>            
            <div class="form-group col-sm-10">
                <select id="base" name="base" placeholder="Centro de labores" class="controlarslide js-states form-control">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['base']))) {echo "selected=\"selected\"";} ?> >Seleccionar</option>
                    <?php foreach($list_base as $list){ ?>
                        <option value="<?php echo $list['id_base']; ?>" <?php if (!(strcmp($list['id_base'], $get_id[0]['base']))) {echo "selected=\"selected\"";} ?> >
                            <?php echo $list['nom_base'];?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <?php
                    $label_descripcion = [
                        'class' => 'col-sm-3 control-label text-bold',
                    ];

                    echo form_label('Descripción de Slide:', 'descripcion', $label_descripcion);
                ?>

            </div>            
            <div class="form-group col-sm-10">
                    <?php
                    $text_area = array(
                        'name' => 'descripcion',
                        'id' => 'descripcion',
                        'value' => $get_id[0]['descripcion'],
                        'placeholder' =>'Ingresar descripción de slider',
                        'class' => 'form-control',
                    );

                    echo form_textarea($text_area);
                ?>
                <?php echo form_error('name', '<div class="text-error">', '</div>') ?>

            </div>

            <div class="form-group col-md-2 ">
                <?php
                    $label_file = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];

                    echo form_label('Archivo de Actual:', 'archivoslide', $label_file);
                ?>
            </div>     

            <div class="form-group col-sm-4">

                <?php if(substr($get_id[0]['archivoslide'],-3) === "mp4"){ ?>
                        <?php echo ' 
                                <video loading="lazy" class="img-thumbnail img-presentation-small-actualizar" controls >
                                    <source class="img_post img-thumbnail img-presentation-small-actualizar" src="' . $url[0]['url_config'] . $get_id[0]['archivoslide'] . '" type="video/mp4">
                                </video>';
                        ?>
                <?php } else {
                    echo'<img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" src="' . $url[0]['url_config'] . $get_id[0]['archivoslide'] . '">'; 
                } ?>                     
            </div> 


            <div class="form-group col-md-2 Div1">
                <?php
                    $label_file = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];

                    echo form_label('Imagen de slide:', 'archivoslide', $label_file);
                ?>
            </div>            
            <div class="form-group col-sm-4 Div1">
                <?php
                    $text_file = array(

                        'type'  => 'file',
                        'name'  => 'archivoslideimagen',
                        'id'    => 'archivoslideimagen',
                        'value' => $get_id[0]['archivoslide'],
                        'class' => 'form-control-file archivoslide',
                        'onchange' => 'return validarfileimagendos()',
                    );

                    echo form_input($text_file);
                ?>
            </div>

            <div class="form-group col-md-2 Div1">
                <?php
                    $label_file = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];

                    echo form_label('Vista Previa:', 'archivoslide', $label_file);
                ?>
            </div>  
            <div class="form-group col-sm-10 Div1">
                <div class="col-sm-12" id="visorArchivouno">
                    <!--Aqui se desplegará el fichero-->
                </div>
            </div>




            <div class="form-group col-md-2 Div2">
                <?php
                    $label_file = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];

                    echo form_label('Video de slide:', 'videoslide', $label_file);
                ?>
            </div>            
            <div class="form-group col-sm-4 Div2">
                <?php
                    $text_file = array(
                        'type'  => 'file',
                        'name'  => 'archivoslidevideodos',
                        'id'    => 'archivoslidevideodos',
                        'value' => $get_id[0]['archivoslide'],
                        'class' => 'form-control-file videoslide',
                        'onchange' => 'return validarfilevideodos()',
                    );

                    echo form_input($text_file);
                ?>
            </div>

            <div class="form-group col-md-2 Div2">
                    <?php
                        $label_file = [
                            'class' => 'col-sm-12 control-label text-bold',
                        ];

                        echo form_label('Vista Previa:', 'archivoslide', $label_file);
                    ?>
                </div> 

                <div class="form-group col-sm-10 Div2">
                    <div class="col-sm-12" id="visorArchivodosdos">
                        <!--Aqui se desplegará el fichero-->
                    </div>
                </div>

        </div>
    </div>

    <div class="modal-footer">
        <input name="id_slide" type="hidden" class="form-control" id="id_slide" value="<?php echo $get_id[0]['id_slide']; ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Edit_Slide_Comercial();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>

<!--</form>-->
<?php echo form_close() ?>


<script>
$("#entrada_slide").inputmask({mask:"9.9"});
$("#salida_slide").inputmask({mask:"9.9"});

$(".img_post").click(function () {
    window.open($(this).attr("src"), 'popUpWindow', 
    "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
});
</script>


<script>
/***********primero tooltip */
var anchors = document.querySelectorAll('.anchor-tooltip');
    anchors.forEach(function(anchor) {
    var toolTipText = anchor.getAttribute('title'),
        toolTip = document.createElement('span');
    toolTip.className = 'title-tooltip';
    toolTip.innerHTML = toolTipText;
    anchor.appendChild(toolTip);
});
/***********primero tooltip. */
/*******input */

/*******input. */

/*******input2 */

/*******input2. */
</script>


<script>
/*
var img = '<?php echo $get_id[0]['tipo_slide'];?>'
$( window ).load(function() {
  $('#tipo_slide option[value="1"]').prop('selected', true);
  var evt = document.createEvent("HTMLEvents");
  evt.initEvent("change", false, true);
  document.getElementById('tipo_slide').dispatchEvent(evt);
});

$( "#tipo_slide" ).change(function() {
  alert($('#tipo_slide').val()); //AGREGAS AQUI TU FUNCIÓN week();

});
*/

    function mostrardos(id) {
        //ways to retrieve selected option and text outside handler
        if (id == "1") {
    
            $(".Div1").show();
            $(".Div2").hide();
            document.getElementById("archivoslidevideodos").value = "";
        }

        if (id == "2") {
            
            $(".Div1").hide();
            $(".Div2").show();
            document.getElementById("archivoslideimagen").value = "";
        }
        if (id == "0") {
            $(".Div1").hide();
            $(".Div2").hide();
        // document.getElementById("archivoslide").value = "";
        }
    }




$(function() {
  var $select = $('#tipo_slide');
 
  $select.on('change', mostrardos);
  
  // 
  $select.trigger('change');
});

function mostrardos(id) {
        //ways to retrieve selected option and text outside handler
        if (id == "1") {
    
            $(".Div1").show();
            $(".Div2").hide();
            document.getElementById("archivoslidevideodos").value = "";
        }

        if (id == "2") {
            
            $(".Div1").hide();
            $(".Div2").show();
            document.getElementById("archivoslideimagen").value = "";
        }
    }



</script>

<script>
    /********Validaciones******/
    function validarfileimagendos(){
        var archivoInput = document.getElementById('archivoslideimagen');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'La imagen debe estar en formato JPG ,JPEG ,PNG.',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }else{
                //PRevio del PDF
                if (archivoInput.files && archivoInput.files[0]) {
                    var visor = new FileReader();
                    visor.onload = function(e) 
                    {
                        document.getElementById('visorArchivouno').innerHTML = 
                        '<embed loading="lazy" src="'+e.target.result+'" width="100%" height="500" />';
                    };
                    visor.readAsDataURL(archivoInput.files[0]);
                }   
            }
    }

  
    function validarfilevideodos(){
        var archivoInput = document.getElementById('archivoslidevideodos');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.mp4)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El video debe de estar en formato MP4 ',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }else{
                 //PRevio del PDF
                 if (archivoInput.files && archivoInput.files[0]) {
                    var visor = new FileReader();
                    visor.onload = function(e) 
                    {
                        document.getElementById('visorArchivodosdos').innerHTML = 
                        '<embed loading="lazy"  src="'+e.target.result+'" width="100%" height="500" />';
                    };
                    visor.readAsDataURL(archivoInput.files[0]);
                }      
            }
    }

  
</script>

<script>
    $('.controlarslide').select2({
            dropdownParent: $('#ModalUpdateSlide')
    });
</script>