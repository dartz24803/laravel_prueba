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
        session('usuario')->id_puesto == 311 ||
        session('usuario')->id_puesto == 315 ||
        session('usuario')->id_puesto == 209)
            @if (session('usuario')->id_nivel == 1 ||
            session('usuario')->id_puesto == 23 ||
            session('usuario')->id_puesto == 311 ||
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
            session('usuario')->id_puesto == 311 ||
            session('usuario')->id_puesto == 315 ||
            session('usuario')->id_puesto == 209)
                <li>
                    <a id="asistencias_segs" href="{{ route('asistencia_seg') }}">
                        <p class="romperpalabra"><span id="icono_active2"></span> Asistencia</p>
                    </a>
                </li>
            @endif
            @if (session('usuario')->id_nivel == 1 ||
            session('usuario')->id_puesto == 23 ||
            session('usuario')->id_puesto == 24 ||
            session('usuario')->id_puesto == 164)
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
            session('usuario')->id_puesto == 311 ||
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
            session('usuario')->id_puesto == 311 ||
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
session('usuario')->id_puesto == 315 ||
//usuarios de base no deben ver configurables
session('usuario')->id_puesto == 312) && !Str::startsWith(session('usuario')->centro_labores, 'B'))
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
            session('usuario')->id_puesto == "23")
                <li id="conf_concurrencias_servicios">
                    <a href="{{ route('ocurrencia_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                        <p class="romperpalabra"><span id="icono_active2"></span> Ocurrencias</p>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif
