<?php
$base = Session('usuario')->centro_labores;
// print_r(Session::get('usuario'));
?>
<div class="toolbar d-flex">
    <?php
    //Cada coordinador le debe aparecer su base respectivamente definido
    $disabled = '';
    $selected = '';
    if ($base == 'OFC') {
        $disabled = '';
        $selected = 'selected';
    } else {
        $disabled = 'disabled';
    } ?>
    <div class="form-group col-md-4">
        <label>Base: </label>
        <select class="form-control basic" id="base" name="base" onchange="Reporte_Fotografico_Listar();"<?= $disabled ?>>
            <option value="0" <?= $selected ?>>TODOS</option>
                <?php foreach ($list_bases as $list) { ?>
                    <option value="<?php echo $list['cod_base']; ?>"
                    <?php
                        if ($list['cod_base'] == $base && $list['cod_base'] != 'OFC') {
                            echo "selected";
                        }
                    ?>>
                <?php echo $list['cod_base']; ?>
            </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>Area: </label>
        <select class="form-control basic" id="area" name="area" onchange="Reporte_Fotografico_Listar();">
            <option value="0" selected>TODOS</option>
            <?php foreach($list_area as $list){ ?>
                <option value="<?php echo $list['id_area']; ?>"><?php echo $list['nom_area']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>Codigo: </label>
        <select class="form-control basic" id="codigo_filtro" name="codigo_filtro" onchange="Reporte_Fotografico_Listar();">
            <option value="0">TODOS</option>
            <?php foreach ($list_codigos as $list) { ?>
                <option value="<?php echo $list['descripcion']; ?>">
                    <?php echo $list['descripcion']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>
@csrf
<div class="table-responsive mb-4 mt-4" id="lista">
</div>
<script>
    Imagenes_Listar();

    function Imagenes_Listar(){
        Cargando();
        var csrfToken = $('input[name="_token"]').val();
/*
        var base = $('#base').val();
        var area = $('#area').val();
        var codigo = $('#codigo_filtro').val();
        var url = "{{ url('Reporte_Fotografico_Listar') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'base': base,
                'area': area,
                'codigo': codigo
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#lista').html(data);
            }
        });*/
    }
</script>
