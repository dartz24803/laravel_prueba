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
            <th width="10%">Base</th>
            <th width="10%">CAP Aprobado</th>
            <?php
                $fecha_repetidor="01-".$mes."-".$anio;
                $repetidor=date('t',strtotime($fecha_repetidor));
                $i=1;
                while($i<=$repetidor){ 
                    $fecha=str_pad($i,2,"0",STR_PAD_LEFT)."-".$mes."-".$anio;
                    $dia=date("l",strtotime($fecha));
                    if($dia=="Monday"){ $nom_dia="lun"; }
                    if($dia=="Tuesday"){ $nom_dia="mar"; }
                    if($dia=="Wednesday"){ $nom_dia="mie"; }
                    if($dia=="Thursday"){ $nom_dia="jue"; }
                    if($dia=="Friday"){ $nom_dia="vie"; }
                    if($dia=="Saturday"){ $nom_dia="sab"; }
                    if($dia=="Sunday"){ $nom_dia="dom"; }
                    ?>
                    <th><?php echo $i." ".$nom_dia; ?></th>
                    <?php $i++;
                }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php 
            $suma_cap_aprobado=0;
            $suma_dia_1=0;
            $suma_dia_2=0;
            $suma_dia_3=0;
            $suma_dia_4=0;
            $suma_dia_5=0;
            $suma_dia_6=0;
            $suma_dia_7=0;
            $suma_dia_8=0;
            $suma_dia_9=0;
            $suma_dia_10=0;
            $suma_dia_11=0;
            $suma_dia_12=0;
            $suma_dia_13=0;
            $suma_dia_14=0;
            $suma_dia_15=0;
            $suma_dia_16=0;
            $suma_dia_17=0;
            $suma_dia_18=0;
            $suma_dia_19=0;
            $suma_dia_20=0;
            $suma_dia_21=0;
            $suma_dia_22=0;
            $suma_dia_23=0;
            $suma_dia_24=0;
            $suma_dia_25=0;
            $suma_dia_26=0;
            $suma_dia_27=0;
            $suma_dia_28=0;
            $suma_dia_29=0;
            $suma_dia_30=0;
            $suma_dia_31=0;
            foreach($list_gestion as $list) {  ?>   
            <tr>
                <td class="text-center"><a style="cursor:pointer;" onclick="Detalle_Gestion_Registro_Cap('<?php echo $list['cod_base']; ?>');"><?php echo $list['nom_base']; ?></a></td>
                <td class="text-center"><?php echo number_format($list['Cap_Aprobado'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_1'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_2'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_3'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_4'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_5'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_6'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_7'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_8'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_9'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_10'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_11'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_12'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_13'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_14'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_15'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_16'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_17'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_18'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_19'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_20'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_21'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_22'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_23'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_24'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_25'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_26'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_27'],1); ?></td>
                <td class="text-center"><?php echo number_format($list['Dia_28'],1); ?></td>
                <?php if($repetidor>=29){ ?>
                    <td class="text-center"><?php echo number_format($list['Dia_29'],1); ?></td>
                <?php } ?>
                <?php if($repetidor>=30){ ?>
                    <td class="text-center"><?php echo number_format($list['Dia_30'],1); ?></td>
                <?php } ?>
                <?php if($repetidor>=31){ ?>
                    <td class="text-center"><?php echo number_format($list['Dia_31'],1); ?></td>
                <?php } ?>
            </tr>
        <?php 
            $i++; 
            $suma_cap_aprobado=$suma_cap_aprobado+$list['Cap_Aprobado'];
            $suma_dia_1=$suma_dia_1+$list['Dia_1'];
            $suma_dia_2=$suma_dia_2+$list['Dia_2'];
            $suma_dia_3=$suma_dia_3+$list['Dia_3'];
            $suma_dia_4=$suma_dia_4+$list['Dia_4'];
            $suma_dia_5=$suma_dia_5+$list['Dia_5'];
            $suma_dia_6=$suma_dia_6+$list['Dia_6'];
            $suma_dia_7=$suma_dia_7+$list['Dia_7'];
            $suma_dia_8=$suma_dia_8+$list['Dia_8'];
            $suma_dia_9=$suma_dia_9+$list['Dia_9'];
            $suma_dia_10=$suma_dia_10+$list['Dia_10'];
            $suma_dia_11=$suma_dia_11+$list['Dia_11'];
            $suma_dia_12=$suma_dia_12+$list['Dia_12'];
            $suma_dia_13=$suma_dia_13+$list['Dia_13'];
            $suma_dia_14=$suma_dia_14+$list['Dia_14'];
            $suma_dia_15=$suma_dia_15+$list['Dia_15'];
            $suma_dia_16=$suma_dia_16+$list['Dia_16'];
            $suma_dia_17=$suma_dia_17+$list['Dia_17'];
            $suma_dia_18=$suma_dia_18+$list['Dia_18'];
            $suma_dia_19=$suma_dia_19+$list['Dia_19'];
            $suma_dia_20=$suma_dia_20+$list['Dia_20'];
            $suma_dia_21=$suma_dia_21+$list['Dia_21'];
            $suma_dia_22=$suma_dia_22+$list['Dia_22'];
            $suma_dia_23=$suma_dia_23+$list['Dia_23'];
            $suma_dia_24=$suma_dia_24+$list['Dia_24'];
            $suma_dia_25=$suma_dia_25+$list['Dia_25'];
            $suma_dia_26=$suma_dia_26+$list['Dia_26'];
            $suma_dia_27=$suma_dia_27+$list['Dia_27'];
            if($numero_dias>27){
                $suma_dia_28=$suma_dia_28+$list['Dia_28'];
            }if($numero_dias>28){
                $suma_dia_29=$suma_dia_29+$list['Dia_29'];
            }if($numero_dias>29){
                $suma_dia_30=$suma_dia_30+$list['Dia_30'];
            }if($numero_dias>30){
                $suma_dia_31=$suma_dia_31+$list['Dia_31'];
            }    
        } ?>
        <tr>
            <td class="text-center">Total</td>
            <td class="text-center"><?php echo number_format($suma_cap_aprobado,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_1,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_2,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_3,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_4,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_5,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_6,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_7,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_8,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_9,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_10,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_11,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_12,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_13,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_14,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_15,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_16,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_17,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_18,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_19,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_20,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_21,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_22,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_23,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_24,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_25,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_26,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_27,1); ?></td>
            <td class="text-center"><?php echo number_format($suma_dia_28,1); ?></td>
            <?php if($repetidor>=29){ ?>
                <td class="text-center"><?php echo number_format($suma_dia_29,1); ?></td>
            <?php } ?>
            <?php if($repetidor>=30){ ?>
                <td class="text-center"><?php echo number_format($suma_dia_30,1); ?></td>
            <?php } ?>
            <?php if($repetidor>=31){ ?>
                <td class="text-center"><?php echo number_format($suma_dia_31,1); ?></td>
            <?php } ?>
        </tr>
        <tr>
            <?php
                if($suma_cap_aprobado==0){
                    $porcentaje_cap_aprobado=0;
                    $porcentaje_dia_1=0;
                    $porcentaje_dia_2=0;
                    $porcentaje_dia_3=0;
                    $porcentaje_dia_4=0;
                    $porcentaje_dia_5=0;
                    $porcentaje_dia_6=0;
                    $porcentaje_dia_7=0;
                    $porcentaje_dia_8=0;
                    $porcentaje_dia_9=0;
                    $porcentaje_dia_10=0;
                    $porcentaje_dia_11=0;
                    $porcentaje_dia_12=0;
                    $porcentaje_dia_13=0;
                    $porcentaje_dia_14=0;
                    $porcentaje_dia_15=0;
                    $porcentaje_dia_16=0;
                    $porcentaje_dia_17=0;
                    $porcentaje_dia_18=0;
                    $porcentaje_dia_19=0;
                    $porcentaje_dia_20=0;
                    $porcentaje_dia_21=0;
                    $porcentaje_dia_22=0;
                    $porcentaje_dia_23=0;
                    $porcentaje_dia_24=0;
                    $porcentaje_dia_25=0;
                    $porcentaje_dia_26=0;
                    $porcentaje_dia_27=0;
                    $porcentaje_dia_28=0;
                    $porcentaje_dia_29=0;
                    $porcentaje_dia_30=0;
                    $porcentaje_dia_31=0;
                }else{
                    $porcentaje_cap_aprobado=$suma_cap_aprobado/$suma_cap_aprobado*100;
                    $porcentaje_dia_1=$suma_dia_1/$suma_cap_aprobado*100;
                    $porcentaje_dia_2=$suma_dia_2/$suma_cap_aprobado*100;
                    $porcentaje_dia_3=$suma_dia_3/$suma_cap_aprobado*100;
                    $porcentaje_dia_4=$suma_dia_4/$suma_cap_aprobado*100;
                    $porcentaje_dia_5=$suma_dia_5/$suma_cap_aprobado*100;
                    $porcentaje_dia_6=$suma_dia_6/$suma_cap_aprobado*100;
                    $porcentaje_dia_7=$suma_dia_7/$suma_cap_aprobado*100;
                    $porcentaje_dia_8=$suma_dia_8/$suma_cap_aprobado*100;
                    $porcentaje_dia_9=$suma_dia_9/$suma_cap_aprobado*100;
                    $porcentaje_dia_10=$suma_dia_10/$suma_cap_aprobado*100;
                    $porcentaje_dia_11=$suma_dia_11/$suma_cap_aprobado*100;
                    $porcentaje_dia_12=$suma_dia_12/$suma_cap_aprobado*100;
                    $porcentaje_dia_13=$suma_dia_13/$suma_cap_aprobado*100;
                    $porcentaje_dia_14=$suma_dia_14/$suma_cap_aprobado*100;
                    $porcentaje_dia_15=$suma_dia_15/$suma_cap_aprobado*100;
                    $porcentaje_dia_16=$suma_dia_16/$suma_cap_aprobado*100;
                    $porcentaje_dia_17=$suma_dia_17/$suma_cap_aprobado*100;
                    $porcentaje_dia_18=$suma_dia_18/$suma_cap_aprobado*100;
                    $porcentaje_dia_19=$suma_dia_19/$suma_cap_aprobado*100;
                    $porcentaje_dia_20=$suma_dia_20/$suma_cap_aprobado*100;
                    $porcentaje_dia_21=$suma_dia_21/$suma_cap_aprobado*100;
                    $porcentaje_dia_22=$suma_dia_22/$suma_cap_aprobado*100;
                    $porcentaje_dia_23=$suma_dia_23/$suma_cap_aprobado*100;
                    $porcentaje_dia_24=$suma_dia_24/$suma_cap_aprobado*100;
                    $porcentaje_dia_25=$suma_dia_25/$suma_cap_aprobado*100;
                    $porcentaje_dia_26=$suma_dia_26/$suma_cap_aprobado*100;
                    $porcentaje_dia_27=$suma_dia_27/$suma_cap_aprobado*100;
                    $porcentaje_dia_28=$suma_dia_28/$suma_cap_aprobado*100;
                    $porcentaje_dia_29=$suma_dia_29/$suma_cap_aprobado*100;
                    $porcentaje_dia_30=$suma_dia_30/$suma_cap_aprobado*100;
                    $porcentaje_dia_31=$suma_dia_31/$suma_cap_aprobado*100;
                }
            ?>
            <td class="text-center">% vs Cap</td>
            <td class="text-center"><?php echo number_format($porcentaje_cap_aprobado,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_1,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_2,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_3,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_4,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_5,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_6,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_7,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_8,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_9,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_10,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_11,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_12,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_13,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_14,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_15,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_16,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_17,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_18,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_19,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_20,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_21,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_22,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_23,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_24,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_25,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_26,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_27,0)."%"; ?></td>
            <td class="text-center"><?php echo number_format($porcentaje_dia_28,0)."%"; ?></td>
            <?php if($repetidor>=29){ ?>
                <td class="text-center"><?php echo number_format($porcentaje_dia_29,0)."%"; ?></td>
            <?php } ?>
            <?php if($repetidor>=30){ ?>
                <td class="text-center"><?php echo number_format($porcentaje_dia_30,0)."%"; ?></td>
            <?php } ?>
            <?php if($repetidor>=31){ ?>
                <td class="text-center"><?php echo number_format($porcentaje_dia_31,0)."%"; ?></td>
            <?php } ?>
        </tr>
    </tbody>
</table>