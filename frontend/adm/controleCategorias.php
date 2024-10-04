<?php

// Connection details
$hostname = '108.179.193.15';
$username = 'axeyfu72_root';
$password = 'AiOu}v3P0kx6';
$database = 'axeyfu72_db';

// Create a connection to the database
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create a new category
function createCategory($conn) {
    if (isset($_POST['create_category'])) {
        $titulo_categoria = trim($_POST['titulo_categoria']);
        $descricao_categoria = trim($_POST['descricao_categoria']);

        if (empty($titulo_categoria) || empty($descricao_categoria) || ctype_space($titulo_categoria) || ctype_space($descricao_categoria)) {
            $erro = "Erro: Não é possível criar uma categoria vazia ou nulla. Por favor, preencha todos os campos com texto válido.";
        } else {
            $sql = "INSERT INTO Categorias (titulo_categoria, descricao_categoria) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $titulo_categoria, $descricao_categoria);
            $stmt->execute();

            ob_end_flush();
            header("Refresh:0");
            exit;
        }
    }
}

// Function to update an existing category
function updateCategory($conn) {
    if (isset($_POST['update_category'])) {
        $categoria_id = $_POST['categoria_id'];
        $titulo_categoria = trim($_POST['titulo_categoria']);
        $descricao_categoria = trim($_POST['descricao_categoria']);

        if (empty($titulo_categoria) || empty($descricao_categoria) || ctype_space($titulo_categoria) || ctype_space($descricao_categoria)) {
            $erro = "Erro: Não é possível atualizar uma categoria vazia ou nulla. Por favor, preencha todos os campos com texto válido.";
        } else {
            $sql = "UPDATE Categorias SET titulo_categoria=?, descricao_categoria=? WHERE categoria_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $titulo_categoria, $descricao_categoria, $categoria_id);
            $stmt->execute();

            ob_end_flush();
            header("Refresh:0");
            exit;
        }
    }
}

// Function to delete a category
function deleteCategory($conn) {
    if (isset($_POST['delete_category'])) {
        $categoria_id = $_POST['categoria_id'];

        $sql = "DELETE FROM Categorias WHERE categoria_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();

        ob_end_flush();
        header("Refresh:0");
        exit;
    }
}

// Function to retrieve all categories
function getAllCategories($conn) {
    $sql = "SELECT * FROM Categorias";
    $result = $conn->query($sql);
    return $result;
}

// Function to retrieve a single category by its ID
function getCategoryById($conn, $categoria_id) {
    $sql = "SELECT * FROM Categorias WHERE categoria_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Handle form submissions
createCategory($conn);
updateCategory($conn);
deleteCategory($conn);

// Retrieve all categories
$categories = getAllCategories($conn);

// Close the database connection
$conn->close();

include '../layouts/head.php';
include '../layouts/nav.php';
?>
<!DOCTYPE html>
<html>
<!-- <head>
    <title>Gerencffiar Categorias</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head> -->
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
    <?php while ($category = $categories->fetch_assoc()) { ?>
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1"><?php echo htmlspecialchars($category['titulo_categoria']); ?></h5>
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
                            <button type="submit" name="update_category" class="btn btn-primary">Atualizar</button>
                        </form>
                    </div>
                </div>
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
    <?php } ?>
</div>
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
                                <button type="submit" name="create_category" class="btn btn-primary">Criar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </main>
    <?php
    include '../layouts/footer.php';
    ?>
</body>
</html>