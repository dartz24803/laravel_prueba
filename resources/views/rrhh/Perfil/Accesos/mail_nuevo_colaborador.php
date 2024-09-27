<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>
        <div class="card-text">Estimado equipo de Soporte TI,</div><br>
        <div class="card-text">Su apoyo para crearle usuario de PC y correo al siguiente ingreso:</div><br>
        <div class="table-responsive">
            <table class="table table-bordered mt-2">
                <thead>
                    <tr class="tableheader">
                        <th class="text-center" style="border: 1px solid black">Fecha inicio</th>
                        <th class="text-center" style="border: 1px solid black">DNI</th>
                        <th class="text-center" style="border: 1px solid black">Apellido paterno</th>
                        <th class="text-center" style="border: 1px solid black">Apellido materno</th>
                        <th class="text-center" style="border: 1px solid black">Nombres</th>
                        <th class="text-center" style="border: 1px solid black">Puesto</th>
                        <th class="text-center" style="border: 1px solid black">Área</th>
                        <th class="text-center" style="border: 1px solid black">Gerencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" style="border: 1px solid black">
                            <?php foreach($list_fec_inicio as $list){
                                echo $list['fec_inicio'];
                            } ?>
                        </td>
                        <td class="text-center" style="border: 1px solid black"><?php echo $get_id[0]['num_doc']; ?></td>
                        <td class="text-center" style="border: 1px solid black"><?php echo $get_id['0']['usuario_apater'];?></td>
                        <td class="text-center" style="border: 1px solid black"><?php echo $get_id['0']['usuario_amater'];?></td>
                        <td class="text-center" style="border: 1px solid black"><?php echo $get_id['0']['usuario_nombres'];?></td>
                        <td class="text-center" style="border: 1px solid black"><?php echo $get_id[0]['nom_puesto']; ?></td>
                        <td class="text-center" style="border: 1px solid black"><?php echo $get_id[0]['nom_area']; ?></td>
                        <td class="text-center" style="border: 1px solid black"><?php echo $get_id[0]['nom_gerencia']; ?></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="card-text">Además de los siguientes requerimientos para la PC:</div>
            <table class="table table-bordered" style="margin-top: 2rem">
                <thead>
                    <tr class="tableheader">
                        <th style="width: 33%; border: 1px solid black">CARPETA ACCESO (DATACORP)</th>
                        <th style="width: 33%; border: 1px solid black">PÁGINAS WEB</th>
                        <th style="width: 33%; border: 1px solid black">PROGRAMAS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid black">
                            <?php
                                $accesos = array_column($list_accesos_datacorp, 'carpeta_acceso');
                                echo implode(', ', $accesos);
                            ?>
                        </td>
                        <td style="border: 1px solid black">
                            <?php
                                $accesos = array_column($list_accesos_paginas_web, 'pagina_acceso');
                                echo implode(', ', $accesos);
                            ?>
                        </td>
                        <td style="border: 1px solid black">
                            OFFICE, 
                            <?php
                                $accesos = array_column($list_accesos_programas, 'programa');
                                echo implode(', ', $accesos);
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="card-text mt-5">Observaciones: </div><br>
        <div class="card-text"> - Todos deben tener acceso a Intranet, Amauta Educa, Zimbra, La Número 1 y Apps de Google.</div><br>
        <div class="card-text"> 
            - Ingresar este correo a los grupos de 
            <?php echo mb_strtolower($get_id[0]['nom_area']) ?>, 
            <?php echo mb_strtolower($get_id[0]['nom_gerencia'])?>, 
            <?php if($get_id[0]['centro_labores']=='OFC'){
                echo 'oficina';
            }else if($get_id[0]['centro_labores']=='AMT'){
                echo 'amauta';
            }else{
                echo $get_id[0]['centro_labores'];
            }
            ?>.
        </div><br>
        <div class="card-text"><?php echo $observaciones;?></div><br>
        <div class="card-text">Gracias. </div><br>
</body>
</html>