<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "axey_senai";


try {
    // Cria a conexão com PDO
    $conexao = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configura o PDO para lançar exceções em caso de erro
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Se a conexão for bem-sucedida, o código continua a ser executado
} catch (PDOException $e) {
    // Em caso de erro, define o código de resposta HTTP para 500 e retorna a mensagem de erro em JSON
    http_response_code(500);

    echo json_encode(["error" => "Falha na conexão: " . $conexao->connect_error]);
    exit();
}

$conexao->close();

?>