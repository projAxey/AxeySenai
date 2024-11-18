
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['id'];
    $tipoUsuario = $_SESSION['tipo_usuario'];

    if (strpos($tipoUsuario, 'Prestador PF') !== false || strpos($tipoUsuario, 'Prestador PJ') !== false) {

        $queryProdutos = "SELECT * FROM Produtos WHERE prestador = :id";
        $stmtProdutos = $conexao->prepare($queryProdutos);
        $stmtProdutos->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtProdutos->execute();

        if ($stmtProdutos->rowCount() > 0) {
            // Se o prestador tiver produtos associados, altere o status dos produtos para "removido"
            $queryUpdateProdutos = "UPDATE Produtos SET status = 4 WHERE prestador = :id";
            $stmtUpdateProdutos = $conexao->prepare($queryUpdateProdutos);
            $stmtUpdateProdutos->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtUpdateProdutos->execute();

            // Armazena a mensagem na sessão
            $_SESSION['message'] = "Este usuário possui produtos associados. Os produtos foram removidos (status 4).";
            header("Location: ../../frontend/adm/controleUsuarios.php");
            exit();
        } else {
            // Caso não tenha produtos associados, pode continuar com o processo de exclusão do usuário ou outra lógica
            $_SESSION['message'] = "Nenhum produto associado encontrado.";
            header("Location: ../../frontend/adm/controleUsuarios.php");
            exit();
        }
    }
}
?>
