<style>
    #hreportbiseguridad>div {
        display: flex;
        align-items: center;
        overflow: hidden;
        /* Asegura que el texto no desborde el contenedor */
    }

    /* Estilo para el texto dentro de <span> */
    #hreportbiseguridad span {
        margin-left: 8px;
        /* Espacio entre el ícono y el texto */
        white-space: normal;
        /* Permite que el texto se ajuste en múltiples líneas */
        overflow-wrap: break-word;
        /* Rompe palabras largas si es necesario */
        word-wrap: break-word;
        /* Compatibilidad con navegadores más antiguos */
    }

    #rreportbiseguridad {
        margin-left: -10%
    }
</style>


<?php if (
    session('usuario')->id_nivel == "1" || session('usuario')->centro_labores == "OFC" || session('usuario')->id_puesto == "161" ||
    session('usuario')->id_puesto == "314" || session('usuario')->id_puesto == "128" || session('usuario')->id_puesto == "251" || session('usuario')->id_puesto == "41" ||
    session('usuario')->id_puesto == "66" || session('usuario')->id_puesto == "73" || session('usuario')->id_puesto == "158" || session('usuario')->id_puesto == "12" ||
    session('usuario')->id_puesto == "155" || session('usuario')->id_puesto == "9" || session('usuario')->id_puesto == "19" || session('usuario')->id_puesto == "21" ||
    session('usuario')->id_puesto == "131" || session('usuario')->id_puesto == "68" || session('usuario')->id_puesto == "72" || session('usuario')->id_puesto == "15" ||
    session('usuario')->id_puesto == "27" || session('usuario')->id_puesto == "148" || session('usuario')->id_puesto == "76" || session('usuario')->id_puesto == "311" ||
    Session('usuario')->id_puesto == "144" || session('usuario')->id_puesto == "22"
) { ?>
    <li class="menu menu-heading">
        <div class="heading">
            <span>INICIO SEGURIDAD</span>
        </div>
    </li>

    <li class="menu" id="inicio_seguridad">
        <a id="hinicio_seguridad" href="{{ url('InicioSeguridad/index') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Inicio SEGURIDAD </span>
            </div>
        </a>
    </li>
<?php } ?>









<li class="menu menu-heading">
    <div class="heading">
        <span>MÓDULOS</span>
    </div>
</li>
{{-- puesto 36 y 315 son lo mismo deben tener mismo acceso; agente de seguridad y prevencionista respectivamente --}}
<li class="menu" id="seguridades">
    <a href="#rseguridades" id="hseguridades" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
            <span>Seguridad</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rseguridades" data-parent="#accordionExample">
        @if (session('usuario')->id_nivel == 1 ||
        session('usuario')->id_puesto == 10 ||
        session('usuario')->id_puesto == 36 ||
        session('usuario')->id_puesto == 29 ||
        session('usuario')->id_puesto == 24 ||
        session('usuario')->id_puesto == 16 ||
        session('usuario')->id_puesto == 20 ||
        session('usuario')->id_puesto == 21 ||
        session('usuario')->id_puesto == 279 ||
        session('usuario')->id_puesto == 26 ||
        session('usuario')->id_puesto == 27 ||
        session('usuario')->id_puesto == 98 ||
        session('usuario')->id_puesto == 23 ||
        session('usuario')->id_puesto == 31 ||
        session('usuario')->id_puesto == 30 ||
        session('usuario')->id_puesto == 19 ||
        session('usuario')->id_puesto == 12 ||
        session('usuario')->id_puesto == 13 ||
        session('usuario')->id_puesto == 104 ||
        session('usuario')->id_puesto == 155 ||
        session('usuario')->id_puesto == 22 ||
        session('usuario')->id_puesto == 161 ||
        session('usuario')->id_puesto == 164 ||
        session('usuario')->id_puesto == 197 ||
        session('usuario')->id_puesto == 148 ||
        session('usuario')->id_puesto == 307 ||
        session('usuario')->id_puesto == 311 ||
        session('usuario')->id_puesto == 314 ||
        session('usuario')->id_puesto == 315 ||
        session('usuario')->id_puesto == 209 ||
        session('usuario')->id_puesto == 277)
        @if (session('usuario')->id_nivel == 1 ||
        session('usuario')->id_puesto == 23 ||
        session('usuario')->id_puesto == 307 ||
        session('usuario')->id_puesto == 311 ||
        session('usuario')->id_puesto == 314 ||
        session('usuario')->id_puesto == 315 ||
        session('usuario')->id_puesto == 29 ||
        session('usuario')->id_puesto == 30 ||
        session('usuario')->id_puesto == 31 ||
        session('usuario')->id_puesto == 197 ||
        session('usuario')->id_puesto == 36 ||
        session('usuario')->id_puesto == 24)
        <li>
            <a id="aperturas_cierres" href="{{ route('apertura_cierre') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Apertura y cierre</p>
            </a>
        </li>
        @endif
        @if (session('usuario')->id_nivel == 1 ||
        session('usuario')->id_puesto == 21 ||
        session('usuario')->id_puesto == 279 ||
        session('usuario')->id_puesto == 23 ||
        session('usuario')->id_puesto == 24 ||
        session('usuario')->id_puesto == 36 ||
        session('usuario')->id_puesto == 19 ||
        session('usuario')->id_puesto == 22 ||
        session('usuario')->id_puesto == 307 ||
        session('usuario')->id_puesto == 311 ||
        session('usuario')->id_puesto == 315 ||
        session('usuario')->id_puesto == 209 ||
        session('usuario')->id_puesto == 277)
        <li>
            <a id="asistencias_segs" href="{{ route('asistencia_seg') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Asistencia</p>
            </a>
        </li>
        @endif
        @if (session('usuario')->id_nivel == 1 ||
        session('usuario')->id_puesto == 23 ||
        session('usuario')->id_puesto == 24 ||
        session('usuario')->id_puesto == 164 ||
        session('usuario')->id_puesto == 307)
        <li>
            <a id="controles_camaras" href="{{ route('control_camara') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Control de cámaras</p>
            </a>
        </li>
        @endif
        @if (session('usuario')->id_nivel == 1 ||
        session('usuario')->id_puesto == 24 ||
        session('usuario')->id_puesto == 36 ||
        session('usuario')->id_puesto == 29 ||
        session('usuario')->id_puesto == 16 ||
        session('usuario')->id_puesto == 20 ||
        session('usuario')->id_puesto == 26 ||
        session('usuario')->id_puesto == 27 ||
        session('usuario')->id_puesto == 98 ||
        session('usuario')->id_puesto == 31 ||
        session('usuario')->id_puesto == 30 ||
        session('usuario')->id_puesto == 10 ||
        session('usuario')->id_puesto == 23 ||
        session('usuario')->id_puesto == 12 ||
        session('usuario')->id_puesto == 13 ||
        session('usuario')->id_puesto == 104 ||
        session('usuario')->id_puesto == 155 ||
        session('usuario')->id_puesto == 161 ||
        session('usuario')->id_puesto == 197 ||
        session('usuario')->id_puesto == 134 ||
        session('usuario')->id_puesto == 307 ||
        session('usuario')->id_puesto == 311 ||
        session('usuario')->id_puesto == 314 ||
        session('usuario')->id_puesto == 315 ||
        session('usuario')->id_puesto == 148)
        <li>
            <a id="lecturas_servicios" href="{{ route('lectura_servicio') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Lectura Servicio</p>
            </a>
        </li>
        @endif
        @if (session('usuario')->id_nivel == 1 ||
        session('usuario')->id_puesto == 23 ||
        session('usuario')->id_puesto == 24 ||
        session('usuario')->id_puesto == 36 ||
        session('usuario')->id_puesto == 26 ||
        session('usuario')->id_puesto == 29 ||
        session('usuario')->id_puesto == 161 ||
        session('usuario')->id_puesto == 197 ||
        session('usuario')->id_puesto == 307 ||
        session('usuario')->id_puesto == 311 ||
        session('usuario')->id_puesto == 314 ||
        session('usuario')->id_puesto == 315 ||
        session('usuario')->id_puesto == 148)
        <li id="locurrencia">
            <a id="hlocurrencia" href="<?= url('OcurrenciaTienda/index') ?>">
                <p class="romperpalabra"><span id="icono_active2"></span> Ocurrencias</p>
            </a>
        </li>
        @endif
        @if (session('usuario')->id_nivel == 1 ||
        session('usuario')->id_puesto == 23 ||
        session('usuario')->id_puesto == 24 ||
        session('usuario')->id_puesto == 307 ||
        session('usuario')->id_puesto == 311 ||
        session('usuario')->id_puesto == 315 ||
        session('usuario')->id_puesto == 36)
        <li id="lrproveedor">
            <a id="hlrproveedor" href="<?= url('RProveedores/index') ?>">
                <p class="romperpalabra"><span id="icono_active2"></span> Reporte de proveedores</p>
            </a>
        </li>
        @endif
        @endif
    </ul>
</li>










<!-- REPORTE BI  -->
<li class="menu menu-heading">
    <div class="heading">
        <span>REPORTES BI</span>
    </div>
</li>

<li class="menu" id="reportbi_primario">
    <a href="#rreportbi_primario" id="hreportbi_primario" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart">
                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
            </svg>
            <span title="{{ $list_subgerencia['nom_sub_gerencia'] }}">{{ $list_subgerencia['nom_sub_gerencia'] }}</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="rreportbi_primario" data-parent="#accordionExample">
        @foreach ($list_subgerencia['areas'] as $area)
        @php
        $normalizedArea = preg_replace('/[áéíóúÁÉÍÓÚ]/', 'a', strtolower($area['nom_area'])); // Reemplazar acentos
        $normalizedArea = preg_replace('/[.]/', '', $normalizedArea); // Eliminar puntos
        $normalizedArea = preg_replace('/\s+/', '_', $normalizedArea); // Reemplazar espacios con guiones bajos
        $normalizedArea = preg_replace('/[^a-z0-9_]/', '', $normalizedArea); // Eliminar caracteres no alfanuméricos
        @endphp
        <li id="{{ $area['id_area'] }}">
            <a href="{{ route('reporte_primario', ['id_area' => $area['id_area'], 'id_subgerencia' => $area['id_subgerencia']]) }}" id="{{ $area['id_area'] }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> {{ $area['nom_area'] }}</p>
            </a>
        </li>
        @endforeach

    </ul>
</li>














@if ((session('usuario')->id_nivel == 1 ||
session('usuario')->id_nivel == 2 ||
session('usuario')->id_nivel == 7 ||
session('usuario')->id_nivel == 11 ||
session('usuario')->id_nivel == 5 ||
session('usuario')->id_nivel == 4 ||
session('usuario')->id_puesto == 102 ||
session('usuario')->id_puesto == 80 ||
session('usuario')->id_puesto == 81 ||
session('usuario')->id_puesto == 122 ||
session('usuario')->id_puesto == 23 ||
session('usuario')->id_puesto == 75 ||
session('usuario')->id_puesto == 7 ||
session('usuario')->id_puesto == 133 ||
session('usuario')->id_puesto == 138 ||
session('usuario')->id_puesto == 83 ||
session('usuario')->id_puesto == 145 ||
session('usuario')->id_puesto == 40 ||
session('usuario')->id_puesto == 164 ||
session('usuario')->id_puesto == 148 ||
session('usuario')->id_puesto == 153 ||
session('usuario')->id_puesto == 157 ||
session('usuario')->id_puesto == 6 ||
session('usuario')->id_puesto == 12 ||
session('usuario')->id_puesto == 19 ||
session('usuario')->id_puesto == 23 ||
session('usuario')->id_puesto == 38 ||
session('usuario')->id_puesto == 81 ||
session('usuario')->id_puesto == 111 ||
session('usuario')->id_puesto == 122 ||
session('usuario')->id_puesto == 137 ||
session('usuario')->id_puesto == 164 ||
session('usuario')->id_puesto == 158 ||
session('usuario')->id_puesto == 9 ||
session('usuario')->id_puesto == 128 ||
session('usuario')->id_puesto == 27 ||
session('usuario')->id_puesto == 10 ||
session('usuario')->id_puesto == 311 ||
session('usuario')->id_puesto == 314 ||
session('usuario')->id_puesto == 315 ||
//usuarios de base no deben ver configurables
session('usuario')->id_puesto == 312) && !Str::startsWith(session('usuario')->centro_labores, 'B') ||
session('usuario')->id_puesto == 307)
<li class="menu menu-heading">
    <div class="heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="19" cy="12" r="1"></circle>
            <circle cx="5" cy="12" r="1"></circle>
        </svg>
        <span>ADMINISTRACIÓN</span>
    </div>
</li>

<li class="menu" id="conf_seguridades">
    <a href="#rconf_seguridades" id="hconf_seguridades" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Seguridad</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="rconf_seguridades" data-parent="#accordionExample">
        @if (session('usuario')->id_nivel == "1" ||
        session('usuario')->id_puesto == 36 ||
        session('usuario')->id_puesto == 307 ||
        session('usuario')->id_puesto == 311 ||
        session('usuario')->id_puesto == "315" ||
        session('usuario')->id_puesto == "23")
        <li id="conf_aperturas_cierres">
            <a href="{{ route('apertura_cierre_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Apertura y cierre</p>
            </a>
        </li>
        <li id="conf_controles_camaras">
            <a href="{{ route('control_camara_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Control de cámaras</p>
            </a>
        </li>
        @endif
        @if (session('usuario')->id_nivel == "1" ||
        session('usuario')->id_puesto == "9" ||
        session('usuario')->id_puesto == 36 ||
        session('usuario')->id_nivel == "11" ||
        session('usuario')->id_puesto == 307 ||
        session('usuario')->id_puesto == 311 ||
        session('usuario')->id_puesto == "315" ||
        session('usuario')->id_puesto == "138")
        <li id="conf_lecturas_servicios">
            <a href="{{ route('lectura_servicio_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Lectura Servicio</p>
            </a>
        </li>
        @endif
        @if (session('usuario')->id_nivel == "1" ||
        session('usuario')->id_puesto == "23" ||
        session('usuario')->id_puesto == 307)
        <li id="conf_concurrencias_servicios">
            <a href="{{ route('ocurrencia_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Ocurrencias</p>
            </a>
        </li>
        @endif
    </ul>
</li>
@endif