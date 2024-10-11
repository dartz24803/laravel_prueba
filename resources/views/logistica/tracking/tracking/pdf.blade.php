<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía de remisión</title>
    <style type="text/css" media="all">
        h2{
            font-weight: 500;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        tr, th, td{
            border: 1px solid #000;
        }

        th{
            font-size: 14px;
            font-weight: 300;
            padding: 10px;
        }

        td{
            font-size: 13px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h2>N° Req: {{ $get_id->n_requerimiento }}</h2>

    <table class="tabla">
        <thead>
            <tr style="background-color:#0093C6;text-align:center;">
                <th>SKU</th>
                <th>Color</th>
                <th>Estilo</th>
                <th>Talla</th>
                <th>Descripción</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_detalle as $list)
                <tr style="text-align:left;">
                    <td style="text-align:center;">{{ $list->sku }}</td>
                    <td>{{ $list->color }}</td>
                    <td>{{ $list->estilo }}</td>
                    <td>{{ $list->talla }}</td>
                    <td>{{ $list->descripcion }}</td>
                    <td style="text-align:center;">{{ $list->cantidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>