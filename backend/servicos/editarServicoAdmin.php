<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../config/conexao.php'; // Inclua a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os dados necessários foram enviados
    if (isset($_POST['produto_id'], $_POST['nome_produto'], $_POST['categoria_id'], $_POST['prestador_id'])) {
        
        $produto_id = $_POST['produto_id'];
        $nome_produto = $_POST['nome_produto'];
        $categoria = $_POST['categoria_id'];
        $prestador = $_POST['prestador_id'];

        // Atualiza o produto no banco de dados
        try {
            $sql = "UPDATE Produtos SET nome_produto = :nome_produto, categoria = :categoria, prestador = :prestador WHERE produto_id = :produto_id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':nome_produto', $nome_produto);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':prestador', $prestador);
            $stmt->bindParam(':produto_id', $produto_id);

            // Executa a atualização
            if ($stmt->execute()) {
                header('Location: ../../frontend/adm/controleServicos.php'); // Redireciona com sucesso
                exit();
            } else {
                echo "Erro ao editar o produto.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }

    } else {
        echo "Todos os campos são obrigatórios.";
    }
} else {
    echo "Método inválido.";
}
?>
