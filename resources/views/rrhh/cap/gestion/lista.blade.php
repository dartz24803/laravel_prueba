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
            <th width="6%">Base</th>
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
        @php
            $suma_cap_aprobado = 0;
            $suma_dia_1 = 0;
            $suma_dia_2 = 0;
            $suma_dia_3 = 0;
            $suma_dia_4 = 0;
            $suma_dia_5 = 0;
            $suma_dia_6 = 0;
            $suma_dia_7 = 0;
            $suma_dia_8 = 0;
            $suma_dia_9 = 0;
            $suma_dia_10 = 0;
            $suma_dia_11 = 0;
            $suma_dia_12 = 0;
            $suma_dia_13 = 0;
            $suma_dia_14 = 0;
            $suma_dia_15 = 0;
            $suma_dia_16 = 0;
            $suma_dia_17 = 0;
            $suma_dia_18 = 0;
            $suma_dia_19 = 0;
            $suma_dia_20 = 0;
            $suma_dia_21 = 0;
            $suma_dia_22 = 0;
            $suma_dia_23 = 0;
            $suma_dia_24 = 0;
            $suma_dia_25 = 0;
            $suma_dia_26 = 0;
            $suma_dia_27 = 0;
            $suma_dia_28 = 0;
            $suma_dia_29 = 0;
            $suma_dia_30 = 0;
            $suma_dia_31 = 0;
        @endphp
        @foreach ($list_gestion as $list)
            <tr class="text-center">
                <td>
                    <a style="cursor:pointer;" onclick="Detalle_Gestion('{{ $list->id_centro_labor }}');">
                        {{ $list->nom_centro_labor }}
                    </a>
                </td>
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
                @if ($repetidor>=29)
                    <td>{{ number_format($list->dia_29,1) }}</td>
                @endif
                @if ($repetidor>=30)
                    <td>{{ number_format($list->dia_30,1) }}</td>
                @endif
                @if ($repetidor>=31)
                    <td>{{ number_format($list->dia_31,1) }}</td>
                @endif
            </tr>
        @php
            $i++;
            $suma_cap_aprobado = $suma_cap_aprobado+$list->cap_aprobado;
            $suma_dia_1 = $suma_dia_1+$list->dia_1;
            $suma_dia_2 = $suma_dia_2+$list->dia_2;
            $suma_dia_3 = $suma_dia_3+$list->dia_3;
            $suma_dia_4 = $suma_dia_4+$list->dia_4;
            $suma_dia_5 = $suma_dia_5+$list->dia_5;
            $suma_dia_6 = $suma_dia_6+$list->dia_6;
            $suma_dia_7 = $suma_dia_7+$list->dia_7;
            $suma_dia_8 = $suma_dia_8+$list->dia_8;
            $suma_dia_9 = $suma_dia_9+$list->dia_9;
            $suma_dia_10 = $suma_dia_10+$list->dia_10;
            $suma_dia_11 = $suma_dia_11+$list->dia_11;
            $suma_dia_12 = $suma_dia_12+$list->dia_12;
            $suma_dia_13 = $suma_dia_13+$list->dia_13;
            $suma_dia_14 = $suma_dia_14+$list->dia_14;
            $suma_dia_15 = $suma_dia_15+$list->dia_15;
            $suma_dia_16 = $suma_dia_16+$list->dia_16;
            $suma_dia_17 = $suma_dia_17+$list->dia_17;
            $suma_dia_18 = $suma_dia_18+$list->dia_18;
            $suma_dia_19 = $suma_dia_19+$list->dia_19;
            $suma_dia_20 = $suma_dia_20+$list->dia_20;
            $suma_dia_21 = $suma_dia_21+$list->dia_21;
            $suma_dia_22 = $suma_dia_22+$list->dia_22;
            $suma_dia_23 = $suma_dia_23+$list->dia_23;
            $suma_dia_24 = $suma_dia_24+$list->dia_24;
            $suma_dia_25 = $suma_dia_25+$list->dia_25;
            $suma_dia_26 = $suma_dia_26+$list->dia_26;
            $suma_dia_27 = $suma_dia_27+$list->dia_27;
            $suma_dia_28 = $suma_dia_28+$list->dia_28;
            if($repetidor>=29){
                $suma_dia_29 = $suma_dia_29+$list->dia_29;
            }
            if($repetidor>=30){
                $suma_dia_30 = $suma_dia_30+$list->dia_30;
            }
            if($repetidor>=31){
                $suma_dia_31 = $suma_dia_31+$list->dia_31;
            }
        @endphp
        @endforeach
        <tr class="text-center">
            <td>Total</td>
            <td>{{ number_format($suma_cap_aprobado,1) }}</td>
            <td>{{ number_format($suma_dia_1,1) }}</td>
            <td>{{ number_format($suma_dia_2,1) }}</td>
            <td>{{ number_format($suma_dia_3,1) }}</td>
            <td>{{ number_format($suma_dia_4,1) }}</td>
            <td>{{ number_format($suma_dia_5,1) }}</td>
            <td>{{ number_format($suma_dia_6,1) }}</td>
            <td>{{ number_format($suma_dia_7,1) }}</td>
            <td>{{ number_format($suma_dia_8,1) }}</td>
            <td>{{ number_format($suma_dia_9,1) }}</td>
            <td>{{ number_format($suma_dia_10,1) }}</td>
            <td>{{ number_format($suma_dia_11,1) }}</td>
            <td>{{ number_format($suma_dia_12,1) }}</td>
            <td>{{ number_format($suma_dia_13,1) }}</td>
            <td>{{ number_format($suma_dia_14,1) }}</td>
            <td>{{ number_format($suma_dia_15,1) }}</td>
            <td>{{ number_format($suma_dia_16,1) }}</td>
            <td>{{ number_format($suma_dia_17,1) }}</td>
            <td>{{ number_format($suma_dia_18,1) }}</td>
            <td>{{ number_format($suma_dia_19,1) }}</td>
            <td>{{ number_format($suma_dia_20,1) }}</td>
            <td>{{ number_format($suma_dia_21,1) }}</td>
            <td>{{ number_format($suma_dia_22,1) }}</td>
            <td>{{ number_format($suma_dia_23,1) }}</td>
            <td>{{ number_format($suma_dia_24,1) }}</td>
            <td>{{ number_format($suma_dia_25,1) }}</td>
            <td>{{ number_format($suma_dia_26,1) }}</td>
            <td>{{ number_format($suma_dia_27,1) }}</td>
            <td>{{ number_format($suma_dia_28,1) }}</td>
            @if ($repetidor>=29)
                <td>{{ number_format($suma_dia_29,1) }}</td>
            @endif
            @if ($repetidor>=30)
                <td>{{ number_format($suma_dia_30,1) }}</td>
            @endif
            @if ($repetidor>=31)
                <td>{{ number_format($suma_dia_31,1) }}</td>
            @endif                        
        </tr>
        <tr class="text-center">
            @php
                $porcentaje_cap_aprobado = 0;
                $porcentaje_dia_1 = 0;
                $porcentaje_dia_2 = 0;
                $porcentaje_dia_3 = 0;
                $porcentaje_dia_4 = 0;
                $porcentaje_dia_5 = 0;
                $porcentaje_dia_6 = 0;
                $porcentaje_dia_7 = 0;
                $porcentaje_dia_8 = 0;
                $porcentaje_dia_9 = 0;
                $porcentaje_dia_10 = 0;
                $porcentaje_dia_11 = 0;
                $porcentaje_dia_12 = 0;
                $porcentaje_dia_13 = 0;
                $porcentaje_dia_14 = 0;
                $porcentaje_dia_15 = 0;
                $porcentaje_dia_16 = 0;
                $porcentaje_dia_17 = 0;
                $porcentaje_dia_18 = 0;
                $porcentaje_dia_19 = 0;
                $porcentaje_dia_20 = 0;
                $porcentaje_dia_21 = 0;
                $porcentaje_dia_22 = 0;
                $porcentaje_dia_23 = 0;
                $porcentaje_dia_24 = 0;
                $porcentaje_dia_25 = 0;
                $porcentaje_dia_26 = 0;
                $porcentaje_dia_27 = 0;
                $porcentaje_dia_28 = 0;
                $porcentaje_dia_29 = 0;
                $porcentaje_dia_30 = 0;
                $porcentaje_dia_31 = 0;
                if($suma_cap_aprobado>0){
                    $porcentaje_cap_aprobado = $suma_cap_aprobado/$suma_cap_aprobado*100;
                    $porcentaje_dia_1 = $suma_dia_1/$suma_cap_aprobado*100;
                    $porcentaje_dia_2 = $suma_dia_2/$suma_cap_aprobado*100;
                    $porcentaje_dia_3 = $suma_dia_3/$suma_cap_aprobado*100;
                    $porcentaje_dia_4 = $suma_dia_4/$suma_cap_aprobado*100;
                    $porcentaje_dia_5 = $suma_dia_5/$suma_cap_aprobado*100;
                    $porcentaje_dia_6 = $suma_dia_6/$suma_cap_aprobado*100;
                    $porcentaje_dia_7 = $suma_dia_7/$suma_cap_aprobado*100;
                    $porcentaje_dia_8 = $suma_dia_8/$suma_cap_aprobado*100;
                    $porcentaje_dia_9 = $suma_dia_9/$suma_cap_aprobado*100;
                    $porcentaje_dia_10 = $suma_dia_10/$suma_cap_aprobado*100;
                    $porcentaje_dia_11 = $suma_dia_11/$suma_cap_aprobado*100;
                    $porcentaje_dia_12 = $suma_dia_12/$suma_cap_aprobado*100;
                    $porcentaje_dia_13 = $suma_dia_13/$suma_cap_aprobado*100;
                    $porcentaje_dia_14 = $suma_dia_14/$suma_cap_aprobado*100;
                    $porcentaje_dia_15 = $suma_dia_15/$suma_cap_aprobado*100;
                    $porcentaje_dia_16 = $suma_dia_16/$suma_cap_aprobado*100;
                    $porcentaje_dia_17 = $suma_dia_17/$suma_cap_aprobado*100;
                    $porcentaje_dia_18 = $suma_dia_18/$suma_cap_aprobado*100;
                    $porcentaje_dia_19 = $suma_dia_19/$suma_cap_aprobado*100;
                    $porcentaje_dia_20 = $suma_dia_20/$suma_cap_aprobado*100;
                    $porcentaje_dia_21 = $suma_dia_21/$suma_cap_aprobado*100;
                    $porcentaje_dia_22 = $suma_dia_22/$suma_cap_aprobado*100;
                    $porcentaje_dia_23 = $suma_dia_23/$suma_cap_aprobado*100;
                    $porcentaje_dia_24 = $suma_dia_24/$suma_cap_aprobado*100;
                    $porcentaje_dia_25 = $suma_dia_25/$suma_cap_aprobado*100;
                    $porcentaje_dia_26 = $suma_dia_26/$suma_cap_aprobado*100;
                    $porcentaje_dia_27 = $suma_dia_27/$suma_cap_aprobado*100;
                    $porcentaje_dia_28 = $suma_dia_28/$suma_cap_aprobado*100;
                    $porcentaje_dia_29 = $suma_dia_29/$suma_cap_aprobado*100;
                    $porcentaje_dia_30 = $suma_dia_30/$suma_cap_aprobado*100;
                    $porcentaje_dia_31 = $suma_dia_31/$suma_cap_aprobado*100;
                }
            @endphp
            <td>% vs Cap</td>
            <td>{{ number_format($porcentaje_cap_aprobado,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_1,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_2,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_3,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_4,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_5,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_6,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_7,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_8,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_9,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_10,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_11,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_12,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_13,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_14,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_15,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_16,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_17,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_18,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_19,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_20,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_21,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_22,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_23,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_24,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_25,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_26,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_27,0)."%" }}</td>
            <td>{{ number_format($porcentaje_dia_28,0)."%" }}</td>
            @if ($repetidor>=29)
                <td>{{ number_format($porcentaje_dia_29,0)."%" }}</td>
            @endif
            @if ($repetidor>=30)
                <td>{{ number_format($porcentaje_dia_30,0)."%" }}</td>
            @endif
            @if ($repetidor>=31)
                <td>{{ number_format($porcentaje_dia_31,0)."%" }}</td>
            @endif                        
        </tr>
    </tbody>
</table>