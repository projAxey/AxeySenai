<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
include_once "../../config/conexao.php";


$idAgendamento = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
// $idAgendamento=12;
if ($idAgendamento) {
    $buscaAgendamentos = 'SELECT agendamento_id FROM Agendamentos WHERE agendamento_id = :disponibilidadeId';
    $stmt = $conexao->prepare($buscaAgendamentos);
    $stmt->bindParam(':disponibilidadeId', $idAgendamento, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($agendamentos);
    } else {
        echo json_encode(['error' => 'Nenhum agendamento encontrado']);
    }
} else {
    echo json_encode(['error' => 'ID inválido']);
}

?>