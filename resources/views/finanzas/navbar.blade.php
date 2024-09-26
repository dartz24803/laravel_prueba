<style>
    #hreportbifinanzas>div {
        display: flex;
        align-items: center;
        overflow: hidden;
        /* Asegura que el texto no desborde el contenedor */
    }

    /* Estilo para el texto dentro de <span> */
    #hreportbifinanzas span {
        margin-left: 8px;
        /* Espacio entre el ícono y el texto */
        white-space: normal;
        /* Permite que el texto se ajuste en múltiples líneas */
        overflow-wrap: break-word;
        /* Rompe palabras largas si es necesario */
        word-wrap: break-word;
        /* Compatibilidad con navegadores más antiguos */
    }

    #rreportbifinanzas {
        margin-left: -10%
    }
</style>
<li class="menu menu-heading">
    <div class="heading">
        <span>REPORTES BI</span>
    </div>
</li>
<li class="menu" id="reportbifinanzas">
    <a href="#rreportbifinanzas" id="hreportbiinterna" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart">
                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
            </svg>
            <span>{{ $list_subgerencia['nom_sub_gerencia'] }}</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rreportbifinanzas" data-parent="#accordionExample">
        {{--@foreach ($list_subgerencia['areas'] as $area)
        @php
        $area_id = 'conf_' . strtolower(str_replace(' ', '_', $area));
        @endphp
        <li id="{{ $area_id }}" clas>
            <a href="#" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> {{ $area }}</p>
            </a>
        </li>

        @endforeach--}}
    </ul>
</li>





<li class="menu menu-heading">
    <div class="heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="19" cy="12" r="1"></circle>
            <circle cx="5" cy="12" r="1"></circle>
        </svg>
        <span>MÓDULOS</span>
    </div>
</li>

<li class="menu" id="tesorerias">
    <a href="#rtesorerias" id="htesorerias" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                <circle cx="12" cy="12" r="10"></circle>
            </svg>
            <span>Tesorería</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rtesorerias" data-parent="#accordionExample">
        <li>
            <a id="cajas_chicas" href="{{ route('caja_chica') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Caja chica</p>
            </a>
        </li>
        @if (session('usuario')->id_usuario == "139")
            <li>
                <a id="registros_letras" href="{{ route('registro_letra') }}">
                    <p class="romperpalabra"><span id="icono_active2"></span> Registro de letras</p>
                </a>
            </li>
        @endif
        <li>
            <a id="tablas_maestras" href="{{ route('tabla_maestra_tesoreria') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Tabla maestra</p>
            </a>
        </li>
    </ul>
</li>

<li class="menu menu-heading">
    <div class="heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="19" cy="12" r="1"></circle>
            <circle cx="5" cy="12" r="1"></circle>
        </svg>
        <span>ADMINISTRACION</span>
    </div>
</li>

<li class="menu" id="conf_tesorerias">
    <a href="#rconf_tesorerias" id="hconf_tesorerias" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Tesorería</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="rconf_tesorerias" data-parent="#accordionExample">
        <li id="conf_cajas_chicas">
            <a href="{{ route('caja_chica_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Caja chica</p>
            </a>
        </li>
    </ul>
</li>