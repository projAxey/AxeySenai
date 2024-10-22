<?php
include_once "/xampp/htdocs/projAxeySenai/config/conexao.php";

header('Content-Type: application/json'); // Definindo o tipo de conteúdo da resposta como JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAgendamento  = $_POST['idAgendamento'];
    $idCliente = $_POST['idCliente'];
    $idProduto = $_POST['idProduto'];
    $idPrestador = $_POST['idPrestador'];
    $idDisponibilidade = $_POST['idDisponibilidade'];
    $nomeServico = $_POST['nomeServico'];
    $descricaoServico = $_POST['descricaoServico'];
    $prestacaoDate = $_POST['prestacaoDate'];
    $prestacaoTime = $_POST['prestacaoTime'];
    $servicoDescricao = $_POST['servicoDescricao'];

    if (empty($idAgendamento)) {
        if (!empty($idCliente) && !empty($idProduto) && !empty($idPrestador) 
        && !empty($idDisponibilidade) && !empty($nomeServico) && !empty($descricaoServico)
        && !empty($prestacaoDate) && !empty($prestacaoTime) && !empty($servicoDescricao)) {
            try {
                // Prepara a query
                $sql = "INSERT INTO Agendamentos (id_agendas,produto,cliente,data_agenda,hora_prestacao,
                servico_descricao)
                
                VALUES (:id_agendas, :produto, :cliente, :data_agenda,:hora_prestacao,:servico_descricao)";
                $stmt = $conexao->prepare($sql);

                // Bind dos parâmetros usando o nome dos campos
                $stmt->bindParam(':id_agendas', $idDisponibilidade);
                $stmt->bindParam(':produto', $idProduto);
                $stmt->bindParam(':cliente', $idCliente);
                $stmt->bindParam(':data_agenda', $prestacaoDate);
                $stmt->bindParam(':hora_prestacao', $prestacaoTime);
                $stmt->bindParam(':servico_descricao', $servicoDescricao);

                // Executa a query
                if ($stmt->execute()) {
                    $response = [
                        'status' => true,
                        'msg' => 'Dados inseridos com sucesso!'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg' => 'Erro ao inserir dados.'
                    ];
                }
            } catch (PDOException $e) {
                $response = [
                    'status' => false,
                    'msg' => 'Erro na execução da query: ' . $e->getMessage()
                ];
            }
        } else {
            $response = [
                'status' => false,
                'msg' => 'Preencha todos os campos.'
            ];
        }

        echo json_encode($response);
    } else if (!empty($idDisponibilidade)) {
        try {
            // Prepara a query
            $sql = "UPDATE Agendas SET prestador = :idPrestador,data_agenda = :startDayDate, data_final = :endDayDate, hora_inicio = :startTime, hora_final = :endTime WHERE agenda_id = :id;";
            $stmt = $conexao->prepare($sql);

            // Bind dos parâmetros usando o nome dos campos
            $stmt->bindParam(':id', $idDisponibilidade);
            $stmt->bindParam(':idPrestador', $idPrestador);
            $stmt->bindParam(':startDayDate', $startDayDate);
            $stmt->bindParam(':endDayDate', $endDayDate);
            $stmt->bindParam(':startTime', $startTime);
            $stmt->bindParam(':endTime', $endTime);

            // Executa a query
            if ($stmt->execute()) {
                $response = [
                    'status' => true,
                    'msg' => 'Dados atulizados com sucesso!'
                ];
            } else {
                $response = [
                    'status' => false,
                    'msg' => 'Erro ao atualizar dados dados.'
                ];
            }
        } catch (PDOException $e) {
            $response = [
                'status' => false,
                'msg' => 'Erro na execução da query: ' . $e->getMessage()
            ];
        }

        echo json_encode($response);
    } else {
        echo json_encode([
            'status' => false,
            'msg' => 'Requisição inválida'
        ]);
    }
}
