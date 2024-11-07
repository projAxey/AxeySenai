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
include '../../config/conexao.php';
include '../../backend/adm/controlCategories.php';
include '../layouts/head.php';
include '../layouts/nav.php';

if (isset($_GET['aviso']) && $_GET['aviso'] === 'true') {
    if (isset($_SESSION['aviso'])) {
        echo "<script>
            Swal.fire({
                title: 'Sucesso!',
                text: '{$_SESSION['aviso']}',
                icon: 'info',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'controleCategorias.php';
            });
          </script>";
    }
} else if (isset($_GET['aviso']) && $_GET['aviso'] === 'erro') {
    if (isset($_SESSION['erro'])) {
        echo "<script>
            Swal.fire({
                title: 'Erro!',
                text: '{$_SESSION['erro']}',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'controleCategorias.php';
            });
          </script>";
    }
}


?>
<html>

<body class="bodyCards">
    <main class="main-admin">
        <div class="container container-admin">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-admin">
                    <li class="breadcrumb-item">
                        <a href="admin.php" style="text-decoration: none; color:#012640;">
                            <strong>Voltar</strong>
                        </a>
                    </li>
                </ol>
            </nav>
            <div class="title-admin text-center mb-3">GERENCIAR CATEGORIAS</div>

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4">
                <!-- Botão de nova categoria -->
                <button type="button" id="meusAgendamentos" class="mb-3 mb-lg-0 btn btn-meus-agendamentos w-100 w-lg-auto"
                    style="background-color: #012640; color: white;" data-bs-toggle="modal" data-bs-target="#novaCategoriaModal">
                    Nova Categoria <i class="bi bi-plus-circle"></i>
                </button>

                <!-- Filtro de status e campo de busca -->
                <div class="d-flex flex-column flex-lg-row w-100 gap-2">
                    <!-- Formulário de filtro -->
                    <form method="GET" action="controleCategorias.php" class="d-flex w-100 mt-2 mt-lg-0">
                        <select name="status_filter" class="form-select me-2" aria-label="Filtrar categorias">
                            <option value="todos" <?php echo isset($_GET['status_filter']) && $_GET['status_filter'] === 'todos' ? 'selected' : ''; ?>>Todos</option>
                            <option value="1" <?php echo isset($_GET['status_filter']) && $_GET['status_filter'] === '1' ? 'selected' : ''; ?>>Visível na home</option>
                            <option value="2" <?php echo isset($_GET['status_filter']) && $_GET['status_filter'] === '2' ? 'selected' : ''; ?>>Oculto na home</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-2 mt-md-0" style="background-color: #012640; color: white;">Filtrar </button>
                    </form>

                    <!-- Formulário de busca -->
                    <form method="GET" action="controleCategorias.php" class="d-flex w-100 mt-2 mt-lg-0">
                        <input type="text" name="search" class="form-control me-2" placeholder="Buscar categorias..."
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button type="submit" class="btn btn-primary" style="background-color: #012640; color: white;">Buscar</button>
                    </form>
                </div>
            </div>

            <?php if (isset($erro)) { ?>
                <div class="alert alert-danger">
                    <?php echo $erro; ?>
                </div>
            <?php } ?>

            <div class="list-group mb-5">
                <?php
                // Captura o filtro de busca
                $search = isset($_GET['search']) ? $_GET['search'] : '';

                // Captura o filtro de status
                $status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'todos';

                // Definindo a consulta com base nos filtros
                $sql = "SELECT * FROM Categorias WHERE 1=1";

                // Se houver um filtro de status
                if ($status_filter !== 'todos') {
                    $sql .= " AND status = :status";
                }

                // Se houver um termo de busca
                if (!empty($search)) {
                    $sql .= " AND (titulo_categoria LIKE :search OR descricao_categoria LIKE :search)";
                }

                $sql .= " ORDER BY titulo_categoria ASC";

                // Preparar a consulta
                $stmt = $conexao->prepare($sql);

                // Vincular os parâmetros de status
                if ($status_filter !== 'todos') {
                    $stmt->bindParam(':status', $status_filter, PDO::PARAM_INT);
                }

                // Vincular o parâmetro de busca, se existir
                if (!empty($search)) {
                    $searchTerm = "%$search%"; // Adiciona % para fazer a busca com LIKE
                    $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
                }

                // Executar a consulta
                $stmt->execute();

                // Exibindo as categorias
                while ($category = $stmt->fetch()) { ?>
                    <div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="mb-2 mb-md-0">
                            <h5 class="mb-1">
                                <i class="<?php echo htmlspecialchars($category['icon']); ?>"></i>
                                <?php echo htmlspecialchars($category['titulo_categoria']); ?>
                            </h5>
                            <p class="mb-1"><?php echo htmlspecialchars($category['descricao_categoria']); ?></p>
                            <p class="mb-1">Status: <?php echo $category['status'] === '1' ? 'Visível na home' : 'Oculto na home'; ?></p>
                        </div>
                        <div class="actions-admin d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                data-bs-target="#editarCategoriaModal<?php echo $category['categoria_id']; ?>">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal"
                                data-bs-target="#excluirCategoriaModal<?php echo $category['categoria_id']; ?>">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal"
                                data-bs-target="#viewModal<?php echo $category['categoria_id']; ?>">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>





                    <!-- Excluir Categoria Modal -->
                    <div class="modal fade" id="excluirCategoriaModal<?php echo $category['categoria_id']; ?>" tabindex="-1"
                        aria-labelledby="excluirCategoriaModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="excluirCategoriaModalLabel">Excluir Categoria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Deseja excluir a categoria "<?php echo htmlspecialchars($category['titulo_categoria']); ?>"?</p>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <input type="hidden" name="categoria_id" value="<?php echo $category['categoria_id']; ?>">
                                        <button type="submit" name="delete_category" class="btn btn-danger">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visualizar Categoria Modal -->
                    <div class="modal fade" id="viewModal<?php echo $category['categoria_id']; ?>" tabindex="-1"
                        aria-labelledby="viewModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel">Visualizar Categoria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Título: <?php echo htmlspecialchars($category['titulo_categoria']); ?></p>
                                    <p>Descrição: <?php echo htmlspecialchars($category['descricao_categoria']); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Editar Categoria Modal -->
                    <div class="modal fade" id="editarCategoriaModal<?php echo $category['categoria_id']; ?>" tabindex="-1"
                        aria-labelledby="editarCategoriaModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <input type="hidden" name="categoria_id" value="<?php echo $category['categoria_id']; ?>">
                                        <div class="mb-3">
                                            <label for="titulo_categoria" class="form-label">Título Categoria</label>
                                            <input type="text" class="form-control" id="titulo_categoria" name="titulo_categoria"
                                                value="<?php echo htmlspecialchars($category['titulo_categoria']); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="descricao_categoria" class="form-label">Descrição Categoria</label>
                                            <input type="text" class="form-control" id="descricao_categoria" name="descricao_categoria"
                                                value="<?php echo htmlspecialchars($category['descricao_categoria']); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="icon" class="form-label">Ícone da Categoria (Font Awesome)</label>
                                            <input type="text" class="form-control" id="icon" name="icon"
                                                placeholder="fa-solid fa-heart" value="<?php echo htmlspecialchars($category['icon']); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="1" <?php echo $category['status'] == 1 ? 'selected' : ''; ?>>Aparecer na home</option>
                                                <option value="2" <?php echo $category['status'] == 2 ? 'selected' : ''; ?>>Não aparecer na home</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="edit_category" class="btn btn-primary">Salvar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Nova Categoria Modal -->
            <div class="modal fade" id="novaCategoriaModal" tabindex="-1" aria-labelledby="novaCategoriaModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="novaCategoriaModalLabel">Nova Categoria</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="mb-3">
                                    <label for="titulo_categoria" class="form-label">Título Categoria</label>
                                    <input type="text" class="form-control" id="titulo_categoria" name="titulo_categoria">
                                </div>
                                <div class="mb-3">
                                    <label for="descricao_categoria" class="form-label">Descrição Categoria</label>
                                    <input type="text" class="form-control" id="descricao_categoria" name="descricao_categoria">
                                </div>
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Ícone da Categoria (Font Awesome)</label>
                                    <input type="text" class="form-control" id="icon" name="icon" placeholder="fa-solid fa-heart">
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="1">Aparecer na home</option>
                                        <option value="2">Não aparecer na home</option>
                                    </select>
                                </div>
                                <button type="submit" name="create_category" class="btn btn-primary">Criar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../layouts/footer.php'; ?>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Seleciona todos os formulários que contêm o campo 'titulo_categoria'
        const forms = document.querySelectorAll("form");

        forms.forEach(form => {
            const tituloCategoriaInput = form.querySelector("input[name='titulo_categoria']");

            // Se o campo existir no formulário, adiciona o evento de validação
            if (tituloCategoriaInput) {
                form.addEventListener("submit", function(event) {
                    if (tituloCategoriaInput.value.length > 25) {
                        event.preventDefault(); // Impede o envio do formulário
                        Swal.fire({
                            title: 'Erro!',
                            text: 'O título da categoria deve ter menos de 25 caracteres.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
</script>

</html>