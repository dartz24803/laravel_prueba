@extends('layouts.plantilla')

@section('content')
<?php 
$id_puesto = Session('usuario')->id_puesto;
$base = Session('usuario')->centro_labores; 
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Cuadro de Control Visual</h3>
            </div>
        </div>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6 p-2">
                    <div class="toolbar d-flex">
                        <?php
                        //Cada coordinador le debe aparecer su base respectivamente definido
                        $disabled = '';
                        if ($base == 'OFC') {
                            $disabled = '';
                        } else {
                            $disabled = 'disabled';
                        } ?>
                        <div class="form-group col-md-2">
                            <label>Base: </label>
                            <select class="form-control basic" id="base" name="base" onchange="Lista_Cuadro_Control_Visual();" <?php echo $disabled?>>
                                    <?php foreach ($list_bases as $list) { ?>
                                        <option value="<?php echo $list->cod_base; ?>" <?php if ($list->cod_base == 'B03') {
                                                                            echo "selected";
                                                                        } ?>>
                                    <?php echo $list->cod_base; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-10">
                            <div class="card d-flex align-items-center" style="height: 67%;">
                                <strong class="text-center" style="font-size: small; height: auto; margin-top: 13px">LEYENDA</strong>
                                <div class="row h-50 d-flex justify-content-between">
                                    <div class="col-md-1">
                                        <p class="card-text d-flex align-items-center" style="font-size: x-small;"><span class="dot" style="color: #68f76d; margin-right: 5px; font-size:xx-large">&#8226;</span> Presente</p>
                                    </div>
                                    <div class="col-md-1">
                                        <p class="card-text d-flex align-items-center" style="font-size: x-small;"><span class="dot" style="color: #f7cd11; margin-right: 5px; font-size:xx-large">&#8226;</span> Break</p>
                                    </div>
                                    <div class="col-md-1">
                                        <p class="card-text d-flex align-items-center" style="font-size: x-small;"><span class="dot" style="color: #fa5c5c; margin-right: 5px; font-size:xx-large">&#8226;</span> Faltó</p>
                                    </div>
                                    <div class="col-md-1">
                                        <p class="card-text d-flex align-items-center" style="font-size: x-small;"><span class="dot" style="color: #6376ff; margin-right: 5px; font-size:xx-large">&#8226;</span> Libre</p>
                                    </div>
                                    <div class="col-md-1">
                                        <p class="card-text d-flex align-items-center" style="font-size: x-small;"><span class="dot" style="color: gray; margin-right: 5px; font-size:xx-large">&#8226;</span> Vacante</p>
                                    </div>
                                    <div class="col-md-1">
                                        <p class="card-text d-flex align-items-center" style="font-size: x-small;"><span class="dot" style="color: #00b1f4; margin-right: 5px; font-size:xx-large">&#8226;</span> Permiso</p>
                                    </div>
                                    <div class="col-md-1">
                                        <p class="card-text d-flex align-items-center" style="font-size: x-small;"><span class="dot" style="color: #FFA700; margin-right: 5px; font-size:xx-large">&#8226;</span> Almuerzo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="table-responsive mb-4" id="lista_cuadro_control_visual">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#tienda").addClass('active');
        $("#htienda").attr('aria-expanded', 'true');
        $("#cuadrocontrolvisual").addClass('active');

        Lista_Cuadro_Control_Visual();

        setInterval(Lista_Cuadro_Control_Visual, 10000);
    });

    function Lista_Cuadro_Control_Visual() {
        // Cargando();

        var base = $('#base').val();
        var url = "{{ url('Lista_Cuadro_Control_Visual_Vista') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'base': base
            },
            success: function(data) {
                $('#lista_cuadro_control_visual').html(data);
            }
        });
    }
    
</script>
@endsection