<?php
require_once '../config/conexao.php';

// Inicia a sessão para usar variáveis de sessão
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tipoUsuario = $_POST['tipoUsuario'];

    $nomeSocial = $_POST['nomeSocial'] ?? null;
    $email = $_POST['email'];
    $dataNascimento = $_POST['dataNascimento'] ?? null;
    $celular = $_POST['celular'];
    $telefone = $_POST['telefone'] ?? null;
    $cep = preg_replace('/\D/', '', $_POST['cep']);
    $logradouro = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['estado'];
    $complemento = $_POST['complemento'] ?? null;
    $senha = $_POST['senha'];
    $senhaRepetida = $_POST['senha_repetida'];

    if ($senha != $senhaRepetida) {
        die('As senhas não coincidem.');
    }

    $senhaCriptografada = password_hash($senha, PASSWORD_BCRYPT);

    // Verifica se o e-mail já existe em ambas as tabelas
    $sqlCheck = "SELECT COUNT(*) FROM Clientes WHERE email = :email UNION SELECT COUNT(*) FROM Prestadores WHERE email = :email";
    $stmtCheck = $conexao->prepare($sqlCheck);
    $stmtCheck->execute([':email' => $email]);

    // Verifica o número de registros encontrados
    $results = $stmtCheck->fetchAll(PDO::FETCH_COLUMN);
    if ($results[0] > 0 || $results[1] > 0) {
        die('Este e-mail já está cadastrado em outra conta.');
    }

    if ($tipoUsuario === 'cliente') {
        $cpf = preg_replace('/\D/', '', $_POST['cpf']);
        $nome = $_POST['nome'];

        $sql = "INSERT INTO Clientes (nome, nome_social, email, data_nascimento, cpf, celular, telefone, cep, logradouro, bairro, numero, cidade, uf, complemento, senha) 
                VALUES (:nome, :nomeSocial, :email, :dataNascimento, :cpf, :celular, :telefone, :cep, :logradouro, :bairro, :numero, :cidade, :uf, :complemento, :senha)";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([
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
            ':senha' => $senhaCriptografada
        ]);
    } elseif ($tipoUsuario === 'prestador') {
        $nome_resp_legal = $_POST['nome'];
        $nomeFantasia = $_POST['nomeFantasia'] ?? null;
        $razaoSocial = $_POST['razaoSocial'] ?? null;
        $cnpj = $_POST['cnpj'] ?? null;
        $cpf = preg_replace('/\D/', '', $_POST['cpf']) ?? null;

        $sql = "INSERT INTO Prestadores (nome_resp_legal, nome_social, nome_fantasia, razao_social, email, data_nascimento, cnpj, cpf, celular, telefone, cep, logradouro, bairro, numero, cidade, uf, complemento, senha) 
                VALUES (:nome_resp_legal, :nomeSocial, :nomeFantasia, :razaoSocial, :email, :dataNascimento, :cnpj, :cpf, :celular, :telefone, :cep, :logradouro, :bairro, :numero, :cidade, :uf, :complemento, :senha)";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':nome_resp_legal' => $nome_resp_legal,
            ':nomeSocial' => $nomeSocial,
            ':nomeFantasia' => $nomeFantasia,
            ':razaoSocial' => $razaoSocial,
            ':email' => $email,
            ':dataNascimento' => $dataNascimento,
            ':cnpj' => $cnpj,
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
            ':senha' => $senhaCriptografada
        ]);
    } else {
        die('Tipo de usuário inválido.');
    }

    // Define a mensagem de sucesso na sessão
    $_SESSION['success_message'] = 'Cadastro realizado com sucesso!';

    // Redireciona para a página de login
    header('Location: ../frontend/auth/login.php');
    exit();
}
?>
