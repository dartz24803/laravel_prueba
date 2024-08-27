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
    $id_nivel = session('usuario')->id_nivel;
    $id_area = session('usuario')->id_area;
    $usuario_codigo = session('usuario')->usuario_codigo;
?>  
<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
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
                <label for="orden" class="col-sm-12 control-label text-bold">Orden:</label>
            </div>
            <div class="form-group col-sm-2">
                <input 
                    type="text" 
                    name="orden_e" 
                    id="orden_e" 
                    value="{{ old('orden', $get_id[0]['orden']) }}" 
                    placeholder="Ingresar Nª de orden" 
                    class="form-control" 
                    maxlength="2" 
                    min="1" 
                    max="100" 
                    pattern=".{2,}" 
                    onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" 
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
            </div>
            
            <div class="form-group col-md-2">
                <label for="entrada_slide" class="col-sm-12 control-label text-bold">
                    Tiempo de Entrada:
                    <a href="#" title="La aparición del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped">
                        <div class="divdea">?</div>
                    </a>
                </label>
            </div>
            <div class="form-group col-sm-2">
                <input 
                    type="text" 
                    name="entrada_slide_e" 
                    id="entrada_slide_e" 
                    value="{{ old('entrada_slide', $get_id[0]['entrada_slide']) }}" 
                    placeholder="Ingresar tiempo de entrada" 
                    class="form-control">
            </div>
            
            <div class="form-group col-md-2">
                <label for="salida_slide" class="col-sm-12 control-label text-bold">
                    Tiempo de Salida:
                    <a href="#" title="La desaparición del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped">
                        <div class="divdea">?</div>
                    </a>
                </label>
            </div>
            <div class="form-group col-sm-2">
                <input 
                    type="text" 
                    name="salida_slide_e" 
                    id="salida_slide_e" 
                    value="{{ old('salida_slide', $get_id[0]['salida_slide']) }}" 
                    placeholder="Ingresar tiempo de salida" 
                    class="form-control">
            </div>
            
            <div class="form-group col-md-2">
                <label for="duracion" class="col-sm-12 control-label text-bold">
                    Tiempo de duración:
                    <a href="#" title="Especificado en segundos y solo permite números enteros" class="anchor-tooltip tooltiped">
                        <div class="divdea">?</div>
                    </a>
                </label>
            </div>
            <div class="form-group col-sm-2">
                <input 
                    type="text" 
                    name="duracion_e" 
                    id="duracion_e" 
                    value="{{ $get_id[0]['duracion'] }}" 
                    placeholder="Ingresar tiempo de duración" 
                    class="form-control" 
                    maxlength="2" 
                    min="1" 
                    max="100" 
                    pattern=".{1,}" 
                    onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" 
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
            </div>
            
            <div class="form-group col-md-2">
                <label for="estado" class="col-sm-12 control-label text-bold">Estado de imagen de Slide:</label>
            </div>
            <div class="form-group col-sm-2">
                <select name="estado_e" id="estado_e" class="form-control">
                    <option value="0">Seleccionar</option>
                    <option value="1" {{ $get_id[0]['estado'] == 1 ? 'selected' : '' }}>Activado</option>
                    <option value="2" {{ $get_id[0]['estado'] == 2 ? 'selected' : '' }}>Desactivado</option>
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label for="tipo_slide" class="col-sm-12 control-label text-bold">Tipo de Slide Actual:</label>
            </div>
            <div class="form-group col-sm-2">
                <select name="tipo_slide_e" id="tipo_slide_e" class="form-control" onChange="mostrardos(this.value);">
                    <option value="0">Seleccionar</option>
                    <option value="1" {{ $get_id[0]['tipo_slide'] == 1 ? 'selected' : '' }}>Imagen</option>
                    <option value="2" {{ $get_id[0]['tipo_slide'] == 2 ? 'selected' : '' }}>Vídeo</option>
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label for="titulo" class="col-sm-12 control-label text-bold">Título:</label>
            </div>
            <div class="form-group col-sm-10">
                <input 
                    type="text" 
                    name="titulo_e" 
                    id="titulo_e" 
                    value="{{ old('titulo', $get_id[0]['titulo']) }}" 
                    placeholder="Ingresar Título de slide" 
                    class="form-control">
            </div>
            
            <div class="form-group col-md-2">
                <label for="base" class="col-sm-12 control-label text-bold">Base:</label>
            </div>
            <div class="form-group col-sm-10">
                <select id="base_e" name="base_e" class="controlarslide js-states form-control">
                    <option value="0" {{ old('base', $get_id[0]['base']) == 0 ? 'selected' : '' }}>Seleccionar</option>
                    @foreach($list_base as $list)
                        <option value="{{ $list['id_base'] }}" {{ $list['id_base'] == old('base', $get_id[0]['base']) ? 'selected' : '' }}>
                            {{ $list['nom_base'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label for="descripcion" class="col-sm-12 control-label text-bold">Descripción de Slide:</label>
            </div>
            <div class="form-group col-sm-10">
                <textarea 
                    name="descripcion_e" 
                    id="descripcion_e" 
                    placeholder="Ingresar descripción de slider" 
                    class="form-control">{{ old('descripcion', $get_id[0]['descripcion']) }}</textarea>
            </div>
            
            <div class="form-group col-md-2">
                <label for="archivoslide" class="col-sm-12 control-label text-bold">Archivo Actual:</label>
            </div>
            <div class="form-group col-sm-4">
                @if(substr($get_id[0]['archivoslide'], -3) === 'mp4')
                    <video loading="lazy" class="img-thumbnail img-presentation-small-actualizar" controls>
                        <source src="{{ $url[0]['url_config'] . $get_id[0]['archivoslide'] }}" type="video/mp4">
                    </video>
                @else
                    <img loading="lazy" class="img-thumbnail img-presentation-small-actualizar" src="{{ $url[0]['url_config'] . $get_id[0]['archivoslide'] }}">
                @endif
            </div>
            
            <div class="form-group col-md-2 Div1">
                <label for="archivoslideimagen" class="col-sm-12 control-label text-bold">Imagen de slide:</label>
            </div>
            <div class="form-group col-sm-4 Div1">
                <input 
                    type="file" 
                    name="archivoslideimagen" 
                    id="archivoslideimagen" 
                    value="{{ old('archivoslideimagen', $get_id[0]['archivoslide']) }}" 
                    class="form-control-file archivoslide" 
                    onchange="return validarfileimagendos();">
            </div>
            
            <div class="form-group col-md-2 Div1">
                <label for="archivoslideimagen" class="col-sm-12 control-label text-bold">Vista Previa:</label>
            </div>            

            <div class="form-group col-sm-10 Div1">
                <div class="col-sm-12" id="visorArchivouno">
                    <!--Aqui se desplegará el fichero-->
                </div>
            </div>

            <div class="form-group col-md-2 Div2">
                <label for="videoslide" class="col-sm-12 control-label text-bold">Video de slide:</label>
            </div>

            <div class="form-group col-sm-4 Div2">
                <input type="file" name="archivoslidevideodos" id="archivoslidevideodos" class="form-control-file videoslide" onchange="return validarfilevideodos()">
            </div>

            <div class="form-group col-md-2 Div2">
                <label for="archivoslide" class="col-sm-12 control-label text-bold">Vista Previa:</label>
            </div> 

            <div class="form-group col-sm-10 Div2">
                <div class="col-sm-12" id="visorArchivodosdos">
                    <!-- Aquí se desplegará el fichero -->
                </div>
            </div>

    </div>

    <div class="modal-footer">
        <input name="id_slide" type="hidden" class="form-control" id="id_slide" value="<?php echo $get_id[0]['id_slide']; ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Edit_Slide_Comercial();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>

<!--</form>-->

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
  var $select = $('#tipo_slide_e');
 
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

    function Valida_Slide_Actualizar_Comercial() {
        if ($('#entrada_slide').val() > 2) {
            msgDate = 'La entrada de slide debe ser menor que 2.0 segundos';
            inputFocus = '#entrada_slide';

            return false;
        }
        if ($('#salida_slide').val() > 2) {
            msgDate = 'La salida del slide debe ser menor que 2.0 segundos';
            inputFocus = '#salida_slide';

            return false;
        }
        return true;
    }

    function Edit_Slide_Comercial() {
        Cargando();
        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ url('Marketing/Update_Slide_Comercial') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Slide_Actualizar_Comercial()) {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Busca_Slide_Comercial();
                        $("#ModalUpdateSlide .close").click()
                    });
                }
            });
        }
    }
  
</script>

<script>
    $('.controlarslide').select2({
            dropdownParent: $('#ModalUpdateSlide')
    });
</script>