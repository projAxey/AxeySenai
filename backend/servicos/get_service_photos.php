<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../../config/conexao.php';

if (isset($_GET['produto_id'])) {
    $produtoId = $_GET['produto_id'];

    try {
        // Consulta para buscar o(s) caminho(s) das imagens do produto
        $sql = "SELECT imagem_produto FROM Produtos WHERE produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
        $stmt->execute();
        $imagem = $stmt->fetch(PDO::FETCH_COLUMN);

        if ($imagem) {
            // Supondo que os caminhos das imagens estejam separados por vírgulas
            $caminhosImagens = explode(',', $imagem);
            $baseUrl = 'http://localhost/projAxeySenai/';
            $imagensCompletas = array_map(function ($caminho) use ($baseUrl) {
                return $baseUrl . trim($caminho); // Adiciona o caminho base a cada imagem
            }, $caminhosImagens);

            // Retorna um JSON com todas as imagens
            echo json_encode(['success' => true, 'images' => $imagensCompletas]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhuma imagem encontrada.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao buscar imagem: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID do produto não fornecido.']);
}
