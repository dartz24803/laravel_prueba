<div class="row">
    <div class="col">
        <h6>VERIFICACIÓN SOCIAL</h6>
    </div>
    <div class="col text-md-right text-center">
        @if ((session('usuario')->id_nivel=="1" || 
        session('usuario')->id_puesto=="21" ||
        session('usuario')->id_puesto=="22" ||
        session('usuario')->id_puesto=="277" ||
        session('usuario')->id_puesto=="278") &&
        $get_id->estado_postulacion>"5")
            @if ($get_id->estado_postulacion>="8")
                <button type="button" class="btn btn-primary" onclick="Update_Ver_Social();">Actualizar</button>
            @else
            <button type="button" class="btn btn-primary" onclick="Update_Verificacion_Social();">Actualizar</button>
            @endif
        @endif
    </div>
</div>
<div class="row">
    <div class="col-lg-11 mx-auto">
        <div class="row">
            @php 
                if((session('usuario')->id_nivel=="1" || 
                session('usuario')->id_puesto=="21" ||
                session('usuario')->id_puesto=="22" ||
                session('usuario')->id_puesto=="277" ||
                session('usuario')->id_puesto=="278") && 
                ($get_id->estado_postulacion>"5" &&
                $get_id->estado_postulacion<"8")){
                    $disabled_1 = "";
                }else{
                    $disabled_1 = "disabled";
                }

                if((session('usuario')->id_nivel=="1" || 
                session('usuario')->id_puesto=="21" ||
                session('usuario')->id_puesto=="22" ||
                session('usuario')->id_puesto=="277" ||
                session('usuario')->id_puesto=="278") && 
                $get_id->estado_postulacion>"5"){
                    $disabled_2 = "";
                }else{
                    $disabled_2 = "disabled";
                }
            @endphp

            <div class="col-lg-12 col-md-8 mt-md-0 mt-4">
                <div class="form">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="resultado_vs">Resultado</label>
                                <select class="form-control" name="resultado_vs" 
                                id="resultado_vs" {{ $disabled_1 }}>  
                                    <option value="0">Seleccione</option>
                                    <option @php if(isset($get_vs->id_ver_social)){ if($get_vs->resultado=="8"){ echo "selected"; } } @endphp value="8">APTO</option>
                                    <option @php if(isset($get_vs->id_ver_social)){ if($get_vs->resultado=="7"){ echo "selected"; } } @endphp value="7">NO APTO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="ver_social">Adjuntar verificacion social</label>
                                @if (isset($get_vs->id_ver_social))
                                    <a title="Verificacion social" href="{{ $get_vs->ver_social }}" target="_blank">
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
                                <input type="file" class="form-control-file" name="ver_social" 
                                id="ver_social" onchange="Valida_Archivo('ver_social');"
                                {{ $disabled_2 }}>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="observaciones_vs">Observaciones</label>
                                <textarea class="form-control" name="observaciones_vs" 
                                id="observaciones_vs" rows="4" placeholder="Observaciones"
                                {{ $disabled_1 }}>@php if(isset($get_vs->id_ver_social)){ echo $get_vs->observaciones; } @endphp</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>            