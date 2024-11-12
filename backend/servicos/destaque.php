<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto_id'])) {
    $produto_id = $_POST['produto_id'];
    $status = 1;

    if (isset($_POST['criaDestaque'])) {
        $status = 2;
    }

    try {
        $sql = "UPDATE Produtos SET status_destaque = :status WHERE produto_id = :produto_id";
        $stmt = $conexao->prepare($sql);

        // Correção: bindParam separados
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header('Location: ../../frontend/prestador/TelaMeusAnuncios.php?mensagem_sucesso=1');
            exit;
        } else {
            echo "Erro ao atualizar o destaque.";
        }
    } catch (PDOException $e) {
        echo "Erro ao atualizar o destaque: " . $e->getMessage();
    }
} else {
    echo "Dados inválidos.";
}
