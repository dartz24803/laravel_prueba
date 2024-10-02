
<style>
    label.archivoInput9 {
    /* color: white; */
    background-image: url(template/assets/img/descarga_img.png);
    background-repeat: no-repeat;
    background-size: 40px 30px;
    background-position: center;
    position: absolute;
    /* margin: 25px; */
    padding-bottom: 45px;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}
</style>


<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Agregar Curso Complementario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">


            <div class="form-group col-md-3">
                <label class="col-sm-3 control-label text-bold">Cursos/Conocimientos Coplementarios </label>
            </div>            
            <div class="form-group col-sm-4">
                <input type="text" class="form-control" id="cod_tipo_documento" name="cod_tipo_documento" placeholder="Ingresar Cursos Coplementarios" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold">Año: </label>
            </div>            
            <div class="form-group col-sm-3">
                <select class="form-control" id="anio_curso_complement">
                    <option selected>Seleccione</option>
                    <option>United States</option>
                    <option>India</option>
                    <option>Japan</option>
                    <option>China</option>
                    <option>Brazil</option>
                    <option>Norway</option>
                    <option>Canada</option>
                </select>            
            </div>

  

            <div class="form-group col-md-3">
                <label class="col-sm-3 control-label text-bold">Adjuntar Certificado </label>
            </div>
            <div class="form-group col-sm-4">
                <input type="file" id="archivoInput9" class="archivoInput nombre9"  />       
                <label  class=" archivoInput9 guiones2" for="archivoInput9">
                    <label  class="filename9 texto" >
                    </label> 
                </label>           
             </div>    


            
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Insert_Tipo_Documento();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
        $(function()
        {

            $(".nombre9").change(function(event) {
                var x = event.target.files[0].name
                $(".filename9").text(x)
            });

            
        })
    </script>