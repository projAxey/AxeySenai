<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $novaSenha = $_POST['novaSenha'];

        if (isset($_POST['btnResetSenha'])) {
            $tabela = $_POST['tabela'];
            $user_id = $_POST['id'];
        }
        if (isset($_POST['btnAlterarSenha'])) {
            $senhaAtual = $_POST['senhaAtual'];
            $user_id = $_SESSION['id'];
            $tipoUsuario = $_SESSION['tipo_usuario'];

            $query = "SELECT senha FROM Clientes WHERE cliente_id = :id UNION SELECT senha FROM Prestadores WHERE prestador_id = :id";
            $stmtCheck = $conexao->prepare($query);
            $stmtCheck->execute([':id' => $user_id]);
            $senhaDoBanco = $stmtCheck->fetchColumn();

            if (!$senhaDoBanco) {
                die('Erro ao buscar a senha do usuário.');
            } else if (!password_verify($senhaAtual, $senhaDoBanco)) {
                $_SESSION['error'] = "A senha atual está incorreta.";
                header('Location: ../../frontend/auth/perfil.php?aviso=1');
                exit();
            }

            $tabela = ($tipoUsuario === 'Cliente') ? 'Clientes' : 'Prestadores';
        }

        $senhaCriptografada = password_hash($novaSenha, PASSWORD_BCRYPT);

        if ($tabela === 'Clientes') {
            $updateQuery = "UPDATE Clientes SET senha = :nova_senha, token_temp = NULL WHERE cliente_id = :id";
        } else if ($tabela === 'Prestadores') {
            $updateQuery = "UPDATE Prestadores SET senha = :nova_senha, token_temp = NULL WHERE prestador_id = :id";
        }

        $updateStmt = $conexao->prepare($updateQuery);
        $updateStmt->execute([
            ':nova_senha' => $senhaCriptografada,
            ':id' => $user_id
        ]);

        header('Location: ../../frontend/auth/login.php?aviso=4');
        exit();
    } catch (PDOException $e) {
        header('Location: ../../frontend/auth/login.php?aviso=5');
        exit();
    }
}
