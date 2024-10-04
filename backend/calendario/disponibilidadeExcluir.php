<?php
header('Content-Type: application/json');
include_once "/xampp/htdocs/projAxeySenai/config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    // Prepara a query de exclusão
    $querryUsuario = "DELETE FROM teste WHERE id=:id";
    $resultadoUsuario = $conexao->prepare($querryUsuario);
    $resultadoUsuario->bindParam(':id', $id);

    // Tenta executar a query
    if ($resultadoUsuario->execute()) {
        // Resposta de sucesso, status deve ser 'true'
        $retorna = ['status' => true, 'msg' => "Disponibilidade $id apagada com sucesso"];
    } else {
        // Resposta de erro, status deve ser 'false'
        $retorna = ['status' => false, 'msg' => "Erro: Não foi possível apagar a disponibilidade $id"];
    }
} else {
    // Caso o ID não seja fornecido
    $retorna = ['status' => false, 'msg' => "Erro: Não foi possível apagar a disponibilidade. ID inválido."];
}

// Retorna o JSON para o cliente
echo json_encode($retorna);
