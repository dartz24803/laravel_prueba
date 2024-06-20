<!DOCTYPE HTML5>
<html>
	<head>
		<title>Amonestación</title>
		<meta charset="utf-8">
		<meta name="description" content="pdf cv numero1">
    <meta name="keywords" content="datos, usuario, pdf">
    <style type="text/css"  media="all">
        *{
            box-sizing: border-box;
            padding:0;
            margin:0;
            font-family: gothic;
            /*font-size:20px;*/
        }
        .clearfix:after {
          content: "";
          display: table;
          clear: both;
        }

        a {
          color: #5D6975;
          text-decoration: underline;
        }

        body {
          position: relative;
          width: 21cm;  
          height: 29.7cm; 
          margin: 0 auto; 
          color: #001028;
          background: #FFFFFF; 
          font-size: 9.5px; 
        }

        header {
          padding: 2px 0;
          margin-bottom: 0px;
        }

        #logo {
          text-align: center;
          margin-bottom: 10px;
        }

        #logo img {
          width: 90px;
          height:20px;
        }

        .hi {
          width:30%;
          height: 30px;
          border-bottom: 3px dashed  #2093c6;
          border-left: 3px solid  #2093c6;
          border-right: 3px solid  #2093c6;
          border-top: 3px dashed  #2093c6;
          color: #2093c6;
          font-size: 1.3em;
          line-height: 1.7em;
          font-weight: bold;
          padding-top: 5px;
          padding-left: 10px;
          padding-right: 10px;
          padding-bottom: 5px;
          margin: 0 0 10px 0;
        }
        .imgaenperfil{
          width: 200px; height:150px; padding-right:10px;border-radius:40px;object-fit: cover;
        }

        #tdprimero{
          text-align: left !important;
          /*background:blue;*/
        }
        #tdsegundo{
          text-align: right !important;
        }

        #project {
          float: left;
        }

        #project span {
          color: #5D6975;
          text-align: right;
          width: 52px;
          margin-right: 15px;
          display: inline-block;
          font-size: 0.8em;
          margin-bottom: 15px;
        }
        #company {
          float: right;
          text-align: center;
        }
        #project div,
        #company div {
          white-space: nowrap;        
        }

        /**************************** */

        table th,
        table #tdb {
          text-align: center;
        }

        #tableuno {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 1px;
        }

        
        #tableuno th {
          padding: 5px 20px;
          color: #5D6975;
          border-bottom: 1px solid #CC7924;
          border-top: 1px solid #9BB552;
          border-left:1px solid #2093C6;
          border-right:1px solid #2093C6;
          white-space: nowrap;        
          font-weight: bold;
        }

      /****************************** */

          #tabledos {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            /*margin-bottom: 0px;*/
          }

          #tabledos td {
            text-align: center;
            padding: 5px ;
            color:#6c6c6c;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            font-size: 8px;
          }
          #tabledos tr:nth-child(2n-1) td {
            background:#C6DAF7;
          }

          
          #tabledos th {
            padding: 5px 20px;
            color: #ffffff;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            white-space: nowrap;        
            font-weight: bold;
            background-color:#2494c4;
          }

          /****************************** */
          #tabledoss {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 0px;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
          }

          #tabledoss th {
            padding: 5px 20px;
            color: #ffffff;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            white-space: nowrap;        
            font-weight: bold;
            background-color:#2494c4;
          }
          #tabledoss td {
            text-align: center;
            padding: 5px;
            color:#6c6c6c;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            font-size: 8px;

          }

          #tabledoss tr:nth-child(2n-1) td {
            background:#C6DAF7;
          }

          
          #tabledoss #aqui tr:nth-child(2n-1) td {
            background:#C6DAF7;
          }

      /*********************** */
          #tabledosss {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 0px;
          }

          #tabledosss th {
            padding: 5px 20px;
            color: #ffffff;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            white-space: nowrap;        
            font-weight: bold;
            background-color:#2494c4;
          }
          #tabledosss td {
            text-align: center;
            padding: 5px ;
            color:#6c6c6c;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            font-size: 8px;

          }
          tbody#aqui tr:nth-child(2n-1) td {
            background:#C6DAF7;
          }

      /******************************** */
        #tabletres {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 0px;
        }
            
        #tabletres td {
          text-align: center;
          padding: 5px ;
          color:#6c6c6c;
          font-size: 8px;
          border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
          
        }

        #tabletres th {
          padding: 5px 20px;
          color: #ffffff;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            white-space: nowrap;        
            font-weight: bold;
            background-color:#2494c4;
        }

        footer {
          color: #5D6975;
          width: 100%;
          height: 30px;
          position: absolute;
          bottom: 40px;
          padding: 8px 0;
          text-align: left;
        }

        .fontlb{
          font-weight: 600;
          font-family: gothic;
        }
        
    </style>
	</head>
	<body>
  <h2 align="right"><?php echo $get_id[0]['cod_amonestacion'] ?></h2>

  <h1 align="center">Amonestación - <?php echo $get_id[0]['nom_tipo_amonestacion'] ?></h1><br>
  <p align="left" style="font-size:14px">Para: <?php echo "&nbsp;&nbsp;&nbsp;".$get_id[0]['colaborador']." <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$get_id[0]['nom_puesto'] ?></p>
  <p align="left" style="font-size:14px">Fecha: <?php echo $get_id[0]['fecha_aprobacion'] ?></p>
  <p align="left" style="font-size:14px">Asunto: Amonestación <?php echo $get_id[0]['nom_gravedad_amonestacion'] ?> por <?php echo $get_id[0]['nom_motivo_amonestacion'] ?></p>
  <H2 align="left">_______________________________________________________________________________________________</H2>
  
  <p style="font-size:13px;text-align:justify">Por medio de la presente le comunicamos la decisión de <b>AMONESTARLO</b> por haber incurrido en la falta de <?php echo $get_id[0]['nom_motivo_amonestacion'] ?>, la cual se detalla a continuación:</p>
  <p style="font-size:13px;text-align:justify"><?php echo nl2br($get_id[0]['detalle']) ?></p>
  <p style="font-size:13px;text-align:justify">Fecha de suceso: <?php echo $get_id[0]['fecha_suceso'] ?></p>
  <p style="font-size:13px;text-align:justify">Conforme a las facultades otorgadas al empleador en el Art. 9° del Decreto Legislativo Nº 728, Ley de Productividad y Competitividad Laboral, se le comunica que la empresa ha decidido imponerle en calidad de medida disciplinaria la siguiente amonestación.</p>
  <p style="font-size:13px;text-align:justify">En caso de que reincida en su comportamiento, <?php if($get_id[0]['tipo']==1){?> nos veremos obligados a generar una amonestación escrita.<?php }if($get_id[0]['tipo']==2){?> nos veremos obligados a generar un memorándum.<?php }
  if($get_id[0]['tipo']==3){?> nos veremos obligados a terminar la relación laboral.<?php }?></p><br><br><br><br><br><br>
  <p align="left" style="font-size:13px">Atentamente</p>
  <p align="left" style="font-size:13px"><?php echo $get_id[0]['jeferrhh'] ?></p>
  <p align="left" style="font-size:13px">Jefe de Recursos Humanos</p><br><br><br><br><br><br><br><br><br><br>
  <H2 align="center">_____________________________________</H2>
  <p align="center" style="font-size:13px">Firma de trabajador</p>

	</body>
</html>