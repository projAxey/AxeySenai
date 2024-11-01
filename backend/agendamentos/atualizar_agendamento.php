<?php
include '../../config/conexao.php';

if (isset($_POST['agendamento_id']) && isset($_POST['status'])) {
    $agendamento_id = $_POST['agendamento_id'];
    $status = (int) $_POST['status']; // Converta o status para inteiro para garantir a segurança

    $sql = "UPDATE Agendamentos SET status = :status WHERE agendamento_id = :agendamento_id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':agendamento_id', $agendamento_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status atualizado com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar status.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dados insuficientes para atualizar.']);
}