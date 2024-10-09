@if ($get_id->lectura=="1")
    <div class="row">     
        <div class="form-group col-lg-12">
            <h5 class="modal-title">Lectura</h5>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-2">
            <label class=" control-label text-bold">Anterior: </label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" class="form-control" id="lant_dato{{ $v }}" name="lant_dato{{ $v }}" 
            placeholder="Anterior" onkeypress="return solo_Numeros_Punto(event);">
        </div>   

        <div class="form-group col-lg-2">
            <label class=" control-label text-bold">Fecha Anterior: </label>
        </div>
        <div class="form-group col-lg-4">
            <input type="date" class="form-control" id="lant_fecha{{ $v }}" name="lant_fecha{{ $v }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-2">
            <label class=" control-label text-bold">Actual: </label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" class="form-control" id="lact_dato{{ $v }}" name="lact_dato{{ $v }}" 
            placeholder="Actual" onkeypress="return solo_Numeros_Punto(event);">
        </div> 
        
        <div class="form-group col-lg-2">
            <label class=" control-label text-bold">Fecha Actual: </label>
        </div>
        <div class="form-group col-lg-4">
            <input type="date" class="form-control" id="lact_fecha{{ $v }}" name="lact_fecha{{ $v }}">
        </div>
    </div>
@endif