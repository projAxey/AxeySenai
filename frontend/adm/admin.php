<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
} else if ($_SESSION['tipo_usuario'] != "Administrador") {
    header("Location: ../../index.php");
    exit();
}

include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php';

try {
    // Consulta para Agendamentos
    $stmtConcluidos = $conexao->query("SELECT COUNT(*) FROM Agendamentos WHERE status = 2");
    $concluidos = $stmtConcluidos->fetchColumn();

    $stmtAgendados = $conexao->query("SELECT COUNT(*) FROM Agendamentos WHERE status = 1");
    $agendados = $stmtAgendados->fetchColumn();

    $stmtFinalizados = $conexao->query("SELECT COUNT(*) FROM Agendamentos WHERE status = 4");
    $finalizados = $stmtFinalizados->fetchColumn();

    // Consulta combinada para Clientes e Prestadores
    $stmtClientes = $conexao->query("
        SELECT DATE(criacao) AS dia, COUNT(*) AS total
        FROM Clientes
        GROUP BY DATE(criacao)
        ORDER BY dia
    ");

    $clientesTotais = [];
    while ($row = $stmtClientes->fetch(PDO::FETCH_ASSOC)) {
        $clientesTotais[$row['dia']] = $row['total'];
    }

    $stmtPrestadores = $conexao->query("
        SELECT DATE(criacao) AS dia, COUNT(*) AS total
        FROM Prestadores
        GROUP BY DATE(criacao)
        ORDER BY dia
    ");

    $prestadoresTotais = [];
    while ($row = $stmtPrestadores->fetch(PDO::FETCH_ASSOC)) {
        $prestadoresTotais[$row['dia']] = $row['total'];
    }

    // Combine as datas e preencha valores faltantes
    $allDates = array_unique(array_merge(array_keys($clientesTotais), array_keys($prestadoresTotais)));
    sort($allDates);

    $clientesFinal = [];
    $prestadoresFinal = [];
    foreach ($allDates as $date) {
        $clientesFinal[] = $clientesTotais[$date] ?? 0;
        $prestadoresFinal[] = $prestadoresTotais[$date] ?? 0;
    }
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}

?>

<body>
    <div class="container mt-4 mb-4">
        <h2 class="mb-1">Administração</h2>
        <p class="mb-4">Painel de controle</p>
        <div class="row mb-4">
            <div class="col-md-6 mt-2">
                <a href="/projAxeySenai/frontend/adm/controleServicos.php" class="text-decoration-none">
                    <div class="status-card-admin green">
                        <i class="fas fa-check-circle me-3 fs-2"></i>
                        <div>
                            <h4 id="servicosAtivos">Serviços ativos</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mt-2">
                <a href="controleUsuarios.php?clearMessage=true" class="text-decoration-none">
                    <div class="status-card-admin green">
                        <i class="fas fa-exclamation-circle me-3 fs-2"></i>
                        <div>
                            <h4 id="usuariosAtivos">Usuários ativos</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mt-2">
                <a href="/projAxeySenai/frontend/adm/controleServicos.php?status=1" class="text-decoration-none">
                    <div class="status-card-admin" style="background-color: #ffbf06;">
                        <i class="fas fa-exclamation-circle me-3 fs-2"></i>
                        <div>
                            <h4 id="produtosPendentes">Serviços pendentes</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mt-2">
                <a href="controleUsuarios.php?status=3&clearMessage=true" class="text-decoration-none">
                    <div class="status-card-admin" style="background-color: #ffbf06;">
                        <i class="fas fa-exclamation-circle me-3 fs-2"></i>
                        <div>
                            <h4 id="prestadoresPendentes">Prestadores pendentes</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Cards de administração -->
        <div class="row mb-4 mt-4">
            <div class="col-md-3 mb-4">
                <div class="card text-center card-admin">
                    <div class="card-body">
                        <i class="fas fa-users icones-admin"></i>
                        <h5 class="card-title-admin">Gerenciar Usuários</h5>
                        <p class="card-text">Gerenciar contas de usuários</p>
                        <a href="controleUsuarios.php?clearMessage=true" class="btn btn-primary btn-primary-admin">Ir para Usuários</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-center card-admin">
                    <div class="card-body">
                        <i class="fas fa-box icones-admin"></i>
                        <h5 class="card-title-admin">Gerenciar Serviços</h5>
                        <p class="card-text">Editar, excluir ou novos serviços</p>
                        <a href="controleServicos.php" class="btn btn-primary btn-primary-admin">Ir para Serviços</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-center card-admin">
                    <div class="card-body">
                        <i class="fas fa-folder icones-admin"></i>
                        <h5 class="card-title-admin">Gerenciar Categorias</h5>
                        <p class="card-text">Editar, excluir ou novas Categorias</p>
                        <a href="controleCategorias.php" class="btn btn-primary btn-primary-admin">Ir para Categorias</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-center card-admin">
                    <div class="card-body">
                        <i class="fas fa-box icones-admin"></i>
                        <h5 class="card-title-admin">Banners</h5>
                        <p class="card-text">Editar, excluir ou novos banners</p>
                        <a href="banners.php" class="btn btn-primary btn-primary-admin">Ir para Banners</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-center card-admin">
                    <div class="card-body">
                        <i class="fas fa-link icones-admin"></i>
                        <h5 class="card-title-admin">Gerenciar Links</h5>
                        <p class="card-text">Edite os links fixos do site</p>
                        <a href="controleLinks.php" class="btn btn-primary btn-primary-admin">Ir para Links</a>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3 mb-4">
                <div class="card text-center card-admin">
                    <div class="card-body">
                        <i class="fas fa-file-alt icones-admin"></i>
                        <h5 class="card-title-admin">Gerenciar Planos</h5>
                        <p class="card-text">Criar e gerenciar planos</p>
                        <a href="" class="btn btn-primary btn-primary-admin" style="background-color: red   ">Adicionar Futuramente</a>
                    </div>
                </div>
            </div> -->

            <div class="col-md-3 mb-4">
                <div class="card text-center card-admin">
                    <div class="card-body">
                        <i class="fas fa-file-alt icones-admin"></i>
                        <h5 class="card-title-admin">Gerenciar Documentos</h5>
                        <p class="card-text">Criar e gerenciar Documentos</p>
                        <a href="controleDocumentos.php" class="btn btn-primary btn-primary-admin">Ir para Documentos</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row">
            <div class="col-md-3 mb-5">
                <div class="card card-admin">
                    <div class="card-body" style="padding-bottom: 45px;">
                        <h5 class="card-title-admin">Agendamentos</h5>
                        <canvas id="payingVsNonPayingChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-admin">
                    <div class="card-body">
                        <h5 class="card-title-admin">Clientes e Prestadores</h5>
                        <canvas id="combinedChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='../../assets/js/contadoresServicos.js'></script>
    <script>
        const ctxPayingVsNonPaying = document.getElementById('payingVsNonPayingChart').getContext('2d');
        const payingVsNonPayingChart = new Chart(ctxPayingVsNonPaying, {
            type: 'pie',
            data: {
                labels: ['Aceitos', 'Agendados', 'Finalizados'],
                datasets: [{
                    label: 'Agendamentos',
                    data: [<?= $concluidos ?>, <?= $agendados ?>, <?= $finalizados ?>],
                    backgroundColor: ['#002b5c', '#dc3545', 'gray']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        const ctxCombined = document.getElementById('combinedChart').getContext('2d');
        const combinedChart = new Chart(ctxCombined, {
            type: 'line',
            data: {
                labels: <?= json_encode($allDates) ?>,
                datasets: [{
                        label: 'Clientes',
                        data: <?= json_encode($clientesFinal) ?>,
                        borderColor: '#002b5c',
                        backgroundColor: 'rgba(0, 0, 255, 0.1)',
                        fill: true
                    },
                    {
                        label: 'Prestadores',
                        data: <?= json_encode($prestadoresFinal) ?>,
                        borderColor: 'green',
                        backgroundColor: 'rgba(0, 128, 0, 0.1)',
                        fill: true
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>

</html>