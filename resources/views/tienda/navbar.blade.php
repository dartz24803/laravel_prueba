<?php if (
    session('usuario')->id_nivel == "1" || session('usuario')->centro_labores == "OFC" || session('usuario')->id_puesto == "29" || session('usuario')->id_puesto == "161" ||
    session('usuario')->id_puesto == "197" || session('usuario')->id_puesto == "128" || session('usuario')->id_puesto == "251" || session('usuario')->id_puesto == "41" ||
    session('usuario')->id_puesto == "66" || session('usuario')->id_puesto == "73" || session('usuario')->id_puesto == "158" || session('usuario')->id_puesto == "12" ||
    session('usuario')->id_puesto == "155" || session('usuario')->id_puesto == "9" || session('usuario')->id_puesto == "19" || session('usuario')->id_puesto == "21" ||
    session('usuario')->id_puesto == "131" || session('usuario')->id_puesto == "68" || session('usuario')->id_puesto == "72" || session('usuario')->id_puesto == "15" ||
    session('usuario')->id_puesto == "27" || session('usuario')->id_puesto == "148" || session('usuario')->id_puesto == "76" || session('usuario')->id_puesto == "311" ||
    Session('usuario')->id_puesto == 144
) { ?>
    <li class="menu" id="tienda">
        <a href="#rtienda" id="htienda" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Tienda</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>

        <ul class="collapse submenu list-unstyled" id="rtienda" data-parent="#accordionExample">
            <li>
                <a id="administradores" href="{{ route('administrador') }}">
                    <p class="romperpalabra"><span id="icono_active2"></span> Administrador</p>
                </a>
            </li>
            <li id="cuadrocontrolvisual">
                <a id="hrpreorden" href="{{ url('Cuadro_Control_Visual_Vista')}}">
                    <p class="romperpalabra"><span id="icono_active2"></span> Cuadro Control Visual</p>
                </a>
            </li>
            <li>
                <a id="funciones_temporales" href="{{ route('funcion_temporal') }}">
                    <p class="romperpalabra"><span id="icono_active2"></span> Funciones temporales</p>
                </a>
            </li>
            <li id="reportefoto">
                <a id="reporte_foto" href="{{ url('/ReporteFotografico')}}">
                    <p class="romperpalabra"><span id="icono_active2"></span> Reporte fotográfico</p>
                </a>
            </li>
        </ul>
    </li>
<?php } ?>

<li class="menu menu-heading">
    <div class="heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
        <span>ADMINISTRACION</span>
    </div>
</li>

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
    <li class="menu" id="ccvtabla">
        <a href="#rccvtabla" id="hccvtabla" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                </svg>
                <span>Tienda</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="rccvtabla" data-parent="#accordionExample">
            <li id="conf_administradores">
                <a href="{{ route('administrador_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="• Supervisión de tienda <br>• Seguimiento al coordinador">
                    <p class="romperpalabra"><span id="icono_active2"></span> Administrador</p>
                </a>
            </li>
            <li id="ccv">
                <a href="{{ url('/TablaCuadroControlVisual') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="• Horarios <br>• Cuadro de Control Visual <br>• Programación Diaria">
                    <p class="romperpalabra"><span id="icono_active2"></span> Cuadro de Control Visual</p>
                </a>
            </li>
            <li id="rfa">
                <a href="{{ url('/Tabla_RF')}}" data-toggle="tooltip" data-placement="right" data-html="true">
                    <p class="romperpalabra"><span id="icono_active2"></span> Reporte Fotográfico</p>
                </a>
            </li>
        </ul>
    </li>
<?php } ?>