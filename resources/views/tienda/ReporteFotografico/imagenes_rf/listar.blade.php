<?php //print_r($list_rf[0]); ?>
<?php foreach($list_rf as $row){ ?>
    <div class="card text-center" style="width: 18rem;">
        <img src="https://lanumerounocloud.com/intranet/REPORTE_FOTOGRAFICO/<?= $row['foto'] ?>?t=<?= time() ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= $row['descripcion'] ?></h5>
            <p class="card-text"><?= $row['fec_reg'] ?></p>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Modal_Detalle_RF/'.$row['id'])}}" class="btn btn-primary">Detalles</a>
        </div>
    </div>
<?php } ?>