<?php
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
        header("Location: ../../frontend/adm/controleServicos.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar o status: " . $e->getMessage();
    }
}
?>
