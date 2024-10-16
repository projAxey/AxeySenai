<?php
session_start(); // Inicia a sessão
include '../../config/conexao.php'; // Inclui a conexão com o banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $produtoId = $_POST['edit-service-id'];
    $nomeProduto = $_POST['edit-service-title'];
    $categoria = $_POST['edit-service-category'];

    try {
        // Atualiza o produto no banco de dados
        $sql = "UPDATE Produtos SET nome_produto = :nomeProduto, categoria = (SELECT categoria_id FROM Categorias WHERE titulo_categoria = :categoria) WHERE produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nomeProduto', $nomeProduto);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':produtoId', $produtoId);
        
        // Executa a consulta
        if ($stmt->execute()) {
            // Redireciona de volta com uma mensagem de sucesso
            $_SESSION['success_message'] = "Produto atualizado com sucesso!";
            header("Location: ../../frontend/prestador/TelaMeusProdutos.php");
            exit();
        } else {
            // Caso ocorra um erro
            $_SESSION['error_message'] = "Erro ao atualizar o produto.";
            header("Location: ../../frontend/prestador/TelaMeusProdutos.php");
            exit();
        }
    } catch (PDOException $e) {
        // Caso ocorra uma exceção
        $_SESSION['error_message'] = "Erro: " . $e->getMessage();
        header("Location: ../../frontend/prestador/TelaMeusProdutos.php");
        exit();
    }
} else {
    // Se o método não for POST, redirecione
    header("Location: ../../frontend/prestador/TelaMeusProdutos.php");
    exit();
}
?>
