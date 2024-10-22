<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../config/conexao.php';

if (isset($_GET['produto_id'])) {
    $produtoId = $_GET['produto_id'];

    try {
        // Consulta para buscar os detalhes do serviço
        $sql = "SELECT * FROM Produtos WHERE produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            // Retornar o formulário preenchido com os dados do produto
            echo '
<form id="editServiceForm" method="post">
    <input type="hidden" name="produto_id" value="' . htmlspecialchars($produto['produto_id']) . '">
    <div class="mb-3">
        <label for="nomeProduto" class="form-label">Nome do Produto/Serviço</label>
        <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" value="' . htmlspecialchars($produto['nome_produto']) . '" required>
    </div>
    <div class="mb-3">
        <label for="valorProduto" class="form-label">Valor</label>
        <input type="text" class="form-control" id="valorProduto" name="valorProduto" onkeyup="formatPriceReversed(this)" value="' . htmlspecialchars($produto['valor_produto']) . '" required>
    </div>
    <div class="mb-3">
        <label for="descricaoProduto" class="form-label">Descrição</label>
        <textarea class="form-control" id="descricaoProduto" name="descricaoProduto" rows="4" required>' . htmlspecialchars($produto['descricao_produto']) . '</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
</form>';
        } else {
            echo 'Produto não encontrado.';
        }
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>
