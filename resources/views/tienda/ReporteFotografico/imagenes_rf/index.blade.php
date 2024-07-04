<?php
$base = Session('usuario')->centro_labores;
// print_r(Session::get('usuario'));
?>
<div class="toolbar d-flex mt-4">
    <?php
    //Cada coordinador le debe aparecer su base respectivamente definido
    $disabled = '';
    $selected = '';
    if ($base == 'OFC' || Session('usuario')->id_puesto == 251 || Session('usuario')->id_puesto == 131 || Session('usuario')->id_puesto == 144 || Session('usuario')->id_puesto == 74 || Session('usuario')->id_puesto == 73 || Session('usuario')->id_puesto == 41) {
        $disabled = '';
        $selected = 'selected';
    } else {
        $disabled = 'disabled';
    } ?>
    <div class="form-group col-md-4">
        <label>Base: </label>
        <select class="form-control basic" id="base" name="base" onchange="Imagenes_Listar();" <?= $disabled ?>>
            <option value="0" <?= $selected ?>>TODOS</option>
            <?php foreach ($list_bases as $list) { ?>
                <option value="<?php echo $list->cod_base; ?>" <?php
                                                                    if ($list->cod_base == $base && $list->cod_base != 'OFC') {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>
                    <?php echo $list->cod_base; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>Categorias: </label>
        <select class="form-control basic_i" id="categoria_filtro" name="categoria_filtro" onchange="Imagenes_Listar();">
            <option value="0">TODOS</option>
            <?php foreach($list_categorias as $list){ ?>
                <option value="<?php echo $list['id']; ?>"><?php echo $list['categoria']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>Fecha: </label>
        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" onchange="Imagenes_Listar();" max="{{$today}}">
    </div>
</div>
@csrf
<div id="lista" class="p-2 row ml-2">
</div>
<script>
    Imagenes_Listar();

    function Imagenes_Listar(){
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var base = $('#base').val();
        var categoria = $('#categoria_filtro').val();
        var fecha = $('#fecha_filtro').val();
        var url = "{{ url('Listar_Imagenes_Reporte_Fotografico') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'base': base,
                'categoria': categoria,
                'fecha' : fecha,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#lista').html(data);
            }
        });
    }
    $('.basic').select2({});
</script>
