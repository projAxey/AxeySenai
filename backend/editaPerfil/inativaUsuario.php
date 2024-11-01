
<?php

/*
    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO


    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO

    ESSA FUNÇÃO SERÁ IMPLEMENTADA NO FUTURO


*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';

// Verifica se a requisição foi feita por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['userId'];
    $table = $_POST['table'];
    $user_type = $_POST['userType'];

    if (strpos($user_type, 'Prestador PF') !== false || strpos($user_type, 'Prestador PJ') !== false) {
        $queryProdutos = "SELECT * FROM Produtos WHERE prestador = :id";
        $stmtProdutos = $conexao->prepare($queryProdutos);
        $stmtProdutos->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtProdutos->execute();
        if ($stmtProdutos->rowCount() > 0) {
            // Armazena a mensagem na sessão
            $_SESSION['message'] = "Este usuário possui produtos associados e não é possível excluí-lo.";
            header("Location: ../../frontend/adm/controleUsuarios.php");
            exit();
        }
    }

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

    // Se não há produtos associados, tentamos excluir o usuário
    $query = "DELETE FROM " . $table . " WHERE " . $coluna . " = :id";

    try {
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Mensagem de sucesso ou erro após a exclusão
        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = "Usuário excluído com sucesso!";
        } else {
            $_SESSION['message'] = "Erro: Usuário não encontrado ou já excluído.";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro ao deletar usuário: " . $e->getMessage() . " (" . $e->getCode() . ")";
    }

    // Redirecionar após a operação
    header("Location: ../../frontend/adm/controleUsuarios.php");
    exit();
}
?>
