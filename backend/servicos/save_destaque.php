<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura o ID do produto enviado pelo formulário
    $produto_id = $_POST['produto_id'];

    try {
        // Query para atualizar o campo categoria_produto
        $sql = "UPDATE Produtos SET categoria_produto = 3 WHERE produto_id = :produto_id";

        // Prepara a query
        $stmt = $conexao->prepare($sql);

        // Vincula o parâmetro
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);

        // Executa o update
        $stmt->execute();

        // Redireciona de volta para a página principal após a atualização
        $_SESSION['mensagem_sucesso'] = "Produto destacado com sucesso!";
        header('Location: ../../frontend/prestador/TelaMeusProdutos.php');
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar o destaque do produto: " . $e->getMessage();
    }
}
