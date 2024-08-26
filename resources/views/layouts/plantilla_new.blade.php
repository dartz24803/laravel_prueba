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

                    <li class="menu menu-heading">
                        <div class="heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            <span>MÓDULOS</span>
                        </div>
                    </li>

                    @yield('navbar')
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