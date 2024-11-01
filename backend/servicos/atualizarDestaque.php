<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php'; // Conectando ao banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'];
    $categoria_produto = $_POST['categoria_produto']; // Recebe o valor de categoria_produto (1 ou 2)

    try {
        // Atualiza a coluna categoria_produto com o valor recebido
        $sql = "UPDATE Produtos SET categoria_produto = :categoria_produto WHERE produto_id = :produto_id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':categoria_produto', $categoria_produto, PDO::PARAM_INT);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redireciona de volta para a página anterior
        $_SESSION['mensagem_sucesso'] = "Produto atualizado com sucesso!";
        header("Location: ../../frontend/adm/controleDestaques.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar a categoria_produto: " . $e->getMessage();
    }
}
?>
