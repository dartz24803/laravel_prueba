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
                                                <h2 class="mediocuadrado">Nuevo comentario</h2><br>
                                                    <span style="font-weight:bold;">Título: </span><?php if(isset($get_ticket[0]['titulo'])){ echo $get_ticket[0]['titulo']; } ?><br><br>
                                                    <span style="font-weight:bold;">Descripción:</span><br> 
                                                    <?php if(isset($get_ticket[0]['descripcion'])){ echo $get_ticket[0]['descripcion']; } ?><br><br>
                                                    <span style="font-weight:bold;">Comentarios</span><br><br>
                                                    <?php foreach($list_comentario as $list){ ?>
                                                        <?php echo $list['fecha']; ?> - <?php echo $list['comentarista']; ?> ha comentado:<br>
                                                        <?php echo $list['comentario']; ?><br><br>
                                                    <?php } ?>
                                                    <span style="color:#00B1F4;font-weight:bold;">Familiaridad</span><br>
                                                    Unión, humanidad, confianza y empatía entre todos los miembros de la empresa y nuestros clientes
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