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