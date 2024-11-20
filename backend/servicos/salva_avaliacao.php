<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Conexão com o banco de dados
        include '../../config/conexao.php';

        // Dados enviados pelo front-end
        $data = json_decode(file_get_contents('php://input'), true);
        $agendamentoId = $data['agendamentoId'] ?? null;
        $nota = $data['nota'] ?? null;
        $comentario = $data['comentario'] ?? '';

        // Obter produto com base no agendamento
        $queryAgendamento = 'SELECT A.produto, p.prestador
                            FROM Agendamentos A
                            JOIN Produtos p ON A.produto = p.produto_id
                            WHERE agendamento_id = :agendamentoId';
        $stmtAgendamento = $conexao->prepare($queryAgendamento);
        $stmtAgendamento->bindParam(':agendamentoId', $agendamentoId, PDO::PARAM_INT);
        $stmtAgendamento->execute();
        $agendamentoData = $stmtAgendamento->fetch(PDO::FETCH_ASSOC);

        if (!$agendamentoData) {
            echo json_encode([
                'status' => false,
                'msg' => 'Agendamento não encontrado.'
            ]);
            exit();
        }

        $produto = $agendamentoData['produto'];
        $prestador = $agendamentoData['prestador'];

        // Validar dados
        if (!$agendamentoId || !$nota || !$produto || !$prestador) {
            echo json_encode([
                'status' => false,
                'msg' => 'Todos os campos obrigatórios devem ser preenchidos.'
            ]);
            exit();
        }

        // Inserir a avaliação no banco de dados
        $query = 'INSERT INTO Avaliacoes (produto, agendamento, nota, comentario, prestador) 
                  VALUES (:produto, :agendamento, :nota, :comentario, :prestador)';
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':produto', $produto, PDO::PARAM_INT);
        $stmt->bindParam(':agendamento', $agendamentoId, PDO::PARAM_INT);
        $stmt->bindParam(':nota', $nota, PDO::PARAM_INT);
        $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
        $stmt->bindParam(':prestador', $prestador, PDO::PARAM_INT);
        $stmt->execute();

        // Atualizar o status do agendamento para "Finalizado"
        $updateStatus = 'UPDATE Agendamentos SET status = 4 WHERE agendamento_id = :agendamentoId';
        $stmtUpdate = $conexao->prepare($updateStatus);
        $stmtUpdate->bindParam(':agendamentoId', $agendamentoId, PDO::PARAM_INT);
        $stmtUpdate->execute();

        echo json_encode([
            'status' => true,
            'msg' => 'Avaliação salva com sucesso!'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'msg' => 'Erro ao salvar avaliação: ' . $e->getMessage()
            
        ]);
    }
} else {
    http_response_code(405); // Método não permitido
    echo json_encode(['status' => false, 'msg' => 'Método não permitido.']);
}
