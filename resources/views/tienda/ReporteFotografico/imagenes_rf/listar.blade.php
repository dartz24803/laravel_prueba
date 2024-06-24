
<?php foreach($list_rf as $row){ ?>
    <div class="card text-center" style="width: 18rem;">
        <img src="https://lanumerounocloud.com/intranet/REPORTE_FOTOGRAFICO/<?= $row['foto'] ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= $row['codigo'] ?></h5>
            <p class="card-text"><?= $row['tipo'] ?></p>
            <a href="{{ url('Modal_Detalle/')}}" class="btn btn-primary">Detalles</a>
        </div>
    </div>
<?php } ?>
