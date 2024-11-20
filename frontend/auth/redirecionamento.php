<?php
// Verifica se o usuário tem uma sessão ativa
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Redireciona para a página inicial se a sessão estiver ativa
    header("Location: ../../index.php");
    exit();
}

include '../layouts/head.php';
?>

<body class="d-flex justify-content-center vh-100 bg-light">
    <div class="container-fluid mt-3">
        <div class="card col-md-4 mx-auto cardLogin" style="border-radius: 8px;">
            <img src="../../assets/imgs/logoAxey.png" class="card-img-top" alt="Imagem de Login">
            <div class="card-body text-center">
                <h1 class="text-danger fs-3 mb-3">Sessão Inativa</h1>
                <p class="fs-5 mb-4">Sua sessão não está ativa. Para acessar o sistema, faça login novamente.</p>
                <a href="../../frontend/auth/login.php" class="btn btn-primary">Clique aqui para fazer login</a>
            </div>
        </div>
    </div>
</body>

</html>