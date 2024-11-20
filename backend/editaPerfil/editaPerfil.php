<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

require_once '../../config/conexao.php'; // Conexão com o banco de dados

$id = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo_usuario'];

// Captura os dados dos usuários 
$dados = [
    'nome' => $_POST['nome'] ?? null,
    'nome_resp_legal' => $_POST['nome_resp_legal'] ?? null,
    'nomeSocial' => $_POST['nomeSocial'] ?? null,
    'nomeFantasia' => $_POST['nomeFantasia'] ?? null,
    'razaoSocial' => $_POST['razaoSocial'] ?? null,
    'email' => $_POST['email'] ?? null,
    'dataNascimento' => $_POST['dataNascimento'] ?? null,
    'cnpj' => $_POST['cnpj'] ?? null,
    'cpf' => $_POST['cpf'] ?? null,
    'categoria' => $_POST['categoria'] ?? null,
    'descricao' => $_POST['descricao'] ?? null,
    'celular' => $_POST['celular'] ?? null,
    'telefone' => $_POST['telefone'] ?? null,
    'cep' => $_POST['cep'] ?? null,
    'logradouro' => $_POST['endereco'] ?? null,
    'bairro' => $_POST['bairro'] ?? null,
    'numero' => $_POST['numero'] ?? null,
    'cidade' => $_POST['cidade'] ?? null,
    'uf' => $_POST['uf'] ?? null,
    'complemento' => $_POST['complemento'] ?? null,
    'tipo_usuario' => $_SESSION['tipo_usuario'] ?? null,
];

function atualizarDados($conexao, $tipoUsuario, $dados, $id)
{
    if ($tipoUsuario == 'Cliente') {
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
                complemento = :complemento 
                WHERE cliente_id = :cliente_id";

        $params = [
            ':nome' => $dados['nome'],
            ':nomeSocial' => $dados['nomeSocial'],
            ':email' => $dados['email'],
            ':dataNascimento' => $dados['dataNascimento'],
            ':cpf' => $dados['cpf'],
            ':celular' => $dados['celular'],
            ':telefone' => $dados['telefone'],
            ':cep' => $dados['cep'],
            ':logradouro' => $dados['logradouro'],
            ':bairro' => $dados['bairro'],
            ':numero' => $dados['numero'],
            ':cidade' => $dados['cidade'],
            ':uf' => $dados['uf'],
            ':complemento' => $dados['complemento'],
            ':cliente_id' => $id,
        ];
    } else if ($tipoUsuario == 'Prestador PF' || $tipoUsuario == 'Prestador PJ') {
        $sql = "UPDATE Prestadores SET
        nome_resp_legal = CASE 
            WHEN :tipo_usuario = 'Prestador PF' THEN :nome
            ELSE :nome_resp_legal
        END,
        nome_social = :nomeSocial, 
        nome_fantasia = :nomeFantasia, 
        razao_social = :razaoSocial, 
        email = :email, 
        data_nascimento = :dataNascimento, 
        cnpj = :cnpj, 
        cpf = :cpf, 
        categoria = :categoria, 
        descricao = :descricao, 
        celular = :celular, 
        telefone = :telefone, 
        cep = :cep, 
        logradouro = :logradouro, 
        bairro = :bairro, 
        numero = :numero, 
        cidade = :cidade, 
        uf = :uf,
        complemento = :complemento 
        WHERE prestador_id = :prestador_id";

        $params = [
            ':tipo_usuario' => $dados['tipo_usuario'], // Passar o tipo de usuario
            ':nome' => $dados['nome'], // Nome completo para PF
            ':nome_resp_legal' => $dados['nome_resp_legal'], // Nome resp legal para PJ
            ':nomeSocial' => $dados['nomeSocial'],
            ':nomeFantasia' => $dados['nomeFantasia'],
            ':razaoSocial' => $dados['razaoSocial'],
            ':email' => $dados['email'],
            ':dataNascimento' => $dados['dataNascimento'],
            ':cnpj' => $dados['cnpj'],
            ':cpf' => $dados['cpf'],
            ':categoria' => $dados['categoria'],
            ':descricao' => $dados['descricao'],
            ':celular' => $dados['celular'],
            ':telefone' => $dados['telefone'],
            ':cep' => $dados['cep'],
            ':logradouro' => $dados['logradouro'],
            ':bairro' => $dados['bairro'],
            ':numero' => $dados['numero'],
            ':cidade' => $dados['cidade'],
            ':uf' => $dados['uf'],
            ':complemento' => $dados['complemento'],
            ':prestador_id' => $id,
        ];
    }
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
            // Dados atualizados com sucesso
            header("Location: /projAxeySenai/frontend/auth/perfil.php?aviso=sucesso"); // Redirecionar após o sucesso
            exit();
        } else {
            // Nenhuma alteração foi feita
            header("Location: /projAxeySenai/frontend/auth/perfil.php?aviso=nada"); // Redirecionar após o sucesso
            exit();
        }
    } catch (Exception $e) {
        // Erro ao atualizar
        header("Location: /projAxeySenai/frontend/auth/perfil.php?aviso=erro"); // Redirecionar após o erro
        exit();
    }
}

// Chama a função para atualizar os dados
atualizarDados($conexao, $tipoUsuario, $dados, $id);
