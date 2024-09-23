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

// Function to create a new product
function createProduct($conn) {
    if (isset($_POST['create_product'])) {
        $nome_produto = $_POST['nome_produto'];
        $valor_produto = $_POST['valor_produto'];
        $descricao_produto = $_POST['descricao_produto'];
        $imagem_produto = $_POST['imagem_produto'];
        $video_produto = $_POST['video_produto'];
        $prestador = $_POST['prestador'];
        $categoria = $_POST['categoria'];

        $sql = "INSERT INTO Produtos (nome_produto, valor_produto, descricao_produto, imagem_produto, video_produto, prestador, categoria) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $nome_produto, $valor_produto, $descricao_produto, $imagem_produto, $video_produto, $prestador, $categoria);
        $stmt->execute();

        header("Location: index.php?message=success");
        exit;
    }
}

// Function to update an existing product
function updateProduct($conn) {
    if (isset($_POST['update_product'])) {
        $produto_id = $_POST['produto_id'];
        $nome_produto = $_POST['nome_produto'];
        $valor_produto = $_POST['valor_produto'];
        $descricao_produto = $_POST['descricao_produto'];
        $imagem_produto = $_POST['imagem_produto'];
        $video_produto = $_POST['video_produto'];
        $prestador = $_POST['prestador'];
        $categoria = $_POST['categoria'];

        $sql = "UPDATE Produtos SET nome_produto=?, valor_produto=?, descricao_produto=?, imagem_produto=?, video_produto=?, prestador=?, categoria=? WHERE produto_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $nome_produto, $valor_produto, $descricao_produto, $imagem_produto, $video_produto, $prestador, $categoria, $produto_id);
        $stmt->execute();

        header("Location: index.php?message=updated");
        exit;
    }
}

// Function to delete a product
function deleteProduct($conn) {
    if (isset($_POST['delete_product'])) {
        $produto_id = $_POST['produto_id'];

        $sql = "DELETE FROM Produtos WHERE produto_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $produto_id);
        $stmt->execute();

        header("Location: index.php?message=deleted");
        exit;
    }
}

// Function to retrieve all products
function getAllProducts($conn) {
    $sql = "SELECT * FROM Produtos";
    $result = $conn->query($sql);
    return $result;
}

// Function to retrieve a single product by its ID
function getProductById($conn, $produto_id) {
    $sql = "SELECT * FROM Produtos WHERE produto_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $produto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Handle form submissions
createProduct($conn);
updateProduct($conn);
deleteProduct($conn);

// Retrieve all products
$products = getAllProducts($conn);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Produtos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <main class="main-admin">
        <div class="container container-admin">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-admin">
                    <li class="breadcrumb-item">
                        <a href="admin.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                    </li>
                </ol>
            </nav>
 <div class="title-admin">GERENCIAR PRODUTOS</div>
            <div class="d-flex justify-content-between mb-4">
                <button type="button" id="meusAgendamentos" class="mb-2 btn btn-primary btn-meus-agendamentos"
                        style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novaProdutoModal">
                    Novo Produto <i class="bi bi-plus-circle"></i>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-striped-admin">
                    <thead>
                        <tr>
                            <th class="th-admin">NOME PRODUTO</th>
                            <th class="th-admin">VALOR PRODUTO</th>
                            <th class="th-admin">DESCRIÇÃO PRODUTO</th>
                            <th class="th-admin">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = $products->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $product['nome_produto']; ?></td>
                                <td><?php echo $product['valor_produto']; ?></td>
                                <td><?php echo $product['descricao_produto']; ?></td>
                                <td class="actions-admin">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarProdutoModal<?php echo $product['produto_id']; ?>">
                                        Editar
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletarProdutoModal<?php echo $product['produto_id']; ?>">
                                        Deletar
                                    </button>
                                </td>
                            </tr>

                            <!-- Editar Produto Modal -->
                            <div class="modal fade" id="editarProdutoModal<?php echo $product['produto_id']; ?>" tabindex="-1" aria-labelledby="editarProdutoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editarProdutoModalLabel">Editar Produto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                <input type="hidden" name="produto_id" value="<?php echo $product['produto_id']; ?>">
                                                <div class="mb-3">
                                                    <label for="nome_produto" class="form-label">Nome Produto</label>
                                                    <input type="text" class="form-control" id="nome_produto" name="nome_produto" value="<?php echo $product['nome_produto']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="valor_produto" class="form-label">Valor Produto</label>
                                                    <input type="text" class="form-control" id="valor_produto" name="valor_produto" value="<?php echo $product['valor_produto']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descricao_produto" class="form-label">Descrição Produto</label>
                                                    <input type="text" class="form-control" id="descricao_produto" name="descricao_produto" value="<?php echo $product['descricao_produto']; ?>">
                                                </div>
                                                <button type="submit" name="update_product" class="btn btn-primary">Atualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Deletar Produto Modal -->
                            <div class="modal fade" id="deletarProdutoModal<?php echo $product['produto_id']; ?>" tabindex="-1" aria-labelledby="deletarProdutoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deletarProdutoModalLabel">Deletar Produto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Você tem certeza que deseja deletar o produto "<?php echo $product['nome_produto']; ?>"?</p>
                                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                <input type="hidden" name="produto_id" value="<?php echo $product['produto_id']; ?>">
                                                <button type="submit" name=" delete_product" class="btn btn-danger">Deletar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Novo Produto Modal -->
            <div class="modal fade" id="novaProdutoModal" tabindex="-1" aria-labelledby="novaProdutoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="novaProdutoModalLabel">Novo Produto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="mb-3">
                                    <label for="nome_produto" class="form-label">Nome Produto</label>
                                    <input type="text" class="form-control" id="nome_produto" name="nome_produto">
                                </div>
                                <div class="mb-3">
                                    <label for="valor_produto" class="form-label">Valor Produto</label>
                                    <input type="text" class="form-control" id="valor_produto" name="valor_produto">
                                </div>
                                <div class="mb-3">
                                    <label for="descricao_produto" class="form-label">Descrição Produto</label>
                                    <input type="text" class="form-control" id="descricao_produto" name="descricao_produto">
                                </div>
                                <button type="submit" name="create_product" class="btn btn-primary">Criar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-<?php echo $_GET['message'] == 'success' ? 'success' : ($_GET['message'] == 'updated' ? 'warning' : 'danger'); ?> alert-dismissible fade show" role="alert">
            <?php echo $_GET['message'] == 'success' ? 'Produto criado com sucesso!' : ($_GET['message'] == 'updated' ? 'Produto atualizado com sucesso!' : 'Produto deletado com sucesso!'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
</body>
</html>