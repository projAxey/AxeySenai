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

// Function to create a new category
function createCategory($conexao)
{
    if (isset($_POST['create_category'])) {
        $titulo_categoria = trim($_POST['titulo_categoria']);
        $descricao_categoria = trim($_POST['descricao_categoria']);
        $icon = trim($_POST['icon']);

        if (empty($titulo_categoria) || empty($descricao_categoria) || ctype_space($titulo_categoria) || ctype_space($descricao_categoria)) {
            $erro = "Erro: Não é possível criar uma categoria vazia ou nulla. Por favor, preencha todos os campos com texto válido.";
        } else {
            // Usando PDO para preparar a consulta
            $sql = "INSERT INTO Categorias (titulo_categoria, descricao_categoria, icon) VALUES (:titulo_categoria, :descricao_categoria, :icon)";
            $stmt = $conexao->prepare($sql);

            // Bind parameters usando PDO
            $stmt->bindParam(':titulo_categoria', $titulo_categoria);
            $stmt->bindParam(':descricao_categoria', $descricao_categoria);
            $stmt->bindParam(':icon', $icon);

            // Execute the statement
            if ($stmt->execute()) {
                ob_end_flush();
                header("Refresh:0");
                exit;
            } else {
                $erro = "Erro ao criar a categoria: " . implode(", ", $stmt->errorInfo());
            }
        }
    }
}

// Function to update an existing category
function edit_category($conexao)
{
    if (isset($_POST['edit_category'])) {
        $categoria_id = $_POST['categoria_id'];
        $titulo_categoria = trim($_POST['titulo_categoria']);
        $descricao_categoria = trim($_POST['descricao_categoria']);
        $icon = trim($_POST['icon']);

        if (empty($titulo_categoria) || empty($descricao_categoria) || ctype_space($titulo_categoria) || ctype_space($descricao_categoria)) {
            $erro = "Erro: Não é possível atualizar uma categoria vazia ou nulla. Por favor, preencha todos os campos com texto válido.";
        } else {
            // Usando PDO para preparar a consulta
            $sql = "UPDATE Categorias SET titulo_categoria = :titulo_categoria, descricao_categoria = :descricao_categoria, icon = :icon WHERE categoria_id = :categoria_id";
            $stmt = $conexao->prepare($sql);

            // Bind parameters usando PDO
            $stmt->bindParam(':titulo_categoria', $titulo_categoria);
            $stmt->bindParam(':descricao_categoria', $descricao_categoria);
            $stmt->bindParam(':icon', $icon);
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);

            // Execute the statement
            if ($stmt->execute()) {
                ob_end_flush();
                header("Refresh:0");
                exit;
            } else {
                $erro = "Erro ao atualizar a categoria: " . implode(", ", $stmt->errorInfo());
            }
        }
    }
}

// Function to delete a category
function deleteCategory($conexao)
{
    if (isset($_POST['delete_category'])) {
        $categoria_id = $_POST['categoria_id'];
    
        // Usando PDO para preparar a consulta
        $sql = "DELETE FROM Categorias WHERE categoria_id = :categoria_id";
        $stmt = $conexao->prepare($sql);
        
        // Bind parameter usando PDO
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        
        // Execute the statement
        if ($stmt->execute()) {
            ob_end_flush();
            header("Refresh:0");
            exit;
        } else {
            $erro = "Erro ao excluir a categoria: " . implode(", ", $stmt->errorInfo());
        }
    }
    
}

// Function to retrieve all categories
function getAllCategories($conexao)
{
    $sql = "SELECT * FROM Categorias";
    $result = $conexao->query($sql);
    return $result;
}

// Function to retrieve a single category by its ID
function getCategoryById($conexao, $categoria_id)
{
    $sql = "SELECT * FROM Categorias WHERE categoria_id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch();
}

// Handle form submissions
createCategory($conexao);
edit_category($conexao);
deleteCategory($conexao);

// Retrieve all categories
$categories = getAllCategories($conexao);

include '../layouts/head.php';
include '../layouts/nav.php';
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
            <div class="title-admin">GERENCIAR CATEGORIAS</div>
            <div class="d-flex justify-content-between mb-4">
                <button type="button" id="meusAgendamentos" class="mb-2 btn btn-meus-agendamentos"
                    style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novaCategoriaModal">
                    Nova Categoria <i class="bi bi-plus-circle"></i>
                </button>
            </div>

            <?php if (isset($erro)) { ?>
                <div class="alert alert-danger">
                    <?php echo $erro; ?>
                </div>
            <?php } ?>

            <div class="list-group mb-5">
                <?php while ($category = $categories->fetch()) { ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">
                                <i class="<?php echo htmlspecialchars($category['icon']); ?>"></i>
                                <?php echo htmlspecialchars($category['titulo_categoria']); ?>
                            </h5>
                            <p class="mb-1"><?php echo htmlspecialchars($category['descricao_categoria']); ?></p>
                        </div>
                        <div class="actions-admin">
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

</html>