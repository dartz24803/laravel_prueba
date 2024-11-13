<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    </head>
    <body class="body" style="padding:0; margin:0; display:flex; background:#ffffff; -webkit-text-size-adjust:none;align-content: center;align-items: center;">
        <table align="center" cellpadding="0" cellspacing="0" width="100%" height="50%">
            <tr>
                <td align="center" valign="top" bgcolor="#ffffff"  width="100%">
                    <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td style="border-bottom:0px solid #e7e7e7;">
                                <center>
                                    <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                        <tr>
                                            <td align="left" class="mobile-padding" style="padding-top: 20px;">
                                                <br class="mobile-hide" />
                                                <h2 class="mediocuadrado">Completado</h2><br>
                                                    ¡Hola <?php if(isset($get_ticket[0]['nom_solicitante'])){ echo $get_ticket[0]['nom_solicitante']; }?>!<br><br>
                                                    Tu requerimiento registrado el día <?php echo $get_ticket[0]['fecha_registro']; ?> se encuentra completado.<br><br>
                                                    <span style="font-weight:bold;">Título: </span><?php if(isset($get_ticket[0]['titulo'])){ echo $get_ticket[0]['titulo']; } ?><br><br>
                                                    <span style="font-weight:bold;">Descripción:</span><br> 
                                                    <?php if(isset($get_ticket[0]['descripcion'])){ echo $get_ticket[0]['descripcion']; } ?><br><br>
                                                    Fecha de Inicio: <?php echo $get_ticket[0]['fecha_inicio']; ?><br>
                                                    Fecha de Fin: <?php echo $get_ticket[0]['fecha_fin']; ?><br><br>
                                                    <span style="font-weight:bold;">Comentarios</span><br><br>
                                                    <?php foreach($list_comentario as $list){ ?>
                                                        <?php echo $list['fecha']; ?> - <?php echo $list['comentarista']; ?> ha comentado:<br>
                                                        <?php echo $list['comentario']; ?><br><br>
                                                    <?php } ?>
                                                    <span style="color:#00B1F4;font-weight:bold;">Pasión</span><br>
                                                    Amor por lo que hacemos comprometidos con nuestra misión
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </td>
                        </tr>
                        <tr></tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
<style type="text/css">

/* Take care of image borders and formatting */

img {
  max-width: 600px;
  outline: none;
  text-decoration: none;
  -ms-interpolation-mode: bicubic;
}
a {
  border: 0;
  outline: none;
}
a img {
  border: none;
}
/* General styling */
td, h1, h2, h3  {
  font-family: Helvetica, Arial, sans-serif;
  font-weight: 400;
}

td {
  font-size: 16px;
  line-height: 150%;
  text-align: left;
}

body {
  -webkit-font-smoothing:antialiased;
  -webkit-text-size-adjust:none;
  width: 100%;
  height: 100vh;
  color: #37302d;
  background: #ffffff;
}

table {
  border-collapse: collapse !important;
}

h1, h2, h3 {
  padding: 0;
  margin: 0;
  color: #444444;
  font-weight: 400;
  line-height: 110%;
}

h1 {
  font-size: 35px;
}

h2 {
  font-size: 30px;
}

h3 {
  font-size: 24px;
}

h4 {
  font-size: 18px;
  font-weight: normal;
}

.important-font {
  color: #21BEB4;
  font-weight: bold;
}

.hide {
  display: none !important;
}

.force-full-width {
  width: 100% !important;
}
  
.mediocuadrado{
  font-weight:bold;
  font-size:30px;
  color:#00B1F4;
}
 
.circulo{
  background-color:#9bb552;
  color:#ffffff;
  display:inline-block;
  font-family:sans-serif;
  font-size:13px;
  font-weight:bold;
  line-height:33px;
  text-align:center;
  text-decoration:none;
  width:100px;
  -webkit-text-size-adjust:none;
  border-radius: 20px;
}

.circulodos{
  background-color:#23ade4;
  color:#ffffff;
  display:inline-block;
  font-family:sans-serif;
  font-size:13px;
  font-weight:bold;
  line-height:33px;
  text-align:center;
  text-decoration:none;
  width:150px;
  -webkit-text-size-adjust:none;
  border-radius: 20px;
}

#pila1{ 
  width: 42px;
  height: 35px;
  background-color: #009fd8;
  color: #ccc;
  margin: 0 auto;
  position: relative;
  padding-top: 0px;
  text-align: center;
  z-index: 1;
  border-radius: 8px;
}
#pila1::before{
  content: "";
  width: 40px;
  height: 37px;
  background-color: #92b550;
  display: block;
  position: absolute;
  top: -20px;
  left: 48px;
  z-index: -1;
  border-radius: 8px;
}
#pila1::after{
  content: "";
  width: 30px;
  height: 25px;
  background-color: #ea7700;
  display: block;
  position: absolute;
  top: 24px;
  left: 65px;
  z-index: -1;
  border-radius: 8px;
}

</style>

<style type="text/css" media="screen">
  @media screen {
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:400);

    /* Thanks Outlook 2013! */
    td, h1, h2, h3 {
      font-family: 'Century Gothic' !important;
    }
  }
</style>

<style type="text/css" media="only screen and (max-width: 600px)">
/* Mobile styles */
@media only screen and (max-width: 600px) {

  table[class="w320"] {
    width: 320px !important;
  }

  table[class="w300"] {
    width: 300px !important;
  }

  table[class="w290"] {
    width: 290px !important;
  }

  td[class="w320"] {
    width: 320px !important;
  }

  td[class~="mobile-padding"] {
    padding-left: 14px !important;
    padding-right: 14px !important;
  }

  td[class*="mobile-padding-left"] {
    padding-left: 14px !important;
  }

  td[class*="mobile-padding-right"] {
    padding-right: 14px !important;
  }

  td[class*="mobile-block"] {
    display: block !important;
    width: 100% !important;
    text-align: left !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    padding-bottom: 15px !important;
  }

  td[class*="mobile-no-padding-bottom"] {
    padding-bottom: 0 !important;
  }

  td[class~="mobile-center"] {
    text-align: center !important;
  }

  table[class*="mobile-center-block"] {
    float: none !important;
    margin: 0 auto !important;
  }

  *[class*="mobile-hide"] {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
    line-height: 0 !important;
    font-size: 0 !important;
  }

  td[class*="mobile-border"] {
    border: 0 !important;
  }
}
</style>