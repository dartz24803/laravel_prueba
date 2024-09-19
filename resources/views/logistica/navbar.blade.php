<style>
    #hreportbilogistica>div {
        display: flex;
        align-items: center;
        overflow: hidden;
        /* Asegura que el texto no desborde el contenedor */
    }

    /* Estilo para el texto dentro de <span> */
    #hreportbilogistica span {
        margin-left: 8px;
        /* Espacio entre el ícono y el texto */
        white-space: normal;
        /* Permite que el texto se ajuste en múltiples líneas */
        overflow-wrap: break-word;
        /* Rompe palabras largas si es necesario */
        word-wrap: break-word;
        /* Compatibilidad con navegadores más antiguos */
    }

    #rreportbilogistica {
        margin-left: -10%
    }
</style>
<li class="menu menu-heading">
    <div class="heading">
        <span>REPORTES BI</span>
    </div>
</li>
<li class="menu" id="reportbilogistica">
    <a href="#rreportbilogistica" id="hreportbilogistica" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
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

    <ul class="collapse submenu list-unstyled" id="rreportbilogistica" data-parent="#accordionExample">
        @foreach ($list_subgerencia['areas'] as $area)
        @php
        $area_id = 'conf_' . strtolower(str_replace(' ', '_', $area));
        @endphp
        <li id="{{ $area_id }}" clas>
            <a href="#" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> {{ $area }}</p>
            </a>
        </li>

        @endforeach
    </ul>
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
    </ul>
</li>