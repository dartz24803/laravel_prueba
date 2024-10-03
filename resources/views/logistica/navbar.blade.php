<li class="menu menu-heading">
    <div class="heading">
        <span>INICIO LOGÍSTICA</span>
    </div>
</li>

<li class="menu" id="inicio_logistica">
    <a id="hinicio_logistica" href="{{ url('logistica') }}" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>INICIO LOGÍSTICA </span>
        </div>
    </a>
</li>







<li class="menu menu-heading">
    <div class="heading">
        <span>MÓDULOS</span>
    </div>
</li>

<li class="menu" id="logisticas">
    <a href="#rlogisticas" id="hlogisticas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <span>Logística</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="rlogisticas" data-parent="#accordionExample">
        <li id="trackings">
            <a href="{{ route('tracking') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Tracking</p>
            </a>
        </li>
        <li id="reprocesos">
            <a href="{{ url('Reproceso/index') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Reproceso</p>
            </a>
        </li>
        <li id="infosapstock">
            <a href="{{ url('infosapstock') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Infosap Stock</p>
            </a>
        </li>
        <li id="errorespicking">
            <a href="{{ url('errorespicking') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Errores Picking</p>
            </a>
        </li>
        <li id="cargainventario">
            <a href="{{ url('cargainventario') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Carga de Inventarios</p>
            </a>
        </li>
        <li id="consumible">
            <a href="{{ url('consumible') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Consumibles</p>
            </a>
        </li>
        <?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_nivel == 10 || session('usuario')->id_nivel == 9 || session('usuario')->id_puesto == 74 || session('usuario')->id_puesto == 35) { ?>
            <li id="mercaderia">
                <a href="{{ url('MercaderiaExtraer/Mercaderia') }}">
                    <p class="romperpalabra"><span id="icono_active2"></span> Mercadería a Extraer</p>
                </a>
            </li>
            <li id="controlubicacionese">
                <a id="rcontrolubicaciones" href="{{ url('ControlUbicaciones/index') }}">
                    <p class="romperpalabra" title="Mercadería a enviar para fotografía"><span id="icono_active2"></span> Control de Ubicaciones</p>
                </a>
            </li>
        <?php } ?>
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
            <a href="{{ route('reporte_primario', ['id_area' => $area['id_area'], 'id_subgerencia' => $area['id_subgerencia']]) }}" id="{{ $area['id_area'] }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> {{ $area['nom_area'] }}</p>
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




<li class="menu" id="logisticaconf">
    <a href="#rlogisticaconf" id="hlogisticaconf" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Logística

            </span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="rlogisticaconf" data-parent="#accordionExample">
        <li>
            <a id="errorespickingta" href="{{ route('errorespickingta_conf') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Errores Picking</p>
            </a>
        </li>
        <li>
            <a id="consumibles" href="{{ route('consumible_art') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Consumibles</p>
            </a>
        </li>
        <li id="mercaderiaconf">
            <a href="{{ url('MercaderiaConf/TablaMercaderia') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Mercadería</p>
            </a>
        </li>
    </ul>
</li>