<?php 
$list_count = count($list_rf); // Total de elementos
foreach ($list_rf as $index => $row) {
    $prev_id = ($index > 0) ? $list_rf[$index - 1]['id'] : 0; // ID anterior (si existe)
    $next_id = ($index < $list_count - 1) ? $list_rf[$index + 1]['id'] : 0; // ID posterior (si existe)
?>
    <div class="card text-center" style="width: 18rem;">
        <a href="javascript:void(0);" 
            id="detalle_{{$row['id']}}"
            data-toggle="modal" 
            data-target="#ModalUpdate" 
            app_elim="<?= url('Modal_Detalle_RF/'.$row['id']. '/'. $prev_id. '/' .$next_id) ?>" 
            class="btn btn-primary p-0">
            <img src="https://lanumerounocloud.com/intranet/REPORTE_FOTOGRAFICO/<?= $row['foto'] ?>?t=<?= time() ?>" class="card-img-top" alt="..." app_detalle="<?= url('ReporteFotografico/Modal_Slider') ?>">
        </a>
        <div class="card-body">
            <h5 class="card-title"><?= $row['descripcion'] ?></h5>
            <p class="card-text"><?= $row['fec_reg'] ?></p>
            <a href="javascript:void(0);" 
                id="detalle_{{$row['id']}}"
                data-toggle="modal" 
                data-target="#ModalUpdate" 
                app_elim="<?= url('Modal_Detalle_RF/'.$row['id']. '/'. $prev_id. '/' .$next_id) ?>" 
                class="btn btn-primary">
                Detalles
            </a>
        </div>
    </div>
<?php } ?>
<script>/*
    $(document).on('click', '.open-modal', function() {
        var currentId = $(this).attr('app_elim').split('/').pop();
        var prevId = $(this).data('prev-id');
        var nextId = $(this).data('next-id');

        console.log(prevId);
        console.log(currentId);
        console.log(nextId);
        
        $('#ModalUpdate').data('prev-id', prevId);
        $('#ModalUpdate').data('next-id', nextId);
    });*/
</script>