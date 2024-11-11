@if (count($list_detalle_gestion)>0)
    <style>
        #tabla_estilo{
            color: #000;
        }

        #tabla_estilo tbody tr:hover{
            background-color: #E3E4E5;
        }
    </style>

    @if ($mes==date('m') && $anio==date('Y'))
        <style>
            #tabla_estilo th:nth-child({{ date('j')+2 }}),td:nth-child({{ date('j')+2 }}){
                background-color: #FFE1E2;
            }
        </style>
    @else
        <style>
            #tabla_estilo th:nth-child({{ date('j')+2 }}),td:nth-child({{ date('j')+2 }}){
                background-color: transparent;
            }
        </style>
    @endif

    <table id="tabla_estilo" style="width:100%;" border="1px">
        <thead>
            <tr class="text-center">
                <th width="15%">Cargo CAP</th>
                <th width="8%">CAP Aprobado</th>
                @php
                    $fecha_repetidor = "01-".$mes."-".$anio;
                    $repetidor = date('t',strtotime($fecha_repetidor));
                    $i = 1;
                    while($i<=$repetidor){ 
                        $fecha = str_pad($i,2,"0",STR_PAD_LEFT)."-".$mes."-".$anio;
                        $dia = date("l",strtotime($fecha));
                        if($dia=="Monday"){ $nom_dia="lun"; }
                        if($dia=="Tuesday"){ $nom_dia="mar"; }
                        if($dia=="Wednesday"){ $nom_dia="mie"; }
                        if($dia=="Thursday"){ $nom_dia="jue"; }
                        if($dia=="Friday"){ $nom_dia="vie"; }
                        if($dia=="Saturday"){ $nom_dia="sab"; }
                        if($dia=="Sunday"){ $nom_dia="dom"; }
                        echo "<th>".$i." ".$nom_dia."</th>";
                        $i++;
                    }
                @endphp
            </tr>
        </thead>
        <tbody>
            @foreach ($list_detalle_gestion as $list)
                <tr class="text-center">
                    <td class="text-left">{{ $list->nom_puesto }}</td>
                    <td>{{ number_format($list->cap_aprobado,1) }}</td>
                    <td>{{ number_format($list->dia_1,1) }}</td>
                    <td>{{ number_format($list->dia_2,1) }}</td>
                    <td>{{ number_format($list->dia_3,1) }}</td>
                    <td>{{ number_format($list->dia_4,1) }}</td>
                    <td>{{ number_format($list->dia_5,1) }}</td>
                    <td>{{ number_format($list->dia_6,1) }}</td>
                    <td>{{ number_format($list->dia_7,1) }}</td>
                    <td>{{ number_format($list->dia_8,1) }}</td>
                    <td>{{ number_format($list->dia_9,1) }}</td>
                    <td>{{ number_format($list->dia_10,1) }}</td>
                    <td>{{ number_format($list->dia_11,1) }}</td>
                    <td>{{ number_format($list->dia_12,1) }}</td>
                    <td>{{ number_format($list->dia_13,1) }}</td>
                    <td>{{ number_format($list->dia_14,1) }}</td>
                    <td>{{ number_format($list->dia_15,1) }}</td>
                    <td>{{ number_format($list->dia_16,1) }}</td>
                    <td>{{ number_format($list->dia_17,1) }}</td>
                    <td>{{ number_format($list->dia_18,1) }}</td>
                    <td>{{ number_format($list->dia_19,1) }}</td>
                    <td>{{ number_format($list->dia_20,1) }}</td>
                    <td>{{ number_format($list->dia_21,1) }}</td>
                    <td>{{ number_format($list->dia_22,1) }}</td>
                    <td>{{ number_format($list->dia_23,1) }}</td>
                    <td>{{ number_format($list->dia_24,1) }}</td>
                    <td>{{ number_format($list->dia_25,1) }}</td>
                    <td>{{ number_format($list->dia_26,1) }}</td>
                    <td>{{ number_format($list->dia_27,1) }}</td>
                    <td>{{ number_format($list->dia_28,1) }}</td>
                    <?php if($repetidor>=29){ ?>
                        <td>{{ number_format($list->dia_29,1) }}</td>
                    <?php } ?>
                    <?php if($repetidor>=30){ ?>
                        <td>{{ number_format($list->dia_30,1) }}</td>
                    <?php } ?>
                    <?php if($repetidor>=31){ ?>
                        <td>{{ number_format($list->dia_31,1) }}</td>
                    <?php } ?>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    Sin resultados
@endif