<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
include_once "/projAxeySenai/config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    // Prepara a query de exclusão
    $querryUsuario = "DELETE FROM Agendas WHERE agenda_id=:id";
    $resultadoUsuario = $conexao->prepare($querryUsuario);
    $resultadoUsuario->bindParam(':id', $id);

    // Tenta executar a query
    if ($resultadoUsuario->execute()) {
        // Resposta de sucesso, status deve ser 'true'
        $retorna = ['status' => true, 'msg' => "Disponibilidade apagada com sucesso"];
    } else {
        // Resposta de erro, status deve ser 'false'
        $retorna = ['status' => false, 'msg' => "Erro: Não foi possível apagar a disponibilidade "];
    }
} else {
    // Caso o ID não seja fornecido
    $retorna = ['status' => false, 'msg' => "Erro: Não foi possível apagar a disponibilidade. ID inválido."];
}

// Retorna o JSON para o cliente
echo json_encode($retorna);

// header("Location: /projAxeySenai/frontend/prestador/gerenciarAgenda.php");
