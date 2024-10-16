<?php
session_start();
include '../layouts/head.php';
?>

<body>
    <div class="container-fluid contLogin mt-5">
        <div class="card col-md-4 cardLogin" style="border-radius: 8px">
            <img src="../../assets/imgs/logoAxey.png" class="card-img-top" alt="Imagem de Login">

            <!-- PHP for handling messages -->
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?= $_SESSION['login_error'];
                    unset($_SESSION['login_error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success mt-3" role="alert" style="width: 100%; text-align: center;">
                    <?= $_SESSION['success_message'];
                    unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form style="width: 80%;" method="POST" action="../../backend/auth/login.php">
                <input type="text" name="email" class="form-control my-2" style="border-radius: 8px" placeholder="Usuário" required>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control my-2" style="border-radius: 8px" placeholder="Senha" required>

                    <button type="button" class="btn" id="toggleSenha" style="color: #1A3C53;">
                        <i class="bi bi-eye-slash" id="iconSenha"></i>
                    </button>
                </div>

                <button type="submit" class="btn btn-primary w-100 my-2" style="color: white; border: none; background-color: #1A3C53; border-radius: 8px">Entrar</button>
            </form>
            <a href="#" class="btnEsqueciSenha btn-sm" data-bs-toggle="modal" data-bs-target="#esqueciSenhaModal" style="color: #00376B;">Esqueci minha senha</a>
           
            <?php include '../password/EsqueciSenha.php'; ?>
            
            <div class="card cardCadastre col-sm-10" style="border-radius: 8px">
                <span class="card-text">Não tem uma conta?
                    <a href="register.php">Cadastre-se</a>
                </span>
            </div>

            <script>
                document.getElementById('toggleSenha').addEventListener('click', function() {
                    const senhaAtualInput = document.getElementById('password'); // Obtém o campo de senha pelo ID
                    const icon = document.getElementById('iconSenha'); // Obtém o ícone do olho
                    if (senhaAtualInput.type === 'password') {
                        senhaAtualInput.type = 'text'; // Altera o tipo para texto
                        icon.classList.remove('bi-eye-slash'); // Altera o ícone
                        icon.classList.add('bi-eye');
                    } else {
                        senhaAtualInput.type = 'password'; // Altera o tipo de volta para senha
                        icon.classList.remove('bi-eye'); // Altera o ícone
                        icon.classList.add('bi-eye-slash');
                    }
                });
            </script>
</body>

</html>