<li class="menu menu-heading">
    <div class="heading">
        <span>INICIO COMERCIAL</span>
    </div>
</li>

<li class="menu" id="inicio_comercial">
    <a id="hinicio_comercial" href="{{ url('Comercial/InicioComercial') }}" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Inicio COMERCIAL </span>
        </div>
    </a>
</li>




<li class="menu menu-heading">
    <div class="heading">
        <span>MÓDULOS</span>
    </div>
</li>

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
        </ul>
    </li>
<?php } ?>

<?php if (
    session('usuario')->id_nivel == 1 ||
    /*USUARIOS DE COMERCIAL*/
    session('usuario')->id_nivel == 5 ||
    session('usuario')->id_puesto == 115 ||
    session('usuario')->id_puesto == 153 ||
    session('usuario')->id_puesto == 66 ||
    session('usuario')->id_puesto == 173
) { ?>
    <li class="menu" id="comercial">
        <a href="#rcomercial" id="hcomercial" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
                <span>Comercial</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="rcomercial" data-parent="#accordionExample">
            <?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_puesto == 40 || session('usuario')->id_puesto == 164 || session('usuario')->id_puesto == 153) { ?>
                <li id="rvisitas">
                    <a href="{{ url('ContadorVisitas/index') }}">
                        <p class="romperpalabra"><span id="icono_active2"></span> Contador Visitas</p>
                    </a>
                </li>
            <?php } ?>
            <?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_nivel == 5  || session('usuario')->id_puesto == 115) { ?>
                <li id="rprenda">
                    <a id="rprenda2" href="{{ url('RequerimientoPrenda/index') }}">
                        <p class="romperpalabra" title="Requerimiento de prendas para fotografía"><span id="icono_active2"></span> Requerimientos de prendas para fotografía</p>
                    </a>
                </li>
            <?php } ?>
            <?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_nivel == 5 || session('usuario')->id_puesto == 153 || session('usuario')->id_puesto == 66) { ?>
                <li id="rsurtido" class="menu">
                    <a href="{{ url('RequerimientoSurtido/index') }}">
                        <p class="romperpalabra"><span id="icono_active2"></span> Requerimiento de Surtido</p>
                    </a>
                </li>
            <?php } ?>
            <li id="requerimientos_tiendas">
                <a href="{{ route('requerimiento_tienda') }}">
                    <p class="romperpalabra"><span id="icono_active2"></span> Requerimientos de tienda</p>
                </a>
            </li>
            <?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_nivel == 5  || session('usuario')->id_puesto == 115) { ?>
                <li id="rsugerenciaprecio">
                    <a id="rsugerenciaprecio1" href="{{ url('SugerenciadePrecios/index') }}">
                        <p class="romperpalabra" title="Sugerencia de Precios"><span id="icono_active2"></span> Sugerencia de Precios</p>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>


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