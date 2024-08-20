<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>La Número 1 | Intranet</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('template/assets/img/favicon.png') }}"/>
    <link href="{{ asset('template/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('template/assets/js/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('template/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <link href="{{ asset('template/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />

    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/table-responsive/responsive.dataTables.min.css') }}">
    <!-- END PAGE LEVEL CUSTOM STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/plugins/select2/select2.min.css') }}">
    <link href="{{ asset('template/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/forms/theme-checkbox-radio.css') }}">
    <!-- END THEME GLOBAL STYLES -->
    <script src="{{ asset('js/momentjs/moment.js') }}"></script>
    <script src="{{ asset('js/momentjs/moment-with-locales.js') }}"></script>
    <script>
        moment.locale('es');
    </script>
    <link rel="stylesheet" href="{{ asset('css/modals.css') }}">
</head>
<body class="alt-menu sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm expand-header d-flex justify-content-around" style="background: #302f30; height:5rem;">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <a id="div_imagen_header" class="col-md-5 offset-5">
                <img src="{{ asset('inicio/Grupo-LN1.png') }}" class="navbar-logo ajuste1" alt="logo">
            </a>
            <ul class="navbar-item flex-row ml-auto">
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><!--<span class="badge badge-success"></span>-->
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="notification-scroll">
                            <div class="dropdown-item">
                                <div class="media">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                    </svg>
                                    <div class="media-body">
                                        <div class="notification-para">Usted no tiene notificaciones nuevas.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <img src="{{ asset('template/assets/img/90x90.jpg') }}" class="img-fluid mr-2" alt="avatar">
                                <div class="media-body">
                                    <h5>{{ session('usuario')->usuario_nombres }} {{ session('usuario')->usuario_apater }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{ route('DestruirSesion') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Salir</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MODAL  -->
    <div id="ModalRegistro" data-backdrop="static" data-keyboard="false" class="modal animated fadeInUp custo-fadeInUp bd-example-modal-lg scrollpagina" tabindex="-1" role="dialog" aria-labelledby="ModalRegistro" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div id="ModalRegistroGrande" data-backdrop="static" data-keyboard="false" class="modal animated fadeInUp custo-fadeInUp bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="ModalRegistroGrande" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div id="ModalUpdate" data-backdrop="static" data-keyboard="false" class="modal animated fadeInRight custo-fadeInRight bd-example-modal-lg scrollpagina" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div id="ModalUpdateGrande" data-backdrop="static" data-keyboard="false" class="modal animated fadeInUp custo-fadeInUp bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateGrande" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div id="ModalUpdateSlide" data-backdrop="static" data-keyboard="false" class="modal animated fadeInRight custo-fadeInRight bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="ModalUpdateSlide" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <script src="{{ asset('template/docs/js/jquery-3.2.1.min.js') }}"></script>

    <link href="{{ asset('template/fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    <script src="{{ asset('template/fileinput/js/fileinput.min.js') }}"></script>
    <script>
        function Cargando() {
            $(document)
            .ajaxStart(function() {
                $.blockUI({
                    message: '<svg> ... </svg>',
                    fadeIn: 800,
                    overlayCSS: {
                        backgroundColor: '#302f30',
                        opacity: 0.8,
                        zIndex: 1200,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        color: '#fff',
                        zIndex: 1201,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
            })
            .ajaxStop(function() {
                $.blockUI({
                    message: '<svg> ... </svg>',
                    fadeIn: 800,
                    timeout: 100,
                    overlayCSS: {
                        backgroundColor: '#302f30',
                        opacity: 0.8,
                        zIndex: 1200,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        color: '#fff',
                        zIndex: 1201,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
            });
        }

        $(document).ready(function() {
            $("#ModalRegistro").on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                $(this).find(".modal-content").load(link.attr("app_reg"));
            });
            $("#ModalRegistroGrande").on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                $(this).find(".modal-content").load(link.attr("app_reg_grande"));
            });
            $("#ModalUpdate").on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                $(this).find(".modal-content").load(link.attr("app_elim"));
            });
            $("#ModalUpdateGrande").on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                $(this).find(".modal-content").load(link.attr("app_upd_grande"));
            });
            $("#ModalUpdateSlide").on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                $(this).find(".modal-content").load(link.attr("app_upd_slide"));
            });
        });
    </script>
    <!-- END MODAL  -->

    <style>
        #accordionExample>.menu.active {
            border: 1.5px solid #ffa700;
            border-radius: 15px;
            font-weight: bold;
        }
        #accordionExample>.active .active #icono_active2 {
            content: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23ffa700' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-disc'><circle cx='12' cy='12' r='10'></circle><circle cx='12' cy='12' r='3'></circle></svg>");
            display: inline-block;
            vertical-align: middle;
        }
        .menu:not(.menu-heading):hover {
            border: 1.5px solid #ffa700;
            border-radius: 15px;
            font-weight: bold;
        }
        img.navbar-logo.ajuste1 {
            width: 140px;
            height: 45px;
        }
        img.navbar-logo.ajuste2 {
            position: relative;
            left: -1rem;
            width: 50px;
            height: 50px;
        }
        #sidebar .theme-brand li.theme-logo img {
            position: relative;
            width: 44px;
            border-radius: 5px;
            height: 2.8rem;
            top: -2px;
            left: 2px;
        }

        .tooltip-inner {
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            background-color: white !important;
            color: #515365;
            border-radius: 5px ;
            border: 1px solid #ffa700;
            text-align: justify;
            line-height: 3;
            margin-bottom: 10px;
            max-width: 100%;
            padding: 0.5rem;
        }
        .tooltip.show.bs-tooltip-right .arrow::before {
            border-right-color: #ffa700 !important;
        }
    </style>
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container sidebar-closed sbar-open" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">
                <ul class="navbar-nav theme-brand flex-row  text-center">
                    <li id="sidebar_logo1" class="nav-item theme-logo text-center">
                        <a>
                            <img src="{{ asset('login_files/img/1.png') }}" class="navbar-logo" alt="logo">
                        </a>
                    </li>
                    <li class="nav-item theme-text" style="margin-top: 8px; margin-bottom: 8px">
                        <a class="nav-link">
                            <img src="{{ asset('inicio/Grupo-LN1.png') }}" class="navbar-logo ajuste1" alt="logo">
                            <!-- <img src="{{ asset('login_files/img/1.png') }}" class="navbar-logo ajuste2" alt="logo"> -->
                        </a>
                    </li>
                </ul>

                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu" id="inicio">
                        <a id="hinicio" href="{{ url('Home') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span>Inicio</span>
                            </div>
                        </a>
                    </li>

                    <!-- Parte aplicaciones solo en inicio -->
                    {{-- @if (url()->current() == url('Home')) --}}
                        <li class="menu menu-heading">
                            <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                                <span>APLICACIONES</span>
                            </div>
                        </li>
                        <li class="menu" id="calendarios">
                            <a href="<?= url('Corporacion/Calendario') ?>" id="hcalendarios" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span id="icono_active"></span>
                                    <span> Calendario</span>
                                </div>
                            </a>
                        </li>
                        <?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_puesto == 75 || session('usuario')->id_puesto == 122
                        || session('usuario')->id_puesto == 83 || session('usuario')->id_puesto == 86 ||
                        /* session('usuario')->calendario_l == "SI" || $id_usuario == 857 ||*/ session('usuario')->id_puesto == 195) { ?>
                            <li class="menu" id="calendario_logistico">
                                <a href="<?= url('Corporacion/Calendario_Logistico') ?>" id="hcalendario_logistico" class="dropdown-toggle">
                                    <div class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span id="icono_active"></span>
                                        <span> Calendario Logístico</span>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (/*$directorio == 1 ||*/ session('usuario')->id_nivel == 1) { ?>
                            <li class="menu" id="contactos">
                                <a href="<?= url('Corporacion/Lista_Directorio_Telefonico') ?>" id="hcontacto" class="dropdown-toggle">
                                    <div class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span id="icono_active"></span>
                                        <span> Contactos</span>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                    {{-- @else --}}
                    <!-- Fin de parte aplicaciones -->
                        <li class="menu menu-heading">
                            <div class="heading">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                <span>MÓDULOS</span>
                            </div>
                        </li>

                        <li class="menu" id="logisticas">
                            <a href="#rlogisticas" id="hlogisticas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
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
                                <li>
                                    <a id="trackings" href="{{ route('tracking') }}">
                                        <p class="romperpalabra"><span id="icono_active2"></span> Tracking</p>
                                    </a>
                                </li>
                            </ul>
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
                                <?php if(
                                session('usuario')->nivel_jerarquico==2 ||
                                session('usuario')->nivel_jerarquico==3 ||
                                session('usuario')->nivel_jerarquico==4 ||
                                session('usuario')->nivel_jerarquico==5 ||
                                session('usuario')->nivel_jerarquico==6 ||
                                session('usuario')->nivel_jerarquico==7 ||
                                session('usuario')->id_puesto==195){
                                    $amonestaciones2 = "<br>• Recibidas";
                                }else{
                                    $amonestaciones2 = "";
                                }?>
                                <li id="amonestaciones">
                                    <a href="{{ url('Amonestacion') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="• Emitidas <?= $amonestaciones2 ?>">
                                        <p class="romperpalabra"><span id="icono_active2"></span> Amonestaciones</p>
                                    </a>
                                </li>
                                <?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_nivel == 2 ||
                                session('usuario')->id_puesto == 133 || session('usuario')->id_puesto == 22 || session('usuario')->id_puesto == 21 || session('usuario')->id_puesto == 278 ||
                                session('usuario')->id_puesto == 279 || session('usuario')->id_puesto == 310) { ?>
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
                            </ul>
                        </li>

                        <li class="menu" id="seguridades">
                            <a href="#rseguridades" id="hseguridades" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    </svg>
                                    <span>Seguridad</span>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </div>
                            </a>

                            <ul class="collapse submenu list-unstyled" id="rseguridades" data-parent="#accordionExample">
                                <li>
                                    <a id="aperturas_cierres" href="{{ route('apertura_cierre') }}">
                                        <p class="romperpalabra"><span id="icono_active2"></span> Apertura y cierre</p>
                                    </a>
                                </li>
                                <li>
                                    <a id="asistencias_segs" href="{{ route('asistencia_seg') }}">
                                        <p class="romperpalabra"><span id="icono_active2"></span> Asistencia</p>
                                    </a>
                                </li>
                                <li>
                                    <a id="controles_camaras" href="{{ route('control_camara') }}">
                                        <p class="romperpalabra"><span id="icono_active2"></span> Control de cámaras</p>
                                    </a>
                                </li>
                                <li>
                                    <a id="lecturas_servicios" href="{{ route('lectura_servicio') }}">
                                        <p class="romperpalabra"><span id="icono_active2"></span> Lectura Servicio</p>
                                    </a>
                                </li>
                                
                            <?php if (
                                session('usuario')->id_puesto == 23 || session('usuario')->id_puesto == 24 || session('usuario')->id_puesto == 36 ||
                                session('usuario')->id_puesto == 26 || session('usuario')->id_puesto == 29 || session('usuario')->id_puesto == 161 || 
                                session('usuario')->id_nivel == 1 || session('usuario')->id_puesto == 197 || session('usuario')->id_puesto == 148                            ) { ?>
                                <li id="locurrencia">
                                    <a id="hlocurrencia" href="<?= url('Corporacion/Ocurrencia_Tienda') ?>">
                                        <p class="romperpalabra"><span id="icono_active2"></span> Ocurrencias</p>
                                    </a>
                                </li>
                            <?php } ?>
                            </ul>
                        </li>

                        <?php if(session('usuario')->id_nivel=="1" || session('usuario')->centro_labores=="OFC" || session('usuario')->id_puesto=="29" || session('usuario')->id_puesto=="161" ||
                        session('usuario')->id_puesto=="197" || session('usuario')->id_puesto=="128" || session('usuario')->id_puesto=="251" || session('usuario')->id_puesto=="41" ||
                        session('usuario')->id_puesto=="66" || session('usuario')->id_puesto=="73" || session('usuario')->id_puesto=="158" || session('usuario')->id_puesto=="12" ||
                        session('usuario')->id_puesto=="155" || session('usuario')->id_puesto=="9" || session('usuario')->id_puesto=="19" || session('usuario')->id_puesto=="21" ||
                        session('usuario')->id_puesto=="131" || session('usuario')->id_puesto=="68" || session('usuario')->id_puesto=="72" || session('usuario')->id_puesto=="15" ||
                        session('usuario')->id_puesto=="27" || session('usuario')->id_puesto=="148" || session('usuario')->id_puesto=="76" || session('usuario')->id_puesto=="311"||
                        Session('usuario')->id_puesto == 144
                        )
                        { ?>
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
                        <!-- Administrables  -->
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

                        <?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_puesto == 80){ ?>
                            <li class="menu" id="conf_controles_internos">
                                <a href="#rconf_controles_internos" id="hconf_controles_internos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    <div class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                                            <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                        </svg>
                                        <span>Control Interno</span>
                                    </div>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="collapse submenu list-unstyled" id="rconf_controles_internos" data-parent="#accordionExample">
                                    <li id="conf_precios_sugeridos">
                                        <a href="{{ route('precio_sugerido_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                                            <p class="romperpalabra"><span id="icono_active2"></span> Precio Sugerido</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

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

                    <li class="menu" id="conf_seguridades">
                        <a href="#rconf_seguridades" id="hconf_seguridades" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                </svg>
                                <span>Seguridad</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="rconf_seguridades" data-parent="#accordionExample">
                            <li id="conf_aperturas_cierres">
                                <a href="{{ route('apertura_cierre_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                                    <p class="romperpalabra"><span id="icono_active2"></span> Apertura y cierre</p>
                                </a>
                            </li>
                            <li id="conf_controles_camaras">
                                <a href="{{ route('control_camara_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                                    <p class="romperpalabra"><span id="icono_active2"></span> Control de cámaras</p>
                                </a>
                            </li>
                            <li id="conf_lecturas_servicios">
                                <a href="{{ route('lectura_servicio_conf') }}" data-toggle="tooltip" data-placement="right" data-html="true">
                                    <p class="romperpalabra"><span id="icono_active2"></span> Lectura Servicio</p>
                                </a>
                            </li>
                        </ul>
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
                    {{-- @endif --}}
                </ul>
            </nav>
        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        @yield('content')
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('template/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('template/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/app.js') }}"></script>
    <script src="{{ asset('template/plugins/blockui/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('template/plugins/blockui/custom-blockui.js') }}"></script>
    <script src="{{ asset('template/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('template/plugins/sweetalerts/custom-sweetalert.js') }}"></script>

    <script>
        $(document).ready(function() {
            App.init();
        });
        //BOTON FLOTANTE SOPORTE
        (function () {
            var options = {
                whatsapp: "+51 967 778 561", // WhatsApp number
                email: "sistemaslanumerouno@gmail.com", // Email
                call_to_action: "Soporte", // Call to action
                button_color: "#00b1f4", // Color of button
                email_color: "#E74339", // Email button color
                position: "right", // Position may be 'right' or 'left'
                order: "whatsapp,email", // Order of buttons
                pre_filled_message: "Hola, Necesito soporte.", // WhatsApp pre-filled message
            };
            var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        })();
    </script>
    <style>
    .dkuywW{
        display:none !important;
    }
    @media (max-width: 600px) {
        #div_imagen_header{
            display:none
        }
    }
    </style>
    <script src="{{ asset('template/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('template/plugins/select2/custom-select2.js') }}"></script>
    <script src="{{ asset('template/plugins/highlight/highlight.pack.js') }}"></script>
    <script src="{{ asset('template/assets/js/custom.js') }}"></script>

    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
    <script src="{{ asset('template/plugins/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('template/table-responsive/datatables.responsive.min.js') }}"></script>
    <!-- END PAGE LEVEL CUSTOM SCRIPTS -->
    <script src="{{ asset('template/assets/js/scrollspyNav.js') }}"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
    </script>
</body>
</html>
