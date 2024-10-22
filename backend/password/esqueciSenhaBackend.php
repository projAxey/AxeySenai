<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
include '../../config/conexao.php';

if (isset($_POST['btnRecuperar'])) {
    if (empty($_POST['emailRecuperaSenha']) || $_POST['emailRecuperaSenha'] == '') {
        header('Location: ../../frontend/auth/login.php?aviso=1');
        exit();
    } else {

        $email = $_POST['emailRecuperaSenha'];

        // Verifica se o e-mail existe na tabela Clientes
        $sqlCliente = "SELECT cliente_id, nome, email FROM Clientes WHERE email = :email";
        $stmtCliente = $conexao->prepare($sqlCliente);
        $stmtCliente->execute([':email' => $email]);
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        // Verifica se o e-mail existe na tabela Prestadores
        $sqlPrestador = "SELECT prestador_id, nome_resp_legal, email FROM Prestadores WHERE email = :email";
        $stmtPrestador = $conexao->prepare($sqlPrestador);
        $stmtPrestador->execute([':email' => $email]);
        $prestador = $stmtPrestador->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            $id = $cliente['cliente_id'];
            $nome = $cliente['nome'];
            $email = $cliente['email'];
            $tabela = 'Clientes';
        } elseif ($prestador) {
            $id = $prestador['prestador_id'];
            $nome = $prestador['nome_resp_legal'];
            $email = $prestador['email'];
            $tabela = 'Prestadores';
        } else {
            header('Location: ../../frontend/auth/login.php?aviso=2');
            exit();
        }

        // Gera o token de 50 caracteres
        $token = bin2hex(random_bytes(25));

        // Atualiza o token na tabela correspondente
        $sqlUpdate = "UPDATE $tabela SET token_temp = :token WHERE email = :email";
        $stmtUpdate = $conexao->prepare($sqlUpdate);
        $stmtUpdate->execute([':token' => $token, ':email' => $email]);

        // URL para redefinir senha
        $resetUrl = "https://axey.fun/projAxeySenai/frontend/password/resetSenha.php?token=$token";

        // Envia o e-mail com o link de redefinição de senha
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'axeysenai@gmail.com';
            $mail->Password   = 'xwsg zjwx mmzy gqvi';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('axeysenai@gmail.com', 'No Reply');
            $mail->addAddress($email, $nome);
            $mail->addReplyTo('axeysenai@gmail.com', 'Information');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Recuperar Senha';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; color: #333; text-align: center;'>
                    <h2 style='color: #4CAF50;'>Recuperação de Senha</h2>
                    <p>Olá <strong>$nome</strong>,</p>
                    <p>Recebemos uma solicitação para redefinir sua senha. Para continuar, clique no botão abaixo:</p>
                    <a href='$resetUrl' style='display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;'>Redefinir Senha</a>
                    <p style='margin-top: 20px;'>Se você não solicitou essa alteração, ignore este e-mail. Sua senha permanecerá inalterada.</p>
                    <br>
                    <p>Atenciosamente,<br>
                    <strong>Equipe Axey</strong></p>
                </div>
            ";
            $mail->AltBody = "Olá $nome, Clique no link para redefinir sua senha: $resetUrl";
            $mail->send();
            header('Location: ../../frontend/auth/login.php?aviso=3');
        } catch (Exception $e) {
            echo "Erro no envio: {$mail->ErrorInfo}";
        }
    }
} else {
    echo 'Erro ao acessar a página.';
}
