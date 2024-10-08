<?php
// Inclui o arquivo de conexão com o banco de dados
include '../config/conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $productType = $_POST['productType'];
    $serviceName = $_POST['serviceName'];
    $serviceValue = str_replace(',', '.', str_replace('.', '', $_POST['serviceValue'])); // Formato numérico
    $serviceCategory = $_POST['serviceCategory'];
    $serviceDescription = $_POST['serviceDescription'];

    // ID do prestador (usuário logado)
    $prestador = $_SESSION['prestador_id'];

    // Processa as imagens
    $imagePaths = [];
    if (isset($_FILES['serviceImages'])) {
        foreach ($_FILES['serviceImages']['tmp_name'] as $index => $tmpName) {
            $fileName = basename($_FILES['serviceImages']['name'][$index]);
            $targetPath = '../assets/imgs/' . $fileName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                // Armazena apenas a parte do caminho que vem a partir de assets
                $imagePaths[] = 'assets/imgs/' . $fileName; // Caminho relativo
            }
        }
    }
    
    // Processa os vídeos
    $videoPaths = [];
    if (isset($_FILES['serviceVideos']) && !empty($_FILES['serviceVideos']['tmp_name'][0])) { // Verifica se há vídeo enviado
        foreach ($_FILES['serviceVideos']['tmp_name'] as $index => $tmpName) {
            $fileName = basename($_FILES['serviceVideos']['name'][$index]);
            $targetPath = '../assets/videos/' . $fileName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                // Armazena apenas a parte do caminho que vem a partir de assets
                $videoPaths[] = 'assets/videos/' . $fileName; // Caminho relativo
            }
        }
    }

    try {
        // Caminho das imagens e vídeos devem ser atribuídos a variáveis antes de passá-los por referência
        $imagePathsString = implode(',', $imagePaths); // Transforma o array de caminhos de imagens em uma string
        $videoPathsString = !empty($videoPaths) ? implode(',', $videoPaths) : null; // Transforma o array de vídeos em uma string ou deixa como NULL se não houver vídeos
        
        // Define a consulta SQL para inserir os dados no banco
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

        // Se nenhum vídeo for enviado, passa NULL, senão, passa o caminho do vídeo
        if (!empty($videoPathsString)) {
            $stmt->bindParam(':video_produto', $videoPathsString); // Caminho dos vídeos
        } else {
            $stmt->bindValue(':video_produto', null, PDO::PARAM_NULL); // Define como NULL se não houver vídeos
        }

        // Executa a consulta
        $stmt->execute();
        
        header('Location: ../frontend/prestador/TelaMeusProdutos.php');
        exit;
    } catch (PDOException $e) {
        // Exibe uma mensagem de erro
        echo "Erro ao cadastrar o produto/serviço: " . $e->getMessage();
    }
}
?>
