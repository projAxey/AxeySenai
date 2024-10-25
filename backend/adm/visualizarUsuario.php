<?php
include '../../config/conexao.php';

$id = $_GET['id'];
$table = $_GET['table'];

// Validação do ID e tabela para evitar SQL Injection e assegurar a tabela correta
if (!is_numeric($id) || !in_array($table, ['UsuariosAdm', 'Prestadores', 'Clientes'])) {
    echo json_encode([]);
    exit;
}

// Define o nome da coluna de ID para cada tabela
$idColumn = match ($table) {
    'UsuariosAdm' => 'usuarioAdm_id',
    'Prestadores' => 'prestador_id',
    'Clientes' => 'cliente_id',
    default => null,
};

// Verifica se a tabela e o nome da coluna de ID foram encontrados
if ($idColumn) {
    // Consulta para obter os dados do usuário
    $query = "SELECT * FROM $table WHERE $idColumn = :id";
    $resultado = $conexao->prepare($query);
    $resultado->bindParam(':id', $id, PDO::PARAM_INT);
    $resultado->execute();

    $usuario = $resultado->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Obter colunas da tabela dinamicamente
        $queryColunas = "SHOW COLUMNS FROM $table";
        $stmtColunas = $conexao->prepare($queryColunas);
        $stmtColunas->execute();
        $colunas = $stmtColunas->fetchAll(PDO::FETCH_COLUMN);

        // Adiciona as colunas e valores ao JSON
        $usuario['columns'] = $colunas;
        echo json_encode($usuario);
    } else {
        echo json_encode(["error" => "User not found."]);
    }
} else {
    echo json_encode(["error" => "Table not found."]);
}
?>
