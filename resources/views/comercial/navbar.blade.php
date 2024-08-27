
<?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_nivel == 4 || session('usuario')->id_puesto == 68) { ?>
    <li class="menu" id="marketing">
        <a href="#rmarketing" id="hmarketing" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span>Marketing</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="rmarketing" data-parent="#accordionExample">
            <li id="sliderc">
                <a id="hslider" href="{{ url('Marketing/Slider_List_Comercial') }}">
                    <p class="romperpalabra"><span id="icono_active2"></span> Slider Marketing</p>
                </a>
            </li>
            <li id="mercaderiamkt">
                <a id="rmercaderiamkt" href="{{ url('Marketing/Mercaderia_Fotografia/2') }}">
                    <p class="romperpalabra" title="Mercadería a enviar para fotografía"><span id="icono_active2"></span> Mercadería a Enviar para fotografía</p>
                </a>
            </li>
        </ul>
    </li>
<?php } ?>