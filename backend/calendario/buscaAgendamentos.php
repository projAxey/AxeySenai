<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
include_once "../../config/conexao.php";


$idAgendamento = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
// $idAgendamento=12;
if ($idAgendamento) {
    $buscaAgendamentos = 'SELECT 
    Produtos.nome_produto,
    Categorias.titulo_categoria,
    Agendamentos.data_agenda,
    Prestadores.nome_fantasia,
    Prestadores.razao_social,
    Prestadores.nome_social,
    Prestadores.nome,    
    Prestadores.nome_resp_legal,
    Agendamentos.servico_descricao
    FROM Agendamentos 
    INNER JOIN Produtos ON Agendamentos.produto = Produtos.produto_id
    INNER JOIN Prestadores ON Produtos.prestador = Prestadores.prestador_id
    INNER JOIN Categorias ON Produtos.categoria = Categorias.categoria_id
    WHERE agendamento_id = :disponibilidadeId';
    $stmt = $conexao->prepare($buscaAgendamentos);
    $stmt->bindParam(':disponibilidadeId', $idAgendamento, PDO::PARAM_INT);
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
