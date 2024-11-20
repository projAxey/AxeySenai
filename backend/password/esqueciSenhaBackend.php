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
        $userType = $_POST['user_type'];  // Captura o tipo de usuário do formulário

        // Verifica se o e-mail existe na tabela correspondente
        if ($userType == 'cliente') {
            $sql = "SELECT cliente_id, nome, email FROM Clientes WHERE email = :email";
        } elseif ($userType == 'prestador') {
            $sql = "SELECT prestador_id, nome_resp_legal, email FROM Prestadores WHERE email = :email";
        } else {
            $sql = "SELECT UsuarioAdm_id, nome, email FROM UsuariosAdm WHERE email = :email";
        }

        $stmt = $conexao->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Recupera o ID, nome e e-mail do usuário
            if ($userType == 'cliente') {
                $id = $usuario['cliente_id'];
                $nome = $usuario['nome'];
                $tabela = 'Clientes';
            } elseif ($userType == 'prestador') {
                $id = $usuario['prestador_id'];
                $nome = $usuario['nome_resp_legal'];
                $tabela = 'Prestadores';
            } else {
                $id = $usuario['usuario_id'];
                $nome = $usuario['nome'];
                $tabela = 'UsuariosAdm';
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

                // Recipients
                $mail->setFrom('axeysenai@gmail.com', 'No Reply');
                $mail->addAddress($email, $nome);
                $mail->addReplyTo('axeysenai@gmail.com', 'Information');

                // Content
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
        } else {
            header('Location: ../../frontend/auth/login.php?aviso=2');
            exit();
        }
    }
} else {
    echo 'Erro ao acessar a página.';
}
