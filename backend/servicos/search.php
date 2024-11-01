<?php
include '../../config/conexao.php';

$query = $_GET['query'] ?? '';

if (!empty($query)) {
    $stmt = $conexao->prepare("SELECT produto_id, nome_produto FROM Produtos WHERE nome_produto LIKE :query OR descricao_produto LIKE :query LIMIT 10");
    $stmt->execute(['query' => "%$query%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}
