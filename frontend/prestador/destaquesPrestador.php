<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include '../layouts/head.php'; ?>
</head>
<body class="bodyCards">
    <div class="container mt-4">
        <ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item">
                <a href="/projAxeySenai/frontend/auth/perfil.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
            </li>
        </ol>

        <div class="title-admin">SERVIÇOS DESTAQUE</div>
        <div id="produtosDestaque" class="list-group mb-5">
            <!-- Produtos em destaque serão carregados via JavaScript -->
        </div>
    </div>

    <!-- Modal para visualizar detalhes do serviço -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Detalhes do Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="serviceDetails">
                    <!-- Detalhes do serviço serão carregados aqui via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <?php include '../layouts/footer.php'; ?>
    <script src="../../assets/JS/global.js"></script>

    <script>
        // Função para carregar todos os produtos de destaque
        function loadProdutosDestaque() {
            fetch('../../backend/servicos/get_destaques.php')
                .then(response => response.json())
                .then(data => {
                    const produtosDestaque = document.getElementById('produtosDestaque');
                    produtosDestaque.innerHTML = ''; // Limpa a lista

                    data.forEach(produto => {
                        const statusClass = produto.categoria_produto == 2 ? 'btn-success' : 'btn-warning';
                        const statusText = produto.categoria_produto == 2 ? 'Ativo' : 'Em Aprovação';

                        produtosDestaque.innerHTML += `
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">${produto.nome_produto}</h5>
                                    <p class="mb-1">${produto.titulo_categoria}</p>
                                </div>
                                <div>
                                    <button class="btn btn-sm ${statusClass}" style="width: 180px; margin-right: 10px;">
                                        ${statusText}
                                    </button>
                                    <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="loadServiceDetails(${produto.produto_id})">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                })
                .catch(error => console.error('Erro ao carregar produtos de destaque:', error));
        }

        // Função para carregar detalhes do serviço específico no modal
        function loadServiceDetails(produtoId) {
            fetch('../../backend/servicos/get_destaques.php?produto_id=' + produtoId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('serviceDetails').innerHTML = data;
                })
                .catch(error => console.error('Erro ao carregar detalhes do serviço:', error));
        }

        // Carregar produtos ao inicializar a página
        document.addEventListener('DOMContentLoaded', loadProdutosDestaque);
    </script>
</body>
</html>
