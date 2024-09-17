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
