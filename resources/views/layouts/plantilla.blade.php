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
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/plugins/table/datatable/dt-global_style.css') }}">
    <!-- END PAGE LEVEL CUSTOM STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/plugins/select2/select2.min.css') }}">
    <link href="{{ asset('template/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
</head>
<body class="alt-menu sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->
    
    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm expand-header">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <ul class="navbar-item flex-row ml-auto">
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><!--<span class="badge badge-success"></span>-->
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="notification-scroll">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
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
    <div id="ModalUpdate" data-backdrop="static" data-keyboard="false" class="modal animated fadeInRight custo-fadeInRight bd-example-modal-lg scrollpagina" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <script src="{{ asset('template/docs/js/jquery-3.2.1.min.js') }}"></script>

    <script>
        function Cargando() {
            $(document)
            .ajaxStart(function() {
                $.blockUI({
                    message: '<svg> ... </svg>',
                    fadeIn: 800,
                    overlayCSS: {
                        backgroundColor: '#1b2024',
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
                        backgroundColor: '#1b2024',
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
            $("#ModalUpdate").on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                $(this).find(".modal-content").load(link.attr("app_elim"));
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
                    <li class="nav-item theme-logo">
                        <a href="{{ route('inicio') }}">
                            <img src="{{ asset('template/assets/img/90x90.jpg') }}" class="navbar-logo" alt="logo">
                        </a>
                    </li>
                    <li class="nav-item theme-text">
                        <a href="{{ route('inicio') }}" class="nav-link"> CORK </a>
                    </li>
                </ul>

                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu">
                        <a href="{{ route('inicio') }}" aria-expanded="false" class="dropdown-toggle">
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
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg><span>MÓDULOS</span></div>
                    </li>

                    <li class="menu" id="li_trackings">
                        <a href="{{ route('tracking') }}" id="a_trackings" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                <span>Tracking</span>
                            </div>
                        </a>
                    </li>

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
                            <li id="reportefoto">
                                <a id="reporte_foto" href="{{ url('/ReporteFotografico')}}">
                                    <p class="romperpalabra"><span id="icono_active2"></span> Reporte fotográfico</p>
                                </a>
                            </li>
                            <li id="cuadrocontrolvisual">
                                <a id="hrpreorden" href="{{ url('Cuadro_Control_Visual_Vista')}}">
                                    <p class="romperpalabra"><span id="icono_active2"></span> Cuadro Control Visual</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Administrables  -->
                    <li class="menu menu-heading">
                        <div class="heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                            <span>ADMINISTRACION</span>
                        </div>
                    </li>
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
                            <li id="rfa">
                                <a href="{{ url('/ReporteFotograficoAdm')}}" data-toggle="tooltip" data-placement="right" data-html="true">
                                    <p class="romperpalabra"><span id="icono_active2"></span> Reporte Fotográfico</p>
                                </a>
                            </li>
                            <li id="ccv">
                                <a href="{{ url('/TablaCuadroControlVisual') }}" data-toggle="tooltip" data-placement="right" data-html="true" title="• Horarios <br>• Cuadro de Control Visual <br>• Programación Diaria">
                                    <p class="romperpalabra"><span id="icono_active2"></span> Cuadro de Control Visual</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        @yield('content')
        <!--<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="page-header">
                    <div class="page-title">
                        <h3>Live Dom Ordering</h3>
                    </div>
                </div>
                
                <div class="row" id="cancel-row">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <table id="example" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td><input type="text" id="row-1-age" class="form-control" name="row-1-age" value="61"></td>
                                        <td><input type="text" id="row-1-position" class="form-control" name="row-1-position" value="System Architect"></td>
                                        <td><select size="1" id="row-1-office" class="form-control" name="row-1-office">
                                            <option value="Edinburgh" selected="selected">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td><input type="text" id="row-2-age" class="form-control" name="row-2-age" value="63"></td>
                                        <td><input type="text" id="row-2-position" class="form-control" name="row-2-position" value="Accountant"></td>
                                        <td><select size="1" id="row-2-office" class="form-control" name="row-2-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo" selected="selected">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td><input type="text" id="row-3-age" class="form-control" name="row-3-age" value="66"></td>
                                        <td><input type="text" id="row-3-position" class="form-control" name="row-3-position" value="Junior Technical Author"></td>
                                        <td><select size="1" id="row-3-office" class="form-control" name="row-3-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco" selected="selected">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Cedric Kelly</td>
                                        <td><input type="text" id="row-4-age" class="form-control" name="row-4-age" value="22"></td>
                                        <td><input type="text" id="row-4-position" class="form-control" name="row-4-position" value="Senior Javascript Developer"></td>
                                        <td><select size="1" id="row-4-office" class="form-control" name="row-4-office">
                                            <option value="Edinburgh" selected="selected">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Airi Satou</td>
                                        <td><input type="text" id="row-5-age" class="form-control" name="row-5-age" value="33"></td>
                                        <td><input type="text" id="row-5-position" class="form-control" name="row-5-position" value="Accountant"></td>
                                        <td><select size="1" id="row-5-office" class="form-control" name="row-5-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo" selected="selected">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Brielle Williamson</td>
                                        <td><input type="text" id="row-6-age" class="form-control" name="row-6-age" value="61"></td>
                                        <td><input type="text" id="row-6-position" class="form-control" name="row-6-position" value="Integration Specialist"></td>
                                        <td><select size="1" id="row-6-office" class="form-control" name="row-6-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York" selected="selected">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Herrod Chandler</td>
                                        <td><input type="text" id="row-7-age" class="form-control" name="row-7-age" value="59"></td>
                                        <td><input type="text" id="row-7-position" class="form-control" name="row-7-position" value="Sales Assistant"></td>
                                        <td><select size="1" id="row-7-office" class="form-control" name="row-7-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco" selected="selected">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Rhona Davidson</td>
                                        <td><input type="text" id="row-8-age" class="form-control" name="row-8-age" value="55"></td>
                                        <td><input type="text" id="row-8-position" class="form-control" name="row-8-position" value="Integration Specialist"></td>
                                        <td><select size="1" id="row-8-office" class="form-control" name="row-8-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo" selected="selected">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Colleen Hurst</td>
                                        <td><input type="text" id="row-9-age" class="form-control" name="row-9-age" value="39"></td>
                                        <td><input type="text" id="row-9-position" class="form-control" name="row-9-position" value="Javascript Developer"></td>
                                        <td><select size="1" id="row-9-office" class="form-control" name="row-9-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco" selected="selected">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Sonya Frost</td>
                                        <td><input type="text" id="row-10-age" class="form-control" name="row-10-age" value="23"></td>
                                        <td><input type="text" id="row-10-position" class="form-control" name="row-10-position" value="Software Engineer"></td>
                                        <td><select size="1" id="row-10-office" class="form-control" name="row-10-office">
                                            <option value="Edinburgh" selected="selected">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Jena Gaines</td>
                                        <td><input type="text" id="row-11-age" class="form-control" name="row-11-age" value="30"></td>
                                        <td><input type="text" id="row-11-position" class="form-control" name="row-11-position" value="Office Manager"></td>
                                        <td><select size="1" id="row-11-office" class="form-control" name="row-11-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London" selected="selected">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Quinn Flynn</td>
                                        <td><input type="text" id="row-12-age" class="form-control" name="row-12-age" value="22"></td>
                                        <td><input type="text" id="row-12-position" class="form-control" name="row-12-position" value="Support Lead"></td>
                                        <td><select size="1" id="row-12-office" class="form-control" name="row-12-office">
                                            <option value="Edinburgh" selected="selected">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Charde Marshall</td>
                                        <td><input type="text" id="row-13-age" class="form-control" name="row-13-age" value="36"></td>
                                        <td><input type="text" id="row-13-position" class="form-control" name="row-13-position" value="Regional Director"></td>
                                        <td><select size="1" id="row-13-office" class="form-control" name="row-13-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco" selected="selected">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Haley Kennedy</td>
                                        <td><input type="text" id="row-14-age" class="form-control" name="row-14-age" value="43"></td>
                                        <td><input type="text" id="row-14-position" class="form-control" name="row-14-position" value="Senior Marketing Designer"></td>
                                        <td><select size="1" id="row-14-office" class="form-control" name="row-14-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London" selected="selected">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Tatyana Fitzpatrick</td>
                                        <td><input type="text" id="row-15-age" class="form-control" name="row-15-age" value="19"></td>
                                        <td><input type="text" id="row-15-position" class="form-control" name="row-15-position" value="Regional Director"></td>
                                        <td><select size="1" id="row-15-office" class="form-control" name="row-15-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London" selected="selected">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Michael Silva</td>
                                        <td><input type="text" id="row-16-age" class="form-control" name="row-16-age" value="66"></td>
                                        <td><input type="text" id="row-16-position" class="form-control" name="row-16-position" value="Marketing Designer"></td>
                                        <td><select size="1" id="row-16-office" class="form-control" name="row-16-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London" selected="selected">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Paul Byrd</td>
                                        <td><input type="text" id="row-17-age" class="form-control" name="row-17-age" value="64"></td>
                                        <td><input type="text" id="row-17-position" class="form-control" name="row-17-position" value="Chief Financial Officer (CFO)"></td>
                                        <td><select size="1" id="row-17-office" class="form-control" name="row-17-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York" selected="selected">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Gloria Little</td>
                                        <td><input type="text" id="row-18-age" class="form-control" name="row-18-age" value="59"></td>
                                        <td><input type="text" id="row-18-position" class="form-control" name="row-18-position" value="Systems Administrator"></td>
                                        <td><select size="1" id="row-18-office" class="form-control" name="row-18-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York" selected="selected">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Bradley Greer</td>
                                        <td><input type="text" id="row-19-age" class="form-control" name="row-19-age" value="41"></td>
                                        <td><input type="text" id="row-19-position" class="form-control" name="row-19-position" value="Software Engineer"></td>
                                        <td><select size="1" id="row-19-office" class="form-control" name="row-19-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London" selected="selected">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Dai Rios</td>
                                        <td><input type="text" id="row-20-age" class="form-control" name="row-20-age" value="35"></td>
                                        <td><input type="text" id="row-20-position" class="form-control" name="row-20-position" value="Personnel Lead"></td>
                                        <td><select size="1" id="row-20-office" class="form-control" name="row-20-office">
                                            <option value="Edinburgh" selected="selected">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Jenette Caldwell</td>
                                        <td><input type="text" id="row-21-age" class="form-control" name="row-21-age" value="30"></td>
                                        <td><input type="text" id="row-21-position" class="form-control" name="row-21-position" value="Development Lead"></td>
                                        <td><select size="1" id="row-21-office" class="form-control" name="row-21-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York" selected="selected">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Yuri Berry</td>
                                        <td><input type="text" id="row-22-age" class="form-control" name="row-22-age" value="40"></td>
                                        <td><input type="text" id="row-22-position" class="form-control" name="row-22-position" value="Chief Marketing Officer (CMO)"></td>
                                        <td><select size="1" id="row-22-office" class="form-control" name="row-22-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York" selected="selected">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Caesar Vance</td>
                                        <td><input type="text" id="row-23-age" class="form-control" name="row-23-age" value="21"></td>
                                        <td><input type="text" id="row-23-position" class="form-control" name="row-23-position" value="Pre-Sales Support"></td>
                                        <td><select size="1" id="row-23-office" class="form-control" name="row-23-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York" selected="selected">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Doris Wilder</td>
                                        <td><input type="text" id="row-24-age" class="form-control" name="row-24-age" value="23"></td>
                                        <td><input type="text" id="row-24-position" class="form-control" name="row-24-position" value="Sales Assistant"></td>
                                        <td><select size="1" id="row-24-office" class="form-control" name="row-24-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Angelica Ramos</td>
                                        <td><input type="text" id="row-25-age" class="form-control" name="row-25-age" value="47"></td>
                                        <td><input type="text" id="row-25-position" class="form-control" name="row-25-position" value="Chief Executive Officer (CEO)"></td>
                                        <td><select size="1" id="row-25-office" class="form-control" name="row-25-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London" selected="selected">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Gavin Joyce</td>
                                        <td><input type="text" id="row-26-age" class="form-control" name="row-26-age" value="42"></td>
                                        <td><input type="text" id="row-26-position" class="form-control" name="row-26-position" value="Developer"></td>
                                        <td><select size="1" id="row-26-office" class="form-control" name="row-26-office">
                                            <option value="Edinburgh" selected="selected">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td>Jennifer Chang</td>
                                        <td><input type="text" id="row-27-age" class="form-control" name="row-27-age" value="28"></td>
                                        <td><input type="text" id="row-27-position" class="form-control" name="row-27-position" value="Regional Director"></td>
                                        <td><select size="1" id="row-27-office" class="form-control" name="row-27-office">
                                            <option value="Edinburgh">
                                                Edinburgh
                                            </option>
                                            <option value="London">
                                                London
                                            </option>
                                            <option value="New York">
                                                New York
                                            </option>
                                            <option value="San Francisco">
                                                San Francisco
                                            </option>
                                            <option value="Tokyo">
                                                Tokyo
                                            </option>
                                        </select></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>-->
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
    </script>
    <script src="{{ asset('template/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('template/plugins/select2/custom-select2.js') }}"></script>
    <script src="{{ asset('template/assets/js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
    <script src="{{ asset('template/plugins/table/datatable/datatables.js') }}"></script>
    <!-- END PAGE LEVEL CUSTOM SCRIPTS -->
</body>
</html>