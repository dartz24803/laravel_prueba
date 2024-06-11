<?php 
use Illuminate\Support\Facades\Session;

$base = Session::get('usuario')->base;

//Cada coordinador le debe aparecer su base respectivamente definido
$disabled = '';
if ($base == 'OFC') {
    $disabled = '';
} else {
    $disabled = 'disabled';
} ?>
<div class="toolbar d-flex">
    <div class="form-group col-md-2">
        <label>Base: </label>
        <select class="form-control basic" id="base" name="base" onchange="Lista_Cuadro_Control_Visual();">
            <?php foreach ($list_bases as $list) { ?>
                <option value="<?php echo $list['cod_base']; ?>" <?php if ($list['cod_base'] == 'B03') {
                                                                        echo "selected";
                                                                    } ?>>
                    <?php echo $list['cod_base']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>
@csrf
<div class="table-responsive mb-4" id="lista_cuadro_control_visual">
</div>

<script>
    Lista_Cuadro_Control_Visual();

    function Lista_Cuadro_Control_Visual() {
        Cargando();

        var base = $('#base').val();
        var url = "{{ url('Lista_Cuadro_Control_Visual') }}";
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
<style>
    #tabla_js_length, #tabla_js_info{
        padding: 1rem;
    }
</style>