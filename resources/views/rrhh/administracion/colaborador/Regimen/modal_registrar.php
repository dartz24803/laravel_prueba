<form id="formulario_registrar_regimen"  method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Regimen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">     
            <div class="form-group col-md-2">
                <label>Codigo Regimen:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingresar codigo" autofocus>
            </div>
                        
            <div class="form-group col-md-2">
                <label>Nombre Regimen:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar nombre" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label>Dia de Vacaciones: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="vacaciones" name="vacaciones"  placeholder="Ingresar vacaciones" autofocus>
            </div>

        </div>  	           	                	        
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Regimen();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form> 

<script>
      $('#vacaciones').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
  });
</script>
