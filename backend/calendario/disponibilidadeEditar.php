<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

header('Content-Type: application/json');
include_once "../../config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if ($id) {
    // Consulta para buscar as informações de acordo com o ID
    $buscaAgendamento = 'SELECT agenda_id,data_agenda, data_final, hora_inicio, hora_final FROM Agendas WHERE agenda_id = :id';
    $stmt = $conexao->prepare($buscaAgendamento);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Verifica se encontrou algum registro
    if ($stmt->rowCount() > 0) {
        $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($agendamento);
    } else {
        echo json_encode(['error' => 'Nenhum registro encontrado']);
    }
} else {
    echo json_encode(['error' => 'ID inválido']);
}

?>