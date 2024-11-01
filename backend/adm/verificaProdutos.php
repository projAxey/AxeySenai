<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';

if (isset($_POST['userId']) && isset($_POST['table'])) {
    $userId = $_POST['userId'];
    
    // Consulta para verificar produtos associados
    $queryProdutos = "SELECT * FROM Produtos WHERE prestador = :userId";
    $stmt = $conexao->prepare($queryProdutos);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($produtos);
} else {
    echo json_encode([]);
}
?>