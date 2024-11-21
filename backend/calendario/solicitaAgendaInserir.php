<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include_once "../../config/conexao.php";
require '../../utils/emailPadrao.php';

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
        if (
            !empty($idCliente) && !empty($idProduto) && !empty($idPrestador)
            && !empty($idDisponibilidade) && !empty($nomeServico) && !empty($descricaoServico)
            && !empty($prestacaoDate) && !empty($prestacaoTime) && !empty($servicoDescricao)
        ) {
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
                    // Obter informações do prestador
                    $stmtPrestador = $conexao->prepare("SELECT email, nome FROM Prestadores WHERE prestador_id = :idPrestador");
                    $stmtPrestador->bindParam(':idPrestador', $idPrestador);
                    $stmtPrestador->execute();
                    $prestador = $stmtPrestador->fetch(PDO::FETCH_ASSOC);

                    $response = [
                        'status' => true,
                        'msg' => 'Agendamento realizado com sucesso!'
                    ];

                    if ($prestador) {
                        $toEmail = $prestador['email'];
                        $toName = $prestador['nome'];
                        $subject = "Serviço Solicitado - Pendente de Aprovação";
                        $body = "
                        <table role='presentation' style='width: 100%; border: 0;'>
                            <tr>
                                <td style='text-align: center;'>
                                    <p>Olá, {$toName}!</p>
                                    <p>Um novo serviço foi solicitado e está pendente de sua aprovação:</p>
                                    <ul style='list-style: none; padding: 0;'>
                                        <li><strong>Serviço:</strong> {$nomeServico}</li>
                                        <li><strong>Descrição:</strong> {$servicoDescricao}</li>
                                        <li><strong>Data:</strong> {$prestacaoDate}</li>
                                        <li><strong>Hora:</strong> {$prestacaoTime}</li>
                                    </ul>
                                    <p>Para aprovar ou rejeitar este serviço, acesse o link abaixo:</p>
                                    <a href='https://axey.fun/projAxeySenai/frontend/prestador/agendamentosPendentes.php' style='
                                        background-color: #007bff;
                                        color: white;
                                        padding: 10px 20px;
                                        text-decoration: none;
                                        border-radius: 5px;
                                        display: inline-block;
                                        font-weight: bold;
                                        text-align: center;
                                    '>Gerenciar Agenda</a>
                                    <p>Atenciosamente,</p>
                                    <p>Equipe Axey</p>
                                </td>
                            </tr>
                        </table>
            ";

                        $altBody = "Olá, {$toName}! Um novo serviço foi solicitado e está pendente de sua aprovação. Detalhes: Serviço: {$nomeServico}, Descrição: {$descricaoServico}, Data: {$prestacaoDate}, Hora: {$prestacaoTime}. Acesse: http://{$_SERVER['HTTP_HOST']}/projAxeySenai/frontend/prestador/gerenciarAgenda.php";

                        // Envia o email
                        sendEmail($toEmail, $toName, $subject, $body, $altBody);
                    }
                } else {
                    $response = [
                        'status' => false,
                        'msg' => 'Erro ao realizar o agendamento.'
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
                'msg' => 'Campos obrigatórios não preenchidos.'
            ];
        }

        echo json_encode($response);
    }
} else if (!empty($idDisponibilidade)) {
    try {
        // Prepara a query
        $sql = "UPDATE Agendas 
                    SET prestador = :idPrestador, 
                        data_agenda = :startDayDate, 
                        data_final = :endDayDate, 
                        hora_inicio = :startTime, 
                        hora_final = :endTime 
                    WHERE agenda_id = :agendaId;";

        $stmt = $conexao->prepare($sql);

        // Bind dos parâmetros usando o nome correto da variável
        $stmt->bindParam(':agendaId', $idDisponibilidade); // Atenção ao nome da coluna
        $stmt->bindParam(':idPrestador', $idPrestador);
        $stmt->bindParam(':startDayDate', $startDayDate);
        $stmt->bindParam(':endDayDate', $endDayDate);
        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':endTime', $endTime);

        // Executa a query
        if ($stmt->execute()) {
            $response = [
                'status' => true,
                'msg' => 'Dados atualizados com sucesso!'
            ];
        } else {
            $response = [
                'status' => false,
                'msg' => 'Erro ao atualizar os dados.'
            ];
        }
    } catch (PDOException $e) {
        $response = [
            'status' => false,
            'msg' => 'Erro na execução da query: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}
