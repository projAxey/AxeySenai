<?php
include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php';

?>

<body class=" bodyCards bodyCadastroProdutos">
    <div class="container mt-4">
        <div class="row d-flex flex-wrap">
            <ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item">
                    <a href="/projAxeySenai/frontend/auth/perfil.php" style="text-decoration: none; color:#012640;">
                        <strong>Voltar</strong>
                    </a>
                </li>
            </ol>
            <div class="title-admin">MEUS SERVIÇOS</div>
        </div>
        <?php
        // Armazene a mensagem de sucesso, se existir
        $mensagemSucesso = '';
        if (isset($_SESSION['mensagem_sucesso'])) {
            $mensagemSucesso = '<div class="alert alert-success">' . $_SESSION['mensagem_sucesso'] . '</div>';
            unset($_SESSION['mensagem_sucesso']); // Limpa a mensagem após exibi-la
        }
        ?>
        <div class="d-flex justify-content-between mb-4">
            <button type="button" id="meusAgendamentos" class="mb-2 btn btn-meus-agendamentos"
                style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novoServicoModal">
                Novo Serviço <i class="bi bi-plus-circle"></i>
            </button>
        </div>
        <?php echo $mensagemSucesso; ?>

        <?php
        // Supondo que $userId está definido como o ID do usuário logado
        $userId = $_SESSION['id'];
        try {
            $sql = "SELECT p.nome_produto, c.titulo_categoria, p.produto_id, p.status
            FROM Produtos p
            JOIN Categorias c ON p.categoria = c.categoria_id 
            WHERE p.prestador = :userId";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar produtos: " . $e->getMessage();
            return;
        }
        ?>
        <div class="list-group mb-5">
            <?php
            // Verifica se há produtos e os exibe
            if (!empty($produtos)) {
                foreach ($produtos as $produto) {
            ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1"><?php echo htmlspecialchars($produto['nome_produto']); ?></h5>
                            <p class="mb-1"><?php echo htmlspecialchars($produto['titulo_categoria']); ?></p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                Abrir Modal
                            </button>
                            <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editService(<?php echo $produto['produto_id']; ?>)">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="confirmDelete(<?php echo $produto['produto_id']; ?>)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="viewService(<?php echo $produto['produto_id']; ?>)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-admin view-photos" data-bs-toggle="modal" data-bs-target="#photosModal" onclick="viewPhotos(<?php echo $produto['produto_id']; ?>)">
                                <i class="fa-solid fa-image"></i>
                            </button>

                            <?php if ($produto['status'] == 1): ?>
                                <button class="btn btn-warning" style="width: 180px; margin-left: 10px;">
                                    Em aprovação
                                </button>
                            <?php elseif ($produto['status'] == 2): ?>
                                <button class="btn btn-success" style="width: 180px; margin-left: 10px;">
                                    Ativo
                                </button>
                            <?php elseif ($produto['status'] == 3): ?>
                                <button class="btn btn-secondary" style="width: 180px; margin-left: 10px;">
                                    Bloqueado
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="list-group-item text-center">Nenhum produto encontrado.</div>';
            }
            ?>
        </div>



        <?php
        try {
            $sql = "SELECT categoria_id, titulo_categoria FROM Categorias";
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar categorias: " . $e->getMessage();
        }
        ?>

        <div class="modal fade" id="novoServicoModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Novo Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" action="../../backend/servicos/save_service.php">
                            <div class="mb-3 col-md-3">
                                <label for="productType" class="form-label">Tipo</label>
                                <select class="form-select" id="productType" name="productType" required onchange="toggleFields()">
                                    <option value="" disabled selected>Selecione o tipo</option>
                                    <option value="1">Produto</option>
                                    <option value="2">Serviço</option>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="serviceName" class="form-label">Título</label>
                                    <input type="text" class="form-control" id="serviceName" name="serviceName" required placeholder="Digite o título do produto / serviço">
                                </div>
                                <div class="col-md-4">
                                    <label for="serviceValue" class="form-label">Valor</label>
                                    <input type="text" class="form-control" id="serviceValue" name="serviceValue" required placeholder="R$ 0,00" onkeyup="formatPriceReversed(this)">
                                </div>

                                <div class="col-md-4">
                                    <label for="serviceCategory" class="form-label">Categoria</label>
                                    <select class="form-select" id="serviceCategory" name="serviceCategory" required>
                                        <option value="" disabled selected>Selecione uma categoria</option>
                                        <?php
                                        // Loop para exibir as categorias
                                        foreach ($categorias as $categoria) {
                                            echo '<option value="' . htmlspecialchars($categoria['categoria_id']) . '">' . htmlspecialchars($categoria['titulo_categoria']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="serviceDescription" class="form-label">Descrição</label>
                                <textarea class="form-control" id="serviceDescription" name="serviceDescription" rows="4" maxlength="900" required></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="serviceImages" class="form-label">Imagens</label>
                                    <input type="file" class="form-control" id="serviceImages" name="serviceImages[]" multiple accept="image/*" onchange="previewImages()">
                                    <div id="imagePreview" class="preview d-flex flex-wrap"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="serviceVideos" class="form-label">Vídeos</label>
                                    <input type="file" class="form-control" id="serviceVideos" name="serviceVideos[]" multiple accept="video/*" onchange="previewVideos()">
                                    <div id="videoPreview" class="preview d-flex flex-wrap"></div>
                                </div>
                            </div>

                            <div class="text-center py-3">
                                <button type="submit" class="btn text-light" style="background-color: #1B3C54; width: 57%;">Cadastrar</button>
                            </div>
                        </form>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Editar Serviço</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editServiceForm">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Tem certeza de que deseja excluir este serviço?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Excluir</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel">Detalhes do Serviço</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- O conteúdo detalhado será carregado via AJAX -->
                                    <div id="serviceDetails"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="photosModal" tabindex="-1" aria-labelledby="photosModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="photosModalLabel">Imagens do Serviço</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- As imagens serão carregadas via AJAX -->
                                    <div id="serviceImages"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../layouts/footer.php';
    ?>

    <script src='../../assets/js/previewImgs.js'></script>
    <script>
        // Função para editar o serviço
        function editService(produtoId) {
            fetch('../../backend/servicos/get_service.php?produto_id=' + produtoId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('editServiceForm').innerHTML = data; // Colocar o conteúdo no modal

                    // Adiciona o listener de evento para o envio do formulário
                    const form = document.getElementById('editServiceForm');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // Impede o envio padrão do formulário

                        const formData = new FormData(form); // Coleta os dados do formulário

                        fetch('../../backend/servicos/update_service.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => {
                                if (response.ok) {
                                    // Redireciona para a página principal após o sucesso
                                    window.location.href = '/projAxeySenai/frontend/prestador/TelaMeusProdutos.php';
                                } else {
                                    // Exibir erro
                                    console.error('Erro ao atualizar produto');
                                }
                            })
                            .catch(error => console.error('Erro:', error));
                    });
                })
                .catch(error => console.error('Erro:', error));
        }

        // Função para confirmar a exclusão de um serviço
        function confirmDelete(produtoId) {
            const confirmButton = document.getElementById('confirmDeleteButton');
            confirmButton.onclick = function() {
                fetch('../../backend/servicos/delete_service.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            produto_id: produtoId
                        }), // Envia o ID do produto em formato JSON
                    })
                    .then(response => {
                        if (response.ok) {
                            // Fechar o modal
                            $('#deleteModal').modal('hide');

                            // Exibir mensagem de sucesso opcional, se necessário
                            alert('Produto excluído com sucesso!'); // Alerta opcional

                            // Atualizar a lista de produtos
                            location.reload(); // Recarrega a página para refletir as mudanças
                        } else {
                            // Exibir uma mensagem de erro caso a exclusão falhe
                            alert('Erro ao excluir o produto. Tente novamente.');
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            }
        }

        // Função para visualizar o serviço
        function viewService(produtoId) {
            fetch('../../backend/servicos/view_service.php?produto_id=' + produtoId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('serviceDetails').innerHTML = data; // Colocar o conteúdo no modal
                })
                .catch(error => console.error('Erro:', error));
        }

        // Função para visualizar as fotos do serviço
        function viewPhotos(produtoId) {
            fetch('../../backend/servicos/get_service_photos.php?produto_id=' + produtoId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('serviceImages').innerHTML = data; // Colocar as imagens no modal
                })
                .catch(error => console.error('Erro:', error));
        }

        function formatPriceReversed(input) {
            let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres que não são dígitos
            if (value.length > 11) {
                value = value.slice(0, 11);
            }
            value = (parseInt(value, 10) / 100).toFixed(2); // Divide por 100 para obter os centavos
            value = value.replace('.', ',');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            input.value = 'R$ ' + value;
        }
    </script>

</body>

</html>