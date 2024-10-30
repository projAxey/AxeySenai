<?php
include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php';
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
            <div class="title-admin">GERENCIAR DESTAQUES</div>
            <div class="d-flex justify-content-between mb-4">
                <?php if (isset($_GET['categoria_produto']) && $_GET['categoria_produto'] == 3): ?>
                    <a href="controleDestaques.php" class="btn btn-secondary ms-auto">
                        Limpar o Filtro
                    </a>
                <?php else: ?>
                    <form method="GET" action="" class="ms-auto">
                        <input type="hidden" name="categoria_produto" value="3">
                        <button type="submit" class="btn btn-success">
                            Aprovações
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <?php
            try {
                // Consulta para todas as categorias
                $categoriesQuery = "SELECT * FROM Categorias";
                $categoriesStmt = $conexao->prepare($categoriesQuery);
                $categoriesStmt->execute();
                $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

                // Filtro de categoria_produto
                $categoriaProdutoFilter = isset($_GET['categoria_produto']) ? $_GET['categoria_produto'] : null;

                // Consulta SQL para produtos com categoria_produto filtrado
                $sql = "SELECT p.*, c.titulo_categoria, pr.nome_resp_legal, pr.razao_social, pr.prestador_id 
                        FROM Produtos p
                        JOIN Categorias c ON p.categoria = c.categoria_id 
                        JOIN Prestadores pr ON p.prestador = pr.prestador_id";

                // Adiciona o filtro de categoria_produto se definido
                if ($categoriaProdutoFilter) {
                    $sql .= " WHERE p.categoria_produto = :categoria_produto";
                } else {
                    // Exibe por padrão produtos com categoria_produto = 2 ou 3 se o filtro não estiver definido
                    $sql .= " WHERE p.categoria_produto IN (2, 3)";
                }

                $stmt = $conexao->prepare($sql);

                if ($categoriaProdutoFilter) {
                    $stmt->bindParam(':categoria_produto', $categoriaProdutoFilter, PDO::PARAM_INT);
                }

                $stmt->execute();
                $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Erro ao buscar destaques: " . $e->getMessage();
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
                                <?php if ($produto['categoria_produto'] == 3): ?>
                                    <!-- Aprovar Produto -->
                                    <form method="POST" action="../../backend/servicos/atualizarDestaque.php" style="display:inline;">
                                        <input type="hidden" name="produto_id" value="<?php echo $produto['produto_id']; ?>">
                                        <input type="hidden" name="categoria_produto" value="2">
                                        <button type="submit" class="btn btn-success" style="width: 180px; margin-left: 10px;">
                                            Aprovar
                                        </button>
                                    </form>
                                <?php elseif ($produto['categoria_produto'] == 2): ?>
                                    <!-- Botão de Bloquear com confirmação -->
                                    <button type="button" class="btn btn-danger" onclick="confirmBlock(<?php echo $produto['produto_id']; ?>)" style="width: 180px; margin-left: 10px;">
                                        Bloquear
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="list-group-item text-center">Nenhum destaque encontrado.</div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../layouts/footer.php'; ?>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmBlock(produtoId) {
            // Exibe o modal de confirmação com SweetAlert2
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Deseja realmente bloquear este produto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'CLARO',
                cancelButtonText: 'NÃO NÃO',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Cria e envia um formulário para atualizar a categoria_produto
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../../backend/servicos/atualizarDestaque.php';

                    // Campos ocultos com produto_id e categoria_produto
                    const produtoIdField = document.createElement('input');
                    produtoIdField.type = 'hidden';
                    produtoIdField.name = 'produto_id';
                    produtoIdField.value = produtoId;
                    form.appendChild(produtoIdField);

                    const categoriaProdutoField = document.createElement('input');
                    categoriaProdutoField.type = 'hidden';
                    categoriaProdutoField.name = 'categoria_produto';
                    categoriaProdutoField.value = 1; // Define como 1 para bloquear (remover destaque)
                    form.appendChild(categoriaProdutoField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</body>

</html>
