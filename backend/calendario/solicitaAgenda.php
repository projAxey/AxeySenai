<?php

header('Content-Type: application/json');
include_once "/xampp/htdocs/projAxeySenai/config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if ($id) {
    // Consulta para buscar as informações de acordo com o ID
    $buscaAgendamento = 'SELECT 
    Produtos.produto_id,
    Produtos.prestador AS prestador_produto,
    Produtos.nome_produto,
    Produtos.descricao_produto,
    Agendas.agenda_id,
    Agendas.prestador AS prestador_agenda,
    Agendas.data_agenda,
    Agendas.data_final,
    Agendas.hora_inicio,
    Agendas.hora_final
FROM Produtos
INNER JOIN Agendas ON Produtos.prestador = Agendas.prestador
WHERE Produtos.produto_id = :produto_id';
    $stmt = $conexao->prepare($buscaAgendamento);
    $stmt->bindParam(':produto_id', $id, PDO::PARAM_INT);
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