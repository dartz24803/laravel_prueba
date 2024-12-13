<style>
    #rreportbi_primario {
        margin-left: -5%
    }

    .reset-link {
        text-decoration: none;
        /* Quitar subrayado */
        color: inherit;
        /* Heredar color del elemento padre */
        display: inline;
        /* Asegurar que se comporte como un enlace */
    }

    .custom-hr {
        margin: 0;
    }

    #rreportbi_secundario {
        margin-left: -5%
    }
</style>

<li class="menu menu-heading">
    <div class="heading">
        <span>INICIO TIENDA</span>
    </div>
</li>
<li class="menu" id="inicio_tienda">
    <a id="hinicio_tienda" href="{{ url('InicioTienda/index') }}" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Inicio TIENDA </span>
        </div>
    </a>
</li>

<li class="menu menu-heading">
    <div class="heading">
        <span>MÓDULOS</span>
    </div>
</li>

@if (session('usuario')->id_nivel == "1" ||
session('usuario')->centro_labores == "OFC" ||
//COORDINADOR DE CONTROL INTERNO (9)
session('usuario')->id_puesto == "9" ||
//JEFE DE DTO. GESTIÓN DE INFRAESTRUCTURA (12)
session('usuario')->id_puesto == "12" ||
//DISEÑADOR DE VISUAL MERCHANDISING (15)
session('usuario')->id_puesto == "15" ||
//JEFE DE DTO. GESTIÓN DEL TALENTO HUMANO (19)
session('usuario')->id_puesto == "19" ||
//COORD. DE CULTURA, BIENESTAR Y DESARROLLO (21)
session('usuario')->id_puesto == "21" ||
//ASISTENTE DE RECURSOS HUMANOS (22)
session('usuario')->id_puesto == "22" ||
//COORDINADOR SR. DE TECNOLOGÍAS DE LA INFORMACIÓN (27)
session('usuario')->id_puesto == "27" ||
//ALMACENERO TIENDA (35)
session('usuario')->id_puesto == "35" ||
//COORDINADOR COMERCIAL CATEGORÍA DAMAS (41)
session('usuario')->id_puesto == "41" ||
//COORDINADOR COMERCIAL CATEGORÍA CABALLEROS (66)
session('usuario')->id_puesto == "66" ||
//COORDINADOR DE MARKETING (68)
session('usuario')->id_puesto == "68" ||
//CREADOR DE CONTENIDOS (72)
session('usuario')->id_puesto == "72" ||
//COORDINADOR COMERCIAL CATEGORÍA NIÑOS Y ACCESORIOS (73)
session('usuario')->id_puesto == "73" ||
//SUPERVISOR DE DISTRIBUCIÓN (76)
session('usuario')->id_puesto == "76" ||
//COORDINADOR SR. DE CAJA (128)
session('usuario')->id_puesto == "128" ||
//SUPERVISOR NACIONAL DE ABASTECIMIENTO E INVENTARIOS (131)
session('usuario')->id_puesto == "131" ||
//DISEÑADOR DE MODAS (144)
session('usuario')->id_puesto == "144" ||
//ASISTENTE DE TECNOLOGÍAS DE LA INFORMACIÓN (148)
session('usuario')->id_puesto == "148" ||
//SUPERVISOR DE MANTENIMIENTO (155)
session('usuario')->id_puesto == "155" ||
//JEFE DE DTO. GESTIÓN DE TIENDAS (158)
session('usuario')->id_puesto == "158" ||
//ADMINISTRADOR DE TIENDA (161)
session('usuario')->id_puesto == "161" ||
//GERENTE DE GESTIÓN COMERCIAL (251)
session('usuario')->id_puesto == "251" ||
///AUXILIAR DE COORDINADOR DE TIENDA (311)
session('usuario')->id_puesto == "30" ||
///BASE (311)
session('usuario')->id_puesto == "311" ||
//COORDINADOR DE TIENDA (314)
session('usuario')->id_puesto == "314")
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
        @if (session('usuario')->id_nivel == "1" ||
        session('usuario')->id_puesto == "161")
        {{--<li>
                    <a id="administradores" href="{{ route('administrador') }}">
        <p class="romperpalabra"><span id="icono_active2"></span> Administrador</p>
        </a>
</li>--}}
@endif
{{--<li id="cuadrocontrolvisual">
                <a id="hrpreorden" href="{{ url('Cuadro_Control_Visual_Vista')}}">
<p class="romperpalabra"><span id="icono_active2"></span> Cuadro Control Visual</p>
</a>
</li>
<li>
    <a id="funciones_temporales" href="{{ route('funcion_temporal') }}">
        <p class="romperpalabra"><span id="icono_active2"></span> Funciones temporales</p>
    </a>
</li>--}}
<li>
    <a id="ocurrencias" href="{{ route('ocurrencia_tienda') }}">
        <p class="romperpalabra"><span id="icono_active2"></span> Ocurrencias</p>
    </a>
</li>
<li id="reportefoto">
    <a id="reporte_foto" href="{{ url('/ReporteFotografico')}}">
        <p class="romperpalabra"><span id="icono_active2"></span> Reporte fotográfico</p>
    </a>
</li>
@if (session('usuario')->id_nivel == "1" ||
session('usuario')->id_puesto == "35" ||
session('usuario')->id_puesto == "161" ||
session('usuario')->id_puesto == "311" ||
session('usuario')->id_puesto == "314")
<li id="requerimientos_tiendas">
    <a href="{{ route('trequerimiento_tienda') }}">
        <p class="romperpalabra"><span id="icono_active2"></span> Requerimientos de tienda</p>
    </a>
</li>
@endif
</ul>
</li>
@endif







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

<?php if ((
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
        session('usuario')->id_puesto == 27 || session('usuario')->id_puesto == 10 || session('usuario')->id_puesto == 22
    ) && !Str::startsWith(session('usuario')->centro_labores, 'B')
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