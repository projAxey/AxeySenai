<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../../config/conexao.php'; // Conexão com o banco de dados


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../../config/conexao.php'; // Conexão com o banco de dados

// Captura o que foi enviado pelo formulário
$email = $_POST['email'];
$password = $_POST['password'];
$userType = $_POST['user_type'];

// Função para realizar login com validação de senha e status
function realizarLogin($usuario, $tipo, $campoSenha, $campoStatus)
{
    global $password;
    if (password_verify($password, $usuario[$campoSenha])) {
        if ($usuario[$campoStatus] == '2') {
            $_SESSION['login_error'] = ucfirst($tipo) . ' bloqueado';
        } else if ($usuario[$campoStatus] == '4') {
            $_SESSION['login_error'] = ucfirst($tipo) . ' inativado';
        } else {
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['id'] = $usuario[$tipo . '_id'];
            $_SESSION['user_image'] = $usuario['url_foto'];
            $_SESSION['nome_social'] = $usuario['nome_social'];
            $_SESSION['nome_fantasia'] = $usuario['nome_fantasia'];
            header("Location: ../../index.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Email ou senha incorretos para " . ucfirst($tipo);
    }
    header("Location: ../../frontend/auth/login.php");
    exit();
}

// Verifica o tipo de login e consulta a tabela correspondente
switch ($userType) {
    case 'cliente':
        $sql = "SELECT * FROM Clientes WHERE email = :email";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cliente) realizarLogin($cliente, 'cliente', 'senha', 'status');
        break;

    case 'admin':
        $sql = "SELECT * FROM UsuariosAdm WHERE email = :email";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin) realizarLogin($admin, 'admin', 'senha', 'status');
        break;

    case 'prestador':
        $sql = "SELECT * FROM Prestadores WHERE email = :email";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $prestador = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($prestador) {
            // Checa se o status é de pendente para Prestadores
            if ($prestador['status'] == '3') {
                $_SESSION['login_error'] = 'Seu usuário ainda não foi aprovado!';
                header("Location: ../../frontend/auth/login.php");
                exit();
            }
            realizarLogin($prestador, 'prestador', 'senha', 'status');
        }
        break;
}

// Se não encontrou o usuário em nenhuma tabela
$_SESSION['login_error'] = 'Email ou senha incorretos';
header("Location: ../../frontend/auth/login.php");
exit();
