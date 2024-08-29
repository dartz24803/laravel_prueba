<li class="menu menu-heading">
    <div class="heading">
        <span>MÓDULOS</span>
    </div>
</li>

<li class="menu" id="rhumanos">
    <a href="#revaluaciones" id="hrhumanos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Recursos Humanos</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>

    <ul class="collapse submenu list-unstyled" id="revaluaciones" data-parent="#accordionExample">
        <li id="reporteasistenciap">
            <a id="hlasistenciap" href="{{ url('Reporte_Control_Asistencia') }}">
                <p class="romperpalabra"><span id="icono_active2"></span> Asistencia</p>
            </a>
        </li>
        <?php if (
            session('usuario')->nivel_jerarquico == 2 ||
            session('usuario')->nivel_jerarquico == 3 ||
            session('usuario')->nivel_jerarquico == 4 ||
            session('usuario')->nivel_jerarquico == 5 ||
            session('usuario')->nivel_jerarquico == 6 ||
            session('usuario')->nivel_jerarquico == 7 ||
            session('usuario')->id_puesto == 195
        ) {
            $amonestaciones2 = "<br>• Recibidas";
        } else {
            $amonestaciones2 = "";
        } ?>
        <li id="amonestaciones">
            <a href="{{ url('Amonestacion') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="• Emitidas <?= $amonestaciones2 ?>">
                <p class="romperpalabra"><span id="icono_active2"></span> Amonestaciones</p>
            </a>
        </li>
        @if (session('usuario')->id_nivel == 1 || 
        session('usuario')->id_nivel == 2 || 
        session('usuario')->id_puesto == 27 || 
        session('usuario')->id_puesto == 133 ||
        session('usuario')->id_puesto == 22 || 
        session('usuario')->id_puesto == 146 || 
        session('usuario')->id_puesto == 21 || 
        session('usuario')->id_puesto == 278 || 
        session('usuario')->id_puesto == 279 || 
        session('usuario')->id_puesto == 128 ||
        session('usuario')->id_puesto == 148 || 
        session('usuario')->id_puesto == 197 || 
        session('usuario')->id_puesto == 310 || 
        session('usuario')->id_puesto == 209)
            <li>
                <a id="colaboradores" href="{{ route('colaborador') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="• Colaborador <br>• Colaborador (Cesados)">
                    <p class="romperpalabra"><span id="icono_active2"></span> Colaboradores</p>
                </a>
            </li>
        @endif
        <?php if (
            session('usuario')->id_nivel == 1 || session('usuario')->id_nivel == 2 ||
            session('usuario')->id_puesto == 133 || session('usuario')->id_puesto == 22 || session('usuario')->id_puesto == 21 || session('usuario')->id_puesto == 278 ||
            session('usuario')->id_puesto == 279 || session('usuario')->id_puesto == 310
        ) { ?>
            <li id="recomunicados">
                <a id="hcomunicados" href="{{ url('Comunicado') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="• Slider RRHH <br>• Anuncios Intranet">
                    <p class="romperpalabra"><span id="icono_active2"></span> Comunicados</p>
                </a>
            </li>
        <?php } ?>
        <?php if (
            session('usuario')->id_nivel == 1 || session('usuario')->id_nivel == 2 ||
            session('usuario')->id_puesto == 27 || session('usuario')->id_puesto == 133 || session('usuario')->id_puesto == 22 || session('usuario')->id_puesto == 146 ||
            session('usuario')->id_puesto == 21 || session('usuario')->id_puesto == 278 || session('usuario')->id_puesto == 279 || session('usuario')->id_puesto == 128 ||
            session('usuario')->id_puesto == 148 || session('usuario')->id_puesto == 310
        ) { ?>
            <li id="recumpleanio">
                <a id="hcumpleanio" href="{{ url('RecursosHumanos/Cumpleanios/index') }}">
                    <p class="romperpalabra"><span id="icono_active2"></span> Cumpleaños</p>
                </a>
            </li>
        <?php } ?>
        <?php if (
            session('usuario')->id_nivel == 1 ||
            session('usuario')->id_nivel == 2 ||
            session('usuario')->id_puesto == 21 ||
            session('usuario')->id_puesto == 278 ||
            session('usuario')->id_puesto == 279 ||
            session('usuario')->id_puesto == 22 ||
            session('usuario')->id_puesto == 133
        ) { ?>
            <!--<li>
                    <a id="postulantes_revisiones" href="{{ route('postulante_revision') }}">
                        <p class="romperpalabra"><span id="icono_active2"></span> Postulantes Revisión</p>
                    </a>
                </li>-->
        <?php } ?>
    </ul>
</li>

<li class="menu menu-heading">
    <div class="heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
        <span>ADMINISTRACION</span>
    </div>
</li>

<li class="menu" id="conf_rrhhs">
    <a href="#rconf_rrhhs" id="hconf_rrhhs" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
            </svg>
            <span>Recursos Humanos</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="rconf_rrhhs" data-parent="#accordionExample">
        <li id="conf_colaboradores">
            <a href="{{ route('colaborador_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Colaboradores</p>
            </a>
        </li>
        <li id="conf_intencion_renuncia">
            <a href="{{ url('IntencionRenunciaConfController/index') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                <p class="romperpalabra"><span id="icono_active2"></span> Intención de renuncia</p>
            </a>
        </li>
    </ul>
</li>