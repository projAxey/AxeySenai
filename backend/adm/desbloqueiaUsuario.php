<?php
session_start(); // Inicia a sessão
include '../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userIdUnblock'];
    $userType = $_POST['userTypeUnblock'];
    $table = $_POST['tableUnblock'];

    // Determina a coluna correta com base na tabela
    if ($table === 'Prestadores') {
        $coluna = 'prestador_id';
    } elseif ($table === 'UsuariosAdm') {
        $coluna = 'usuarioAdm_id';
    } elseif ($table === 'Clientes') {
        $coluna = 'cliente_id';
    } else {
        // Armazena a mensagem de tabela desconhecida na sessão
        $_SESSION['message'] = "Tabela desconhecida.";
        header("Location: ../../frontend/adm/controleUsuarios.php");
        exit();
    }

    try {
        // Atualiza produtos associados, se for um prestador
        if (strpos($userType, 'Prestador') !== false) {
            $queryProdutos = "UPDATE Produtos SET status = 2 WHERE prestador = :userId";
            $stmtProdutos = $conexao->prepare($queryProdutos);
            $stmtProdutos->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmtProdutos->execute();
        }

        // Bloqueia o usuário na tabela especificada
        $queryblock = "UPDATE $table SET status = 1 WHERE $coluna = :userId";
        $stmtblock = $conexao->prepare($queryblock);
        $stmtblock->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtblock->execute();

        // Define a mensagem de sucesso ou erro
        if ($stmtblock->rowCount() > 0) {
            $_SESSION['message'] = "Usuário desbloqueado com sucesso!";
        } else {
            $_SESSION['message'] = "Erro: Usuário não encontrado ou já desbloqueado.";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro ao desbloquear usuário: " . $e->getMessage();
    }

    // Redireciona após o processamento
    header("Location: ../../frontend/adm/controleUsuarios.php");
    exit();
} else {
    $_SESSION['message'] = "Dados insuficientes para realizar o desbloqueio.";
    header("Location: ../../frontend/adm/controleUsuarios.php");
    exit();
}
