<?php
use App\Models\TrackingDetalleProceso;
?>
<style>
    .vibrate {
        animation: vibrate 0.1s infinite;
        -webkit-animation: vibrate 0.1s infinite; /* Para Safari 4.0 - 8.0 */
        -moz-animation: vibrate 0.1s infinite; /* Para Firefox 5.0 - 15.0 */
        -o-animation: vibrate 0.1s infinite; /* Para Opera 12.0 */
        -ms-animation: vibrate 0.1s infinite; /* Para Internet Explorer 10.0 */
    }

    @keyframes vibrate {
        0% { transform: translate(0, 0); }
        25% { transform: translate(1px, 0); }
        50% { transform: translate(0, 1px); }
        75% { transform: translate(-1px, 0); }
        100% { transform: translate(0, -1px); }
    }

    @-webkit-keyframes vibrate {
        0% { -webkit-transform: translate(0, 0); }
        25% { -webkit-transform: translate(1px, 0); }
        50% { -webkit-transform: translate(0, 1px); }
        75% { -webkit-transform: translate(-1px, 0); }
        100% { -webkit-transform: translate(0, -1px); }
    }

    @-moz-keyframes vibrate {
        0% { -moz-transform: translate(0, 0); }
        25% { -moz-transform: translate(1px, 0); }
        50% { -moz-transform: translate(0, 1px); }
        75% { -moz-transform: translate(-1px, 0); }
        100% { -moz-transform: translate(0, -1px); }
    }

    @-o-keyframes vibrate {
        0% { -o-transform: translate(0, 0); }
        25% { -o-transform: translate(1px, 0); }
        50% { -o-transform: translate(0, 1px); }
        75% { -o-transform: translate(-1px, 0); }
        100% { -o-transform: translate(0, -1px); }
    }

    @-ms-keyframes vibrate {
        0% { -ms-transform: translate(0, 0); }
        25% { -ms-transform: translate(1px, 0); }
        50% { -ms-transform: translate(0, 1px); }
        75% { -ms-transform: translate(-1px, 0); }
        100% { -ms-transform: translate(0, -1px); }
    }
    .subnav {
        list-style-type: none;
    }
    .num{
        margin-top: 2px;
    }
    .nav{
        font-size: 0.6rem;
    }
    .nav-link{
        font-size: 0.5rem;
        left: 1rem !important;
    }
    a{
        color:white;
    }

    @media screen and (max-width: 1550px) {
        .nav {
            font-size: 0.5rem; /* Reducir aún más el tamaño de fuente en pantallas muy pequeñas */
        }/*
        .nav-link{
            padding: 2.5rem !important;
        }*/
        .num{
            padding-left: 0.1rem !important;
        }
        svg{
            width: 20px;
            height: 20px;
        }
        .num{
            margin-top: 0px;
        }
    }
    /* Media Queries para diferentes pantallas */
    @media screen and (max-width: 1200) {
        .nav {
            font-size: 0.4rem; /* Reducir tamaño de fuente en pantallas pequeñas */
        }
        .nav-link{
            font-size: 0.2rem;
        }
        .num{
            font-size: 0.5rem;
        }
        .num{
            margin-top: 0px;
        }
    }

    @media screen and (max-width: 480px) {
        .nav {
            font-size: 0.3rem; /* Reducir aún más el tamaño de fuente en pantallas muy pequeñas */
            width: 20rem;
        }
        .nav-link{
            font-size: 1rem;
            width: 20rem;
        }
        .num{
            margin-top: 0px;
        }
    }
    
    :root{
        --sw-progress-color: #00b1f4 !important;/*
        --sw-anchor-default-secondary-color: #fea701 !important;
        --sw-anchor-disabled-primary-color: #fea701 !important;
        --sw-anchor-disabled-secondary-color: #00ba8e !important;
        --sw-loader-background-color: #fea701 !important;
        --sw-anchor-done-primary-color: #ff295c !important;*/
    }
    
#smartwizard1 .nav-item:nth-child(9n-8)::after,
#smartwizard1 .nav-item:nth-child(9n-7)::after {
    border-left-color: #00ba8e;
}

#smartwizard1 .nav-item:nth-child(9n-6)::after,
#smartwizard1 .nav-item:nth-child(9n-5)::after {
    border-left-color: #ff295c;
}

#smartwizard1 .nav-item:nth-child(9n-4)::after,
#smartwizard1 .nav-item:nth-child(9n-3)::after {
    border-left-color: #fea701;
}

#smartwizard1 .nav-item:nth-child(9n-2)::after,
#smartwizard1 .nav-item:nth-child(9n-1)::after {
    border-left-color: #00b1f4;
}

#smartwizard1 .nav-item:nth-child(9n)::after {
    border-left-color: black;
}

.parte1::after{
    border-left-color: #00ba8e !important;
}
.parte2::after{
    border-left-color: #ff295c !important;
}
.parte3::after{
    border-left-color: #fea701 !important;
}
.parte4::after{
    border-left-color: #00b1f4 !important;
}
.parte1.disable{
    background-color: white !important;
    color: #00ba8e !important;
}
.parte1.disable::after{
    border-left-color: white !important;
}

.parte2.disable{
    background-color: white !important;
    color: #ff295c !important;
}
.parte2.disable::after{
    border-left-color: white !important;
}

.parte3.disable{
    background-color: white !important;
    color: #fea701 !important;
}
.parte3.disable::after{
    border-left-color: white !important;
}

.parte4.disable{
    background-color: white !important;
    color: #00b1f4 !important;
}
.parte4.disable::after{
    border-left-color: white !important;
}

.parte5.disable{
    background-color: white !important;
    color: black !important;
}
.parte5.disable::after{
    border-left-color: white !important;
}
.sw-theme-arrows > .nav .nav-link:nth-child(9n-6)::after, 
.sw-theme-arrows > .nav .nav-link:nth-child(9n-5)::after {
    border-left-color: #ff295c;
}
.sw-theme-arrows > .nav .parte1.disable::before {
    border-left-color: #00ba8e;
}
.sw-theme-arrows > .nav .parte2.disable::before {
    border-left-color: #ff295c;
}
.sw-theme-arrows > .nav .parte3.disable::before {
    border-left-color: #fea701;
}
.sw-theme-arrows > .nav .parte4.disable::before {
    border-left-color: #00b1f4;
}
.sw-theme-arrows > .nav .parte5.disable::before {
    border-left-color: #302f30;
}
.nav-item{
    height: 4rem !important;
}

.default.active {
    animation: pulse 2s infinite;
    z-index: 1;
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
</style>

<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th class="no-content"></th>
            <th>N° requerimiento</th>
            <th>Desde</th>
            <th>Hacia</th>
            <th>Proceso</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($list_tracking as $list)
            <tr class="text-center">
                <td>
                    @if ($list->id_estado == 2)
                        <a href="javascript:void(0);" title="Salida de mercadería" onclick="Insert_Salida_Mercaderia('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle text-dark">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 16 16 12 12 8"></polyline>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==3)
                        <a href="{{ route('tracking.detalle_transporte', $list->id) }}" title="Detalle de transporte">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==4)
                        <a href="javascript:void(0);" title="Llegada a tienda" onclick="Insert_Confirmacion_Llegada('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle text-dark">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 16 16 12 12 8"></polyline>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==5)
                        <a href="javascript:void(0);" title="Confirmación de llegada" onclick="Insert_Confirmacion_Llegada('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle text-dark">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 16 16 12 12 8"></polyline>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==7)
                        <a href="javascript:void(0);" title="Verificación de fardos" onclick="Verificacion_Fardos('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==8)
                        <a href="javascript:void(0);" title="Cierre inspección de fardos" onclick="Insert_Cierre_Inspeccion_Fardos('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-success">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </a>
                    @elseif($list->id_estado==9)
                        <a href="{{ route('tracking.pago_transporte', $list->id) }}" title="Pago de transporte">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card text-primary">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==12)
                        <a href="javascript:void(0);" title="Conteo de mercadería" onclick="Insert_Conteo_Mercaderia('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-success">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </a>
                    @elseif($list->id_estado==13)
                        <a href="javascript:void(0);" title="Reporte de mercadería" onclick="Reporte_Mercaderia('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==14)
                        <a href="{{ route('tracking.cuadre_diferencia', $list->id) }}" title="Cuadre de diferencias">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-dark">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </a>
                    @elseif($list->id_estado==15)
                        <a href="{{ route('tracking.detalle_operacion_diferencia', $list->id) }}" title="Detalle de operaciones de diferencias">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @elseif($list->id_estado==17)
                        <a href="{{ route('tracking.solicitud_devolucion', $list->id) }}" title="Solicitud de devolución">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-dark">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </a>
                    @elseif($list->id_estado==18)
                        <a href="{{ route('tracking.evaluacion_devolucion', $list->id) }}" title="Evaluación de devolución">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning vibrate">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </a>
                    @endif
                </td>
                <td>{{ $list->n_requerimiento }}</td>
                <td>{{ $list->desde }}</td>
                <td>{{ $list->hacia }}</td>
                <td>{{ $list->proceso }}</td>
                <td>{{ $list->fecha }}</td>
                <td>{{ $list->hora }}</td>
                <td>{{ $list->estado }}</td>
            </tr>
            <tr>
                <td colspan="8" style="width: 100%;">
                    <div id="smartwizard{{$list->id}}" dir class="mt-4 mb-5">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center parte1" title="Ver detalles">
                                    <div class="num">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                                    </div>
                                    DESPACHO<br>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center parte1" title="Ver detalles">
                                    <span class="num">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                        </svg><br>
                                    </span>
                                    TRASLADO<br>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center parte2" title="Ver detalles">
                                    <span class="num">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg><br>
                                    </span>
                                    RECEPCIÓN <br> DE MERCADERÍA<br>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center parte2" title="Ver detalles">
                                    <span class="num">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                            <line x1="3" y1="6" x2="21" y2="6"></line>
                                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                                        </svg><br>
                                    </span>
                                    INSPECCIÓN <br> DE FARDO<br>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center parte3" title="Ver detalles">
                                    <span class="num">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg><br>
                                    </span>
                                    PAGO DE <br> MERCADERÍA
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center parte3" title="Ver detalles">
                                    <span class="num">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zoom-in"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg><br>
                                    </span>
                                    INSPECCIÓN DE <br> MERCADERÍA
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center parte4" title="Ver detalles">
                                    <span class="num">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg><br>
                                    </span>
                                    DIFERENCIAS
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center parte4" title="Ver detalles">
                                    <span class="num">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-repeat"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg><br>
                                    </span>
                                    DEVOLUCIÓN
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center parte5" title="Ver detalles">
                                    <span class="num">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square">
                                            <polyline points="9 11 12 14 22 4"></polyline>
                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                        </svg><br>
                                    </span>
                                    FIN
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content card">
                            <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #00ba8e">DESPACHO</h5>
                                    @foreach ($estado as $row)
                                        @if ($row['id_proceso'] == 1)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00ba8e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                            {{ $row['descripcion'] }}<br>
                                            <?php if ($row['descripcion'] == $list->descripcion){ break; } ?>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #00ba8e">TRASLADO</h5>
                                    @foreach ($estado as $row)
                                        @if ($row['id_proceso'] == 2)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00ba8e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                            {{ $row['descripcion'] }}<br>
                                            <?php if ($row['descripcion'] == $list->descripcion){ break; } ?>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #ff295c">RECEPCION DE MERCADERÍA</h5>
                                    @foreach ($estado as $row)
                                        @if ($row['id_proceso'] == 3)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff295c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                            {{ $row['descripcion'] }}<br>
                                            <?php if ($row['descripcion'] == $list->descripcion){ break; } ?>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #ff295c">INSPECCIÓN DE FARDO</h5>
                                    @foreach ($estado as $row)
                                        @if ($row['id_proceso'] == 4)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff295c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                            {{ $row['descripcion'] }}<br>
                                            <?php if ($row['descripcion'] == $list->descripcion){ break; } ?>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #fea701">PAGO DE MERCADERÍA</h5>
                                    @foreach ($estado as $row)
                                        @if ($row['id_proceso'] == 5)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fea701" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                            {{ $row['descripcion'] }}<br>
                                            <?php if ($row['descripcion'] == $list->descripcion){ break; } ?>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #fea701">INSPECCION DE MERCADERÍA</h5>
                                    @foreach ($estado as $row)
                                        @if ($row['id_proceso'] == 6)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fea701" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                            {{ $row['descripcion'] }}<br>
                                            <?php if ($row['descripcion'] == $list->descripcion){ break; } ?>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #00b1f4">DIFERENCIAS</h5>
                                    <?php
                                    $mensaje_mostrado1 = false;
                                    $contiene_proceso_7 = false;
                                    $proceso = TrackingDetalleProceso::where('id_tracking', $list->id)->get();
                                    foreach($proceso as $dd){
                                        if ($dd->id_proceso == 7) {
                                            $contiene_proceso_7 = true;
                                            break;
                                        }
                                    };
                                    ?>
                                    @if ($contiene_proceso_7)
                                        @foreach ($estado as $row)
                                            @if ($row['id_proceso'] == 7)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00b1f4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                {{ $row['descripcion'] }}<br>
                                                <?php if ($row['descripcion'] == $list->descripcion){ break; } ?>
                                                <?php $mensaje_mostrado1 = true; ?>
                                            @endif
                                        @endforeach
                                    @else
                                    (no hay registro de devolución)
                                    @endif
                                </div>
                            </div>
                            <div id="step-8" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #00b1f4">DEVOLUCIÓN</h5>
                                    <?php 
                                        $mensaje_mostrado2 = false;
                                        $contiene_proceso_8 = false;
                                        foreach($proceso as $dd){
                                            if ($dd->id_proceso == 8) {
                                                $contiene_proceso_8 = true;
                                                break;
                                            }
                                        };
                                    ?>
                                    @if ($contiene_proceso_8)
                                        @foreach ($estado as $row)
                                            @if ($row['id_proceso'] == 8)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00b1f4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                {{ $row['descripcion'] }}<br>
                                                <?php if ($row['descripcion'] == $list->descripcion){ break; } ?>
                                                <?php $mensaje_mostrado2 = true; ?>
                                            @endif
                                        @endforeach
                                    @else
                                    (no hay registro de devolución)
                                    @endif
                                </div>
                            </div>
                            <div id="step-9" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                                <div class="card-body">
                                    <h5 class="card-title">FIN</h5>
                                    @foreach ($estado as $row)
                                        @if ($row['id_proceso'] == 9)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#302f30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                            {{ $row['descripcion'] }}<br>
                                            <?php if ($row['descripcion'] == $list->descripcion){ break; } ?>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tabla_js').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10
        });
    });

    function Insert_Salida_Mercaderia(id) {
        Cargando();

        var url = "{{ route('tracking.salida_mercaderia', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea cambiar el estado?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }
        })
    }

    function Insert_Confirmacion_Llegada(id) {
        Cargando();

        var url = "{{ route('tracking.confirmacion_llegada', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea cambiar el estado?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }
        })
    }

    function Verificacion_Fardos(id) {
        Cargando();

        var url = "{{ route('tracking.cierre_inspeccion_fardos', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿El fardo llegó en buenas condiciones?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }else{
                window.location = "{{ route('tracking.verificacion_fardos', ':id') }}".replace(':id', id);
            }
        })
    }

    function Insert_Cierre_Inspeccion_Fardos(id) {
        Cargando();

        var url = "{{ route('tracking.cierre_inspeccion_fardos', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea cambiar el estado?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'validacion':1},
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }
        })
    }

    function Insert_Conteo_Mercaderia(id) {
        Cargando();

        var url = "{{ route('tracking.conteo_mercaderia', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea cambiar el estado?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }
        })
    }

    function Reporte_Mercaderia(id) {
        Cargando();

        var url = "{{ route('tracking.mercaderia_entregada', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿La mercadería llegó en buenas condiciones?',
            text: "El cambio será permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Tracking();
                        });
                    }
                });
            }else{
                window.location = "{{ route('tracking.reporte_mercaderia', ':id') }}".replace(':id', id);
            }
        })
    }
    $(function() {
        <?php foreach ($list_tracking as $list) :
            $estado = intval($list->id_proceso) -1; ?>
            $('#smartwizard<?= $list->id; ?>').smartWizard({
                selected: <?= $estado; ?>,
                //theme: 'square',
                theme: 'arrows',
                toolbar: {
                    position: 'none', // none|top|bottom|both
                },
                transition: {
                    animation: 'css',
                },
            });
            // Deshabilitar los enlaces a partir del estado actual
            for (let i = <?= $estado + 1; ?>; i <= 8; i++) {
                let stepLink = $('#smartwizard<?= $list->id; ?> .nav-link:eq(' + i + ')');
                stepLink.addClass('disable');
            }
        
            // Aplica los estilos personalizados después de inicializar SmartWizard
            $('#smartwizard<?= $list->id; ?> .nav-item:nth-child(9n-8), #smartwizard<?= $list->id; ?> .nav-item:nth-child(9n-7)').css({
                'background-color': '#00ba8e',
                'color': 'white'
            });
            $('.parte1').css({
                'background-color': '#00ba8e'
            })

            $('#smartwizard<?= $list->id; ?> .nav-item:nth-child(9n-6), #smartwizard<?= $list->id; ?> .nav-item:nth-child(9n-5)').css({
                'background-color': '#ff295c',
                'color': 'white'
            });

            $('#smartwizard<?= $list->id; ?> .nav-item:nth-child(9n-4), #smartwizard<?= $list->id; ?> .nav-item:nth-child(9n-3)').css({
                'background-color': '#fea701',
                'color': 'white'
            });

            $('#smartwizard<?= $list->id; ?> .nav-item:nth-child(9n-2), #smartwizard<?= $list->id; ?> .nav-item:nth-child(9n-1)').css({
                'background-color': '#00b1f4',
                'color': 'white'
            });

            $('#smartwizard<?= $list->id; ?> .nav-item:nth-child(9n)').css({
                'background-color': '#302f30',
                'color': 'white'
            });
        <?php endforeach; ?>
    });
</script>