<li class="menu menu-heading">
    <div class="heading">
        <span>INICIO MANUFACTURA</span>
    </div>
</li>

<li class="menu" id="inicio_manufactura">
    <a id="hinicio_manufactura" href="{{ url('manufactura') }}" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Inicio MANUFACTURA </span>
        </div>
    </a>
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

<li class="menu" id="manufactura">
    <a href="#rmanufactura" id="hmanufactura" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                <circle cx="12" cy="12" r="10"></circle>
            </svg>
            <span>Producción</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rmanufactura" data-parent="#accordionExample">
        <li>
            <a id="asignacion_visitas" href="{{ route('produccionav') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Asignación de Visitas</p>
            </a>
        </li>
        <li>
            <a id="registro_visitas" href="{{ route('produccionrev') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Registro de Visitas</p>
            </a>
        </li>
        <li>
            <a id="fichas_tecnicas" href="{{ route('produccionft') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Registrar Ficha Técnica</p>
            </a>
        </li>
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
        <li id="{{ $area['id_area'] }}">
            <a href="{{ route('reporte_primario', ['id_area' => $area['id_area'], 'id_subgerencia' => $area['id_subgerencia']]) }}"
                id="{{ $area['id_area'] }}"
                data-toggle="tooltip"
                data-placement="right"
                data-html="true"
                title="{{ $area['nom_area'] }}"> <!-- Se agrega el atributo title -->
                <p class="romperpalabra">
                    <span id="icono_active2"></span> {{ $area['nom_area'] }}
                </p>
            </a>
        </li>
        @endforeach
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

<li class="menu" id="conf_manufactura">
    <a href="#rconf_manufactura" id="hconf_manufactura" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Producción</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="rconf_manufactura" data-parent="#accordionExample">
        <li id="conf_asignaciones_visitas">
            <a href="{{ route('avisita_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Asignación de Visitas</p>
            </a>
        </li>
    </ul>
</li>