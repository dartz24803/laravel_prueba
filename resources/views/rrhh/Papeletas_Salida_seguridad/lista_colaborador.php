<?php
    $id_puesto = session('usuario')->id_puesto;
    $id_nivel = session('usuario')->id_nivel;
    $centro_labores = session('usuario')->centro_labores;
?>

<table id="style-322" class="table " style="width:100%">
    <thead>
        <tr>
            <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $id_puesto==26 || $centro_labores=="CD" || $centro_labores=="OFC" || $centro_labores=="AMT"){ ?>
                <th>Base</th>
            <?php } ?>
            <th>Colaborador</th>
            <th>Motivo</th>
            <?php if($id_nivel==1 || $id_puesto==19 || $id_puesto==21 || $id_puesto==279 || $id_puesto==23 || $id_puesto==128 || $id_puesto==26){ ?>
                <th>Destino</th>
                <th>Especificación</th>
                <th>Trámite</th>
                <th>Especificación</th>
            <?php } ?>
            <th>Fecha</th>
            <th>H. Salida</th>
            <th>H. Retorno</th>
            <th>H. Real Salida</th>
            <th>H. Real Retorno</th>
            <th>Estado</th>
            <th class="no-content"></th>
            <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $id_puesto==26){ ?>
                <th>Aprobado Por</th>
                <th>Hora</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($list_papeletas_salida as $list) {  ?>   
        <tr>
            <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $id_puesto==26 || $centro_labores=="CD" || $centro_labores=="OFC" || $centro_labores=="AMT"){ ?>
                <td> <?php echo $list['centro_labores']; ?></td>
            <?php } ?>
            <td><?php echo $list['usuario_apater']." ".$list['usuario_amater']." ".$list['usuario_nombres']; ?></td>
            <td>
                <?php 
                    if( $list['id_motivo']==1){
                        echo "Laboral"; 
                    }else if ($list['id_motivo']==2){
                        echo "Personal"; 
                    }else{
                        echo $list['motivo']; 
                    }
                ?>                                        
            </td>
            <?php if($id_nivel==1 || $id_puesto==19 || $id_puesto==21 || $id_puesto==279 || $id_puesto==23 || $id_puesto==128 || $id_puesto==26){ ?>
                <td><?php echo $list['nom_destino']; ?></td>
                <td><?php echo $list['especificacion_destino']; ?></td>
                <td><?php echo $list['nom_tramite']; ?></td>
                <td><?php echo $list['especificacion_tramite']; ?></td>
            <?php } ?>
            <td><?php echo date_format(date_create($list['fec_solicitud']), "d/m/Y"); ?></td>
            <td>
                <?php
                    if($list['sin_ingreso'] == 1 ){
                        echo "Sin Ingreso";
                    }else{
                        echo $list['hora_salida']; 
                    }
                ?>
            </td>
            <td>
                <?php
                    if($list['sin_retorno'] == 1 ){
                        echo "Sin Retorno";
                    }else{
                        echo $list['hora_retorno']; 
                    }
                ?>
            </td>                                        
            <td>
                <?php
                    if($list['sin_ingreso'] == 1 ){
                        echo "Sin Ingreso";
                    }else{
                        if($list['horar_salida']!="00:00:00"){
                            echo $list['horar_salida']; 
                        }
                    }
                ?>
            </td>
            <td>
                <?php 
                    if( $list['sin_retorno']==1){
                        echo "Sin retorno"; 
                    }else{
                        if($list['horar_retorno']!="00:00:00"){
                            echo $list['horar_retorno']; 
                        }
                    }
                ?>
            </td>
            <td> 
                <?php 
                    if( $list['estado_solicitud']=='1'){
                        echo "<span class='shadow-none badge badge-warning'>En proceso</span>"; 
                    }else if ($list['estado_solicitud']=='2'){
                        echo "<span class='shadow-none badge badge-primary'>Aprobado</span>"; 
                    }else if ($list['estado_solicitud']=='3'){
                        echo " <span class='shadow-none badge badge-danger'>Denegado</span>"; 
                    }else if ($list['estado_solicitud']=='4'){
                        echo " <span class='shadow-none badge badge-warning'>En proceso - Aprobación Gerencia</span>"; 
                    }else if ($list['estado_solicitud']=='5'){
                        echo " <span class='shadow-none badge badge-warning'>En proceso - Aprobación RRHH</span>"; 
                    }else{
                        echo "<span class='shadow-none badge badge-primary'>Error</span>"; 
                    }
                ?>
            </td>
            <td class="text-center">
                
                <?php if( $list['estado_solicitud']==2) {  ?> 
                    <?php if($list['sin_ingreso']==1 && $list['sin_retorno']==0){ ?>
                        <?php if($list['horar_retorno']=="00:00:00"){ ?>
                            <a style="cursor: pointer;display: block;" title="Retorno"  onclick="Retorno_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')"  class="retornoo" role="button">
                                <svg width="40" height="40" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><rect x="192.545" y="13.086" style="fill:#69280F;" width="241.406" height="454.924"/><path style="fill:#A56941;" d="M433.956,481.088H192.547c-7.225,0-13.083-5.858-13.083-13.083V13.083C179.464,5.858,185.321,0,192.547,0h241.409c7.225,0,13.083,5.858,13.083,13.083v454.923C447.038,475.231,441.181,481.088,433.956,481.088z M203.463,459.239H423.04V21.85H203.463V459.239z"/><path style="fill:#501E0F;" d="M391.205,140.634H235.298c-4.607,0-8.341-3.735-8.341-8.341V63.969c0-4.607,3.735-8.341,8.341-8.341h155.906c4.607,0,8.341,3.735,8.341,8.341v68.322C399.546,136.899,395.811,140.634,391.205,140.634z"/><circle style="fill:#A56941;" cx="389.776" cy="257.111" r="18.843"/><g><path style="fill:#E4F2F6;" d="M335.092,172.099c-2.24-3.712-1.046-8.537,2.666-10.776l40.109-24.196c3.712-2.238,8.538-1.046,10.776,2.666c2.24,3.712,1.046,8.537-2.666,10.776l-40.109,24.196C342.136,177.016,337.319,175.791,335.092,172.099z"/><path style="fill:#E4F2F6;" d="M339.241,194.944c-0.459-4.311,2.662-8.178,6.973-8.637l30.105-3.209c4.299-0.463,8.178,2.662,8.637,6.973c0.459,4.311-2.662,8.178-6.973,8.637l-30.105,3.209C343.576,202.377,339.701,199.262,339.241,194.944z"/></g><circle style="fill:#FFB69E;" cx="162.058" cy="72.564" r="39.197"/><path style="fill:#343E6B;" d="M189.23,512c-12.6,0-22.814-10.214-22.814-22.814V306.833c0-12.6,10.214-22.814,22.814-22.814c12.6,0,22.814,10.214,22.814,22.814v182.353C212.044,501.786,201.829,512,189.23,512z"/><path style="fill:#414B82;" d="M134.157,512c-12.6,0-22.814-10.214-22.814-22.814V306.833c0-12.6,10.214-22.814,22.814-22.814s22.814,10.214,22.814,22.814v182.353C156.971,501.786,146.756,512,134.157,512z"/><path style="fill:#252D5C;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l-38.307,23.784v-35.367c-0.123-24.557-20.38-44.536-44.937-44.536h-0.699c-12.091,0-89.062,0-101.572,0c-25.07,0-45.568,20.081-45.691,44.765c0,0.032,0,0.063,0,0.095v139.67c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012V169.173c0.04-3.616,3.685-6.9,7.669-6.9h0.684v144.56h100.701c0-13.477,0-129.6,0-144.754c0.101,0,0.987,0,0.886,0c3.803,0,7.26,3.095,7.279,6.897v69.172c0.074,14.811,16.376,23.745,28.891,15.974l67.029-41.617C325.004,206.995,327.731,195.334,322.221,186.46z"/><path style="fill:#1B224A;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l-38.307,23.784v-35.367c-0.123-24.557-20.38-44.536-44.937-44.536c-6.494,0-44.999,0-51.244,0v182.583h50.356c0-13.477,0-129.6,0-144.754c0.101,0,0.987,0,0.886,0c3.803,0,7.26,3.095,7.28,6.897v69.172c0.074,14.811,16.376,23.745,28.891,15.974l67.029-41.617C325.004,206.995,327.731,195.334,322.221,186.46z"/><path style="fill:#FFB69E;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l19.954,32.138C325.004,206.995,327.731,195.334,322.221,186.46z"/><g>                                        <rect x="283.86" y="194.463" transform="matrix(-0.5226 -0.8526 0.8526 -0.5226 291.7662 560.3716)" style="fill:#FFFFFF;" width="37.829" height="8.068"/><path style="fill:#FFFFFF;" d="M64.962,298.975v9.806c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012v-9.806H64.962z"/></g><path style="fill:#FFB69E;" d="M64.962,308.291v0.489c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012v-0.489H64.962z"/><polygon style="fill:#FFFFFF;" points="132.679,124.25 161.688,200.377 190.703,124.25 "/><path style="fill:#FF4619;" d="M174.305,150.165l-6.445-11.721l5.554-10.101c1.01-1.837-0.321-4.092-2.42-4.092h-18.619c-2.096,0-3.431,2.253-2.42,4.092l5.573,10.136l-6.427,11.688c-0.89,1.619-1.179,3.498-0.818,5.31l3.964,20.124l9.439,24.778l9.448-24.782l3.986-20.117C175.485,153.665,175.195,151.785,174.305,150.165z"/><path style="fill:#DC1428;" d="M174.305,150.165l-6.445-11.721l5.554-10.101c1.01-1.837-0.32-4.092-2.42-4.092h-9.308v76.111v0.016l9.448-24.783l3.986-20.117C175.485,153.666,175.195,151.785,174.305,150.165z"/><rect x="175.736" y="182.74" style="fill:#252D5C;" width="25.118" height="7.745"/></svg>
                            </a>

                            <a style="cursor: pointer;display: block;" title="Sin Retorno" onclick="Cambiar_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')" class="sin_retorno" role="button">
                                <svg width="40" height="40" id="Icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                    <defs>
                                        <style>
                                            .cls-1{fill:#45413c;opacity:0.15;}
                                            .cls-2{fill:#ff6242;}.cls-3{fill:#ff866e;}
                                            .cls-4{fill:none;stroke:#45413c;stroke-linecap:round;stroke-linejoin:round;}
                                        </style>
                                    </defs>
                                    <title>Sin Retorno</title>
                                    <ellipse id="_Ellipse_" data-name="&lt;Ellipse&gt;" class="cls-1" cx="24" cy="44.18" rx="8.48" ry="1.82"/>
                                    <path class="cls-2" d="M25.4,2.5H22.6c-1.86,0-3.34,1.18-3.23,2.57L21,26.32c.09,1.18,1.4,2.11,3,2.11s2.88-.93,3-2.11L28.63,5.07C28.74,3.68,27.26,2.5,25.4,2.5Z"/>
                                    <path id="_Path_" data-name="&lt;Path&gt;" class="cls-3" d="M19.56,7.48a3.31,3.31,0,0,1,3-1.6h2.8a3.31,3.31,0,0,1,3,1.6l.19-2.41c.11-1.39-1.37-2.57-3.23-2.57H22.6c-1.86,0-3.34,1.18-3.23,2.57Z"/>
                                    <path class="cls-4" d="M25.4,2.5H22.6c-1.86,0-3.34,1.18-3.23,2.57L21,26.32c.09,1.18,1.4,2.11,3,2.11s2.88-.93,3-2.11L28.63,5.07C28.74,3.68,27.26,2.5,25.4,2.5Z"/>
                                    <circle id="_Path_2" data-name="&lt;Path&gt;" class="cls-2" cx="24" cy="35.24" r="3.65"/>
                                    <path id="_Path_3" data-name="&lt;Path&gt;" class="cls-3" d="M24,33.93A3.58,3.58,0,0,1,27.57,36a3.94,3.94,0,0,0,.08-.77,3.65,3.65,0,1,0-7.3,0,3.94,3.94,0,0,0,.08.77A3.58,3.58,0,0,1,24,33.93Z"/>
                                    <circle id="_Path_4" data-name="&lt;Path&gt;" class="cls-4" cx="24" cy="35.24" r="3.65"/>
                                </svg>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if($list['sin_ingreso']==0 && $list['sin_retorno']==1){ ?>
                        <?php if($list['horar_salida']=="00:00:00"){ ?>
                            <a style="cursor: pointer;display: block;" title="Salida"  onclick="Salida_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')" class="salidaa" role="button">
                                <svg width="40" height="40" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#4F2410;" d="M318.314,463.959H10.969C4.911,463.959,0,459.048,0,452.989V11.607C0,5.55,4.911,0.639,10.969,0.639h307.344c6.058,0,10.969,4.911,10.969,10.969v441.382C329.282,459.048,324.371,463.959,318.314,463.959z M21.939,442.02h285.406V22.577H21.939V442.02z"/><path style="fill:#632C15;" d="M176.449,48.474L14.042,1.078C10.728,0.11,7.15,0.76,4.389,2.832C1.626,4.904,0,8.155,0,11.607v441.382c0,4.875,3.217,9.164,7.896,10.53l162.408,47.397c7.009,2.045,14.043-3.214,14.043-10.53V59.004C184.346,54.13,181.129,49.84,176.449,48.474z"/><path style="fill:#80391B;" d="M149.318,323.443c-6.058,0-10.969-4.911-10.969-10.969v-69.725c0-6.058,4.911-10.969,10.969-10.969c6.058,0,10.969,4.911,10.969,10.969v69.725C160.288,318.531,155.377,323.443,149.318,323.443z"/><path style="fill:#252D5C;" d="M191.111,249.65c-5.024,0-10.025-2.064-13.628-6.113c-6.693-7.522-6.02-19.047,1.503-25.74l69.745-62.052c2.777-2.471,6.244-4.034,9.934-4.479l90.535-10.927c10.003-1.209,19.079,5.919,20.286,15.916c1.206,9.997-5.919,19.079-15.916,20.285l-84.866,10.243l-65.48,58.256C199.749,248.13,195.422,249.65,191.111,249.65z"/><path style="fill:#414B82;" d="M341.579,478.067c-11.053-3.924-16.831-16.066-12.907-27.118l32.042-90.246l-53.573-84.139c-6.299-9.893-3.386-23.021,6.508-29.32c9.891-6.299,23.02-3.386,29.319,6.507l59.139,92.883c3.514,5.518,4.287,12.347,2.098,18.511l-35.51,100.014C364.791,476.163,352.679,482.008,341.579,478.067z"/><path style="fill:#53618C;" d="M400.355,144.46l-45.289-17.292c-14.026-5.356-29.737,1.673-35.092,15.699l-49.751,130.298l-25.609,88.966l-45.263,86.038c-5.461,10.38-1.473,23.221,8.907,28.682c10.403,5.473,23.234,1.45,28.682-8.907l46.255-87.924c0.66-1.254,1.193-2.572,1.59-3.932l25.587-87.592l5.765,2.201l54.807,6.996l45.109-118.139C421.41,165.527,414.381,149.815,400.355,144.46z"/><path style="fill:#1B224A;" d="M316.139,290.695l-45.914-17.532l49.751-130.297c5.356-14.026,21.066-21.054,35.092-15.699l45.289,17.292c14.026,5.356,21.054,21.066,15.699,35.092l-45.109,118.139L316.139,290.695z"/><circle style="fill:#FFB69E;" cx="403.766" cy="87.135" r="40.238"/><path style="fill:#FFFFFF;" d="M185.089,212.368l-6.103,5.43c-7.523,6.693-8.195,18.217-1.503,25.739c6.711,7.543,18.236,8.178,25.74,1.503l5.713-5.082L185.089,212.368z"/><path style="fill:#FFB69E;" d="M178.986,217.798c-7.523,6.693-8.195,18.217-1.503,25.739c6.711,7.543,18.236,8.178,25.74,1.503L178.986,217.798z"/><path style="fill:#59250F;" d="M469.267,311.312h-41.062c-4.418,0-7.999-3.581-7.999-7.999v-39.462c0-4.418,3.581-7.999,7.999-7.999h41.062c4.418,0,7.999,3.581,7.999,7.999v39.462C477.266,307.731,473.685,311.312,469.267,311.312z M436.204,295.314h25.064V271.85h-25.064V295.314z"/><path style="fill:#80391B;" d="M512,293.904v69.139c0,5.547-4.497,10.044-10.044,10.044H395.514c-5.547,0-10.044-4.497-10.044-10.044v-69.14c0-5.547,4.497-10.044,10.044-10.044h106.442C507.503,283.86,512,288.356,512,293.904z"/><path style="fill:#252D5C;" d="M451.922,278.554c-1.976,0.163-4.012,0.005-6.04-0.516l-70.548-18.132c-5.914-1.52-10.672-5.898-12.681-11.665l-29.186-83.856c-3.311-9.51,1.716-19.902,11.226-23.212c9.508-3.316,19.902,1.716,23.212,11.226l25.973,74.625l61.08,15.699c9.753,2.507,15.626,12.444,13.12,22.196C466.094,272.643,459.445,277.933,451.922,278.554z"/><path style="fill:#FFFFFF;" d="M454.96,242.722l-9.069-2.331l-8.725,35.406l8.717,2.241c9.761,2.51,19.693-3.379,22.196-13.12C470.585,255.165,464.713,245.229,454.96,242.722z"/><path style="fill:#FFB69E;" d="M454.96,242.722l-9.077,35.316c9.761,2.51,19.693-3.379,22.196-13.12C470.585,255.165,464.713,245.229,454.96,242.722z"/></svg>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if($list['sin_ingreso']==0 && $list['sin_retorno']==0){ ?>
                        <?php if($list['horar_salida']=="00:00:00"){ ?>
                            <a style="cursor: pointer;display: block;" title="Salida"  onclick="Salida_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')" class="salidaa" role="button">
                                <svg width="40" height="40" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#4F2410;" d="M318.314,463.959H10.969C4.911,463.959,0,459.048,0,452.989V11.607C0,5.55,4.911,0.639,10.969,0.639h307.344c6.058,0,10.969,4.911,10.969,10.969v441.382C329.282,459.048,324.371,463.959,318.314,463.959z M21.939,442.02h285.406V22.577H21.939V442.02z"/><path style="fill:#632C15;" d="M176.449,48.474L14.042,1.078C10.728,0.11,7.15,0.76,4.389,2.832C1.626,4.904,0,8.155,0,11.607v441.382c0,4.875,3.217,9.164,7.896,10.53l162.408,47.397c7.009,2.045,14.043-3.214,14.043-10.53V59.004C184.346,54.13,181.129,49.84,176.449,48.474z"/><path style="fill:#80391B;" d="M149.318,323.443c-6.058,0-10.969-4.911-10.969-10.969v-69.725c0-6.058,4.911-10.969,10.969-10.969c6.058,0,10.969,4.911,10.969,10.969v69.725C160.288,318.531,155.377,323.443,149.318,323.443z"/><path style="fill:#252D5C;" d="M191.111,249.65c-5.024,0-10.025-2.064-13.628-6.113c-6.693-7.522-6.02-19.047,1.503-25.74l69.745-62.052c2.777-2.471,6.244-4.034,9.934-4.479l90.535-10.927c10.003-1.209,19.079,5.919,20.286,15.916c1.206,9.997-5.919,19.079-15.916,20.285l-84.866,10.243l-65.48,58.256C199.749,248.13,195.422,249.65,191.111,249.65z"/><path style="fill:#414B82;" d="M341.579,478.067c-11.053-3.924-16.831-16.066-12.907-27.118l32.042-90.246l-53.573-84.139c-6.299-9.893-3.386-23.021,6.508-29.32c9.891-6.299,23.02-3.386,29.319,6.507l59.139,92.883c3.514,5.518,4.287,12.347,2.098,18.511l-35.51,100.014C364.791,476.163,352.679,482.008,341.579,478.067z"/><path style="fill:#53618C;" d="M400.355,144.46l-45.289-17.292c-14.026-5.356-29.737,1.673-35.092,15.699l-49.751,130.298l-25.609,88.966l-45.263,86.038c-5.461,10.38-1.473,23.221,8.907,28.682c10.403,5.473,23.234,1.45,28.682-8.907l46.255-87.924c0.66-1.254,1.193-2.572,1.59-3.932l25.587-87.592l5.765,2.201l54.807,6.996l45.109-118.139C421.41,165.527,414.381,149.815,400.355,144.46z"/><path style="fill:#1B224A;" d="M316.139,290.695l-45.914-17.532l49.751-130.297c5.356-14.026,21.066-21.054,35.092-15.699l45.289,17.292c14.026,5.356,21.054,21.066,15.699,35.092l-45.109,118.139L316.139,290.695z"/><circle style="fill:#FFB69E;" cx="403.766" cy="87.135" r="40.238"/><path style="fill:#FFFFFF;" d="M185.089,212.368l-6.103,5.43c-7.523,6.693-8.195,18.217-1.503,25.739c6.711,7.543,18.236,8.178,25.74,1.503l5.713-5.082L185.089,212.368z"/><path style="fill:#FFB69E;" d="M178.986,217.798c-7.523,6.693-8.195,18.217-1.503,25.739c6.711,7.543,18.236,8.178,25.74,1.503L178.986,217.798z"/><path style="fill:#59250F;" d="M469.267,311.312h-41.062c-4.418,0-7.999-3.581-7.999-7.999v-39.462c0-4.418,3.581-7.999,7.999-7.999h41.062c4.418,0,7.999,3.581,7.999,7.999v39.462C477.266,307.731,473.685,311.312,469.267,311.312z M436.204,295.314h25.064V271.85h-25.064V295.314z"/><path style="fill:#80391B;" d="M512,293.904v69.139c0,5.547-4.497,10.044-10.044,10.044H395.514c-5.547,0-10.044-4.497-10.044-10.044v-69.14c0-5.547,4.497-10.044,10.044-10.044h106.442C507.503,283.86,512,288.356,512,293.904z"/><path style="fill:#252D5C;" d="M451.922,278.554c-1.976,0.163-4.012,0.005-6.04-0.516l-70.548-18.132c-5.914-1.52-10.672-5.898-12.681-11.665l-29.186-83.856c-3.311-9.51,1.716-19.902,11.226-23.212c9.508-3.316,19.902,1.716,23.212,11.226l25.973,74.625l61.08,15.699c9.753,2.507,15.626,12.444,13.12,22.196C466.094,272.643,459.445,277.933,451.922,278.554z"/><path style="fill:#FFFFFF;" d="M454.96,242.722l-9.069-2.331l-8.725,35.406l8.717,2.241c9.761,2.51,19.693-3.379,22.196-13.12C470.585,255.165,464.713,245.229,454.96,242.722z"/><path style="fill:#FFB69E;" d="M454.96,242.722l-9.077,35.316c9.761,2.51,19.693-3.379,22.196-13.12C470.585,255.165,464.713,245.229,454.96,242.722z"/></svg>
                            </a>
                        <?php } ?>

                        <?php if($list['horar_retorno']=="00:00:00" && $list['horar_salida']!="00:00:00"){ ?>
                            <a style="cursor: pointer;display: block;" title="Retorno"  onclick="Retorno_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')"  class="retornoo" role="button">
                                <svg width="40" height="40" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><rect x="192.545" y="13.086" style="fill:#69280F;" width="241.406" height="454.924"/><path style="fill:#A56941;" d="M433.956,481.088H192.547c-7.225,0-13.083-5.858-13.083-13.083V13.083C179.464,5.858,185.321,0,192.547,0h241.409c7.225,0,13.083,5.858,13.083,13.083v454.923C447.038,475.231,441.181,481.088,433.956,481.088z M203.463,459.239H423.04V21.85H203.463V459.239z"/><path style="fill:#501E0F;" d="M391.205,140.634H235.298c-4.607,0-8.341-3.735-8.341-8.341V63.969c0-4.607,3.735-8.341,8.341-8.341h155.906c4.607,0,8.341,3.735,8.341,8.341v68.322C399.546,136.899,395.811,140.634,391.205,140.634z"/><circle style="fill:#A56941;" cx="389.776" cy="257.111" r="18.843"/><g><path style="fill:#E4F2F6;" d="M335.092,172.099c-2.24-3.712-1.046-8.537,2.666-10.776l40.109-24.196c3.712-2.238,8.538-1.046,10.776,2.666c2.24,3.712,1.046,8.537-2.666,10.776l-40.109,24.196C342.136,177.016,337.319,175.791,335.092,172.099z"/><path style="fill:#E4F2F6;" d="M339.241,194.944c-0.459-4.311,2.662-8.178,6.973-8.637l30.105-3.209c4.299-0.463,8.178,2.662,8.637,6.973c0.459,4.311-2.662,8.178-6.973,8.637l-30.105,3.209C343.576,202.377,339.701,199.262,339.241,194.944z"/></g><circle style="fill:#FFB69E;" cx="162.058" cy="72.564" r="39.197"/><path style="fill:#343E6B;" d="M189.23,512c-12.6,0-22.814-10.214-22.814-22.814V306.833c0-12.6,10.214-22.814,22.814-22.814c12.6,0,22.814,10.214,22.814,22.814v182.353C212.044,501.786,201.829,512,189.23,512z"/><path style="fill:#414B82;" d="M134.157,512c-12.6,0-22.814-10.214-22.814-22.814V306.833c0-12.6,10.214-22.814,22.814-22.814s22.814,10.214,22.814,22.814v182.353C156.971,501.786,146.756,512,134.157,512z"/><path style="fill:#252D5C;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l-38.307,23.784v-35.367c-0.123-24.557-20.38-44.536-44.937-44.536h-0.699c-12.091,0-89.062,0-101.572,0c-25.07,0-45.568,20.081-45.691,44.765c0,0.032,0,0.063,0,0.095v139.67c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012V169.173c0.04-3.616,3.685-6.9,7.669-6.9h0.684v144.56h100.701c0-13.477,0-129.6,0-144.754c0.101,0,0.987,0,0.886,0c3.803,0,7.26,3.095,7.279,6.897v69.172c0.074,14.811,16.376,23.745,28.891,15.974l67.029-41.617C325.004,206.995,327.731,195.334,322.221,186.46z"/><path style="fill:#1B224A;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l-38.307,23.784v-35.367c-0.123-24.557-20.38-44.536-44.937-44.536c-6.494,0-44.999,0-51.244,0v182.583h50.356c0-13.477,0-129.6,0-144.754c0.101,0,0.987,0,0.886,0c3.803,0,7.26,3.095,7.28,6.897v69.172c0.074,14.811,16.376,23.745,28.891,15.974l67.029-41.617C325.004,206.995,327.731,195.334,322.221,186.46z"/><path style="fill:#FFB69E;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l19.954,32.138C325.004,206.995,327.731,195.334,322.221,186.46z"/><g>                                        <rect x="283.86" y="194.463" transform="matrix(-0.5226 -0.8526 0.8526 -0.5226 291.7662 560.3716)" style="fill:#FFFFFF;" width="37.829" height="8.068"/><path style="fill:#FFFFFF;" d="M64.962,298.975v9.806c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012v-9.806H64.962z"/></g><path style="fill:#FFB69E;" d="M64.962,308.291v0.489c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012v-0.489H64.962z"/><polygon style="fill:#FFFFFF;" points="132.679,124.25 161.688,200.377 190.703,124.25 "/><path style="fill:#FF4619;" d="M174.305,150.165l-6.445-11.721l5.554-10.101c1.01-1.837-0.321-4.092-2.42-4.092h-18.619c-2.096,0-3.431,2.253-2.42,4.092l5.573,10.136l-6.427,11.688c-0.89,1.619-1.179,3.498-0.818,5.31l3.964,20.124l9.439,24.778l9.448-24.782l3.986-20.117C175.485,153.665,175.195,151.785,174.305,150.165z"/><path style="fill:#DC1428;" d="M174.305,150.165l-6.445-11.721l5.554-10.101c1.01-1.837-0.32-4.092-2.42-4.092h-9.308v76.111v0.016l9.448-24.783l3.986-20.117C175.485,153.666,175.195,151.785,174.305,150.165z"/><rect x="175.736" y="182.74" style="fill:#252D5C;" width="25.118" height="7.745"/></svg>
                            </a>

                            <a style="cursor: pointer;display: block;" title="Sin Retorno" onclick="Cambiar_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')" class="sin_retorno" role="button">
                                <svg width="40" height="40" id="Icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><defs><style>.cls-1{fill:#45413c;opacity:0.15;}.cls-2{fill:#ff6242;}.cls-3{fill:#ff866e;}.cls-4{fill:none;stroke:#45413c;stroke-linecap:round;stroke-linejoin:round;}</style></defs><title>Sin Retorno</title><ellipse id="_Ellipse_" data-name="&lt;Ellipse&gt;" class="cls-1" cx="24" cy="44.18" rx="8.48" ry="1.82"/><path class="cls-2" d="M25.4,2.5H22.6c-1.86,0-3.34,1.18-3.23,2.57L21,26.32c.09,1.18,1.4,2.11,3,2.11s2.88-.93,3-2.11L28.63,5.07C28.74,3.68,27.26,2.5,25.4,2.5Z"/><path id="_Path_" data-name="&lt;Path&gt;" class="cls-3" d="M19.56,7.48a3.31,3.31,0,0,1,3-1.6h2.8a3.31,3.31,0,0,1,3,1.6l.19-2.41c.11-1.39-1.37-2.57-3.23-2.57H22.6c-1.86,0-3.34,1.18-3.23,2.57Z"/><path class="cls-4" d="M25.4,2.5H22.6c-1.86,0-3.34,1.18-3.23,2.57L21,26.32c.09,1.18,1.4,2.11,3,2.11s2.88-.93,3-2.11L28.63,5.07C28.74,3.68,27.26,2.5,25.4,2.5Z"/><circle id="_Path_2" data-name="&lt;Path&gt;" class="cls-2" cx="24" cy="35.24" r="3.65"/><path id="_Path_3" data-name="&lt;Path&gt;" class="cls-3" d="M24,33.93A3.58,3.58,0,0,1,27.57,36a3.94,3.94,0,0,0,.08-.77,3.65,3.65,0,1,0-7.3,0,3.94,3.94,0,0,0,.08.77A3.58,3.58,0,0,1,24,33.93Z"/><circle id="_Path_4" data-name="&lt;Path&gt;" class="cls-4" cx="24" cy="35.24" r="3.65"/></svg>
                            </a>
                        <?php } ?>
                    <?php } ?>
                <?php }  ?>
            </td>
            <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $id_puesto==26){ ?>
                <td><?php echo $list['apater_apro']." ".$list['amater_apro']." ".$list['nom_apro']; ?> </td>
                <td><?php echo date_format(date_create($list['fec_apro']), "H:i:s"); ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>

 <script>
    $('#style-322').DataTable({
        responsive:true,
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Mostrando página _PAGE_ de _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
    "sLengthMenu": "Resultados :  _MENU_",
    },
    "stripeClasses": [],
    "lengthMenu": [50, 70, 100],
        "pageLength": 50
});
    /*c3 = $('#style-32').DataTable({
        responsive:true,
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Mostrando página _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",

        },
        "stripeClasses": [],
        "lengthMenu": [50, 70, 100],
        "pageLength": 50
    });

    multiCheck(c3);*/
</script>