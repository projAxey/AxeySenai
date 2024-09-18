<?php
session_start();

// Supondo que as credenciais corretas estejam em um banco de dados, você faria a conexão e verificação aqui.
// Para este exemplo simples, vamos usar credenciais fixas.
$validUsername = 'admin';
$validPassword = '123456';

// Captura o que foi enviado pelo formulário
$username = $_POST['username'];
$password = $_POST['password'];

// Verifica se o nome de usuário e senha são válidos
if ($username === $validUsername && $password === $validPassword) {
    // Autenticação bem-sucedida
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;
    header("Location: ../index.php");
    exit();
} else {
    // Autenticação falhou, armazena mensagem de erro na sessão
    $_SESSION['login_error'] = 'Nome de usuário ou senha incorretos';
    
    // Redireciona de volta para a página de login
    header("Location: ../frontend/auth/login.php");
    exit();
}
?>