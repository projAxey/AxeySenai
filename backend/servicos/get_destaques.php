<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../config/conexao.php';

try {
    if (isset($_GET['produto_id'])) {
        // Buscar detalhes de um produto específico
        $produtoId = $_GET['produto_id'];
        $sql = "SELECT * FROM Produtos WHERE produto_id = :produtoId AND categoria_produto IN (2, 3)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            $status = ($produto['categoria_produto'] == 2) ? 'APROVADO' : 'EM APROVAÇÃO';
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

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-control" readonly>' . $status . '</div>
                </div>

                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>';
        } else {
            echo 'Produto não encontrado ou não está em destaque.';
        }
    } else {
        // Buscar todos os produtos em destaque
        $sql = "SELECT p.produto_id, p.nome_produto, p.categoria_produto, p.descricao_produto, c.titulo_categoria
                FROM Produtos p
                JOIN Categorias c ON p.categoria = c.categoria_id
                WHERE p.categoria_produto IN (2, 3)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($produtos);
    }
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>