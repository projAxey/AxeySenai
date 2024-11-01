<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';

if (isset($_GET['produto_id'])) {
    $produtoId = $_GET['produto_id'];

    try {
        // Consulta para buscar os detalhes do serviço
        $sql = "SELECT p.nome_produto, p.valor_produto, p.descricao_produto, c.titulo_categoria 
                FROM Produtos p
                JOIN Categorias c ON p.categoria = c.categoria_id 
                WHERE p.produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            echo '
            <h5>' . htmlspecialchars($produto['nome_produto']) . '</h5>
            <p><strong>Categoria:</strong> ' . htmlspecialchars($produto['titulo_categoria']) . '</p>
            <p><strong>Valor:</strong> ' . htmlspecialchars($produto['valor_produto']) . '</p>
            <p><strong>Descrição:</strong> ' . htmlspecialchars($produto['descricao_produto']) . '</p>';
        } else {
            echo 'Produto não encontrado.';
        }
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>
