<form id="formulario_horario_e" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Horario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>     
    
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <?php if($funciona>0){ ?>
            <div class="col-md-12 row">
                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Nombre: </label>
                    <div class="">
                        <input type="text" class="form-control" value="<?php echo $get_id[0]['nombre'] ?>" readonly>       
                    </div>
                </div>  

                <div class="form-group col-md-12">
                    <label class="control-label text-bold">Días Laborados: </label>
                </div>

                <div class="form-group col-md-12">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <?php $lunes="style='display:none'";$martes="style='display:none'";$miercoles="style='display:none'";$jueves="style='display:none'";$viernes="style='display:none'";$sabado="style='display:none'";$domingo="style='display:none'";
                        $busq_detalle = $get_detalle->contains('dia', '1');
                        $posicion = $get_detalle->search(fn($item) => $item->dia == '1');

                        if ($busq_detalle) { 
                            $lunes = "style='display:block'"; 
                        }
                        ?>
                        <input type="checkbox" class="new-control-input"  id="ch_lunese" name="ch_lunese" <?php if ($busq_detalle != false) {echo "checked";} ?> value="1" disabled>
                        <input type="hidden" id="id_lunes" name="id_lunes" value="<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                        <span class="new-control-indicator"></span> &nbsp;  Lunes
                    </label>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <?php
                        $busq_detalle = $get_detalle->contains('dia', '2');
                        $posicion = $get_detalle->search(fn($item) => $item->dia == '2');

                        if ($busq_detalle) { 
                            $martes = "style='display:block'"; 
                        }
                        ?>
                        <input type="checkbox" class="new-control-input"  id="ch_martese" name="ch_martese" <?php if ($busq_detalle != false) {echo "checked";} ?> value="1" disabled>
                        <input type="hidden" id="id_martes" name="id_martes" value="<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                        <span class="new-control-indicator"></span> &nbsp;  Martes
                    </label>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <?php
                        $busq_detalle = $get_detalle->contains('dia', '3');
                        $posicion = $get_detalle->search(fn($item) => $item->dia == '3');

                        if ($busq_detalle) { 
                            $miercoles = "style='display:block'"; 
                        }
                        ?>
                        <input type="checkbox" class="new-control-input"  id="ch_miercolese" name="ch_miercolese" <?php if ($busq_detalle != false) {echo "checked";} ?> value="1" disabled>
                        <input type="hidden" id="id_miercoles" name="id_miercoles" value="<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                        <span class="new-control-indicator"></span> &nbsp;  Miércoles
                    </label>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <?php
                        $busq_detalle = $get_detalle->contains('dia', '4');
                        $posicion = $get_detalle->search(fn($item) => $item->dia == '4');
                        if ($busq_detalle != false){ $jueves="style='display:block'"; }?>
                        <input type="checkbox" class="new-control-input"  id="ch_juevese" name="ch_juevese" <?php if ($busq_detalle != false) {echo "checked";} ?> value="1" disabled>
                        <input type="hidden" id="id_jueves" name="id_jueves" value="<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                        <span class="new-control-indicator"></span> &nbsp;  Jueves
                    </label>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <?php
                        $busq_detalle = $get_detalle->contains('dia', '5');
                        $posicion = $get_detalle->search(fn($item) => $item->dia == '5');
                        if ($busq_detalle != false){ $viernes="style='display:block'"; }?>
                        <input type="checkbox" class="new-control-input"  id="ch_viernese" name="ch_viernese" <?php if ($busq_detalle != false) {echo "checked";} ?> value="1" disabled>
                        <input type="hidden" id="id_viernes" name="id_viernes" value="<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                        <span class="new-control-indicator"></span> &nbsp;  Viernes
                    </label>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <?php 
                        $busq_detalle = $get_detalle->contains('dia', '6');
                        $posicion = $get_detalle->search(fn($item) => $item->dia == '6');
                        if ($busq_detalle != false){ $sabado="style='display:block'"; }?>
                        <input type="checkbox" class="new-control-input"  id="ch_sabadoe" name="ch_sabadoe" <?php if ($busq_detalle != false) {echo "checked";} ?> value="1" disabled>
                        <input type="hidden" id="id_sabado" name="id_sabado" value="<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                        <span class="new-control-indicator"></span> &nbsp;  Sábado
                    </label>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <?php
                        $busq_detalle = $get_detalle->contains('dia', '7');
                        $posicion = $get_detalle->search(fn($item) => $item->dia == '7');
                        if ($busq_detalle != false){ $domingo="style='display:block'"; }?>
                        <input type="checkbox" class="new-control-input"  id="ch_domingoe" name="ch_domingoe" <?php if ($busq_detalle != false) {echo "checked";} ?> value="1" disabled>
                        <input type="hidden" id="id_domingo" name="id_domingo" value="<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                        <span class="new-control-indicator"></span> &nbsp;  Domingo
                    </label>
                </div>
            </div>

            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Conf. Básica</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Almuerzo</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-md-12 row">&nbsp;<br>&nbsp;</div>
                    <div class="col-md-12 row" >
                        <div class="form-group col-md-2" id="div_lunes1e" <?php echo $lunes ?>>
                            <label class=" control-label text-bold">Lunes: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_lunes2e" <?php echo $lunes ?>>
                            <div id="nonLinearLunese"></div>
                            <div class="row mt-4 mb-4">
                            
                                <input type="hidden" name="hora_entrada_le" id="hora_entrada_le" >
                                <input type="hidden" name="hora_salida_le" id="hora_salida_le">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_martes1e" <?php echo $martes ?>>
                            <label class=" control-label text-bold">Martes: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_martes2e" <?php echo $martes ?>>
                            <div id="nonLinearMartese"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_entrada_mae" id="hora_entrada_mae">
                                <input type="hidden" name="hora_salida_mae" id="hora_salida_mae">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_miercoles1e" <?php echo $miercoles ?>>
                            <label class=" control-label text-bold">Miércoles: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_miercoles2e" <?php echo $miercoles ?>>
                            <div id="nonLinearMiercolese"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_entrada_mie" id="hora_entrada_mie">
                                <input type="hidden" name="hora_salida_mie" id="hora_salida_mie">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_jueves1e" <?php echo $jueves ?>>
                            <label class=" control-label text-bold">Jueves: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_jueves2e" <?php echo $jueves ?>>
                            <div id="nonLinearJuevese"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_entrada_jue" id="hora_entrada_jue">
                                <input type="hidden" name="hora_salida_jue" id="hora_salida_jue">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_viernes1e" <?php echo $viernes ?>>
                            <label class=" control-label text-bold">Viernes: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_viernes2e" <?php echo $viernes ?>>
                            <div id="nonLinearViernese"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_entrada_ve" id="hora_entrada_ve">
                                <input type="hidden" name="hora_salida_ve" id="hora_salida_ve">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_sabado1e" <?php echo $sabado ?>>
                            <label class=" control-label text-bold">Sábado: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_sabado2e" <?php echo $sabado ?>>
                            <div id="nonLinearSabadoe"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_entrada_se" id="hora_entrada_se">
                                <input type="hidden" name="hora_salida_se" id="hora_salida_se">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_domingo1e" <?php echo $domingo ?>>
                            <label class=" control-label text-bold">Domingo: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_domingo2e" <?php echo $domingo ?>>
                            <div id="nonLinearDomingoe"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_entrada_de" id="hora_entrada_de">
                                <input type="hidden" name="hora_salida_de" id="hora_salida_de">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="col-md-12 row">&nbsp;<br>&nbsp;</div>
                    <div class="col-md-12 row" >
                        <div class="form-group col-md-2" id="div_lunes3e" <?php echo $lunes ?>>
                            <label class=" control-label text-bold">Lunes: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_lunes4e" <?php echo $lunes ?>>
                            <div id="nonLinearLunes_descansoe"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_edescanso_le" id="hora_edescanso_le">
                                <input type="hidden" name="hora_sdescanso_le" id="hora_sdescanso_le">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_martes3e" <?php echo $martes ?>>
                            <label class=" control-label text-bold">Martes: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_martes4e" <?php echo $martes ?>>
                            <div id="nonLinearMartes_descansoe"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_edescanso_mae" id="hora_edescanso_mae">
                                <input type="hidden" name="hora_sdescanso_mae" id="hora_sdescanso_mae">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_miercoles3e" <?php echo $miercoles ?>>
                            <label class=" control-label text-bold">Miercoles: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_miercoles4e" <?php echo $miercoles ?>>
                            <div id="nonLinearMiercoles_descansoe"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_edescanso_mie" id="hora_edescanso_mie">
                                <input type="hidden" name="hora_sdescanso_mie" id="hora_sdescanso_mie">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_jueves3e" <?php echo $jueves ?>>
                            <label class=" control-label text-bold">Jueves: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_jueves4e" <?php echo $jueves ?>>
                            <div id="nonLinearJueves_descansoe"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_edescanso_jue" id="hora_edescanso_jue">
                                <input type="hidden" name="hora_sdescanso_jue" id="hora_sdescanso_jue">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_viernes3e" <?php echo $viernes ?>>
                            <label class=" control-label text-bold">Viernes: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_viernes4e" <?php echo $viernes ?>>
                            <div id="nonLinearViernes_descansoe"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_edescanso_ve" id="hora_edescanso_ve">
                                <input type="hidden" name="hora_sdescanso_ve" id="hora_sdescanso_ve">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_sabado3e" <?php echo $sabado ?>>
                            <label class=" control-label text-bold">Sábado: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_sabado4e" <?php echo $sabado ?>>
                            <div id="nonLinearSabado_descansoe"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_edescanso_se" id="hora_edescanso_se">
                                <input type="hidden" name="hora_sdescanso_se" id="hora_sdescanso_se">
                            </div>
                        </div>
                        <div class="form-group col-md-2" id="div_domingo3e" <?php echo $domingo ?>>
                            <label class=" control-label text-bold">Domingo: </label>
                        </div>
                        <div class="form-group col-md-10 container" id="div_domingo4e" <?php echo $domingo ?>>
                            <div id="nonLinearDomingo_descansoe"></div>
                            <div class="row mt-4 mb-4">
                                <input type="hidden" name="hora_edescanso_de" id="hora_edescanso_de">
                                <input type="hidden" name="hora_sdescanso_de" id="hora_sdescanso_de">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }else{ ?>
            <div class="col-md-12 row">
                <div class="form-group col-md-4">
                    <label class="control-label text-bold">No tiene horario asignado para su base.</label>
                </div>  
            </div>
        <?php } ?>
    </div>

    <div class="modal-footer">
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<style>
.noUi-connect {
    background: #4361ee !important;
}
</style>
@if($funciona>0)
<script>
    //lunes
    <?php
        $busq_detalle = $get_detalle->contains('dia', '1');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '1');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_entrada']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_salida']; }else{echo "18";} ?>';
        
    var nonLinearLunese = document.getElementById('nonLinearLunese');
    noUiSlider.create(nonLinearLunese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +  minutes.toString().padStart(2, '0');
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
            
            
        }
        
    });

    nonLinearLunese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_le').val(values[0]);
        $('#hora_salida_le').val(values[1]);
    });

    //martes
    <?php 
        $busq_detalle = $get_detalle->contains('dia', '2');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '2');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_entrada']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_salida']; }else{echo "18";} ?>';
    var nonLinearMartese = document.getElementById('nonLinearMartese');
    noUiSlider.create(nonLinearMartese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearMartese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_mae').val(values[0]);
        $('#hora_salida_mae').val(values[1]);
    });
    //miercoles
    <?php
        $busq_detalle = $get_detalle->contains('dia', '3');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '3');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_entrada']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_salida']; }else{echo "18";} ?>';
    var nonLinearMiercolese = document.getElementById('nonLinearMiercolese');
    noUiSlider.create(nonLinearMiercolese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearMiercolese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_mie').val(values[0]);
        $('#hora_salida_mie').val(values[1]);
    });
    //jueves
    <?php
        $busq_detalle = $get_detalle->contains('dia', '4');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '4');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_entrada']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_salida']; }else{echo "18";} ?>';
    var nonLinearJuevese = document.getElementById('nonLinearJuevese');
    noUiSlider.create(nonLinearJuevese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearJuevese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_jue').val(values[0]);
        $('#hora_salida_jue').val(values[1]);
    });
    //viernes
    <?php
        $busq_detalle = $get_detalle->contains('dia', '5');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '5');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_entrada']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_salida']; }else{echo "18";} ?>';
    var nonLinearViernese = document.getElementById('nonLinearViernese');
    noUiSlider.create(nonLinearViernese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearViernese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_ve').val(values[0]);
        $('#hora_salida_ve').val(values[1]);
    });
    //sabado
    <?php
        $busq_detalle = $get_detalle->contains('dia', '6');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '6');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_entrada']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_salida']; }else{echo "18";} ?>';
    var nonLinearSabadoe = document.getElementById('nonLinearSabadoe');
    noUiSlider.create(nonLinearSabadoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearSabadoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_se').val(values[0]);
        $('#hora_salida_se').val(values[1]);
    });
    //domingo
    <?php
        $busq_detalle = $get_detalle->contains('dia', '7');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '7');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_entrada']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_salida']; }else{echo "18";} ?>';
    var nonLinearDomingoe = document.getElementById('nonLinearDomingoe');
    noUiSlider.create(nonLinearDomingoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearDomingoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_de').val(values[0]);
        $('#hora_salida_de').val(values[1]);
    });

    //descanso
    //lunes
    <?php
        $busq_detalle = $get_detalle->contains('dia', '1');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '1');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_e']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_s']; }else{echo "18";} ?>';
    var nonLinearLunes_descansoe = document.getElementById('nonLinearLunes_descansoe');
    noUiSlider.create(nonLinearLunes_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +  minutes.toString().padStart(2, '0');
                
                //$('#hora_entrada_l').val(desde_l);
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
            
            
        }
        
    });

    nonLinearLunes_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_edescanso_le').val(values[0]);
        $('#hora_sdescanso_le').val(values[1]);
    });

    //martes
    <?php
        $busq_detalle = $get_detalle->contains('dia', '2');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '2');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_e']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_s']; }else{echo "18";} ?>';
    var nonLinearMartes_descansoe = document.getElementById('nonLinearMartes_descansoe');
    noUiSlider.create(nonLinearMartes_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearMartes_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_edescanso_mae').val(values[0]);
        $('#hora_sdescanso_mae').val(values[1]);
    });
    //miercoles
    <?php
        $busq_detalle = $get_detalle->contains('dia', '3');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '3');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_e']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_s']; }else{echo "18";} ?>';
    var nonLinearMiercoles_descansoe = document.getElementById('nonLinearMiercoles_descansoe');
    noUiSlider.create(nonLinearMiercoles_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearMiercoles_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_edescanso_mie').val(values[0]);
        $('#hora_sdescanso_mie').val(values[1]);
    });
    //jueves
    <?php
        $busq_detalle = $get_detalle->contains('dia', '4');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '4');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_e']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_s']; }else{echo "18";} ?>';
    var nonLinearJueves_descansoe = document.getElementById('nonLinearJueves_descansoe');
    noUiSlider.create(nonLinearJueves_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearJueves_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_edescanso_jue').val(values[0]);
        $('#hora_sdescanso_jue').val(values[1]);
    });
    //viernes
    <?php
        $busq_detalle = $get_detalle->contains('dia', '5');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '5');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_e']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_s']; }else{echo "18";} ?>';
    var nonLinearViernes_descansoe = document.getElementById('nonLinearViernes_descansoe');
    noUiSlider.create(nonLinearViernes_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearViernes_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_edescanso_ve').val(values[0]);
        $('#hora_sdescanso_ve').val(values[1]);
    });
    //sabado
    <?php
        $busq_detalle = $get_detalle->contains('dia', '6');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '6');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_e']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_s']; }else{echo "18";} ?>';
    var nonLinearSabado_descansoe = document.getElementById('nonLinearSabado_descansoe');
    noUiSlider.create(nonLinearSabado_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearSabado_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_edescanso_se').val(values[0]);
        $('#hora_sdescanso_se').val(values[1]);
    });
    //domingo
    <?php
        $busq_detalle = $get_detalle->contains('dia', '9');
        $posicion = $get_detalle->search(fn($item) => $item->dia == '9');
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_e']; }else{echo "8";} ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['hora_descanso_s']; }else{echo "18";} ?>';
    var nonLinearDomingo_descansoe = document.getElementById('nonLinearDomingo_descansoe');
    noUiSlider.create(nonLinearDomingo_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 20 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearDomingo_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_edescanso_de').val(values[0]);
        $('#hora_sdescanso_de').val(values[1]);
    });

    // Seleccionar todos los elementos con la clase 'noUi-horizontal'
    var elements = document.getElementsByClassName('noUi-horizontal');

    // Iterar sobre cada elemento y establecer el atributo 'disabled'
    for (var i = 0; i < elements.length; i++) {
        elements[i].setAttribute('disabled', true);
    }
</script>
@endif