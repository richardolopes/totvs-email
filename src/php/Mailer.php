<?php

namespace Totvs;

use \PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public function __construct($subject, $html, $email, $csv = [])
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "automacaobot@gmail.com";
        $mail->Password = PASSWORD_EMAIL;
        $mail->setFrom('automacaobot@gmail.com', utf8_decode('Quebras Automação'));

        // if (count($email) > 0) {
        //     for ($i = 0; $i < count($email); $i++) {
        //         $mail->addAddress($email[$i], explode('@', $email[$i])[0]);
        //     }
        // }

        $mail->addAddress('richard.lopes@totvs.com.br', 'Richard');

        if (count($csv) > 0) {
            for ($i = 0; $i < count($csv); $i++) {
                $mail->AddAttachment($csv[$i]["LOCAL"], rawurldecode($csv[$i]["NOME"]));
            }
        }

        $mail->Subject = utf8_decode($subject);
        $mail->msgHTML($html);

        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return "Message sent!";
        }
    }

}
