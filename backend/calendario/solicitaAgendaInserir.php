<?php
include_once "/xampp/htdocs/projAxeySenai/config/conexao.php";

header('Content-Type: application/json'); // Definindo o tipo de conteúdo da resposta como JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idDisponibilidade = $_POST['idDisponibilidade'];
    $idPrestador = $_POST['idPrestador'];
    $startDayDate = $_POST['startDayDate'];
    $endDayDate = $_POST['endDayDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];


    if (empty($idDisponibilidade)) {
        if (!empty($startDayDate) && !empty($endDayDate) && !empty($startTime) && !empty($endTime)) {
            try {
                // Prepara a query
                $sql = "INSERT INTO Agendas (prestador,data_agenda, data_final, hora_inicio, hora_final) VALUES (:idPrestador,:startDayDate, :endDayDate, :startTime, :endTime)";
                $stmt = $conexao->prepare($sql);

                // Bind dos parâmetros usando o nome dos campos
                $stmt->bindParam(':idPrestador', $idPrestador);
                $stmt->bindParam(':startDayDate', $startDayDate);
                $stmt->bindParam(':endDayDate', $endDayDate);
                $stmt->bindParam(':startTime', $startTime);
                $stmt->bindParam(':endTime', $endTime);

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
