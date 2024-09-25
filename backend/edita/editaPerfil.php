<?php
session_start();
require_once '../../config/conexao.php'; // Conexão com o banco de dados

$id = $_SESSION['cliente_id'];
$tipoUsuario = $_SESSION['tipo_usuario'];

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || $tipoUsuario !== 'cliente') {
    header("Location: ../../frontend/auth/login.php");
    exit();
}

// Captura os dados do cliente
$nome = $_POST['nome'] ?? null;
$nomeSocial = $_POST['nomeSocial'] ?? null; // Se não houver nome social, será null
$email = $_POST['email'] ?? null;
$dataNascimento = $_POST['dataNascimento'] ?? null;
$cpf = $_POST['cpf'] ?? null;
$celular = $_POST['celular'] ?? null;
$telefone = $_POST['telefone'] ?? null;
$cep = $_POST['cep'] ?? null;
$logradouro = $_POST['logradouro'] ?? null;
$bairro = $_POST['bairro'] ?? null;
$numero = $_POST['numero'] ?? null;
$cidade = $_POST['cidade'] ?? null;
$uf = $_POST['uf'] ?? null; // Supondo que o estado esteja sendo enviado
$complemento = $_POST['complemento'] ?? null;
$senha = $_POST['senha'] ?? null;

// Atualiza os dados do cliente
$sql = "UPDATE Clientes SET 
            nome = :nome, 
            nome_social = :nomeSocial, 
            email = :email, 
            data_nascimento = :dataNascimento, 
            cpf = :cpf, 
            celular = :celular, 
            telefone = :telefone, 
            cep = :cep, 
            logradouro = :logradouro, 
            bairro = :bairro, 
            numero = :numero, 
            cidade = :cidade, 
            uf = :uf, 
            complemento = :complemento" . 
            ($senha ? ", senha = :senha" : "") . 
            " WHERE cliente_id = :cliente_id";

$stmt = $conexao->prepare($sql);

$params = [
    ':nome' => $nome,
    ':nomeSocial' => $nomeSocial,
    ':email' => $email,
    ':dataNascimento' => $dataNascimento,
    ':cpf' => $cpf,
    ':celular' => $celular,
    ':telefone' => $telefone,
    ':cep' => $cep,
    ':logradouro' => $logradouro,
    ':bairro' => $bairro,
    ':numero' => $numero,
    ':cidade' => $cidade,
    ':uf' => $uf,
    ':complemento' => $complemento,
    ':cliente_id' => $id,
];

if ($senha) {
    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    $params[':senha'] = $senhaCriptografada;
}

try {
    // Executa a consulta com os parâmetros
    $stmt->execute($params);

    // Verifica se a atualização foi bem-sucedida
    if ($stmt->rowCount() > 0) {
        $_SESSION['update_success'] = 'Dados atualizados com sucesso!';
    } else {
        $_SESSION['update_error'] = 'Nenhuma alteração foi feita.';
    }
} catch (Exception $e) {
    $_SESSION['update_error'] = 'Erro ao atualizar dados: ' . $e->getMessage();
}

header("Location: /projAxeySenai/frontend/cliente/perfilCliente.php"); // Redirecionar após o sucesso
exit();
?>
