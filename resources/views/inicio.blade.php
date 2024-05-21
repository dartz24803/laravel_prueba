<!DOCTYPE html>
<html lang="en">
{{-- header --}}
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ZZZZZZZZ</title>
    <!-- Custom fonts for this template-->
    <script>
    </script>
    <link href="{{ asset('css/structure.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    {{-- <link href="{{ asset('css/bootstrap/bootstrap.min.css') }} " rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <!--Datatables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <link rel="stylesheet" href="<?php echo base_path() ?>/resources/css/datatables.css"> -->
<style>
    #demo_vertical::-ms-clear,
    #demo_vertical2::-ms-clear {
        display: none;
    }

    input#demo_vertical {
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    input#demo_vertical2 {
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .widget-content-area {
        border-radius: 6px;
    }

    .daterangepicker.dropdown-menu {
        z-index: 1059;
    }

    .flatpickr-calendar.open {
        display: inline-block;
        z-index: 10000;
    }

    p {
        margin-top: 0;
        margin-bottom: 0.625rem;
    }
</style>
    <style>
        .t-rotate270 {
            -webkit-transform: rotate(270deg);
            transform: rotate(270deg)
        }
    </style>
    <style>
        .widget-content-area {
            border-radius: 6px;
        }

        .daterangepicker.dropdown-menu {
            z-index: 1059;
        }
    </style>
    <script>
        //moment.locale('es');
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LHENKPE6DM"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-LHENKPE6DM');
    </script>
</head>


<body class="alt-menu " data-spy="scroll" data-target="#navSection" data-offset="140">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center">

                </div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>
            <ul class="navbar-item flex-row ml-auto">
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </a>
                    <div class="dropdown-menu position-absolute e-animated e-fadeInUp" aria-labelledby="notificationDropdown">
                        <div class="notification-scroll">
                                <div class="dropdown-item">
                                    <a onclick="Update_Notificacion_Leido('');">
                                        <div class="media">
                                            <div class="media-body">
                                                <div class="notification-para"><span class="user-name"></span></div>
                                                <div class="notification-meta-time"> minutos atrás</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-item">
                                    <div class="media">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <polyline points="17 11 19 13 23 9"></polyline>
                        </svg>
                    </a>
                    <div class="dropdown-menu position-absolute e-animated e-fadeInUp" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="media-body">
                                    <h5></h5>
                                    <!--<p>Web Developer</p>-->
                                </div>
                            </div>
                        </div>
                                <div class="dropdown-item">
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg> <span>Mi Perfil</span>
                                    </a>
                                </div>

                            <div class="dropdown-item">
                                <a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg> <span>Cambiar Contraseña</span>
                                </a>
                            </div>
                        <div class="dropdown-item">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> <span>Salir</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    {{-- nav --}}
    <style>
        img.navbar-logo.ajuste {
            width: 150px;
            height: 47px;
        }

        #sidebar .theme-brand li.theme-logo img {
            width: 40px;
            border-radius: 5px;
        }

        p.romperpalabra {
            word-break: break-all;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .heading span {
            color: #00b1f4;
            font-weight: bold;
        }

        .menu:not(.menu-heading):hover {
            border: 1.5px solid #ffa700;
            border-radius: 15px;
            font-weight: bold;
        }

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
        .tooltip-inner {
            font-family: Century;
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
        .cLcbjv {
            display: none;
        }
    </style>
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container sidebar-closed sbar-open" id="container">
    <!-- <div class="main-container" id="container"> -->
        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">
            <nav id="sidebar">
                <ul class="navbar-nav theme-brand flex-row  text-center">
                    <li class="nav-item theme-logo">
                        <a>
                            <img src="{{ asset('login_files/img/la_numerouno.png') }}" class="navbar-logo" alt="logo">
                        </a>
                    </li>
                    <li class="nav-item theme-text">
                        <a class="nav-link">
                            <img src="{{ asset('login_files/img/grupo.png') }}" class="navbar-logo ajuste" alt="logo">
                        </a>
                    </li>
                </ul>
                <li id="focusInput" class="nav-item align-self-center search-animated row ml-1">
                    <form class="form-inline search-full form-inline search col-md-12" role="search">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input id="sidebarSearch" type="text" class="form-control search-form-control ml-2" style="width: 80%;" placeholder="Buscar en la barra">
                        </div>
                    </form>
                </li>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li id="inicio" class="menu">
                        <a id="hinicio" href="" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span id="icono_active"></span>
                                <span> Inicio</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- validaciones -->
    </div>
    <div id="content" class="main-content">
        <a href="{{ url('DestruirSesion') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg> <span>Salir</span>
        </a>
    </div>
    <!-- footer -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app2.js') }}"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
</body>
</html>