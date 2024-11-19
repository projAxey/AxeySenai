<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produtoId = $_POST['produto_id'];
    $nomeProduto = $_POST['nomeProduto'];
    $valorProduto = $_POST['valorProduto'];
    $descricaoProduto = $_POST['descricaoProduto'];
    $imagensRemovidas = isset($_POST['imagensRemovidas']) ? explode(',', $_POST['imagensRemovidas']) : [];

    try {
        // Obtém as URLs de imagens atuais do banco de dados
        $stmt = $conexao->prepare("SELECT imagem_produto FROM Produtos WHERE produto_id = :produtoId");
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagensAtuais = $produto ? explode(',', $produto['imagem_produto']) : [];

        // Remove as URLs das imagens que foram excluídas pelo usuário
        $imagensAtualizadas = array_diff($imagensAtuais, $imagensRemovidas);

        // Adiciona as novas imagens
        if (!empty($_FILES['serviceImagesEdita']['name'][0])) {
            $uploadDir = '/projAxeySenai/files/imgsServicos/'; // Caminho relativo ao servidor
            foreach ($_FILES['serviceImagesEdita']['tmp_name'] as $key => $tmpName) {
                $fileName = basename($_FILES['serviceImagesEdita']['name'][$key]);
                $uploadFilePath = $uploadDir . $fileName; // Caminho relativo para armazenar no banco
                if (move_uploaded_file($tmpName, $_SERVER['DOCUMENT_ROOT'] . '/' . $uploadFilePath)) {
                    // Adiciona a nova imagem ao array de imagens (salvando no banco apenas o caminho relativo)
                    $imagensAtualizadas[] = 'files/imgsServicos/' . $fileName;
                } else {
                    echo 'Erro ao mover o arquivo: ' . $fileName;
                }
            }
        }

        // Atualiza o banco de dados com a lista de imagens atualizadas
        $imagensString = implode(',', $imagensAtualizadas);
        $status = 1; // Status para aprovação
        $sql = "UPDATE Produtos 
                SET nome_produto = :nomeProduto, 
                    valor_produto = :valorProduto, 
                    descricao_produto = :descricaoProduto, 
                    imagem_produto = :imagensAtualizadas, 
                    status_destaque = 1,
                    status = :status 
                WHERE produto_id = :produtoId";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nomeProduto', $nomeProduto);
        $stmt->bindParam(':valorProduto', $valorProduto);
        $stmt->bindParam(':descricaoProduto', $descricaoProduto);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->bindParam(':imagensAtualizadas', $imagensString);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->execute();

        // Redireciona após a atualização
        $_SESSION['mensagem_sucesso'] = 'Produto atualizado com sucesso!';
        header('Location: /projAxeySenai/frontend/prestador/TelaMeusAnuncios.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['mensagem_erro'] = 'Erro ao atualizar produto: ' . $e->getMessage();
        header('Location: /projAxeySenai/frontend/prestador/TelaMeusAnuncios.php');
        exit();
    }
}
