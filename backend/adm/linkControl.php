<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(["status" => "error", "message" => "Usuário não autenticado."]);
    exit();
}

include '../../config/conexao.php';

// Função para validar entradas obrigatórias
function checkRequiredFields($fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return false;
        }
    }
    return true;
}

// CREATE LINK
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) || $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] !== 'PUT')) {
    $titulo = $_POST['titulo'] ?? '';
    $url = $_POST['url'] ?? '';
    $icone = !empty($_POST['icone']) ? $_POST['icone'] : null;

    // Validação de campos obrigatórios
    if (!checkRequiredFields([$titulo, $url])) {
        echo json_encode(["status" => "error", "message" => "Por favor, preencha todos os campos obrigatórios."]);
        exit();
    }

    try {
        $sql = "INSERT INTO LinksUteis (titulo_link, url_link, icon) VALUES (:titulo, :url, :icone)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':icone', $icone, PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Link salvo com sucesso."]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erro ao cadastrar o link: " . $e->getMessage()]);
        exit;
    }
}

// EDIT LINK
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) && $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] === 'PUT') {
    $id = $_POST['id'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $url = $_POST['url'] ?? '';
    $icone = !empty($_POST['icone']) ? $_POST['icone'] : null;

    if (!checkRequiredFields([$id, $titulo, $url])) {
        echo json_encode(["status" => "error", "message" => "ID, título e URL são obrigatórios para edição."]);
        exit();
    }

    try {
        $sql = $icone !== null
            ? "UPDATE LinksUteis SET titulo_link = :titulo, url_link = :url, icon = :icone WHERE link_id = :id"
            : "UPDATE LinksUteis SET titulo_link = :titulo, url_link = :url WHERE link_id = :id";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':url', $url);

        if ($icone !== null) {
            $stmt->bindParam(':icone', $icone);
        }

        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Link atualizado com sucesso."]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erro ao atualizar o link: " . $e->getMessage()]);
        exit;
    }
}

// DELETE LINK
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'] ?? '';

    if (empty($id)) {
        echo json_encode(["status" => "error", "message" => "ID do link é obrigatório para exclusão."]);
        exit();
    }

    try {
        $sql = "DELETE FROM LinksUteis WHERE link_id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Link excluído com sucesso."]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erro ao excluir o link: " . $e->getMessage()]);
        exit;
    }
}

// GET ALL LINKS
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $sql = "SELECT link_id, titulo_link, url_link, icon FROM LinksUteis";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $links = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["status" => "success", "data" => $links]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erro ao buscar links: " . $e->getMessage()]);
        exit;
    }
}

echo json_encode(["status" => "error", "message" => "Método inválido."]);
exit;

