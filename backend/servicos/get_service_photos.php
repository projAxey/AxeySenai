<?php
include '../../config/conexao.php';

if (isset($_GET['produto_id'])) {
    $produtoId = $_GET['produto_id'];

    try {
        // Consulta para buscar as imagens do serviço
        $sql = "SELECT imagem_produto FROM Produtos WHERE produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto && !empty($produto['imagem_produto'])) {
            // Supondo que as imagens sejam salvas como caminhos separados por vírgula
            $imagens = explode(',', $produto['imagem_produto']);
            foreach ($imagens as $imagem) {
                echo '<img src="' . htmlspecialchars($imagem) . '" class="img-fluid" alt="Imagem do Produto">';
            }
        } else {
            echo 'Nenhuma imagem encontrada para este produto.';
        }
    } catch (PDOException $e) {
        echo 'Erro ao buscar imagens: ' . $e->getMessage();
    }
}
?>
