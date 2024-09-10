<?php

$servername = "108.179.193.15";
$username = "axeyfu72_root";
$password = "AiOu}v3P0kx6";
$dbname = "axeyfu72_db";

try {
    // Cria a conexão com PDO
    $conexao = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configura o PDO para lançar exceções em caso de erro
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Se a conexão for bem-sucedida, o código continua a ser executado
} catch (PDOException $e) {
    // Em caso de erro, define o código de resposta HTTP para 500 e retorna a mensagem de erro em JSON
    http_response_code(500);
    echo json_encode(["error" => "Falha na conexão: " . $e->getMessage()]);
    exit();
}

echo "Conexão bem sucedida";

// Fecha a conexão
$conexao = null;
?>