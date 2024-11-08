<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redireciona se o usuário não estiver autenticado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';

if (isset($_GET['produto_id'])) {
    $produtoId = $_GET['produto_id'];

    try {
        // Consulta para buscar os detalhes do produto
        $sql = "SELECT * FROM Produtos WHERE produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            // Adicione o CSS para estilização
            echo '
            <style>
                .product-image {
                    width: 100px; /* Largura fixa */
                    height: 100px; /* Altura fixa */
                    object-fit: cover; /* Preenche o espaço mantendo a proporção */
                    border: 1px solid #ddd; /* Borda opcional */
                    border-radius: 4px; /* Bordas arredondadas opcional */
                }
                .image-container {
                    margin-bottom: 10px; /* Espaçamento entre as imagens */
                }
            </style>
            <form id="editServiceForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="imagensRemovidas" id="imagensRemovidas">


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
                    <label for="imagensProduto" class="form-label">Imagens do Produto/Serviço</label>';

            // Explodir as imagens em um array
            $imagens = explode(',', $produto['imagem_produto']);
            if ($imagens) {
                foreach ($imagens as $index => $imagem) {
                    echo '<div class="image-container" id="loadedImage' . $index . '">
                            <img src="/projAxeySenai/' . htmlspecialchars(trim($imagem)) . '" alt="Imagem do produto" class="product-image me-2">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeImage(\'loadedImage' . $index . '\', \'' . htmlspecialchars(trim($imagem)) . '\')">Remover</button>
                          </div>';
                }
            } else {
                echo '<p>Nenhuma imagem encontrada.</p>';
            }
?>
           <?php echo ' <div class="row mb-3">
                <div class="col-md-6">
                    <label for="serviceImagesEdita" class="form-label">Adicionar Imagens</label>
                    <input type="file" class="form-control" id="serviceImagesEdita" name="serviceImagesEdita[]" multiple accept="image/*" onchange="previewImages(\'serviceImagesEdita\', \'imagePreviewEdita\')">
                    <div id="imagePreviewEdita" class="preview d-flex flex-wrap"></div>
                </div>
            </div>
          </div>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>';
        } else {
            echo '<p>Produto não encontrado.</p>';
        }
    } catch (PDOException $e) {
        echo '<p>Erro: ' . htmlspecialchars($e->getMessage()) . '</p>'; // Mensagem de erro
    }
}

            ?>