<style>
    .main-container, #content {
        min-height: auto; 
    }

    #container{
        position: relative;
        top: -2rem;
    }

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
<!-- <div class="main-container" id="container"> -->
<div class="main-container" id="container">
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
                    <a id="hinicio" href="{{ url('/Inicio')}}" aria-expanded="false" class="dropdown-toggle">
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
                <li class="menu menu-heading">
                    <div class="heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <span>MÓDULOS</span>
                    </div>
                </li>
                <li class="menu" id="trackings">
                    <a href="{{ route('tracking') }}" id="a_trackings" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            <span id="icono_active"></span>
                            <span> Tracking</span>
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
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
