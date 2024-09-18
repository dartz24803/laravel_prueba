@if (session('usuario')->id_nivel == 1 || 
session('usuario')->id_nivel == 7 ||
session('usuario')->id_puesto == 28 || 
session('usuario')->id_puesto == 128 || 
session('usuario')->id_puesto == 9 ||
session('usuario')->id_puesto == 29 || 
session('usuario')->id_puesto == 31 || 
session('usuario')->id_puesto == 32 || 
session('usuario')->id_puesto == 36 ||
session('usuario')->id_puesto == 23 ||
session('usuario')->id_puesto == 98 || 
session('usuario')->id_puesto == 128 || 
session('usuario')->id_puesto == 26 || 
session('usuario')->id_puesto == 27 ||
session('usuario')->id_puesto == 16 || 
session('usuario')->id_puesto == 33 || 
session('usuario')->id_puesto == 30 ||
session('usuario')->id_puesto == 167 || 
session('usuario')->id_puesto == 161 || 
session('usuario')->id_puesto == 19 || 
session('usuario')->id_puesto == 20 ||
session('usuario')->id_puesto == 21 || 
session('usuario')->id_puesto == 279 || 
session('usuario')->id_puesto == 197 || 
session('usuario')->id_puesto == 148)
    <li class="menu menu-heading">
        <div class="heading">
            <span>MÓDULOS</span>
        </div>
    </li>

    <li class="menu" id="cajas">
        <a href="#rcajas" id="hcajas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                <span>Caja</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="rcajas" data-parent="#accordionExample">
            @if (session('usuario')->id_nivel == 1 || 
            session('usuario')->id_puesto == 36 || 
            session('usuario')->id_puesto == 23 ||
            session('usuario')->id_puesto == 29 || 
            session('usuario')->id_puesto == 161 ||
            session('usuario')->id_puesto == 32 || 
            session('usuario')->id_puesto == 31 || 
            session('usuario')->id_puesto == 98 || 
            session('usuario')->id_puesto == 128 ||
            session('usuario')->id_puesto == 20 || 
            session('usuario')->id_puesto == 26 || 
            session('usuario')->id_puesto == 27 || 
            session('usuario')->id_puesto == 16 ||
            session('usuario')->id_puesto == 33 || 
            session('usuario')->id_puesto == 30 || 
            session('usuario')->id_puesto == 167 || 
            session('usuario')->id_puesto == 23 ||
            session('usuario')->id_puesto == 197 || 
            session('usuario')->id_puesto == 148)
                <li id="cambios_prendas">
                    <a href="{{ route('cambio_prenda') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                        <p class="romperpalabra"><span id="icono_active2"></span> Cambio de prenda</p>
                    </a>
                </li>
            @endif
            @if (session('usuario')->id_nivel == 1 || 
            session('usuario')->id_puesto == 128)
                <li id="capacitaciones_cajeros">
                    <a href="{{ route('capacitacion_cajero') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                        <p class="romperpalabra"><span id="icono_active2"></span> Capacitación cajero</p>
                    </a>
                </li>
            @endif
            @if (session('usuario')->id_nivel == 1 || 
            session('usuario')->id_puesto == 28 ||  
            session('usuario')->id_puesto == 128)
                <li id="duraciones_transacciones">
                    <a href="{{ route('duracion_transaccion') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                        <p class="romperpalabra"><span id="icono_active2"></span> Duración de transaccion</p>
                    </a>
                </li>
            @endif
            @if (session('usuario')->id_nivel == 1 || 
            session('usuario')->id_nivel == 7 || 
            session('usuario')->id_puesto == 128 || 
            session('usuario')->id_puesto == 148 || 
            session('usuario')->id_puesto == 31 || 
            session('usuario')->id_puesto == 32)
                <li id="insumos">
                    <a href="{{ route('insumo') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                        <p class="romperpalabra"><span id="icono_active2"></span> Insumos</p>
                    </a>
                </li>
            @endif
            @if (session('usuario')->id_nivel == 1 || 
            session('usuario')->id_puesto == 128 || 
            session('usuario')->id_puesto == 9 || 
            session('usuario')->id_puesto == 29 ||
            session('usuario')->id_puesto == 161 || 
            session('usuario')->id_puesto == 19 || 
            session('usuario')->id_puesto == 20 ||
            session('usuario')->id_puesto == 21 || 
            session('usuario')->id_puesto == 279)
                <li id="lineas_carreras">
                    <a href="{{ route('linea_carrera') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                        <p class="romperpalabra"><span id="icono_active2"></span> Línea de carrera</p>
                    </a>
                </li>
            @endif
            @if (session('usuario')->id_nivel == 1 || 
            session('usuario')->id_puesto == 9 || 
            session('usuario')->id_puesto == 29 || 
            session('usuario')->id_puesto == 31 || 
            session('usuario')->id_puesto == 32 || 
            session('usuario')->id_puesto == 128 || 
            session('usuario')->id_puesto == 167 || 
            session('usuario')->id_puesto == 161 ||
            session('usuario')->id_puesto == 197)
                <li id="observaciones">
                    <a href="{{ route('observacion') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                        <p class="romperpalabra"><span id="icono_active2"></span> Observaciones</p>
                    </a>
                </li>
            @endif
            @if (session('usuario')->id_nivel == 1 || 
            session('usuario')->id_puesto == 29 || 
            session('usuario')->id_puesto == 31 || 
            session('usuario')->id_puesto == 32 || 
            session('usuario')->id_puesto == 161)
                <li id="salidas_insumos"> 
                    <a href="{{ route('salida_insumo') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                        <p class="romperpalabra"><span id="icono_active2"></span> Salida de insumo</p>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif

@if (session('usuario')->id_nivel == 1 || 
session('usuario')->id_nivel == 2 || 
session('usuario')->id_nivel == 7 ||
session('usuario')->id_nivel == 5 ||
session('usuario')->id_nivel == 11 ||
session('usuario')->id_nivel == 4 ||
session('usuario')->id_puesto == 80 ||
session('usuario')->id_puesto == 128 ||
session('usuario')->id_puesto == 148 ||
session('usuario')->id_puesto == 102 ||
session('usuario')->id_puesto == 81 ||
session('usuario')->id_puesto == 122 ||
session('usuario')->id_puesto == 23 ||
session('usuario')->id_puesto == 9 ||
session('usuario')->id_puesto == 75 ||
session('usuario')->id_puesto == 7 ||
session('usuario')->id_puesto == 133 ||
session('usuario')->id_puesto == 138 ||
session('usuario')->id_puesto == 83 ||
session('usuario')->id_puesto == 145 ||
session('usuario')->id_puesto == 40 ||
session('usuario')->id_puesto == 164)
    <li class="menu menu-heading">
        <div class="heading">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
            <span>ADMINISTRACIÓN</span>
        </div>
    </li>

    @if (session('usuario')->id_nivel == 1 || 
    session('usuario')->id_nivel == 2 || 
    session('usuario')->id_nivel == 7 ||
    session('usuario')->id_nivel == 5 ||
    session('usuario')->id_nivel == 11 ||
    session('usuario')->id_nivel == 4 ||
    session('usuario')->id_puesto == 80 ||
    session('usuario')->id_puesto == 128 ||
    session('usuario')->id_puesto == 148 ||
    session('usuario')->id_puesto == 102 ||
    session('usuario')->id_puesto == 81 ||
    session('usuario')->id_puesto == 122 ||
    session('usuario')->id_puesto == 23 ||
    session('usuario')->id_puesto == 9 ||
    session('usuario')->id_puesto == 75 ||
    session('usuario')->id_puesto == 7 ||
    session('usuario')->id_puesto == 133 ||
    session('usuario')->id_puesto == 138 ||
    session('usuario')->id_puesto == 83 ||
    session('usuario')->id_puesto == 145 ||
    session('usuario')->id_puesto == 40 ||
    session('usuario')->id_puesto == 164)
        <li class="menu" id="conf_cajas">
            <a href="#rconf_cajas" id="hconf_cajas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                        <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                    </svg>
                    <span>Caja</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="rconf_cajas" data-parent="#accordionExample">
                @if (session('usuario')->id_nivel == 1 || 
                session('usuario')->id_puesto == 128)
                    <li id="conf_cambios_prendas">
                        <a href="{{ route('cambio_prenda_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                            <p class="romperpalabra"><span id="icono_active2"></span> Cambio de prenda</p>
                        </a>
                    </li>
                @endif
                @if (session('usuario')->id_nivel == 1 || 
                session('usuario')->id_nivel == 7 || 
                session('usuario')->id_puesto == 148)
                    <li id="conf_insumos">
                        <a href="{{ route('insumo_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                            <p class="romperpalabra"><span id="icono_active2"></span> Insumo</p>
                        </a>
                    </li>
                @endif
                @if (session('usuario')->id_nivel == 1 || 
                session('usuario')->id_puesto == 128)
                    <li id="conf_lineas_carreras">
                        <a href="{{ route('linea_carrera_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                            <p class="romperpalabra"><span id="icono_active2"></span> Línea de carrera</p>
                        </a>
                    </li>
                @endif
                @if (session('usuario')->id_nivel == 1 || 
                session('usuario')->id_puesto == 128)
                    <li id="conf_observaciones">
                        <a href="{{ route('observacion_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                            <p class="romperpalabra"><span id="icono_active2"></span> Observaciones</p>
                        </a>
                    </li>
                @endif
                @if (session('usuario')->id_nivel == 1 || 
                session('usuario')->id_puesto == 128 || 
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
                session('usuario')->id_puesto == 9 ||
                session('usuario')->id_puesto == 75 || 
                session('usuario')->id_puesto == 7 || 
                session('usuario')->id_puesto == 133 ||
                session('usuario')->id_puesto == 138 || 
                session('usuario')->id_puesto == 83 ||
                session('usuario')->id_puesto == 145 || 
                session('usuario')->id_puesto == 40 || 
                session('usuario')->id_puesto == 164 || 
                session('usuario')->id_puesto == 148)
                    <li id="conf_requiciones_tiendas">
                        <a href="{{ route('requisicion_tienda_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                            <p class="romperpalabra"><span id="icono_active2"></span> Requisición tienda</p>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if (session('usuario')->id_nivel == 1 || 
    session('usuario')->id_puesto == 80)
        <li class="menu" id="conf_controles_internos">
            <a href="#rconf_controles_internos" id="hconf_controles_internos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                        <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                    </svg>
                    <span>Control Interno</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="rconf_controles_internos" data-parent="#accordionExample">
                <li id="conf_precios_sugeridos">
                    <a href="{{ route('precio_sugerido_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                        <p class="romperpalabra"><span id="icono_active2"></span> Precio Sugerido</p>
                    </a>
                </li>
            </ul>
        </li>
    @endif
@endif