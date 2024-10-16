<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
include '../../config/conexao.php';

if (isset($_POST['btnRecuperar'])) {
    if (empty($_POST['emailRecuperaSenha']) || $_POST['emailRecuperaSenha'] == '') {
        header('Location: ../../frontend/auth/login.php?erro=1');
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
            header('Location: ../../frontend/auth/login.php?erro=2');
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
            $mail->Password   = 'Axey@2024';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('axeysenai@gmail.com', 'No Reply');
            $mail->addAddress($email, $nome);
            $mail->addReplyTo('axeysenai@gmail.com', 'Information');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Recuperar Senha';
            $mail->Body    = "Olá $nome, <br> Clique no link abaixo para redefinir sua senha: <br>
                              <a href='$resetUrl'>Redefinir Senha</a>";
            $mail->AltBody = "Olá $nome, Clique no link para redefinir sua senha: $resetUrl";

            $mail->send();
            echo 'E-mail enviado para redefinição de senha.';
        } catch (Exception $e) {
            echo "Erro no envio: {$mail->ErrorInfo}";
        }
    }
} else {
    echo 'Erro ao acessar a página.';
}
