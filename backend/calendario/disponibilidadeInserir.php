<?php
include_once "/xampp/htdocs/projAxeySenai/config/conexao.php";
// include "/xampp/htdocs/projAxeySenai/frontend/prestador/gerenciarAgenda.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDayDate = $_POST['startDayDate'];
    $endDayDate = $_POST['endDayDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];


    if (!empty($startDayDate) && !empty($endDayDate) && !empty($startTime) && !empty($endTime)) {
        try {
            // Prepara a query
            $sql = "INSERT INTO teste (data_agenda, data_final, hora_inicio, hora_final) VALUES (:startDayDate, :endDayDate, :startTime, :endTime)";
            $stmt = $conexao->prepare($sql);

            // Bind dos parâmetros usando o nome dos campos
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
} else {
    echo json_encode([
        'status' => false,
        'msg' => 'Requisição inválida'
    ]);
}

header("Location: /projAxeySenai/frontend/prestador/gerenciarAgenda.php");