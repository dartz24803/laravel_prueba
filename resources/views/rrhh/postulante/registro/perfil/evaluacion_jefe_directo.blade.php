<div class="row">
    <div class="col">
        <h6>EVALUACIÓN JEFE DIRECTO</h6>
    </div>
    <div class="col text-md-right text-center">
        @if ($get_id->id_area=="14" || $get_id->id_area=="44")
            @if ((session('usuario')->id_nivel=="1" || 
            session('usuario')->id_puesto=="21" ||
            session('usuario')->id_puesto=="161" ||
            session('usuario')->id_puesto=="277" ||
            session('usuario')->id_puesto=="278" ||
            session('usuario')->id_puesto=="314") &&
            ($get_id->estado_postulacion=="2" ||
            $get_id->estado_postulacion=="4" ||
            $get_id->estado_postulacion=="5"))
                <button type="button" class="btn btn-primary" onclick="Update_Jefe_Directo();">Actualizar</button>
            @endif
        @else
            @if ((session('usuario')->id_nivel=="1" || 
            session('usuario')->id_puesto=="21" ||
            session('usuario')->id_puesto=="22" ||
            session('usuario')->id_puesto=="277" ||
            session('usuario')->id_puesto=="278") &&
            ($get_id->estado_postulacion>"3" &&
            $get_id->estado_postulacion<"6"))
                <button type="button" class="btn btn-primary" onclick="Update_Jefe_Directo();">Actualizar</button>
            @endif
        @endif
    </div>
</div>
<div class="row">
    <div class="col-lg-11 mx-auto">
        <div class="row">
            @if ($get_id->id_area=="14" || $get_id->id_area=="44")
                @php 
                    if((session('usuario')->id_nivel=="1" || 
                    session('usuario')->id_puesto=="21" ||
                    session('usuario')->id_puesto=="161" ||
                    session('usuario')->id_puesto=="277" ||
                    session('usuario')->id_puesto=="278" ||
                    session('usuario')->id_puesto=="314") &&
                    ($get_id->estado_postulacion=="2" ||
                    $get_id->estado_postulacion=="4" ||
                    $get_id->estado_postulacion=="5")){
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
                                    <label for="resultado_jd">Resultado</label>
                                    <select class="form-control" name="resultado_jd" 
                                    id="resultado_jd" {{ $disabled }}>
                                        <option value="0">Seleccione</option>
                                        <option @php if(isset($get_eval_jd->id_eval_jefe_directo)){ if($get_eval_jd->resultado=="2"){ echo "selected"; } } @endphp value="2">APTO</option>
                                        <option @php if(isset($get_eval_jd->id_eval_jefe_directo)){ if($get_eval_jd->resultado=="5"){ echo "selected"; } } @endphp value="5">NO APTO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="eval_sicologica">Adjuntar evaluación psicológica</label>
                                    @if (isset($get_eval_jd->id_eval_jefe_directo))
                                        <a title="Evaluación psicológica" href="{{ $get_eval_jd->eval_sicologica }}" target="_blank">
                                            <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                                <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                                                <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                                                <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533
                                                    s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2
                                                    s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                                                <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667
                                                    s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                                                <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733
                                                    c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    <input type="file" class="form-control-file" name="eval_sicologica" 
                                    id="eval_sicologica" onchange="Valida_Archivo('eval_sicologica');"
                                    {{ $disabled }}>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="observaciones_jd">Observaciones</label>
                                    <textarea class="form-control" name="observaciones_jd" 
                                    id="observaciones_jd" rows="4" placeholder="Observaciones" 
                                    {{ $disabled }}>@php if(isset($get_eval_jd->id_eval_jefe_directo)){ echo $get_eval_jd->observaciones; } @endphp</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @php 
                    if((session('usuario')->id_nivel=="1" || 
                    session('usuario')->id_puesto=="21" ||
                    session('usuario')->id_puesto=="22" ||
                    session('usuario')->id_puesto=="277" ||
                    session('usuario')->id_puesto=="278") &&
                    ($get_id->estado_postulacion>"3" &&
                    $get_id->estado_postulacion<"6")){
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
                                    <label for="resultado_jd">Resultado</label>
                                    <select class="form-control" name="resultado_jd" 
                                    id="resultado_jd" {{ $disabled }}>  
                                        <option value="0">Seleccione</option>
                                        <option @php if(isset($get_eval_jd->id_eval_jefe_directo)){ if($get_eval_jd->resultado=="6"){ echo "selected"; } } @endphp value="6">APTO</option>
                                        <option @php if(isset($get_eval_jd->id_eval_jefe_directo)){ if($get_eval_jd->resultado=="5"){ echo "selected"; } } @endphp value="5">NO APTO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="observaciones_jd">Observaciones</label>
                                    <textarea class="form-control" name="observaciones_jd" 
                                    id="observaciones_jd" rows="4" placeholder="Observaciones"
                                    {{ $disabled }}>@php if(isset($get_eval_jd->id_eval_jefe_directo)){ echo $get_eval_jd->observaciones; } @endphp</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>            