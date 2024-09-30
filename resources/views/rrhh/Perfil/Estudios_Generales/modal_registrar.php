<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Agregar Estudios Generales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">


            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Grado de Instrucción </label>
            </div>            
            <div class="form-group col-sm-4">
                <select class="form-control" id="grad_instruc" name="grad_instruc">
                        <option selected>Selección</option>
                        <option> United States</option>
                        <option>India</option>
                        <option>Japan</option>
                        <option>China</option>
                        <option>Brazil</option>
                        <option>Norway</option>
                        <option>Canada</option>
                </select> 
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Carrera de estudios </label>
            </div>            
            <div class="form-group col-sm-4">
                <input type="text" class="form-control" id="carrera_estudios" name="carrera_estudios" placeholder="Ingresar Tipo de Documento" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Centro de estudios </label>
            </div>
            <div class="form-group col-sm-6">
                <input type="text" class="form-control" id="centro_estudios" name="centro_estudios" placeholder="Ingresar Centro de estudios">
            </div>


            
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Insert_Tipo_Documento();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>