<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

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
        // Remove as colunas indesejadas
        unset($usuario['cliente_id'], $usuario['prestador_id'], $usuario['usuarioAdm_id'], $usuario['senha'], $usuario['status'], $usuario['url_foto'], $usuario['alteracao'], $usuario['token_temp']);

        // Definir mapeamento de nomes de colunas para rótulos
        $columnLabels = [
            "tipo_usuario" => "Tipo de Usuário",
            "email" => "E-mail",
            "celular" => "Celular",
            "telefone" => "Telefone",
            "data_nascimento" => "Data de Nascimento",
            "cep" => "CEP",
            "uf" => "UF",
            "cidade" => "Cidade",
            "bairro" => "Bairro",
            "numero" => "Número",
            "complemento" => "Complemento",
            "logradouro" => "Logradouro",
            "criacao" => "Data de Criação",
            "usuarioAdm_id" => "ID",
            "prestador_id" => "ID",
            "nome_resp_legal" => "Nome do Responsável",
            "nome_fantasia" => "Nome Fantasia",
            "razao_social" => "Razão Social",
            "cnpj" => "CNPJ",
            "categoria" => "Categoria",
            "descricao" => "Descrição",
            "cliente_id" => "ID",
            "nome" => "Nome Completo",
           
            "cpf" => "CPF",
            "cargo" => "Cargo"
        ];

        // Verificar e formatar as colunas de data
        $dateFields = ['data_nascimento', 'criacao'];
        foreach ($usuario as $key => $value) {
            if (!empty($value)) {
                // Formatar data para formato brasileiro
                if (in_array($key, $dateFields)) {
                    $value = date('d/m/Y', strtotime($value));
                }
                // Usar o rótulo definido, caso exista, senão manter o nome original
                $filteredUserData[$columnLabels[$key] ?? $key] = $value;
            }
        }

        // Enviar os dados filtrados no JSON
        echo json_encode($filteredUserData);
    } else {
        echo json_encode(["error" => "User not found."]);
    }
} else {
    echo json_encode(["error" => "Table not found."]);
}