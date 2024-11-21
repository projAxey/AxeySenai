<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
include_once "../../config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    // Prepara a query de exclusão
    $queryUsuario = "DELETE FROM Agendamentos WHERE agendamento_id = :id";
    $resultadoUsuario = $conexao->prepare($queryUsuario);
    $resultadoUsuario->bindParam(':id', $id);

    // Tenta executar a query
    if ($resultadoUsuario->execute() && $resultadoUsuario->rowCount() > 0) {
        $retorna = ['status' => true, 'msg' => "Agendamento apagado com sucesso"];
    } else {
        $erroInfo = $resultadoUsuario->errorInfo();
        $retorna = [
            'status' => false,
            'msg' => "Erro: Agendamento não encontrado ou não foi possível apagá-lo. Detalhes: " . $erroInfo[2]
        ];
    }
} else {
    // Caso o ID não seja fornecido ou seja inválido
    $retorna = ['status' => false, 'msg' => "Erro: ID inválido. Não foi possível apagar o Agendamento."];
}

echo json_encode($retorna);
?>
