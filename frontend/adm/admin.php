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
                <a href="controleUsuarios.php?clearMessage=true" class="text-decoration-none">
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
            <div class="col-md-3 mb-4">
                <div class="card text-center card-admin">
                    <div class="card-body">
                        <i class="fas fa-file-alt icones-admin"></i>
                        <h5 class="card-title-admin">Gerenciar Planos</h5>
                        <p class="card-text">Criar e gerenciar planos</p>
                        <a href="" class="btn btn-primary btn-primary-admin" style="background-color: red   ">Adicionar Futuramente</a>
                    </div>
                </div>
            </div>

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
            <div class="col-md-6">
                <div class="card card-admin">
                    <div class="card-body">
                        <h5 class="card-title-admin">Serviços por mês</h5>
                        <canvas id="totalSellsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-admin">
                    <div class="card-body" style="padding-bottom: 45px;">
                        <h5 class="card-title-admin">Planos mais comprados</h5>
                        <canvas id="topCouponsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-admin">
                    <div class="card-body" style="padding-bottom: 45px;">
                        <h5 class="card-title-admin">Serviços</h5>
                        <canvas id="payingVsNonPayingChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card card-admin">
                    <div class="card-body">
                        <h5 class="card-title-admin">Novos usuários</h5>
                        <canvas id="totalOrdersChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-admin">
                    <div class="card-body">
                        <h5 class="card-title-admin">Acessos ao site</h5>
                        <canvas id="newCustomersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='../../assets/js/contadoresServicos.js'></script>
    <script>
        // Função que busca os contadores e atualiza a tela


        // Configurações dos gráficos
        const ctxTotalSells = document.getElementById('totalSellsChart').getContext('2d');
        const totalSellsChart = new Chart(ctxTotalSells, {
            type: 'line',
            data: {
                labels: ['Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov'],
                datasets: [{
                    label: 'Serviços concluídos',
                    data: [24, 11, 15, 31, 27, 19, 21],
                    borderColor: '#002b5c',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxTotalOrders = document.getElementById('totalOrdersChart').getContext('2d');
        const totalOrdersChart = new Chart(ctxTotalOrders, {
            type: 'bar',
            data: {
                labels: ['Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov'],
                datasets: [{
                    label: 'Usuários',
                    data: [12, 19, 3, 5, 2, 3, 7],
                    backgroundColor: '#002b5c'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxNewCustomers = document.getElementById('newCustomersChart').getContext('2d');
        const newCustomersChart = new Chart(ctxNewCustomers, {
            type: 'line',
            data: {
                labels: ['01/05', '02/05', '03/05', '04/05', '05/05', '06/05', '07/05', '08/05', '09/05'],
                datasets: [{
                    label: 'Novos acessos',
                    data: ['57', '72', '55', '85', '54', '63', '81', '74', '66'],
                    borderColor: '#002b5c',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxTopCoupons = document.getElementById('topCouponsChart').getContext('2d');
        const topCouponsChart = new Chart(ctxTopCoupons, {
            type: 'doughnut',
            data: {
                labels: ['Plano 1', 'Plano 2', 'Plano 3'],
                datasets: [{
                    label: 'Planos',
                    data: [72, 18, 10],
                    backgroundColor: ['#002b5c', '#ffc107', '#28a745']
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

        const ctxPayingVsNonPaying = document.getElementById('payingVsNonPayingChart').getContext('2d');
        const payingVsNonPayingChart = new Chart(ctxPayingVsNonPaying, {
            type: 'pie',
            data: {
                labels: ['Concluídos', 'Pendentes'],
                datasets: [{
                    label: 'Serviços',
                    data: [65, 35],
                    backgroundColor: ['#002b5c', '#dc3545']
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
    </script>
</body>

</html>