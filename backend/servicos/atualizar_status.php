<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php'; // Conectando ao banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'];
    $status = $_POST['status'];
    

    try {
        $sql = "UPDATE Produtos SET status = :status WHERE produto_id = :produto_id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirecionar de volta para a página anterior
        if(isset($_POST['aprovar'])) {
            header("Location: ../../frontend/adm/controleServicos.php?status=1");
            exit();
        }
        header("Location: ../../frontend/adm/controleServicos.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar o status: " . $e->getMessage();
    }
}
?>
