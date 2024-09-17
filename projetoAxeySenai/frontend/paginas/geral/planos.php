<?php
// Classe para gerenciar as operações com a tabela Categorias
class Categoria {
    private $conn;

    // Construtor para conectar ao banco de dados
    public function __construct($db) {
        $this->conn = $db;
    }

    // Função para criar uma nova categoria
    public function criarCategoria($titulo, $descricao) {
        $sql = "INSERT INTO Categorias (titulo_categoria, descricao_categoria, create_categoria) 
                VALUES (:titulo, :descricao, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        return $stmt->execute();
    }

    // Função para ler todas as categorias
    public function listarCategorias() {
        $sql = "SELECT * FROM Categorias";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função para atualizar uma categoria
    public function atualizarCategoria($id, $titulo, $descricao) {
        $sql = "UPDATE Categorias 
                SET titulo_categoria = :titulo, descricao_categoria = :descricao, altera_categoria = NOW() 
                WHERE idCategoria = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        return $stmt->execute();
    }

    // Função para excluir uma categoria
    public function deletarCategoria($id) {
        $sql = "DELETE FROM Categorias WHERE idCategoria = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

// Classe Page para renderizar o layout e o conteúdo
class Page {
    private $categoria;

    public function __construct($categoria) {
        $this->categoria = $categoria;
    }

    public function render() {
        $this->head();
        echo '<body class="bodyCategorias">';
        $this->nav();
        echo '<div class="main-container">';
        $this->content();
        $this->footer();
        echo '</div>';
        echo $this->getScripts();
        echo '</body></html>';
    }

    private function head() {
        include '../../padroes/head.php';
    }

    private function nav() {
        include '../../padroes/nav.php';
    }

    private function content() {
        $categorias = $this->categoria->listarCategorias();

        echo '
        <div class="container mt-3">
            <h2 class="tituloCategorias">Gerenciar Categorias</h2>
            <a href="criar_categoria.php" class="btn btn-success mb-2">Nova Categoria</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($categorias as $categoria) {
            echo '
                    <tr>
                        <td>' . $categoria['idCategoria'] . '</td>
                        <td>' . $categoria['titulo_categoria'] . '</td>
                        <td>' . $categoria['descricao_categoria'] . '</td>
                        <td>' . $categoria['create_categoria'] . '</td>
                        <td>' . $categoria['altera_categoria'] . '</td>
                        <td>
                            <a href="editar_categoria.php?id=' . $categoria['idCategoria'] . '" class="btn btn-primary btn-sm">Editar</a>
                            <a href="deletar_categoria.php?id=' . $categoria['idCategoria'] . '" class="btn btn-danger btn-sm">Deletar</a>
                        </td>
                    </tr>';
        }

        echo '
                </tbody>
            </table>
        </div>';
    }

    private function footer() {
        include '../../padroes/footer.php';
    }

    private function getScripts() {
        return '
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';
    }
}

// Configuração do banco de dados e inicialização do CRUD
try {
    $db = new PDO('mysql:host=localhost;dbname=seu_banco', 'usuario', 'senha');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $categoria = new Categoria($db);
    $page = new Page($categoria);
    $page->render();
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
}
?>
