<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto_id'])) {
    $produtoId = $_POST['produto_id'];

    try {
        // Atualizar o campo categoria_produto para 1 no banco de dados
        $sql = "UPDATE Produtos SET categoria_produto = 1 WHERE produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhum produto atualizado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o destaque: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Produto ID não especificado ou método incorreto.']);
}
