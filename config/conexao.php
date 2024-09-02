<?

$dbname = "axey_db";
$servername = "localhost";
$username = "root";
$password = "";

$conexao = new mysqli($servername, $username, $password, $dbname);

if ($conexao->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Falha na conexão"]);
    exit();
}
