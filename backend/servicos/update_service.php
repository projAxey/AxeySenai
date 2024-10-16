<?php
session_start(); // Inicie a sessão

include '../../config/conexao.php'; // Inclua a configuração do banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifique se o método é POST
    $produtoId = $_POST['produto_id'];
    $nomeProduto = $_POST['nomeProduto'];
    $valorProduto = $_POST['valorProduto'];
    $descricaoProduto = $_POST['descricaoProduto'];

    try {
        // Atualiza o produto com os novos dados
        $sql = "UPDATE Produtos SET nome_produto = :nomeProduto, valor_produto = :valorProduto, descricao_produto = :descricaoProduto WHERE produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nomeProduto', $nomeProduto);
        $stmt->bindParam(':valorProduto', $valorProduto);
        $stmt->bindParam(':descricaoProduto', $descricaoProduto);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();

        // Armazenar mensagem de sucesso na sessão
        $_SESSION['mensagem_sucesso'] = 'Produto atualizado com sucesso!';
        
        // Redirecionar de volta à página principal
        header('Location: /projAxeySenai/frontend/prestador/TelaMeusProdutos.php');
        exit(); // Termina o script após o redirecionamento
    } catch (PDOException $e) {
        // Armazenar mensagem de erro na sessão
        $_SESSION['mensagem_erro'] = 'Erro ao atualizar produto: ' . $e->getMessage();
        
        // Redirecionar de volta à página principal
        header('Location: /projAxeySenai/frontend/prestador/TelaMeusProdutos.php');
        exit();
    }
}
?>
