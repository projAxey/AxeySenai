<?php
include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php'; // Conectando ao banco de dados
?>
<body class="bodyCards">
    <main class="main-admin">
        <div class="container container-admin">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-admin">
                    <li class="breadcrumb-item">
                        <a href="admin.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                    </li>
                </ol>
            </nav>
            <div class="title-admin">GERENCIAR SERVIÇOS</div>
            <div class="d-flex justify-content-between mb-4">
    <button type="button" class="btn btn-meus-agendamentos"
            style="background-color: #012640; color:white"
            onclick="window.location.href='controleCategorias.php'">
        Gerenciar Categorias
    </button>

    <?php if (isset($_GET['status']) && $_GET['status'] == 1): ?>
        <a href="controleServicos.php" class="btn btn-secondary">
            Limpar o Filtro
        </a>
    <?php else: ?>

        <form method="GET" action="">
            <input type="hidden" name="status" value="1">
            <button type="submit" class="btn btn-success">
                Aprovações
            </button>
        </form>
    <?php endif; ?>
</div>

            <?php
            try {

                $statusFilter = isset($_GET['status']) ? $_GET['status'] : null;
            
                $sql = "SELECT p.*, c.titulo_categoria, pr.nome_resp_legal, pr.razao_social 
                        FROM Produtos p
                        JOIN Categorias c ON p.categoria = c.categoria_id 
                        JOIN Prestadores pr ON p.prestador = pr.prestador_id";
            
                if ($statusFilter) {
                    $sql .= " WHERE p.status = :status";
                }
            
                $stmt = $conexao->prepare($sql);
                
                if ($statusFilter) {
                    $stmt->bindParam(':status', $statusFilter, PDO::PARAM_INT);
                }
                
                $stmt->execute();
                $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Erro ao buscar produtos: " . $e->getMessage();
            }
            ?>

            <div class="list-group mb-5">
                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1"><?php echo htmlspecialchars($produto['nome_produto']); ?></h5>
                                <p class="mb-1"><?php echo htmlspecialchars($produto['titulo_categoria']); ?></p>

                                <small>
                                    Prestador: <?php echo htmlspecialchars($produto['nome_resp_legal']); ?> <br>
                                    Razão Social: <?php echo htmlspecialchars($produto['razao_social']); ?>
                                </small>
                            </div>
                            <div class="actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal">
                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                <?php if ($produto['status'] == 1): ?>
                        <form method="POST" action="../../backend/atualizar_status.php" style="display:inline;">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['produto_id']; ?>">
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="btn btn-success" style="width: 180px; margin-left: 10px;">
                                Aprovar
                            </button>
                        </form>
                    <?php elseif ($produto['status'] == 2): ?>
                        <form method="POST" action="../../backend/atualizar_status.php" style="display:inline;">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['produto_id']; ?>">
                            <input type="hidden" name="status" value="3">
                            <button type="submit" class="btn btn-danger" style="width: 180px; margin-left: 10px;">
                                Bloquear
                            </button>
                        </form>
                        <?php elseif ($produto['status'] == 3): ?>
                        <form method="POST" action="../../backend/atualizar_status.php" style="display:inline;">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['produto_id']; ?>">
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="btn btn-secondary" style="width: 180px; margin-left: 10px;">
                                Desbloquear
                            </button>
                        </form>
                    <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="list-group-item text-center">Nenhum produto encontrado.</div>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="service-title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="service-title" value="Reparos Gerais e Pequenas Reformas">
                        </div>
                        <div class="mb-3">
                            <label for="service-category" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="service-category" value="Manutenção Residencial">
                        </div>
                        <div class="mb-3">
                            <label for="service-provider" class="form-label">Prestador</label>
                            <input type="text" class="form-control" id="service-provider" value="Ana Silva">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Excluir Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza de que deseja excluir este serviço?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Visualizar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Título: Reparos Gerais e Pequenas Reformas</p>
                    <p>Categoria: Manutenção Residencial</p>
                    <p>Prestador: Ana Silva</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
   
</body>
<?php
include '../layouts/footer.php';
?>
</html>
