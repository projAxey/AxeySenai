<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';

$response = [
    'produtosPendentes' => 0,
    'servicosAtivos' => 0,
    'usuariosAtivos' => 0,
    'prestadoresPendentes' => 0,

];

try {
    // Contador para produtos com status = 1 pendentes
    $stmt = $conexao->prepare("SELECT COUNT(*) as total FROM Produtos WHERE status = 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['produtosPendentes'] = $result['total'];

    // Contador para serviços com status = 2 ativos
    $stmt = $conexao->prepare("SELECT COUNT(*) as total FROM Produtos WHERE status = 2");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['servicosAtivos'] = $result['total'];

    $stmt = $conexao->prepare("SELECT COUNT(*) as total FROM Prestadores WHERE status = 3");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['prestadoresPendentes'] = $result['total'];

// Contador para usuarios ativos
    $stmt = $conexao->prepare("
        SELECT 
            (SELECT COUNT(*) FROM Prestadores WHERE status = 1) +
            (SELECT COUNT(*) FROM Clientes WHERE status = 1) AS total
    ");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['usuariosAtivos'] = $result['total'];

} catch (PDOException $e) {
    $response['error'] = 'Erro ao buscar contagens: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
