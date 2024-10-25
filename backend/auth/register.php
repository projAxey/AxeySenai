<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../../config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tipoUsuario = $_POST['tipoUsuario'];
    $nomeSocial = $_POST['nomeSocial'] ?? null;
    $email = $_POST['email'];
    $dataNascimento = $_POST['dataNascimento'] ?? null;
    $celular = $_POST['celular'] ?? null;
    $telefone = $_POST['telefone'] ?? null;
    $cep = $_POST['cep'] ?? null;
    $logradouro = $_POST['endereco'] ?? null;
    $bairro = $_POST['bairro'] ?? null;
    $numero = $_POST['numero'] ?? null;
    $cidade = $_POST['cidade'] ?? null;
    $uf = $_POST['uf'] ?? null;
    $complemento = $_POST['complemento'] ?? null;
    $senha = $_POST['senha'];
    $senhaRepetida = $_POST['senha_repetida'];

    if ($senha != $senhaRepetida) {
        die('As senhas não coincidem.');
    }

    $senhaCriptografada = password_hash($senha, PASSWORD_BCRYPT);

    // Verifica se o e-mail já existe em ambas as tabelas
    $sqlCheck = "SELECT COUNT(*) FROM Clientes WHERE email = :email UNION SELECT COUNT(*) FROM Prestadores WHERE email = :email UNION SELECT COUNT(*) FROM UsuariosAdm WHERE email = :email";
    $stmtCheck = $conexao->prepare($sqlCheck);
    $stmtCheck->execute([':email' => $email]);

    // Verifica o número de registros encontrados
    $results = $stmtCheck->fetchAll(PDO::FETCH_COLUMN);

    // Corrigido: Verifica se o array tem pelo menos 2 elementos
    if (count($results) >= 2 && ($results[0] > 0 || $results[1] > 0)) {
        die('Este e-mail já está cadastrado em outra conta.');
    }

    if ($tipoUsuario === 'Cliente') {
        $cpf = $_POST['cpf'];
        $nome = $_POST['nome'];

        $sql = "INSERT INTO Clientes (tipo_usuario, nome, nome_social, email, data_nascimento, cpf, celular, telefone, cep, logradouro, bairro, numero, cidade, uf, complemento, senha) 
                VALUES (:tipoUsuario, :nome, :nomeSocial, :email, :dataNascimento, :cpf, :celular, :telefone, :cep, :logradouro, :bairro, :numero, :cidade, :uf, :complemento, :senha)";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':tipoUsuario' => $tipoUsuario,
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
    } else if ($tipoUsuario === 'Prestador PF' || $tipoUsuario === 'Prestador PJ') {
        $nome_resp_legal = $_POST['nome'];
        $nomeFantasia = $_POST['nomeFantasia'] ?? null;
        $razaoSocial = $_POST['razaoSocial'] ?? null;
        $cnpj = $_POST['cnpj'] ?? null;
        $cpf = $_POST['cpf'] ?? null;
        $categoria = $_POST['categoria'] ?? null;
        $descricao = $_POST['descricao'] ?? null;

        $sql = "INSERT INTO Prestadores (tipo_usuario, nome_resp_legal, nome_social, nome_fantasia, razao_social, email, data_nascimento, cnpj, cpf, categoria, descricao, celular, telefone, cep, logradouro, bairro, numero, cidade, uf, complemento, senha) 
                VALUES (:tipoUsuario, :nome_resp_legal, :nomeSocial, :nomeFantasia, :razaoSocial, :email, :dataNascimento, :cnpj, :cpf, :categoria, :descricao, :celular, :telefone, :cep, :logradouro, :bairro, :numero, :cidade, :uf, :complemento, :senha)";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':tipoUsuario' => $tipoUsuario,
            ':nome_resp_legal' => $nome_resp_legal,
            ':nomeSocial' => $nomeSocial,
            ':nomeFantasia' => $nomeFantasia,
            ':razaoSocial' => $razaoSocial,
            ':email' => $email,
            ':dataNascimento' => $dataNascimento,
            ':cnpj' => $cnpj,
            ':cpf' => $cpf,
            ':categoria' => $categoria,
            ':descricao' => $descricao,
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
    } else if ($tipoUsuario === 'Administrador') {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $cargo = $_POST['cargo'];

        // Corrigido: Removida vírgula extra
        $sql = "INSERT INTO UsuariosAdm (tipo_usuario, nome, email, data_nascimento, cpf, cargo, celular, telefone, cep, logradouro, bairro, numero, cidade, uf, complemento, senha) 
                VALUES (:tipoUsuario, :nome, :email, :dataNascimento, :cpf, :cargo, :celular, :telefone, :cep, :logradouro, :bairro, :numero, :cidade, :uf, :complemento, :senha)";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':tipoUsuario' => $tipoUsuario,
            ':nome' => $nome,
            ':email' => $email,
            ':dataNascimento' => $dataNascimento,
            ':cpf' => $cpf,
            ':cargo' => $cargo,
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
    if ($tipoUsuario === 'Administrador') {
        header('Location: ../../frontend/adm/controleUsuarios.php');
        exit();
    } else {
        header('Location: ../../frontend/auth/login.php');
        exit();
    }

}
