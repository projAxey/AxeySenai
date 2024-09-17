<?php
// Inclua o arquivo de conexão
include '../../config/conexao.php';

// Classe Categoria
class Categoria {
    private $conn;
    private $table = 'categorias';

    public $id;
    public $titulo;
    public $descricao;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar Categoria
    public function criar() {
        $query = "INSERT INTO " . $this->table . " SET titulo=:titulo, descricao=:descricao";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler Categorias
    public function ler() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Atualizar Categoria
    public function atualizar() {
        $query = "UPDATE " . $this->table . " SET titulo = :titulo, descricao = :descricao WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Excluir Categoria
    public function excluir() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}

// Classe Controladora de Categoria
class CategoriaController {
    private $db;
    private $categoria;

    public function __construct($db) {
        $this->db = $db;
        $this->categoria = new Categoria($this->db);
    }

    // Criar nova categoria
    public function criar($titulo, $descricao) {
        $this->categoria->titulo = $titulo;
        $this->categoria->descricao = $descricao;
        return $this->categoria->criar();
    }

    // Ler todas as categorias
    public function ler() {
        return $this->categoria->ler();
    }

    // Atualizar categoria
    public function atualizar($id, $titulo, $descricao) {
        $this->categoria->id = $id;
        $this->categoria->titulo = $titulo;
        $this->categoria->descricao = $descricao;
        return $this->categoria->atualizar();
    }

    // Excluir categoria
    public function excluir($id) {
        $this->categoria->id = $id;
        return $this->categoria->excluir();
    }
}

// Inicia a manipulação de requisições
$categoriaController = new CategoriaController($conn);

// Criar categoria
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['criar_categoria'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $categoriaController->criar($titulo, $descricao);
    header('Location: '.$_SERVER['PHP_SELF']);
    exit();
}

// Atualizar categoria
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar_categoria'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $categoriaController->atualizar($id, $titulo, $descricao);
    header('Location: '.$_SERVER['PHP_SELF']);
    exit();
}

// Excluir categoria
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $categoriaController->excluir($id);
    header('Location: '.$_SERVER['PHP_SELF']);
    exit();
}

$resultado = $categoriaController->ler();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="title-admin">GERENCIAR CATEGORIAS</div>
        <div class="d-flex justify-content-between mb-4">
            <button type="button" id="meusAgendamentos" class="mb-2 btn btn-primary btn-meus-agendamentos"
                    style="background-color: #012640; color:white" data-bs-toggle="modal"
                    data-bs-target="#novaCategoriaModal">
                Nova Categoria <i class="bi bi-plus-circle"></i>
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-striped-admin">
                <thead>
                <tr>
                    <th class="th-admin">TÍTULO</th>
                    <th class="th-admin">DESCRIÇÃO</th>
                    <th class="th-admin">AÇÕES</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['titulo']; ?></td>
                        <td><?php echo $row['descricao']; ?></td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                    data-bs-target="#editModal<?php echo $row['id']; ?>"><i class="fa-solid fa-pen"></i></button>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-admin delete-admin"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                    <!-- Modal de Edição -->
                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Editar Categoria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="mb-3">
                                            <label for="titulo" class="form-label">Título</label>
                                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $row['titulo']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="descricao" class="form-label">Descrição</label>
                                            <textarea class="form-control" id="descricao" name="descricao" rows="4"><?php echo $row['descricao']; ?></textarea>
                                        </div>
                                        <button type="submit" name="atualizar_categoria" class="btn btn-primary">Salvar Alterações</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Nova Categoria -->
<div class="modal fade" id="novaCategoriaModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newModalLabel">Nova Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4" required></textarea>
                    </div>
                    <button type="submit" name="criar_categoria" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
