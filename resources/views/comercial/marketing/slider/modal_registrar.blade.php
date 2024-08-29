<?php
    $id_nivel = session('usuario')->id_nivel;
    $id_area = session('usuario')->id_area;
    $usuario_codigo = session('usuario')->usuario_codigo;
    $centro_labores = session('usuario')->centro_labores;
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
                <label for="orden" class="col-sm-12 control-label text-bold">Nª de Orden:</label>
            </div>
            <div class="form-group col-sm-2">
                <input 
                    type="text" 
                    name="orden" 
                    id="orden" 
                    placeholder="Ingresar Nª orden" 
                    class="form-control" 
                    maxlength="2"
                >
            </div>
            
            <div class="form-group col-md-2">
                <label for="entrada_slide" class="col-sm-12 control-label text-bold">
                    Tiempo de Entrada:
                    <a href="#" title="La aparicion del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped">
                        <div class="divdea">?</div>
                    </a>
                </label>
            </div>
            <div class="form-group col-sm-2">
                <input 
                    type="text" 
                    name="entrada_slide" 
                    id="entrada_slide" 
                    placeholder="Ingresar tiempo de entrada" 
                    class="form-control"
                >
            </div>
            
            <div class="form-group col-md-2">
                <label for="salida_slide" class="col-sm-12 control-label text-bold">
                    Tiempo de salida:
                    <a href="#" title="La desaparción del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped">
                        <div class="divdea">?</div>
                    </a>
                </label>
            </div>
            <div class="form-group col-sm-2">
                <input 
                    type="text" 
                    name="salida_slide" 
                    id="salida_slide" 
                    placeholder="Ingresar tiempo de salida" 
                    class="form-control"
                >
            </div>
            
            <div class="form-group col-md-2">
                <label for="duracion" class="col-sm-12 control-label text-bold">
                    Tiempo de duración:
                    <a href="#" title="Especificado en segundos y solo perimite números enteros" class="anchor-tooltip tooltiped">
                        <div class="divdea">?</div>
                    </a>
                </label>
            </div>
            <div class="form-group col-sm-2">
                <input 
                    type="text" 
                    name="duracion" 
                    id="duracion" 
                    placeholder="Ingresar tiempo de duración" 
                    class="form-control" 
                    maxlength="2" 
                >
            </div>
            
            <div class="form-group col-md-2">
                <label for="tipo_slide" class="col-sm-12 control-label text-bold">Tipo de Slide:</label>
            </div>
            <div class="form-group col-sm-6">
                <select 
                    id="tipo_slide" 
                    name="tipo_slide" 
                    class="form-control" 
                    onChange="mostrar(this.value);"
                >
                    <option value="Seleccione">Seleccione</option>
                    <option value="0">Seleccionar</option>
                    <option value="1">Imagen</option>
                    <option value="2">Video</option>
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label for="titulo" class="col-sm-12 control-label text-bold">Título:</label>
            </div>
            <div class="form-group col-sm-10">
                <input 
                    type="text" 
                    name="titulo" 
                    id="titulo" 
                    placeholder="Ingresar Titulo de slide" 
                    class="form-control"
                >
            </div>
            
            <div class="form-group col-md-2">
                <label for="base" class="col-sm-12 control-label text-bold">Base:</label>
            </div>
            <div class="form-group col-sm-10">
                <select 
                    id="base" 
                    name="base" 
                    class="controlarslide js-states form-control"
                >
                    <option value="0">Seleccionar</option>
                    @foreach($list_base as $list)
                        <option value="{{ $list['id_base'] }}" {{ $centro_labores == $list['id_base'] ? 'selected' : '' }}>
                            {{ $list['nom_base'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label for="descripcion" class="col-sm-12 control-label text-bold">Descripción del Slide:</label>
            </div>
            <div class="form-group col-sm-10">
                <textarea 
                    name="descripcion" 
                    id="descripcion" 
                    placeholder="Ingresar descripción del slider" 
                    class="form-control"
                ></textarea>
            </div>
            
            <div class="form-group col-md-2 Div1">
                <label for="archivoslide" class="col-sm-12 control-label text-bold">Imagen de slide:</label>
            </div>            
            <div class="form-group col-sm-10 Div1">
                <input 
                    type="file" 
                    name="archivoslide" 
                    id="archivoslide" 
                    class="form-control-file archivoslide" 
                    onchange="return validarfileimagen()"
                >
            </div>
            
            <div class="form-group col-md-2 Div1">
                <label for="archivoslide" class="col-sm-12 control-label text-bold">Vista Previa:</label>
            </div>
            

            <div class="form-group col-sm-10 Div1">
                <div class="col-sm-12" id="visorArchivo">
                    <!--Aqui se desplegará el fichero-->
                </div>
            </div>
            <div class="form-group col-md-2 Div2">
                <label for="archivoslidevideo" class="col-sm-12 control-label text-bold">Video de slide:</label>
            </div>
            
            <div class="form-group col-sm-10 Div2">
                <input 
                    type="file" 
                    name="archivoslidevideo" 
                    id="archivoslidevideo" 
                    class="form-control-file videoslide" 
                    onchange="return validarfilevideo()"
                >
            </div>
            
            <div class="form-group col-md-2 Div2">
                <label for="archivoslide" class="col-sm-12 control-label text-bold">Vista Previa:</label>
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
    
    function Insert_Slide_Comercial() {
        Cargando();
        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ url('Marketing/Insert_Slide_Comercial') }}";
        var csrfToken = $('input[name="_token"]').val();

        //if (Valida_Slide_Comercial()) {
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
                    if (data == "error") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Busca_Slide_Comercial();
                            $("#ModalRegistroGrande .close").click()
                        });
                    }
                }
            });
        //}
    }

</script>


<script>
    $('.controlarslide').select2({
            dropdownParent: $('#ModalRegistroGrande')
    });
</script>