<?php
    $sesion =  $_SESSION['usuario'][0];
    $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
    $id_area=$_SESSION['usuario'][0]['id_area'];
    $usuario_codigo=$_SESSION['usuario'][0]['usuario_codigo'];
    $centro_labores=$_SESSION['usuario'][0]['centro_labores'];
?>  

<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">

    <input name="id_area" type="hidden" class="form-control" id="id_area" value="<?php echo $id_area ?>">

    <div class="modal-header">
        <h5 class="modal-title">Agregar un slide</h5>
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
                    // 'style' => 'color: #000;'
                    ];

                    echo form_label('Nª de Orden:', 'orden', $label_orden);
                ?>
            </div>            
            <div class="form-group col-sm-2">
                <?php
                    $text_input = array(
                        'type' => 'text',
                        'name' => 'orden',
                        'id' => 'orden',
                        'value' => '',
                        'placeholder' =>'Ingresar Nª orden',
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
                        'type' => 'text',
                        'name' => 'entrada_slide',
                        'id' => 'entrada_slide',
                        'value' => '',
                        'placeholder' =>'Ingresar tiempo de entrada',
                        'class' => 'form-control',
                       // 'maxlength' => '3',
                       // 'min' => '1',
                       // 'max' => '2',
                       // 'pattern' => '^\d+\.{0,1}\d{0,2}$',
                       // 'onkeypress' => 'return isNumberKeyprimero(event)',
                       // 'oninput' => 'isDecimalKeyuno(event,this)',
                    );

                    echo form_input($text_input);
                ?>
                <?php echo form_error('name', '<div class="text-error">', '</div>') ?>
            </div>

            <div class="form-group col-md-2">
                <?php
                    $label_salida = [
                        'class' => 'col-sm-12 control-label text-bold',
                    // 'style' => 'color: #000;'
                    ];

                    echo form_label('Tiempo de salida:<a href="#" title="La desaparción del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a>', 'salida_slide', $label_salida);
                ?>
            </div>

            <div class="form-group col-sm-2">
                <?php
                    $text_input = array(
                        'name' => 'salida_slide',
                        'id' => 'salida_slide',
                        'value' => '',
                        'placeholder' =>'Ingresar tiempo de salida',
                        'class' => 'form-control',
                        //'maxlength' => '3',
                        //'min' => '1',
                        //'max' => '10',
                        //'pattern' => '^\d+\.{0,1}\d{0,2}$',
                        //'onkeypress' => 'return isNumberKeydos(event)',
                        //'oninput' => 'isDecimalKeydos(event,this)',
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
                        'value' => '',
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
                    $label_tipo = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];
                    echo form_label('Tipo de Slide:', 'tipo_slide', $label_tipo);
                ?>
            </div> 

            <div class="form-group col-sm-6">
                <?php
                   /* echo form_dropdown('posted', $data_posted, $posted, 'class="form-control"')*/
                    echo form_dropdown('tipo_slide', $tipo_slide, 'Seleccione', 'class="form-control" id="tipo_slide" onChange="mostrar(this.value);" ')
                ?>
            </div>

            <div class="form-group col-md-2">
                <?php
                    $label_titulo = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];
                    echo form_label('Título:', 'titulo', $label_titulo);
                ?>
            </div>            
            <div class="form-group col-sm-10">
                <?php
                    $text_input = array(
                        'name' => 'titulo',
                        'id' => 'titulo',
                        'value' => '',
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
                    <option value="0" >Seleccionar</option>
                    <?php foreach($list_base as $list){
                        if($centro_labores == $list['id_base']){ ?>
                                <option value="<?php echo $list['id_base']; ?>" selected> <?php echo $list['nom_base'];?> </option>
                        <?php }else{?>
                                <option value="<?php echo $list['id_base']; ?>"> <?php echo $list['nom_base'];?> </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <?php
                    $label_descripcion = [
                        'class' => 'col-sm-12 control-label text-bold',
                    ];

                    echo form_label('Descripción del Slide:', 'descripcion', $label_descripcion);
                ?>
            </div>            
            <div class="form-group col-sm-10">
                    <?php
                    $text_area = array(
                        'name' => 'descripcion',
                        'id' => 'descripcion',
                        'value' => '',
                        'placeholder' =>'Ingresar descripción del slider',
                        'class' => 'form-control',
                    );

                    echo form_textarea($text_area);
                ?>
                <?php echo form_error('name', '<div class="text-error">', '</div>') ?>

            </div>

                <div class="form-group col-md-2 Div1">
                    <?php
                        $label_file = [
                            'class' => 'col-sm-12 control-label text-bold',
                        ];

                        echo form_label('Imagen de slide:', 'archivoslide', $label_file);
                    ?>
                </div>            
                <div class="form-group col-sm-10 Div1">
                    <?php
                        $text_file = array(

                            'type'  => 'file',
                            'name'  => 'archivoslide',
                            'id'    => 'archivoslide',
                            'value' => '',
                            'class' => 'form-control-file archivoslide',
                            'onchange' => 'return validarfileimagen()',
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
                    <div class="col-sm-12" id="visorArchivo">
                        <!--Aqui se desplegará el fichero-->
                    </div>
                </div>

                <div class="form-group col-md-2 Div2">
                    <?php
                        $label_file = [
                            'class' => 'col-sm-12 control-label text-bold',
                        ];

                        echo form_label('Video de slide:', 'archivoslide', $label_file);
                    ?>
                </div>            
                <div class="form-group col-sm-10 Div2">
                    <?php
                        $text_file = array(

                            'type'  => 'file',
                            'name'  => 'archivoslidevideo',
                            'id'    => 'archivoslidevideo',
                            'value' => '',
                            'class' => 'form-control-file videoslide',
                            'onchange' => 'return validarfilevideo()',


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
                    <div class="col-sm-12" id="visorArchivodos">
                        <!--Aqui se desplegará el fichero-->
                    </div>
                </div>

        </div>
    </div>

    <div class="modal-footer">


        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Slide_Comercial();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>

$(document).ready(function() {
        $("#entrada_slide").inputmask({mask:"9.9"});
        $("#salida_slide").inputmask({mask:"9.9"});
    });


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
    
</script>

<script>
    function mostrar(id) {
    if (id == "1") {
        $(".Div1").show();
        $(".Div2").hide();
        document.getElementById("archivoslidevideo").value = "";

    }

    if (id == "2") {
        $(".Div1").hide();
        $(".Div2").show();
        document.getElementById("archivoslide").value = "";
    }

    if (id == "0") {
        $(".Div1").hide();
        $(".Div2").hide();
       // document.getElementById("archivoslide").value = "";
    }
}
</script>

<script>
    /********Validaciones******/
    function validarfileimagen(){
        var archivoInput = document.getElementById('archivoslide');
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
                        document.getElementById('visorArchivo').innerHTML = 
                        '<embed  loading="lazy"  src="'+e.target.result+'" width="100%" height="500" />';
                    };
                    visor.readAsDataURL(archivoInput.files[0]);
                }   
            }
    }

  
    function validarfilevideo(){
        var archivoInput = document.getElementById('archivoslidevideo');
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
                        document.getElementById('visorArchivodos').innerHTML = 
                        '<embed loading="lazy"  src="'+e.target.result+'" width="100%" height="500" />';
                    };
                    visor.readAsDataURL(archivoInput.files[0]);
                }      
            }
    }
</script>


<script>
    $('.controlarslide').select2({
            dropdownParent: $('#ModalRegistroSlide')
    });
    
</script>