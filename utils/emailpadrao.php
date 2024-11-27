<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/projAxeySenai/vendor/autoload.php'; // Certifique-se de ajustar o caminho conforme necessário

/**
 * Envia um e-mail com PHPMailer.
 *
 * @param string $toEmail Endereço de e-mail do destinatário
 * @param string $toName Nome do destinatário
 * @param string $subject Assunto do e-mail
 * @param string $body Conteúdo HTML do e-mail
 * @param string $altBody Conteúdo alternativo (texto plano)
 * @return void
 * @throws Exception
 */
function sendEmail($toEmail, $toName, $subject, $body, $altBody) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'axeysenai@gmail.com'; // Substitua pelo seu e-mail
        $mail->Password   = 'jrlf aobm txnl ovpz'; // Substitua pela sua senha ou app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Configuração do remetente e destinatário
        $mail->setFrom('axeysenai@gmail.com', 'Equipe Axey');
        $mail->addAddress($toEmail, $toName);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altBody;

        $mail->send();
    } catch (Exception $e) {
        throw new Exception("Erro ao enviar e-mail: {$mail->ErrorInfo}");
    }
}
