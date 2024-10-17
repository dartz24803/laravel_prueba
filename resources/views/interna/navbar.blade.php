<li class="menu menu-heading">
    <div class="heading">
        <span>INICIO INTERNA</span>
    </div>
</li>

<li class="menu" id="inicio_interna">
    <a id="hinicio_interna" href="{{ url('interna') }}" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-home">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Inicio INTERNA </span>
        </div>
    </a>
</li>









<li class="menu menu-heading">
    <div class="heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-more-horizontal">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="19" cy="12" r="1"></circle>
            <circle cx="5" cy="12" r="1"></circle>
        </svg>
        <span>MÓDULOS</span>
    </div>
</li>

<?php if (
    session('usuario')->id_nivel == "1" || session('usuario')->centro_labores == "OFC" || session('usuario')->id_puesto == "29" || session('usuario')->id_puesto == "161" ||
    session('usuario')->id_puesto == "197" || session('usuario')->id_puesto == "128" || session('usuario')->id_puesto == "251" || session('usuario')->id_puesto == "41" ||
    session('usuario')->id_puesto == "66" || session('usuario')->id_puesto == "73" || session('usuario')->id_puesto == "158" || session('usuario')->id_puesto == "12" ||
    session('usuario')->id_puesto == "155" || session('usuario')->id_puesto == "9" || session('usuario')->id_puesto == "19" || session('usuario')->id_puesto == "21" ||
    session('usuario')->id_puesto == "131" || session('usuario')->id_puesto == "68" || session('usuario')->id_puesto == "72" || session('usuario')->id_puesto == "15" ||
    session('usuario')->id_puesto == "27" || session('usuario')->id_puesto == "148" || session('usuario')->id_puesto == "76" || session('usuario')->id_puesto == "311" ||
    Session('usuario')->id_puesto == 144
) { ?>
<li class="menu" id="procesos">
    <a href="#rprocesos" id="hprocesos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-circle">
                <circle cx="12" cy="12" r="10"></circle>
            </svg>
            <span>Procesos</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rprocesos" data-parent="#accordionExample">
        <li>
            <a id="portalprocesos" href="{{ route('portalprocesos') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Portal Procesos</p>
            </a>
        </li>

        <li>
            <a id="capacitacion" href="{{ route('portalprocesoscap') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Capacitación</p>
            </a>
        </li>
    </ul>
</li>
<?php } ?>

<?php if (
    session('usuario')->id_nivel == "1" || session('usuario')->centro_labores == "OFC" || session('usuario')->id_puesto == "29" || session('usuario')->id_puesto == "161" ||
    session('usuario')->id_puesto == "197" || session('usuario')->id_puesto == "128" || session('usuario')->id_puesto == "251" || session('usuario')->id_puesto == "41" ||
    session('usuario')->id_puesto == "66" || session('usuario')->id_puesto == "73" || session('usuario')->id_puesto == "158" || session('usuario')->id_puesto == "12" ||
    session('usuario')->id_puesto == "155" || session('usuario')->id_puesto == "9" || session('usuario')->id_puesto == "19" || session('usuario')->id_puesto == "21" ||
    session('usuario')->id_puesto == "131" || session('usuario')->id_puesto == "68" || session('usuario')->id_puesto == "72" || session('usuario')->id_puesto == "15" ||
    session('usuario')->id_puesto == "27" || session('usuario')->id_puesto == "148" || session('usuario')->id_puesto == "76" || session('usuario')->id_puesto == "311" ||
    Session('usuario')->id_puesto == 144
) { ?>
<li class="menu" id="bi">
    <a href="#rbi" id="hbi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-pie-chart">
                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
            </svg>
            <span>Bi</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rbi" data-parent="#accordionExample">
        <li>
            <a id="bireporte" href="{{ route('bireporte') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Reportes</p>
            </a>
        </li>
    </ul>
</li>
<?php } ?>

<!-- MODULO SOPORTE -->

<li class="menu" id="soporte_master">

    <a href="{{ url('soporte_master') }}" id="hsoporte_master" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-settings">
                <circle cx="12" cy="12" r="3"></circle>
                <path
                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                </path>
            </svg>
            <span>Soporte</span>
        </div>
    </a>

</li>









<li class="menu menu-heading">
    <div class="heading">
        <span>REPORTES BI</span>
    </div>
</li>

<li class="menu" id="reportbi_primario">
    <a href="#rreportbi_primario" id="hreportbi_primario" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-pie-chart">
                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
            </svg>
            <span
                title="{{ $list_subgerencia['nom_sub_gerencia'] }}">{{ $list_subgerencia['nom_sub_gerencia'] }}</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="rreportbi_primario" data-parent="#accordionExample">
        @foreach ($list_subgerencia['areas'] as $area)
            <li id="{{ $area['id_area'] }}">
                <a href="{{ route('reporte_primario', ['id_area' => $area['id_area'], 'id_subgerencia' => $area['id_subgerencia']]) }}"
                    id="{{ $area['id_area'] }}" data-toggle="tooltip" data-placement="right" data-html="true">
                    <p class="romperpalabra"><span id="icono_active2"></span> {{ $area['nom_area'] }}</p>
                </a>
            </li>
        @endforeach
    </ul>

</li>





<li class="menu menu-heading">
    <div class="heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-more-horizontal">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="19" cy="12" r="1"></circle>
            <circle cx="5" cy="12" r="1"></circle>
        </svg>
        <span>ADMINISTRACION</span>
    </div>
</li>

<?php if (session('usuario')->id_nivel == 1) { ?>
<li class="menu" id="slider_menu">
    <a href="#inicio_carousel" id="inicio_slider" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Inicio</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="inicio_carousel" data-parent="#accordionExample">
        <li id="slider_inicio">
            <a href="{{ url('Inicio/index') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Slider Inicio</p>
            </a>
        </li>
        <li id="frases_inicio">
            <a href="{{ url('Inicio/index_frases') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Frases Inicio</p>
            </a>
        </li>
    </ul>
</li>

<li class="menu" id="conf_notificaciones">
    <a href="#rconf_notificaciones" id="hconf_notificaciones" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Notificación</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="rconf_notificaciones" data-parent="#accordionExample">
        <li id="conf_notificaciones">
            <a href="{{ route('notificacion_conf') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Tipo</p>
            </a>
        </li>
    </ul>
</li>
<?php } ?>

<?php if (
    session('usuario')->id_nivel == 1 || session('usuario')->id_puesto == 102 || session('usuario')->id_puesto == 80 ||
    session('usuario')->id_puesto == 81 || session('usuario')->id_puesto == 122 || session('usuario')->id_puesto == 23 ||
    session('usuario')->id_puesto == 75 || session('usuario')->id_puesto == 7 || session('usuario')->id_puesto == 133 ||
    session('usuario')->id_puesto == 138 || session('usuario')->id_puesto == 83 || session('usuario')->id_puesto == 145 ||
    session('usuario')->id_puesto == 40 || session('usuario')->id_puesto == 164 || session('usuario')->id_puesto == 148 ||
    session('usuario')->id_puesto == 153 || session('usuario')->id_puesto == 157 || session('usuario')->id_puesto == 6 ||
    session('usuario')->id_puesto == 12 || session('usuario')->id_puesto == 19 || session('usuario')->id_puesto == 23 ||
    session('usuario')->id_puesto == 38 || session('usuario')->id_puesto == 81 || session('usuario')->id_puesto == 111 ||
    session('usuario')->id_puesto == 122 || session('usuario')->id_puesto == 137 || session('usuario')->id_puesto == 164 ||
    session('usuario')->id_puesto == 158 || session('usuario')->id_puesto == 9 || session('usuario')->id_puesto == 128 ||
    session('usuario')->id_puesto == 27 || session('usuario')->id_puesto == 10 || session('usuario')->id_puesto == 312
) { ?>
<li class="menu" id="reporteconf">
    <a href="#rreportebiconf" id="hreportebiconf" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Bi

            </span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rreportebiconf" data-parent="#accordionExample">
        <li>
            <a id="dbreporteconf" href="{{ route('bireporte_ra_conf') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Acceso de Reportes </p>
            </a>
        </li>
    </ul>
</li>
<?php } ?>


<?php if (
    session('usuario')->id_nivel == 1 || session('usuario')->id_puesto == 102 || session('usuario')->id_puesto == 80 ||
    session('usuario')->id_puesto == 81 || session('usuario')->id_puesto == 122 || session('usuario')->id_puesto == 23 ||
    session('usuario')->id_puesto == 75 || session('usuario')->id_puesto == 7 || session('usuario')->id_puesto == 133 ||
    session('usuario')->id_puesto == 138 || session('usuario')->id_puesto == 83 || session('usuario')->id_puesto == 145 ||
    session('usuario')->id_puesto == 40 || session('usuario')->id_puesto == 164 || session('usuario')->id_puesto == 148 ||
    session('usuario')->id_puesto == 153 || session('usuario')->id_puesto == 157 || session('usuario')->id_puesto == 6 ||
    session('usuario')->id_puesto == 12 || session('usuario')->id_puesto == 19 || session('usuario')->id_puesto == 23 ||
    session('usuario')->id_puesto == 38 || session('usuario')->id_puesto == 81 || session('usuario')->id_puesto == 111 ||
    session('usuario')->id_puesto == 122 || session('usuario')->id_puesto == 137 || session('usuario')->id_puesto == 164 ||
    session('usuario')->id_puesto == 158 || session('usuario')->id_puesto == 9 || session('usuario')->id_puesto == 128 ||
    session('usuario')->id_puesto == 27 || session('usuario')->id_puesto == 10
) { ?>
<li class="menu" id="procesoconf">
    <a href="#rprocesosconf" id="hprocesosconf" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Procesos</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rprocesosconf" data-parent="#accordionExample">
        <li>
            <a id="repbiconf" href="{{ route('portalprocesoscap_conf') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Tema Capacitaciones</p>
            </a>
        </li>
    </ul>
</li>
<?php } ?>
<li class="menu" id="soporteconf">
    <a href="#rsoporteconf" id="hsoporteconf" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Soporte</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rsoporteconf" data-parent="#accordionExample">
        <li>
            <a id="rticksoporte" href="{{ route('soporteticket_conf') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Asunto Soporte</p>
            </a>
        </li>
    </ul>
</li>
