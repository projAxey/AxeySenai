<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
require '../../config/conexao.php';
require '../../utils/emailPadrao.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['id'];
    $tipoUsuario = $_SESSION['tipo_usuario'];
    $senhaInformada = $_POST['senha'];

    try {
        // Determina a tabela e os campos com base no tipo de usuário
        switch ($tipoUsuario) {
            case 'Prestador PF':
            case 'Prestador PJ':
                $tabelaUsuario = 'Prestadores';
                $colunaId = 'prestador_id';
                $campoSenha = 'senha';
                $campoProduto = 'prestador';
                $campoEmail = 'email';
                $campoNome = 'nome_resp_legal';
                break;

            case 'Administrador':
                $tabelaUsuario = 'Administradores';
                $colunaId = 'usuarioAdm_id';
                $campoSenha = 'senha';
                $campoProduto = null; // Administradores não têm produtos
                $campoEmail = 'email';
                $campoNome = 'nome'; // Ajuste conforme a estrutura da tabela
                break;

            default: // Clientes
                $tabelaUsuario = 'Clientes';
                $colunaId = 'cliente_id';
                $campoSenha = 'senha';
                $campoProduto = null; // Clientes não têm produtos
                $campoEmail = 'email';
                $campoNome = 'nome'; // Ajuste conforme a estrutura da tabela
                break;
        }

        // Consulta para verificar a senha
        $querySenha = "SELECT $campoSenha, $campoEmail, $campoNome FROM $tabelaUsuario WHERE $colunaId = :id";
        $stmtSenha = $conexao->prepare($querySenha);
        $stmtSenha->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtSenha->execute();

        if ($stmtSenha->rowCount() > 0) {
            $usuario = $stmtSenha->fetch(PDO::FETCH_ASSOC);
            $senhaHash = $usuario[$campoSenha];
            $emailUsuario = $usuario[$campoEmail];
            $nomeUsuario = $usuario[$campoNome];

            // Verifica se a senha informada está correta
            if (password_verify($senhaInformada, $senhaHash)) {
                // Atualiza produtos/serviços para Prestadores
                if ($campoProduto !== null) {
                    $queryUpdateProdutos = "UPDATE Produtos SET status = 5 WHERE $campoProduto = :id";
                    $stmtUpdateProdutos = $conexao->prepare($queryUpdateProdutos);
                    $stmtUpdateProdutos->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmtUpdateProdutos->execute();
                }

                // Atualiza o status do usuário para 3 (inativo)
                $queryUpdateUsuario = "UPDATE $tabelaUsuario SET status = 3 WHERE $colunaId = :id";
                $stmtUpdateUsuario = $conexao->prepare($queryUpdateUsuario);
                $stmtUpdateUsuario->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtUpdateUsuario->execute();

                // Envia notificação por e-mail
                $subject = "Conta Inativada";
                $body = "
                    <div style='font-family: Arial, color: #333;'>
                        <h2 style='color: #ff4d4d;'>Conta Inativada</h2>
                        <p>Olá <strong>$nomeUsuario</strong>,</p>
                        <p>Informamos que sua conta foi inativada no sistema.</p>
                        <p>Se isso foi um engano ou deseja reativá-la, entre em contato com o suporte.</p>
                        <br>
                        <p>Atenciosamente,<br>Equipe Axey</p>
                    </div>
                ";
                $altBody = "Olá $nomeUsuario, sua conta foi inativada. Entre em contato com o suporte para mais informações.";

                sendEmail($emailUsuario, $nomeUsuario, $subject, $body, $altBody);

                header("Location: ../../frontend/auth/perfil.php?status=excluido");
                exit();
            } else {
                // Senha inválida
                header("Location: ../../frontend/auth/perfil.php?status=errorSenha");
                exit();
            }
        } else {
            // Usuário não encontrado
            header("Location: ../../frontend/auth/perfil.php?status=error");
            exit();
        }
    } catch (PDOException $e) {
        // Captura erros de conexão ou execução
        $_SESSION['aviso'] = "Erro ao processar a solicitação: " . $e->getMessage();
        header("Location: ../../frontend/auth/perfil.php");
        exit();
    }
}
