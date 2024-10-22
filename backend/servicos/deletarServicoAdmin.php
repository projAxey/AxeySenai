<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../config/conexao.php'; // Inclua a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o produto_id foi enviado
    if (isset($_POST['produto_id'])) {

        $produto_id = $_POST['produto_id'];

        // Exclui o produto do banco de dados
        try {
            $sql = "DELETE FROM Produtos WHERE produto_id = :produto_id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);

            // Executa a exclusão
            if ($stmt->execute()) {
                header('Location: ../../frontend/adm/controleServicos.php'); // Redireciona com sucesso
                exit();
            } else {
                echo "Erro ao excluir o produto.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }

    } else {
        echo "Produto não encontrado.";
    }
} else {
    echo "Método inválido.";
}
?>
