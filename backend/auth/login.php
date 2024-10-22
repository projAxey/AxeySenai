<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../../config/conexao.php'; // Conexão com o banco de dados

// Captura o que foi enviado pelo formulário
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta para buscar o cliente pelo email
$sqlCliente = "SELECT * FROM Clientes WHERE email = :email";
$stmtCliente = $conexao->prepare($sqlCliente);
$stmtCliente->bindParam(':email', $email);
$stmtCliente->execute();
$cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

if ($cliente) {
    // Se encontrou o cliente, faz a autenticação como cliente
    if (password_verify($password, $cliente['senha'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = $cliente['email'];
        $_SESSION['tipo_usuario'] = $cliente['tipo_usuario'];
        $_SESSION['nome'] = $cliente['nome'];
        $_SESSION['id'] = $cliente['cliente_id'];
        $_SESSION['nome_social'] = $cliente['nome_social'];

        header("Location: ../../index.php");
        exit();
    } else {
        $_SESSION['login_error'] = 'Email ou senha incorretos para Cliente';
        header("Location: ../../frontend/auth/login.php");
        exit();
    }
}

// Só faz a consulta no prestador se não encontrou o cliente
$sqlPrestador = "SELECT * FROM Prestadores WHERE email = :email";
$stmtPrestador = $conexao->prepare($sqlPrestador);
$stmtPrestador->bindParam(':email', $email);
$stmtPrestador->execute();
$prestador = $stmtPrestador->fetch(PDO::FETCH_ASSOC);


if ($prestador) {
    if (password_verify($password, $prestador['senha'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['nome'] = $prestador['nome_resp_legal'];
        $_SESSION['email'] = $prestador['email'];
        $_SESSION['tipo_usuario'] = $prestador['tipo_usuario'];
        $_SESSION['id'] = $prestador['prestador_id'];
        $_SESSION['nome_social'] = $prestador['nome_social'];
        $_SESSION['nome_fantasia'] = $prestador['nome_fantasia'];
       
        header("Location: ../../index.php");
        exit();
    } else {
        $_SESSION['login_error'] = 'Email ou senha incorretos para Prestador';
        header("Location: ../../frontend/auth/login.php");
        exit();
    }
}

// Se não encontrou o usuário em nenhuma tabela
$_SESSION['login_error'] = 'Email ou senha incorretos';
header("Location: ../../frontend/auth/login.php");
exit();
