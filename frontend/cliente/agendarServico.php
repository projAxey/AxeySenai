<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../frontend/layouts/head.php';
include '../../frontend/layouts/nav.php';
include_once '../../config/conexao.php' ?>


<?php
$produto_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Consulta atualizada para incluir o campo `url_foto` da tabela Prestadores
$buscaAgendasPrestadorServico = 'SELECT 
    Produtos.produto_id,
    Produtos.prestador,
    Produtos.nome_produto,
    Produtos.descricao_produto,
    Agendas.agenda_id,
    Agendas.prestador,
    Agendas.data_agenda,
    Agendas.data_final,
    Agendas.hora_inicio,
    Agendas.hora_final,
    Prestadores.url_foto, -- Campo adicionado
    Prestadores.nome_resp_legal,
    Prestadores.descricao
FROM Produtos
INNER JOIN Agendas 
    ON Produtos.prestador = Agendas.prestador
INNER JOIN Prestadores 
    ON Produtos.prestador = Prestadores.prestador_id -- Adicionando a relação com Prestadores
WHERE Produtos.produto_id = :produto_id';

$retornoBusca = $conexao->prepare($buscaAgendasPrestadorServico);
$retornoBusca->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
$retornoBusca->execute();
?>


<link rel="stylesheet" href="/projAxeySenai/assets/css/calendario.css">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
<!-- <script src="../../../projAxeySenai/assets/JS/solicitaAgenda.js"></script> -->

<body class="bodyCards">


    <style>

.card-container {
    flex-wrap: wrap;
    gap: 1rem;
}

.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    flex: 1 1 calc(33.333% - 1rem); /* 3 cards por linha */
}

.card-body {
    align-items: center;
    justify-content: space-between;
}

.card p {
    margin: 0;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

        textarea {
            resize: none;
            height: 100px;
        }

        a {
            text-decoration: none;
            color: #012640;
        }
    </style>
    <?php
    $email_logado = $_SESSION['email'];

    $sql = "SELECT * FROM Clientes WHERE email = :email";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':email', $email_logado);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        $statusClientes = 'false';
    } else {
        $statusClientes = 'true';
    }
    // visually-hidden
    echo "<div class='status visually-hidden' data-status='{$statusClientes}'>
    <p>Produto ID: '{$statusClientes}'</p>
    </div>";
    ?>

<div class="container mt-4" style="min-height: 100vh;">
    <div class="row d-flex flex-wrap">
        <ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item">
                <a href="/projAxeySenai/index.php" style="text-decoration: none; color:#012640;">
                    <strong>Voltar</strong>
                </a>
            </li>
        </ol>
        <div class="title-admin">SOLICITAÇÃO DE SERVIÇO</div>
        <div class="col-12 mt-2">
            <div class="card-container">
                <?php
                if ($retornoBusca->rowCount() == 0) {
                    echo '<p>Nenhum dado cadastrado</p>';
                } else {
                    echo '<ul class="list-group">';
                    while ($rowBusca = $retornoBusca->fetch(PDO::FETCH_ASSOC)) {
                        $id = $rowBusca['produto_id'];
                        $id_agenda = $rowBusca['agenda_id'];
                        $dataInicio = DateTime::createFromFormat('Y-m-d', $rowBusca['data_agenda'])->format('d/m/Y');
                        $dataFinal = DateTime::createFromFormat('Y-m-d', $rowBusca['data_final'])->format('d/m/Y');
                        $horaInicio = $rowBusca['hora_inicio'];
                        $horaFinal = $rowBusca['hora_final'];
                        $horaInicioFormatada = date('H:i', strtotime($horaInicio));
                        $horaFinalFormatada = date('H:i', strtotime($horaFinal));
                        $urlFoto = $rowBusca['url_foto'];
                        $nomePrestador = $rowBusca['nome_resp_legal'];
                        $descricao = $rowBusca['descricao'];

                        echo "
                        <li class='list-group-item d-flex align-items-center'>
                            <div class='row w-100'>
                                <div class='col-md-3 d-flex align-items-center'>
                                    <div class='circle-image'>
                                        <img src='/projAxeySenai/files/imgPerfil/$urlFoto' alt='Foto do prestador' class='rounded-circle' style='width: 6rem; height: 6rem; object-fit: cover; margin-right: 10px;'>
                                    </div>
                                    <div>
                                        <p class='mb-0'><strong>$nomePrestador</strong></p>
                                        <p class='mb-0'><strong>$descricao</strong></p>
                                    </div>
                                </div>
                                <div class='col-md-9 mt-3'>
                                    <p>Profissional com disponibilidade entre os dias $dataInicio até $dataFinal</p>
                                    <p>Horários disponíveis:</p>
                                    <p>$horaInicioFormatada às $horaFinalFormatada</p>
                                    <div class='d-flex justify-content-end'>
                                        <button class='btn btn-primary editaDisponibilidade' id='editaDisponibilidade' data-bs-toggle='modal' data-bs-target='#editModal' style='margin-top: -50px; margin-bottom: 20px;' value='$id_agenda'>CONTRATAR SERVIÇO</button>
                                    </div>
                                </div>
                            </div>
                        </li>";
                    }
                    echo '</ul>';
                }
                echo "<div class='produto visually-hidden' data-id='{$id}'>
                            <p>Produto ID: {$id}</p>
                          </div>";
                ?>
            </div>
        </div>
    </div>
</div>

    <?php
    include '../../frontend/calendario/calendariocliente.php';
    ?>



</body>
<?php
include '../layouts/footer.php';
?>