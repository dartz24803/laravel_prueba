@extends('layouts.plantilla')

@section('content')
<div id="content" class="main-content">
    <!--<button class="btn btn-primary" type="button" onclick="validar_reporte_fotografico_dia_job_2();">Guardar</button>-->
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow row">
                    <div class="widget-content simple-tab col-md-10" style="background-color: #f0f3f3;">
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div class="container" id="container" style="background-image: url('{{ asset('inicio/NEW.Intranet-Icono-Fondo2.jpg') }}');">
                                    <div class="row layout-top-spacing">
                                        <!-- Logo Logistica-->
                                        <div id="logo_logistica" class="col-sm-8">
                                            <div class="logo6" style="width: 6rem;">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #fea701;height:6rem">
                                                    <img class="imagen_1"  src="{{ asset('inicio/NEW.Intranet-Icono-Logistica.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Logística</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Comercial-->
                                        <div id="logo_comercial" class="col-sm-4 d-flex justify-content-end">
                                            <div class="logo7 mb-4" style="width: 7rem">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #ff295c; height: 7rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Comercial.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Comercial</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Talento Humano-->
                                        <div id="logo_talento_humano" class="col-sm-2 d-flex justify-content-center">
                                            <div class="logo7" style="width: 7rem;">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00b1f4; height:7rem;">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-TalentoHumano.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Talento Humano</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Infraestructura-->
                                        <div id="logo_infraestructura" class="col-sm-3">
                                            <div class="logo7" style="width: 7rem;">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00ba8e; height: 7rem;">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Infraestructuras.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Infraestructura</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Interna-->
                                        <div id="logo_interna" class="col-sm-3 d-flex justify-content-end">
                                            <div class="logo6" style="width: 6rem;">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00ba8e;height:6rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Interna.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Interna</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo central LN1-->
                                        <div id="logo_central" class="col-sm-4 zoom-card-2 d-flex justify-content-center">
                                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                                    <?php foreach ($list_frases as $index => $row) { ?>
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="<?= $index + 1 ?>"></li>
                                                    <?php } ?>
                                                </ol>
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active text-center">
                                                        <img src="{{ asset('/inicio/LN1-Isotipo.png') }}" alt="La número 1" style="height: 10rem;">
                                                    </div>
                                                    <?php foreach ($list_frases as $row) { ?>
                                                    <div class="carousel-item text-center">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div class="card-body">
                                                                <br><br>
                                                                <h5 class="card-text" style="font-family: 'Poppins', sans-serif;">{{ $row['frase']}}</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <!--<div class="card text-center border-0 rounded_z" style="background-color: #f1f3f5;">
                                                <div class="card-body text-center">
                                                    <img src="{{ asset('/inicio/LN1-Isotipo.png') }}" alt="La número 1" style="height: 10rem">
                                                </div>
                                            </div>-->
                                        </div>
                                        <!-- Logo Finanzas-->
                                        <div id="logo_finanzas" class="col-sm-3 d-flex justify-content-center align-items-end">
                                            <div class="logo6" style="width: 6rem;">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00b1f4;height:6rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Finanzas.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Finanzas</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Seguridad y Salud-->
                                        <div id="logo_seguridad" class="col-sm-5 d-flex justify-content-end">
                                            <div class="logo7" style="width: 7rem;">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00b1f4; height:7rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-SeguridadSalud.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Seguridad y Salud</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Caja y Control-->
                                        <div id="logo_caja" class="col-sm-2 d-flex justify-content-center">
                                            <div class="logo6" style="width: 6rem;">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #fea701; height: 6rem;">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-CajaControlInterno.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Caja y Control Interno</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Manufactura-->
                                        <div id="logo_manufactura" class="col-sm-2 d-flex align-items-start">
                                            <div class="logo7" style="width: 7rem;">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00ba8e; height: 7rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Manufactura.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Manufactura</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Tiendas-->
                                        <div id="logo_tiendas" class="col-sm-3 d-flex justify-content-start">
                                            <div class="logo7" style="width: 7rem; margin-top: 2rem;">
                                                <div class="zoom-card card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #ff295c;height: 7rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Tiendas.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Tiendas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End layout spacing -->
                            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

                            <!-- <img src="{{ asset('/inicio/Estamos-trabajando.png') }}" alt="" style="max-width: 100%;"> -->
                            <div class="col-md-12 footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <i class="bx bxs-navigation"></i>
                                            <a href="https://www.lanumero1.com.pe" target="_blank"><strong>www.lanumero1.com.pe</strong></a>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 d-block d-sm-flex justify-content-around offset-1">
                                        <div class="icon d-flex align-items-center py-1 py-lg-0">
                                            <i class="bx bxl-facebook-square"></i>
                                            <a href="https://www.facebook.com/Lanumero1.peru" target="_blank"><strong>Lanumero1.peru</strong></a>
                                        </div>

                                        <div class="icon d-flex align-items-center py-1 py-lg-0 px-sm-3">
                                            <i class="bx bxl-instagram"></i>
                                            <a href="https://www.instagram.com/lanumero1moda" target="_blank"><strong>lanumero1moda</strong></a>
                                        </div>

                                        <div class="icon d-flex align-items-center py-1 py-lg-0">
                                            <i class="bx bxl-tiktok"></i>
                                            <a href="https://www.tiktok.com/@lanumero1.peru" target="_blank"><strong>lanumero1.peru</strong></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-3 justify-content-center">
                                                            <?php if(count($list_cumple)>0){ ?>
                                                                <div class="card-heading">
                                                                    <h5><b>Próximos cumpleaños</b></h5>
                                                                </div>
                                                                <div class="card-content">
                                                                    <div class="table-responsive">
                                                                        <table class="table" style="width:100%">
                                                                            <tbody>
                                                                                <?php $i=0; foreach($list_cumple as $list){$i++;
                                                                                    if($i<6){?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="d-flex justify-content-center">
                                                                                                <img style="max-width:100px;max-height:70px;margin:0 10px 10px 0;" src="{{ asset('template/assets/img/torta_saludo.png')}}">
                                                                                                <img style="max-width:70px;max-height:70px;border-radius: 10%;border: 3px solid #e0e6ed;" src="<?php if ($list['foto_nombre'] !=""){echo $get_foto[0]['url_config'].$list['foto_nombre'];}else{echo asset("template/assets/especiales/user-mini.png");}  ?>" alt="avatar" title="<?php echo $list['foto_nombre'] ?>">
                                                                                            </div>
                                                                                            <div class="d-flex justify-content-center">
                                                                                                <span style="color:#3b3f71"><b><?php $nombre=explode(" ",$list['nombres_min']); echo mb_convert_case($nombre[0]." ".$list['apater_min'], MB_CASE_TITLE, "UTF-8"); ?></b></span>
                                                                                            </div>
                                                                                            <div class="d-flex justify-content-center">
                                                                                                <span ><?php echo date('d', strtotime($list['cumpleanio']))." de ".strtolower($list['nom_mes']) ?></span>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } }?>
                                                                            </tbody>
                                                                        </table>

                                                                        <?php if(count($list_cumple)>5){?>
                                                                            <div class="text-center mb-4">
                                                                                <a class="boton" href="javascript:void(0)" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="{{ url('Corporacion/Modal_Ver_Todo_Cumpleanios') }}"><span>Ver Todos</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php foreach($list_slider_inicio as $row):
                                    $color = '#fff';
                                    if($row['categoria'] == 'INSTRUCTIVOS'){
                                        $active = "";
                                        $image = asset('inicio/NEW.Intranet-Slide-04Instructivos.png');
                                    }else if($row['categoria'] == 'POLÍTICA'){
                                        $active = "";
                                        $image = asset('inicio/NEW.Intranet-Slide-03Politica.png');
                                    }else if($row['categoria'] == 'MANUAL'){
                                        $active = "";
                                        $image = asset('inicio/NEW.Intranet-Slide-02Manual.png');
                                    }else if($row['categoria'] == 'PROCESOS'){
                                        $active = "";
                                        $image = asset('inicio/NEW.Intranet-Slide-01Procesos.png');
                                    }
                                    ?>
                                    <div class="carousel-item <?= $active ?>">
                                        <img id="imagen_fondo_slider" style="max-width: 101%; padding-left: 1%; padding-right: 1%;" src="<?= $image ?>">
                                        <div id="carousel-caption" class="carousel-caption d-none d-block text-left">
                                            <p class="mensaje_nuevo_slider" style="color: <?= $color ?>; margin-bottom: 0%; margin-left: 0.2rem"><?= $row['descripcion'] ?></p>
                                            <span class="d-flex align-items-center titulo_slider" style="color: <?= $color ?>;"><?= $row['titulo'] ?></span>
                                            <a  href="<?= $row['link'] ?>" target="_blank" style="max-width:100%;">
                                                <span class="badge" style="background-color: #fea600; color:white; margin-top: 1%;">
                                                    <img id="mano_slider" style="max-width: 10%; margin-right: 1%;" src="{{ asset('inicio/LN1-Intranet-Mano.png') }}" alt="">
                                                    DESCÚBRELO
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .rounded_z{
        border-radius: 1.1rem;
    }

    .zoom-card {
        transition: transform 0.5s; /* Animación de transición suave */
    }
    .zoom-card:hover {
        transform: scale(1.1); /* Efecto de zoom */
        cursor: pointer;
    }

    img{
        max-width: 100%;
    }

    .zoom-card-2 {
        transition: transform 1s; /* Animación de transición suave */
    }
    .zoom-card-2:hover {
        transform: scale(1.05); /* Efecto de zoom */
        cursor: pointer;
    }
    #container {
        background-position: center;
        background-repeat: no-repeat;
        background-size: 135rem auto;
    }
    @media screen and (min-width: 1051px) {
        #logo_logistica{
            margin-left: 39.5rem;
            margin-top: 6rem;
            height: 9rem;
        }
        #logo_comercial{
            margin-left: 4rem;
            margin-top: -2rem;
            height: 8rem;
        }
        #logo_talento_humano{
            margin-top: -4rem;
        }
        #logo_infraestructura{
            margin-left: 9rem;
            margin-top: -1rem
        }
        #logo_interna{
            margin-left: 5rem;
        }
        #logo_central{
            margin-top: -1.5rem;
            margin-left: 3rem;
            height: 10rem;
        }
        #logo_finanzas{
            margin-left: -2.5rem;
        }
        #logo_seguridad{
            margin-left: -2rem;
            margin-top: 1rem;
        }
        #logo_caja{
            margin-top: 10rem;
            height: 12rem;
        }
        #logo_manufactura{
            margin-top: 5rem;
            margin-left: -1rem;
        }
        #logo_tiendas{
            margin-top: 1rem
        }
    }
    .imagen_1{
        mix-blend-mode: multiply;
        position: absolute;
        filter: brightness(88%);
    }
    .card-text{
        z-index: 9;
        transition: opacity 1s ease; /* Transición para el texto */
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Sombra de texto */
    }
    .zoom-card:hover .imagen_1{
        filter: none;
        mix-blend-mode: unset;
    }
    .zoom-card:hover .card-text{
        opacity: 0;
    }

    i{
        color: #00b1f4;
    }
    .carousel-control-prev,
    .carousel-control-next {
        background-color: gray;
        border-radius: 50%;
        padding: 10px;
        height: 3rem;
        margin-top: 17rem;
    }

    /* Keyframes for sliding out */
    @keyframes sliderOutSection {
        0% {
            opacity: 1;
            transform: translateX(0);
        }
        100% {
            opacity: 0;
            transform: translateX(-30%);
        }
    }

    /* Keyframes for sliding in */
    @keyframes sliderIn {
        0% {
            opacity: 0;
            transform: translateX(30%);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }
    /* Apply animations to carousel items */
    .carousel-item {
        transition: transform 2s ease-in-out, opacity 2s ease-in-out;
        position: absolute;
        top: 0;
        left: 0;/*
        width: 300px;
        height: 100px;*/
    }
    .carousel-item-next, .carousel-item-prev, .carousel-item.active {
        opacity: 1;
        transform: translateX(0);
        position: relative;
    }

    .carousel-item-next.carousel-item-left,
    .carousel-item-prev.carousel-item-right {
        animation: sliderIn 2s forwards;
    }

    .carousel-item-left,
    .carousel-item-prev.carousel-item-right {
        animation: sliderOutSection 2s forwards;
    }
    .widget{
        border: none !important;
    }
    @media screen and (min-width: 2000px){
        /*.w-100{
            width: 90% !important;
        }*/
    }
    @media screen and (max-width: 835px) {
        #container{
            background-image: none !important;
        }
        .logo6{
            width: 7rem !important;
            margin-top: 0 !important;
        }
        .zoom-card{
            height: 7rem !important;
        }
        #logo_central{
            display: none;
        }
        /*#logo_seguridad{
            margin-top: 2rem;
        }*/
    }
    .titulo_slider{
        font-size: 36px;
        height: 4rem;
        font-weight: bold;
        line-height: 1;
        width: 23rem;
        margin-bottom: 0rem;
        text-transform: uppercase;
    }

    #carousel-caption{
        margin-left: -7%;
        height: 100%;
        top: 0;
    }

    @media screen and (max-width: 1050px) and (min-width: 800) {
        .mensaje_nuevo_slider{
            font-size: medium;
        }

        .titulo_slider{
            font-size: x-large;
        }

        #imagen_fondo_slider{
            height: 144px;
        }
    }
    @media screen and (max-width: 799px) {
        .titulo_slider{
            font-size: x-small;
            height: 1rem;
        }
        .mensaje_nuevo_slider{
            margin-top: 15%;
            font-size: xx-small;
            height: 1rem;
        }

        #carousel-caption{
            top: -40%;
        }
        #imagen_fondo_slider{
            height: 99px;
        }

        .badge{
            font-size: 10px;
        }

        .contenedorestilos{
            display: none;
        }
        #logo_comercial{
            margin-top: 1.5rem;
        }
        #logo_infraestructura{
            margin-top: 1.5rem;
        }
        #logo_interna{
            margin-top: 1.5rem;
        }
        #logo_finanzas{
            margin-top: 1.5rem;
        }
    }

    @media screen and (min-width: 1900px)  {
        #carousel-caption {
            margin-left: -7%;
            height: 100%;
            top: 0%;
        }
        .titulo_slider {
            font-size: 20px;
            height: 8rem;
            font-weight: bold;
            line-height: 1;
            width: 36rem;
            margin-bottom: 0rem;
            text-transform: uppercase;
        }

        .mensaje_nuevo_slider{
            color: #fa2b5c;
            margin-bottom: 0%;
            margin-left: 0.2rem;
            font-size: large;
            margin-top: 40rem;
        }

        .badge{
            font-size: 10px;
            /* width: 18%; */
        }
    }
</style>
<script>
    $(document).ready(function() {
        $("#inicio").addClass('active');
        $("#hinicio").attr('aria-expanded','true');
        cambiarClaseSegunResolucion();
    });
    function cambiarClaseSegunResolucion(){
        var ventanaAncho = $(window).width();
        console.log(ventanaAncho);
        if (350 < ventanaAncho && ventanaAncho <= 834) {
            $('#logo_logistica').removeClass('col-sm-8').addClass('col-sm-4 d-flex justify-content-center');
            $('#logo_comercial').removeClass('justify-content-end').addClass('justify-content-center');
            $('#logo_talento_humano').removeClass('col-sm-2').addClass('col-sm-4');
            $('#logo_infraestructura').removeClass('col-sm-3').addClass('col-sm-4 d-flex justify-content-center');
            $('#logo_interna').removeClass('col-sm-3 justify-content-end').addClass('col-sm-4 justify-content-center');
            $('#logo_central').removeClass('d-flex');
            $('#logo_finanzas').removeClass('col-sm-3 align-items-end').addClass('col-sm-4');
            $('#logo_seguridad').removeClass('col-sm-5 justify-content-end').addClass('col-sm-4 justify-content-center mt-4');
            $('#logo_caja').removeClass('col-sm-2').addClass('col-sm-4 mt-4');
            $('#logo_manufactura').removeClass('col-sm-2 align-items-start').addClass('col-sm-4 justify-content-center mt-4');
            $('#logo_tiendas').removeClass('col-sm-3 justify-content-start').addClass('col-sm-12 justify-content-center');
        }else{
            $('#logo_logistica').addClass('col-sm-8');
            $('#logo_comercial').addClass('justify-content-end');
            $('#logo_talento_humano').addClass('col-sm-2');
            $('#logo_infraestructura').addClass('col-sm-3');
            $('#logo_interna').addClass('col-sm-3 justify-content-end');
            $('#logo_central').addClass('d-flex');
            $('#logo_finanzas').addClass('col-sm-3 align-items-end');
            $('#logo_seguridad').addClass('col-sm-5 justify-content-end');
            $('#logo_caja').addClass('col-sm-2');
            $('#logo_manufactura').addClass('col-sm-2 align-items-start')
            $('#logo_tiendas').addClass('col-sm-3 justify-content-start')
        }
    }

    // Llama a la función al cargar la página
    cambiarClaseSegunResolucion();

    // Llama a la función en respuesta al cambio de tamaño de la ventana
    $(window).resize(cambiarClaseSegunResolucion);

    /*function validar_reporte_fotografico_dia_job_2(){
        Cargando();

        var url = "{{ url('ReporteFotografico/validar_reporte_fotografico_dia_job_2') }}";

        $.ajax({
            url: url,
            type: "GET",
            processData: false,
            contentType: false,
            success:function (data) {
                swal.fire(
                    '¡Registro Exitoso!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                });
            },
        });
    }*/
</script>
@endsection
