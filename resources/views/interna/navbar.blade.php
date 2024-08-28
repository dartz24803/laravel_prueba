<li class="menu menu-heading">
    <div class="heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
        <span>ADMINISTRACION</span>
    </div>
</li>

<?php if (session('usuario')->id_nivel == 1) { ?>
    <li class="menu" id="slider_menu">
        <a href="#inicio_carousel" id="inicio_slider" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                </svg>
                <span>Inicio</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
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
<?php } ?>