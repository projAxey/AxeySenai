<?php
session_start();
include '../../config/conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaSenha = $_POST['novaSenha']; // Captura o campo 'novaSenha', presente nos dois formulários

    // Verifica se o formulário veio da página de redefinição (reset senha)
    if (isset($_POST['btnResetSenha'])) {
        $tabela = $_POST['tabela']; 
        $user_id = $_POST['id']; 
    }
    // Caso venha da página de alteração de senha (perfil), faz a verificação da senha atual
    if (isset($_POST['btnAlterarSenha'])) {
        $senhaAtual = $_POST['senhaAtual'];
        $user_id = $_SESSION['id']; 
        $tipoUsuario = $_SESSION['tipo_usuario'];

        // Consulta ao banco para verificar a senha atual
        $query = "SELECT senha FROM Clientes WHERE cliente_id = :id UNION SELECT senha FROM Prestadores WHERE prestador_id = :id";
        $stmtCheck = $conexao->prepare($query);
        $stmtCheck->execute([':id' => $user_id]);
        $senhaDoBanco = $stmtCheck->fetchColumn();

        if (!$senhaDoBanco) {
            die('Erro ao buscar a senha do usuário.');
        } else if (!password_verify($senhaAtual, $senhaDoBanco)) {
            $_SESSION['error'] = "A senha atual está incorreta.";
            header('Location: ../../frontend/auth/perfil.php'); 
            exit();
        }

        // Define a tabela correta para a consulta, com base no tipo de usuário da sessão
        $tabela = ($tipoUsuario === 'cliente') ? 'Clientes' : 'Prestadores';
    }

    // Criptografa a nova senha
    $senhaCriptografada = password_hash($novaSenha, PASSWORD_BCRYPT);

    // Define a query de atualização para a tabela correta
    if ($tabela === 'Clientes') {
        $updateQuery = "UPDATE Clientes SET senha = :nova_senha, token_temp = NULL WHERE cliente_id = :id";
    } else if ($tabela === 'Prestadores') {
        $updateQuery = "UPDATE Prestadores SET senha = :nova_senha, token_temp = NULL WHERE prestador_id = :id";
    }

    // Prepara e executa a atualização
    $updateStmt = $conexao->prepare($updateQuery);
    $updateStmt->execute([
        ':nova_senha' => $senhaCriptografada,
        ':id' => $user_id
    ]);

    // Mensagem de sucesso e redirecionamento
    header('Location: ../../frontend/auth/login.php');
    exit();
}
