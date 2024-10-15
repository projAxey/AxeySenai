<?php
session_start();
include '../../config/conexao.php'; // Inclua sua conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senhaAtual = $_POST['senhaAtual'];
    $novaSenha = $_POST['senha'];
    $user_id = $_SESSION['id']; // Pegue o ID do usuário da sessão
    $tipoUsuario = $_SESSION['tipo_usuario'];

    // Consulta ao banco para verificar a senha atual
    $query = "SELECT senha FROM Clientes WHERE cliente_id = :id UNION SELECT senha FROM Prestadores WHERE prestador_id = :id";
    $stmtCheck = $conexao->prepare($query); // Corrigido para usar a variável correta
    $stmtCheck->execute([':id' => $user_id]);
    $senhaDoBanco = $stmtCheck->fetchColumn();

    if (!$senhaDoBanco) {
        die('Erro ao buscar a senha do usuário.');
    } else if (password_verify($senhaAtual, $senhaDoBanco)) { // Verifica se a senha atual bate com a do banco
        // A senha atual está correta, agora criptografa a nova senha
        $senhaCriptografada = password_hash($novaSenha, PASSWORD_BCRYPT);

        // Atualiza a nova senha no banco de dados
        // Verifica em qual tabela atualizar
        $updateQuery = "UPDATE Clientes SET senha = :nova_senha WHERE cliente_id = :id";
        $updateQueryPrestador = "UPDATE Prestadores SET senha = :nova_senha WHERE prestador_id = :id";

        // Executa a atualização para a tabela correta
        if ($tipoUsuario == 'cliente') {
            $updateStmt = $conexao->prepare($updateQuery);
        } else {
            $updateStmt = $conexao->prepare($updateQueryPrestador);
        }

        $updateStmt->execute([
            ':nova_senha' => $senhaCriptografada,
            ':id' => $user_id
        ]);

        // Mensagem de sucesso
        $_SESSION['success'] = "Senha alterada com sucesso!";
    } else {
        // Mensagem de erro
        $_SESSION['error'] = "A senha atual está incorreta.";
    }

    // Redireciona de volta para a página anterior ou exibe a modal novamente
    header('Location: ../../frontend/auth/perfil.php'); // Altere para a página que deseja redirecionar
    exit();
}
