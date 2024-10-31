<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../layouts/nav.php';
include '../layouts/head.php';
include '../../config/conexao.php';
?>

<body class="bodyCards bodyCadastroProdutos">
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
            <button type="button" id="novoProduto" class="mb-2 btn btn-novo-produto"
                style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novoServicoModal">
                Novo Serviço <i class="bi bi-plus-circle"></i>
            </button>
        </div>
        <?php echo $mensagemSucesso; ?>

        <?php
        // Supondo que $userId está definido como o ID do usuário logado
        $userId = $_SESSION['id'];
        try {
            // Inclui o campo categoria_produto na seleção
            $sql = "SELECT p.nome_produto, c.titulo_categoria, p.produto_id, p.status, p.categoria_produto
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
                    <h5 class="mb-1">
                        <?php echo htmlspecialchars($produto['nome_produto']); ?>
                        <span class="badge bg-secondary">
                            <?php echo "Categoria: " . htmlspecialchars($produto['categoria_produto']); ?>
                        </span>
                    </h5>
                    <p class="mb-1"><?php echo htmlspecialchars($produto['titulo_categoria']); ?></p>
                </div>
                <div>
                    <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editService(<?php echo $produto['produto_id'] ?>)">
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

                    <!-- Botão de destaque atualizado para condicionalmente abrir o modal ou cancelar o destaque -->
                    <button onclick="abrirDestaqueModal(<?php echo $produto['produto_id']; ?>, <?php echo $produto['categoria_produto']; ?>)" 
                            class="btn btn-sm btn-admin destaque" 
                            id="destaque" 
                            style="color: <?php echo $produto['categoria_produto'] == 1 ? 'blue' : 'red'; ?>;">
                        <i class="fa-solid fa-trophy"></i>
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
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editServiceForm">
                            <!-- Campos de edição irão aqui -->
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
        <div class="modal fade" id="destaqueModal" tabindex="-1" aria-labelledby="destaqueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="../../backend/servicos/save_destaque.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="destaqueModalLabel">Confirmar Destaque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Confirma a criação de um destaque para este serviço?</p>
                    <!-- Campo oculto para enviar o produto_id -->
                    <input type="hidden" name="produto_id" id="produto_id_destacar" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="confirmaDestaque">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- Outros modais, etc... -->
    </div>

    <?php include '../layouts/footer.php'; ?>

    <script src='../../assets/js/previewImgs.js'></script>
    <script src='../../assets/js/servicosEdestaques.js'></script>
</body>
</html>
