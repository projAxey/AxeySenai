<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $productType = $_POST['productType'];
    $serviceName = $_POST['serviceName'];
    $serviceValue = str_replace(',', '.', str_replace('.', '', $_POST['serviceValue'])); // Formato numérico
    $serviceCategory = $_POST['serviceCategory'];
    $serviceDescription = $_POST['serviceDescription'];
    $prestador = $_SESSION['id'];

    // Processa as imagens
    $imagePaths = [];
    if (isset($_FILES['serviceImages'])) {
        foreach ($_FILES['serviceImages']['tmp_name'] as $index => $tmpName) {
            $fileName = basename($_FILES['serviceImages']['name'][$index]);
            $targetPath = '../../files/imgsServicos/' . $fileName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                $imagePaths[] = 'files/imgsServicos/' . $fileName; // Caminho relativo
            }
        }
    }

    // Processa os vídeos
    $videoPaths = [];
    if (isset($_FILES['serviceVideos']) && !empty($_FILES['serviceVideos']['tmp_name'][0])) { // Verifica se há vídeo enviado
        foreach ($_FILES['serviceVideos']['tmp_name'] as $index => $tmpName) {
            $fileName = basename($_FILES['serviceVideos']['name'][$index]);
            $targetPath = '../../files/videosServicos/' . $fileName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                $videoPaths[] = 'files/videosServicos/' . $fileName;
            }
        }
    }

    try {
        $imagePathsString = implode(',', $imagePaths); // Transforma o array de imagens em uma string
        $videoPathsString = !empty($videoPaths) ? implode(',', $videoPaths) : null; // Transforma o array de vídeos em uma string ou deixa como NULL se não houver vídeos

        $sql = "INSERT INTO Produtos 
                (prestador, categoria, tipo_produto, nome_produto, valor_produto, descricao_produto, imagem_produto, video_produto, status, criacao, alteracao)
                VALUES 
                (:prestador, :categoria, :tipo_produto, :nome_produto, :valor_produto, :descricao_produto, :imagem_produto, :video_produto, 1, NOW(), NOW())";

        // Prepara a consulta
        $stmt = $conexao->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':prestador', $prestador);
        $stmt->bindParam(':categoria', $serviceCategory);
        $stmt->bindParam(':tipo_produto', $productType);
        $stmt->bindParam(':nome_produto', $serviceName);
        $stmt->bindParam(':valor_produto', $serviceValue);
        $stmt->bindParam(':descricao_produto', $serviceDescription);
        $stmt->bindParam(':imagem_produto', $imagePathsString); // Caminho das imagens
        if (!empty($videoPathsString)) {
            $stmt->bindParam(':video_produto', $videoPathsString); // Caminho dos vídeos
        } else {
            $stmt->bindValue(':video_produto', null, PDO::PARAM_NULL); // Define como NULL se não houver vídeos
        }

        $stmt->execute();

        header('Location: ../../frontend/prestador/TelaMeusProdutos.php');
        exit;
    } catch (PDOException $e) {
        echo "Erro ao cadastrar o produto/serviço: " . $e->getMessage();
    }
}
