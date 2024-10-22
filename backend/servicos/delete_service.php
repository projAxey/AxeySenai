<?php
session_start();
include '../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produtoId = $_POST['produto_id'];

    try {
        // Exclui o produto
        $sql = "DELETE FROM Produtos WHERE produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();

        // Retorna uma resposta de sucesso
        echo 'Serviço excluído com sucesso.';
    } catch (PDOException $e) {
        echo 'Erro ao excluir serviço: ' . $e->getMessage();
    }
}
?>
