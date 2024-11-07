<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';

header('Content-Type: application/json');

// Receber o JSON enviado pelo JavaScript
$data = json_decode(file_get_contents("php://input"), true);

// Verificar se os campos necessários estão presentes
if (isset($data['titulo_Link']) && isset($data['url_link']) && isset($data['icon'])) {
    $titulo = $data['titulo_Link'];
    $url = $data['url_link'];
    $icon = $data['icon'];

    // Preparar a instrução SQL para inserção
    $stmt = $conn->prepare("INSERT INTO LinksUteis (titulo_Link, url_link, icon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $titulo, $url, $icon);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Link criado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados no banco de dados.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
}

$conn->close();
?>
