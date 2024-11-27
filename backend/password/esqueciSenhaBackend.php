<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../../config/conexao.php';
require '../../utils/emailPadrao.php'; 

if (isset($_POST['btnRecuperar'])) {
    if (empty($_POST['emailRecuperaSenha']) || $_POST['emailRecuperaSenha'] == '') {
        header('Location: ../../frontend/auth/login.php?aviso=1');
        exit();
    } else {
        $email = $_POST['emailRecuperaSenha'];
        $userType = $_POST['user_type'];  

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

            $token = bin2hex(random_bytes(25));

            $sqlUpdate = "UPDATE $tabela SET token_temp = :token WHERE email = :email";
            $stmtUpdate = $conexao->prepare($sqlUpdate);
            $stmtUpdate->execute([':token' => $token, ':email' => $email]);

            $resetUrl = "http://$_SERVER[HTTP_HOST]/projAxeySenai/frontend/password/resetSenha.php?token=$token";

            $subject = 'Recuperação de Senha';
            $body = "
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
            $altBody = "Olá $nome, Clique no link para redefinir sua senha: $resetUrl";

            try {
                sendEmail($email, $nome, $subject, $body, $altBody); // Chamada à função reutilizável
                header('Location: ../../frontend/auth/login.php?aviso=3');
            } catch (Exception $e) {
                echo "Erro no envio: {$e->getMessage()}";
            }
        } else {
            header('Location: ../../frontend/auth/login.php?aviso=2');
            exit();
        }
    }
} else {
    echo 'Erro ao acessar a página.';
}
