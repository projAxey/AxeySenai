<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
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
                    <a href="../auth/perfil.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                </li>
            </ol>
            <div class="title-admin">MEUS ANÚNCIOS</div>
        </div>
        <?php
        $mensagemSucesso = '';
        if (isset($_SESSION['mensagem_sucesso'])) {
            $mensagemSucesso = '<div class="alert alert-success">' . $_SESSION['mensagem_sucesso'] . '</div>';
            unset($_SESSION['mensagem_sucesso']);
        }
        ?>
        <div class="d-flex justify-content-between mb-4">
            <button type="button" id="novoProduto" class="mb-2 btn btn-novo-produto"
                style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novoAnuncioModal">
                Novo Anúncio <i class="bi bi-plus-circle"></i>
            </button>
        </div>

        <?php
        $userId = $_SESSION['id'];
        try {
            $sql = "SELECT p.nome_produto, c.titulo_categoria, p.produto_id, p.status, p.status_destaque, p.motivo_recusa
                    FROM Produtos p
                    JOIN Categorias c ON p.categoria = c.categoria_id 
                    WHERE p.prestador = :userId
                    ORDER BY p.status_destaque DESC";
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
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                    <div class="list-group-item d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column flex-grow-1">
                            <h5 class="mb-1">
                                <?php echo htmlspecialchars($produto['nome_produto']); ?>
                                <input type="hidden" name="status_destaque" value="<?php echo htmlspecialchars($produto['status_destaque']); ?>">
                            </h5>
                            <p class="mb-1"><?php echo htmlspecialchars($produto['titulo_categoria']); ?></p>
                        </div>

                        <!-- Área dos ícones e botão de status -->
                        <div class="d-flex flex-column flex-lg-row align-items-center">
                            <!-- Ícones -->
                            <div class="d-flex flex-wrap justify-content-end mb-2 mb-lg-0">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editService(<?php echo $produto['produto_id'] ?>)">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="confirmDelete(<?php echo $produto['produto_id']; ?>)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-admin view-photos" data-bs-toggle="modal" data-bs-target="#photosModal" onclick="fillPhotosModal(<?php echo $produto['produto_id']; ?>)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <!-- Ícone do troféu -->
                                <?php if ($produto['status'] == 2): ?>
                                    <button class="btn btn-sm btn-admin trophy-admin" data-bs-toggle="modal"
                                        data-bs-target="<?php echo ($produto['status_destaque'] == 2) ? '#removeDestaqueModal' : '#destaqueModal'; ?>"
                                        onclick="setProductId(<?php echo $produto['produto_id']; ?>)">
                                        <i class="fa-solid fa-trophy" style="color: <?php echo ($produto['status_destaque'] == 2) ? '#FFD700' : '#C0C0C0'; ?>;"></i>
                                    </button>
                                <?php endif; ?>

                            </div>

                            <!-- Botões de Status (apenas na versão web) -->
                            <div class="d-none d-lg-flex justify-content-end ms-2">
                                <?php if ($produto['status'] == 1): ?>
                                    <button class="btn btn-warning" style="width: 180px;">
                                        Em aprovação
                                    </button>
                                <?php elseif ($produto['status'] == 2): ?>
                                    <button class="btn btn-success" style="width: 180px;">
                                        Ativo
                                    </button>
                                <?php elseif ($produto['status'] == 3): ?>
                                    <button class="btn btn-secondary" style="width: 180px;">
                                        Bloqueado
                                    </button>
                                <?php elseif ($produto['status'] == 4): ?>
                                    <button
                                        class="btn btn-danger"
                                        style="width: 180px;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rejectionReasonModal"
                                        data-reason="<?php echo htmlspecialchars($produto['motivo_recusa']); ?>">
                                        Reprovado
                                    </button>
                                <?php endif; ?>
                            </div>

                            <!-- Botões de Status (apenas no mobile) -->
                            <div class="d-lg-none d-flex justify-content-end mt-2">
                                <?php if ($produto['status'] == 1): ?>
                                    <button class="btn btn-warning" style="width: 100px;">
                                        Em aprovação
                                    </button>
                                <?php elseif ($produto['status'] == 2): ?>
                                    <button class="btn btn-success" style="width: 100px;">
                                        Ativo
                                    </button>
                                <?php elseif ($produto['status'] == 3): ?>
                                    <button class="btn btn-secondary" style="width: 100px;">
                                        Bloqueado
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                <?php endforeach; ?>
            <?php else: ?>
                <div class="list-group-item text-center">Nenhum produto encontrado.</div>
            <?php endif; ?>
        </div>

        <!-- Modal de Novo Anuncio (Cadastro) -->
        <div class="modal fade" id="novoAnuncioModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newModalLabel">Novo Anúncio</h5>
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
                                        try {
                                            $sql = "SELECT categoria_id, titulo_categoria FROM Categorias ORDER BY titulo_categoria ASC";
                                            $stmt = $conexao->prepare($sql);
                                            $stmt->execute();
                                            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($categorias as $categoria) {
                                                echo '<option value="' . htmlspecialchars($categoria['categoria_id']) . '">' . htmlspecialchars($categoria['titulo_categoria']) . '</option>';
                                            }
                                        } catch (PDOException $e) {
                                            echo '<option value="">Erro ao carregar categorias</option>';
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
                                    <input type="file" class="form-control" id="serviceImages" name="serviceImages[]" multiple accept="image/*" onchange="previewImages('serviceImages', 'imagePreview')">
                                    <div id="imagePreview" class="preview d-flex flex-wrap"></div>
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
        <!-- Modal de Edição -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Anúncio</h5>
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

        <!-- Modal de Exclusão -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza de que deseja excluir este anúncio?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Excluir</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cria um novo destaque -->
        <div class="modal fade" id="destaqueModal" tabindex="-1" aria-labelledby="destaqueModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../../backend/servicos/destaque.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="destaqueModalLabel">Confirmar Destaque</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Confirma a criação de um destaque para este anúncio?</p>
                            <!-- Campo oculto para enviar o produto_id -->
                            <input type="hidden" name="produto_id" id="produto_id_destaque" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="confirmaDestaque" name="criaDestaque">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Remove o destaque -->
        <div class="modal fade" id="removeDestaqueModal" tabindex="-1" aria-labelledby="removeDestaqueModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../../backend/servicos/destaque.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="removeDestaqueModalLabel">Remover Destaque</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Confirma a remoção deste anúncio dos destaques?</p>
                            <input type="hidden" name="produto_id" id="produto_id_remover_destaque" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger" name="remove_destaque">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Unificada de Visualização de Detalhes e Fotos -->
        <div class="modal fade" id="photosModal" tabindex="-1" aria-labelledby="photosModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="photosModalLabel">Detalhes e Imagens do Anúncio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Seção de Detalhes do Serviço -->
                        <div id="serviceDetails" class="mb-3">
                            <!-- Detalhes do serviço serão carregados via JavaScript -->
                        </div>
                        <hr>
                        <!-- Seção de Fotos do Serviço -->
                        <div id="service-photos-container" class="d-flex flex-wrap justify-content-center mt-3">
                            <!-- As fotos serão carregadas dinamicamente aqui -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para exibir o motivo da recusa -->
    <div class="modal fade" id="rejectionReasonModal" tabindex="-1" aria-labelledby="rejectionReasonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectionReasonModalLabel">Motivo da Recusa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="rejectionReasonText">Motivo não informado.</p>
                </div>
                <div class="modal-body">
                    <p>Fique a vontade para editar seu serviço e tentar novamente!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layouts/footer.php'; ?>
    <script src='../../assets/js/previewImgs.js'></script>
    <script src='../../assets/js/servicosEDestaques.js'></script>
    <script>
        function setProductId(produtoId) {
            document.getElementById('produto_id_destaque').value = produtoId;
            document.getElementById('produto_id_remover_destaque').value = produtoId;
        }
    </script>
</body>