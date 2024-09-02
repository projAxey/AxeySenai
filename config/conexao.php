<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "axey_senai";

$conexao = new mysqli($servername, $username, $password, $dbname);

if ($conexao->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Falha na conexão: " . $conexao->connect_error]);
    exit();
}

$conexao->close();
?>