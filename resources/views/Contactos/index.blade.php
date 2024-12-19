@extends('layouts.plantilla')

@section('navbar')
@endsection

@section('content')
{{-- <link href="{{ asset('template/assets/css/elements/search.css') }}" rel="stylesheet" type="text/css" /> --}}
<link href="{{ asset('template/assets/css/apps/contacts.css') }}" rel="stylesheet" type="text/css" />
<style>
    svg.warning {
        color: #e2a03f;
        fill: rgba(233, 176, 43, 0.19);

    }

    svg.primary {
        color: #2196f3;
        fill: rgba(33, 150, 243, 0.19);

    }

    svg.danger {
        color: #e7515a;
        fill: rgba(231, 81, 90, 0.19);

    }

    .pegadoleft {
        padding-left: 0px !important
    }

    .profile-img img {
        border-radius: 6px;
        background-color: #ebedf2;
        padding: 2px;
        width: 35px;
        height: 35px;
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-spacing layout-top-spacing" id="cancel-row">
            <div class="col-lg-12">
                <div class="widget-content searchable-container grid">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center">
                            <form class="form-inline my-2 my-lg-0">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                    <input type="text" class="form-control product-search" id="input-search" placeholder="Buscar Contacto...">
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                            <div class="d-flex justify-content-sm-end justify-content-center">

                                <div class="switch align-self-center" style="width: 100%;height: 100%;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list view-list">
                                        <line x1="8" y1="6" x2="21" y2="6"></line>
                                        <line x1="8" y1="12" x2="21" y2="12"></line>
                                        <line x1="8" y1="18" x2="21" y2="18"></line>
                                        <line x1="3" y1="6" x2="3" y2="6"></line>
                                        <line x1="3" y1="12" x2="3" y2="12"></line>
                                        <line x1="3" y1="18" x2="3" y2="18"></line>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid view-grid active-view">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="searchable-items grid">
                        <div class="items items-header-section">
                            <div class="item-content">
                                <div class="user-profile">
                                    <h4>Colaborador</h4>
                                </div>
                                <div class="user-email">
                                    <h4 style="font-weight: 600">Área</h4>
                                </div>
                                <div class="user-phone">
                                    <h4>Celular</h4>
                                </div>
                                <div class="user-phone">
                                    <h4 style="margin-left: 0;">Telefono Corporativo</h4>
                                </div>
                                <div class="user-phone">
                                    <h4 style="margin-left: 3px;">Anexo</h4>
                                </div>
                                <div class="user-email">
                                    <h4 style="margin-left: 3px;">Correo Corp</h4>
                                </div>
                            </div>
                        </div>

                        <?php foreach ($list_directorio_telefonico as $list) {  ?>
                            <div class="items">
                                <div class="item-content">
                                    <div class="user-profile">
                                        <img onclick="Vista_Imagen_Perfil('<?php echo $list['foto'] ?>','<?php echo $list['usuario_nombres'] ?>');" style="object-fit: cover;width:90px;height:90px;" src="<?php
                                                                                                                                                                                                            if (isset($list['foto'])) {
                                                                                                                                                                                                                echo $list['foto'];
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                echo base_url() . 'template/assets/img/90x90.jpg';
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?>" alt="avatar">
                                        <div class="user-meta-info">
                                            <p class="user-name" data-name="Alan Green"><?php echo $list['usuario_nombres']; ?></p>
                                            <p class="user-name" data-name="Alan Green"><?php echo $list['usuario_apater'] . " " . $list['usuario_amater']; ?></p>
                                            <p class="user-name" data-occupation="Web Developer"><?php echo $list['centro_labores']; ?></p>
                                            <p class="user-work" data-occupation="Web Developer"><?php echo $list['nom_puesto']; ?></p>
                                        </div>
                                    </div>
                                    <div class="user-email">
                                        <p class="info-title">Área: </p>
                                        <p class="usr-ph-no"><?php echo $list['nom_area']; ?> </p>
                                    </div>
                                    <div class="user-phone">
                                        <p class="info-title">Celular Corporativo: </p>
                                        <p class="usr-ph-no"><a href="https://api.whatsapp.com/send?phone=51<?php echo $list['num_cele'] ?>&text=hola,%20<?php echo $list['usuario_nombres']; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="24px" height="24px" fill-rule="evenodd" clip-rule="evenodd">
                                                    <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z" />
                                                    <path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z" />
                                                    <path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z" />
                                                    <path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z" />
                                                    <path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd" />
                                                </svg></a><a href="tel:+51<?php echo $list['num_cele'] ?>"><?php echo $list['num_cele']; ?></a></p>
                                    </div>
                                    <div class="user-phone">
                                        <p class="info-title">Teléfono Corporativo: </p>
                                        <p class="usr-ph-no"><?php echo $list['num_fijoe']; ?></p>
                                    </div>
                                    <div class="user-phone">
                                        <p class="info-title">Anexo: </p>
                                        <p class="usr-ph-no"><?php echo $list['num_anexoe']; ?> </p>
                                    </div>
                                    <div class="user-email">
                                        <p class="info-title">Correo Corporativo: </p>
                                        <p class="usr-email-addr" style="width: 160px; word-wrap: break-word; overflow-wrap: break-word; margin-bottom: 4px;" onkeyup="javascript:this.value=this.value.toLowerCase();"><?php echo $list['emailp']; ?> </p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade profile-modal" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="modal-header justify-content-center" id="profileModalLabel">
                <div class="modal-profile">
                    <img style="border-radius: 100% !important;height: 200px;width: 200px;object-fit: cover;" id="modalImgs" alt="avatar" src="assets/img/90x90.jpg" class="rounded-circle">
                </div>
            </div>
            <div class="modal-body text-center">
                <p style="word-break: break-all;" id="modelTitle" class="mt-2"></p>
            </div>

            <div class="modal-footer justify-content-center mb-4" id="descargarcertificado_estudiog">
            </div>
            <div align="center"></div>

        </div>
    </div>
</div>


<script>
    /***********primero tooltip */
    var anchors = document.querySelectorAll('.anchor-tooltip');
    anchors.forEach(function(anchor) {
        var toolTipText = anchor.getAttribute('title'),
            toolTip = document.createElement('span');
        toolTip.className = 'title-tooltip';
        toolTip.innerHTML = toolTipText;
        anchor.appendChild(toolTip);
    });
    /***********primero tooltip. */


    $('.buttonDownload[download]').each(function() {
        var $a = $(this),
            fileUrl = $a.attr('href');
        $a.attr('href', 'data:application/octet-stream,' + encodeURIComponent(fileUrl));
    });

    $(document).ready(function() {
        $("#contactos").addClass('active');
        $("#hcontacto").attr('aria-expanded', 'true');
    });

    function Vista_Imagen_Perfil(image_url, imageTitle) {
        $('#modelTitle').html(imageTitle);
        $('#modalImgs').attr('src', image_url);
        $('#profileModal').modal('show');
        //var nombredeusu= $("#id_usuarioactual").val();
        var nombredeusu = 'p';
        document.getElementById("descargarcertificado_estudiog").innerHTML = "<a href='" + image_url + "' id='imga' class='btn buttonDownload' download='qr_" + nombredeusu + ".jpg'>Descargar</a>"

    }

    $(document).ready(function() {

        checkall('contact-check-all', 'contact-chkbox');

        $('#input-search').on('keyup', function() {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable-items .items:not(.items-header-section)').hide();
            $('.searchable-items .items:not(.items-header-section)').filter(function() {
                return rex.test($(this).text());
            }).show();
        });
    });

    $('.view-grid').on('click', function(event) {
        event.preventDefault();
        /* Act on the event */

        $(this).parents('.switch').find('.view-list').removeClass('active-view');
        $(this).addClass('active-view');

        $(this).parents('.searchable-container').removeClass('list');
        $(this).parents('.searchable-container').addClass('grid');

        $(this).parents('.searchable-container').find('.searchable-items').removeClass('list');
        $(this).parents('.searchable-container').find('.searchable-items').addClass('grid');

        $('.user-email').removeClass('col-2');
        $('.user-profile').removeClass('col-3');
        $('.user-phone').removeClass('col-1');
        $('.item-content').removeClass('col-12');
    });

    $('.view-list').on('click', function(event) {
        event.preventDefault();
        /* Act on the event */
        $(this).parents('.switch').find('.view-grid').removeClass('active-view');
        $(this).addClass('active-view');

        $(this).parents('.searchable-container').removeClass('grid');
        $(this).parents('.searchable-container').addClass('list');

        $(this).parents('.searchable-container').find('.searchable-items').removeClass('grid');
        $(this).parents('.searchable-container').find('.searchable-items').addClass('list');

        $('.user-phone').addClass('col-1');
        $('.user-email').addClass('col-2');
        $('.user-profile').addClass('col-3');
        $('.item-content').addClass('col-12');
    });
</script>

@endsection