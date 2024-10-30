<?php
include '../../config/conexao.php';

$response = [
    'destaquesPendentes' => 0,
    'produtosPendentes' => 0,
    'servicosAtivos' => 0,
];

try {
    // Contador para produtos com categoria_produto = 3 (Destaques pendentes)
    $stmt = $conexao->prepare("SELECT COUNT(*) as total FROM Produtos WHERE categoria_produto = 3");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['destaquesPendentes'] = $result['total'];

    // Contador para produtos com status = 1 (Produtos pendentes)
    $stmt = $conexao->prepare("SELECT COUNT(*) as total FROM Produtos WHERE status = 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['produtosPendentes'] = $result['total'];

    // Contador para serviços com status = 2 (Serviços ativos)
    $stmt = $conexao->prepare("SELECT COUNT(*) as total FROM Produtos WHERE status = 2");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['servicosAtivos'] = $result['total'];

} catch (PDOException $e) {
    $response['error'] = 'Erro ao buscar contagens: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
