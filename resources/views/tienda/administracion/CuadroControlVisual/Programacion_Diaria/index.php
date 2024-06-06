<div class="d-flex justify-content-between align-items-center">
    <div class="form-group col-lg-2">
        <label>Base: </label>
        <select class="form-control basic" id="base" name="base" onchange="Lista_Programacion_Diaria();">
            <option value="0">Todas</option>
            <?php foreach ($list_bases as $list) { ?>
                <option value="<?php echo $list['cod_base']; ?>">
                    <?php echo $list['cod_base']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-lg-10 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="<?= site_url('Tienda/Modal_Programacion_Diaria') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Registrar
        </button>
    </div>
</div>

<div class="table-responsive mb-4 mt-4" id="lista_programacion_diaria">
</div>

<script>
    Lista_Programacion_Diaria();

    function Lista_Programacion_Diaria() {
        Cargando();

        var base = $('#base').val();
        var url = "<?php echo site_url(); ?>Tienda/Lista_Programacion_Diaria";

        $.ajax({
            url: url,
            type: "POST",
            data: {'base': base},
            success: function(resp) {
                $('#lista_programacion_diaria').html(resp);
            }
        });
    }
</script>