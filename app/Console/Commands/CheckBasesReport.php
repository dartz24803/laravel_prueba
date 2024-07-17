<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CheckBasesReport extends Command
{
    protected $signature = 'report:checkbases';

    protected $description = 'Check bases report and send email if necessary';

    public function handle(){
        // Ejecutar la consulta
        $sql = "SELECT 
                    IFNULL(rfa.categoria, 'Sin categoría') AS categoria,
                    bases.base,
                    IFNULL(COUNT(rf.id), 0) AS num_fotos
                FROM 
                    (SELECT DISTINCT base FROM reporte_fotografico_new WHERE base LIKE 'B%') AS bases
                CROSS JOIN 
                    (SELECT * FROM reporte_fotografico_adm_new WHERE estado = 1) rfa
                LEFT JOIN 
                    codigos_reporte_fotografico_new crf ON rfa.id = crf.tipo
                LEFT JOIN 
                    reporte_fotografico_new rf ON crf.id = rf.codigo AND rf.estado = 1 AND DATE(rf.fec_reg) = CURDATE() AND bases.base = rf.base
                GROUP BY 
                    rfa.categoria,
                    bases.base
                HAVING 
                    num_fotos = 0
                ORDER BY 
                    bases.base ASC,
                    categoria ASC;";

        $results = DB::select($sql);

        // Verificar si hay resultados
        if (count($results) > 0) {
            // Construir el cuerpo del correo con una tabla HTML
            $emailBody = '<h2>Reporte diario de bases</h2>';
            $emailBody .= '<p>A continuación se presenta el detalle de las bases con menos 0 fotos hoy:</p>';
            $emailBody .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
            $emailBody .= '<thead>';
            $emailBody .= '<tr>';
            $emailBody .= '<th style="text-align: center;">Base</th>';
            $emailBody .= '<th style="text-align: center;">Categoría</th>';
            $emailBody .= '<th style="text-align: center;"># Fotos</th>';
            $emailBody .= '</tr>';
            $emailBody .= '</thead>';
            $emailBody .= '<tbody>';

            foreach ($results as $result) {
                $emailBody .= '<tr>';
                $emailBody .= '<td>' . $result->base . '</td>';
                $emailBody .= '<td>' . $result->categoria . '</td>';
                $emailBody .= '<td style="text-align: center;">' . $result->num_fotos . '</td>';
                $emailBody .= '</tr>';
            }

            $emailBody .= '</tbody>';
            $emailBody .= '</table>';

            // Enviar correo con el detalle
            $this->sendEmail($emailBody);
        } else {
            $this->info('No hay bases con 0 fotos hoy.');
        }

        return 0;
    }

    protected function sendEmail($emailBody){
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       =  'mail.lanumero1.com.pe';
            $mail->SMTPAuth   =  true;
            $mail->Username   =  'intranet@lanumero1.com.pe';
            $mail->Password   =  'lanumero1$1';
            $mail->SMTPSecure =  'tls';
            $mail->Port     =  587;
            $mail->setFrom('somosuno@lanumero1.com.pe','REPORTE FOTOGRAFICO CONTROL');

            $mail->addAddress('pcardenas@lanumero1.com.pe');
            /*$mail->addCC("acanales@lanumero1.com.pe");
            $mail->addCC("dvilca@lanumero1.com.pe");
            $mail->addCC("fclaverias@lanumero1.com.pe");*/

            $mail->isHTML(true);
            $mail->Subject = 'Reporte diario de bases con 0 fotos';
            $mail->Body    = $emailBody;
            $mail->CharSet = 'UTF-8';

            $mail->send();
            $this->info('Correo enviado correctamente.');
        } catch (Exception $e) {
            $this->error("Error al enviar el correo: {$mail->ErrorInfo}");
        }
    }
}
