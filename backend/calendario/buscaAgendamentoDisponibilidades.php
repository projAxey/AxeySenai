<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
include_once "../../config/conexao.php";


$idDisponibilidade = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
// $idAgendamento=12;
if ($idDisponibilidade) {
    $buscaAgendamentos = 'SELECT 
    Agendamentos.id_agendas
    FROM Agendamentos
    WHERE Agendamentos.id_agendas = :id_agendas';
    $stmt = $conexao->prepare($buscaAgendamentos);
    $stmt->bindParam(':id_agendas', $idDisponibilidade, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $agendamentos = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($agendamentos);
    } else {
        echo json_encode(['error' => 'Nenhum agendamento encontrado']);
    }
} else {
    echo json_encode(['error' => 'ID inválido']);
}
