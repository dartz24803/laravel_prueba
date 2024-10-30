@php 
    if(session('usuario')->id_nivel=="1" || 
    session('usuario')->id_puesto=="21" ||
    session('usuario')->id_puesto=="22" ||
    session('usuario')->id_puesto=="277" ||
    session('usuario')->id_puesto=="278"){
        $disabled = "";
    }else{
        $disabled = "disabled";
    }
@endphp

<div class="col-lg-12 col-md-8 mt-md-0 mt-4">
    <div class="form">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="resultado_final">Resultado</label>
                    <select class="form-control" name="resultado_final" id="resultado_final" 
                    {{ $disabled }}>  
                        <option value="0">Seleccione</option>
                        <option @php if($get_id->estado_postulacion=="10"){ echo "selected"; } @endphp value="10">SELECCIONADO</option>
                        <option @php if($get_id->estado_postulacion=="9"){ echo "selected"; } @endphp value="9">NO SELECCIONADO</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>