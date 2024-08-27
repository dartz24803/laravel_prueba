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
        <li>
            <a id="aperturas_cierres" href="{{ route('apertura_cierre') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Apertura y cierre</p>
            </a>
        </li>
        <li>
            <a id="asistencias_segs" href="{{ route('asistencia_seg') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Asistencia</p>
            </a>
        </li>
        <li>
            <a id="controles_camaras" href="{{ route('control_camara') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Control de cámaras</p>
            </a>
        </li>
        <li>
            <a id="lecturas_servicios" href="{{ route('lectura_servicio') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Lectura Servicio</p>
            </a>
        </li>

        <?php if (
            session('usuario')->id_puesto == 23 || session('usuario')->id_puesto == 24 || session('usuario')->id_puesto == 36 ||
            session('usuario')->id_puesto == 26 || session('usuario')->id_puesto == 29 || session('usuario')->id_puesto == 161 ||
            session('usuario')->id_nivel == 1 || session('usuario')->id_puesto == 197 || session('usuario')->id_puesto == 148
        ) { ?>
            <li id="locurrencia">
                <a id="hlocurrencia" href="<?= url('OcurrenciaTienda/index') ?>">
                    <p class="romperpalabra"><span id="icono_active2"></span> Ocurrencias</p>
                </a>
            </li>
        <?php } ?>

        <?php if (
            session('usuario')->id_puesto == 23 || session('usuario')->id_puesto == 24 ||
            session('usuario')->id_nivel == 1 || session('usuario')->id_puesto == 36
        ) { ?>
            <li id="lrproveedor">
                <a id="hlrproveedor" href="<?= url('RProveedores/index') ?>">
                    <p class="romperpalabra"><span id="icono_active2"></span> Reporte de proveedores</p>
                </a>
            </li>
        <?php } ?>

    </ul>
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
        <li id="conf_lecturas_servicios">
            <a href="{{ route('lectura_servicio_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Lectura Servicio</p>
            </a>
        </li>
        <li id="conf_concurrencias_servicios">
            <a href="{{ route('ocurrencia_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Ocurrencias</p>
            </a>
        </li>

    </ul>
</li>