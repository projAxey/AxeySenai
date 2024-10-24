<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclui o arquivo de conexão com o banco de dados
include_once "../../config/conexao.php";

// Definindo o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');

// Verifica se a requisição foi feita pelo método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebendo os dados do formulário enviados via POST
    $idDisponibilidade = $_POST['idDisponibilidade'];
    $idPrestador = $_POST['idPrestador'];
    $startDayDate = $_POST['startDayDate'];
    $endDayDate = $_POST['endDayDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    // Caso o campo idDisponibilidade esteja vazio, realiza uma inserção
    if (empty($idDisponibilidade)) {
        // Verifica se todos os campos obrigatórios foram preenchidos
        if (!empty($startDayDate) && !empty($endDayDate) && !empty($startTime) && !empty($endTime)) {
            try {
                // Prepara a query de inserção
                $sql = "INSERT INTO Agendas (prestador, data_agenda, data_final, hora_inicio, hora_final) 
                        VALUES (:idPrestador, :startDayDate, :endDayDate, :startTime, :endTime)";
                $stmt = $conexao->prepare($sql);

                // Vincula os parâmetros da query com os valores recebidos
                $stmt->bindParam(':idPrestador', $idPrestador);
                $stmt->bindParam(':startDayDate', $startDayDate);
                $stmt->bindParam(':endDayDate', $endDayDate);
                $stmt->bindParam(':startTime', $startTime);
                $stmt->bindParam(':endTime', $endTime);

                // Executa a query e verifica o sucesso da inserção
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
                // Tratamento de erro ao executar a query
                $response = [
                    'status' => false,
                    'msg' => 'Erro na execução da query: ' . $e->getMessage()
                ];
            }
        } else {
            // Retorna uma mensagem se algum campo obrigatório não foi preenchido
            $response = [
                'status' => false,
                'msg' => 'Preencha todos os campos.'
            ];
        }

        // Retorna a resposta como JSON
        echo json_encode($response);

    // Caso o campo idDisponibilidade esteja preenchido, realiza uma atualização
    } else if (!empty($idDisponibilidade)) {
        try {
            // Prepara a query de atualização
            $sql = "UPDATE Agendas 
                    SET prestador = :idPrestador, data_agenda = :startDayDate, data_final = :endDayDate, 
                        hora_inicio = :startTime, hora_final = :endTime 
                    WHERE agenda_id = :id";
            $stmt = $conexao->prepare($sql);

            // Vincula os parâmetros da query com os valores recebidos
            $stmt->bindParam(':id', $idDisponibilidade);
            $stmt->bindParam(':idPrestador', $idPrestador);
            $stmt->bindParam(':startDayDate', $startDayDate);
            $stmt->bindParam(':endDayDate', $endDayDate);
            $stmt->bindParam(':startTime', $startTime);
            $stmt->bindParam(':endTime', $endTime);

            // Executa a query e verifica o sucesso da atualização
            if ($stmt->execute()) {
                $response = [
                    'status' => true,
                    'msg' => 'Dados atualizados com sucesso!'
                ];
            } else {
                $response = [
                    'status' => false,
                    'msg' => 'Erro ao atualizar dados.'
                ];
            }
        } catch (PDOException $e) {
            // Tratamento de erro ao executar a query
            $response = [
                'status' => false,
                'msg' => 'Erro na execução da query: ' . $e->getMessage()
            ];
        }

        // Retorna a resposta como JSON
        echo json_encode($response);
    } else {
        // Caso a requisição seja inválida, retorna um erro
        echo json_encode([
            'status' => false,
            'msg' => 'Requisição inválida'
        ]);
    }
}
?>
