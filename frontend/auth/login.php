<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../layouts/head.php';
?>

<body>
    <div class="container-fluid contLogin mt-5">
        <div class="card col-md-4 cardLogin" style="border-radius: 8px; position: relative;">

            <div class="btn-voltar-index">
                <button type="button" class="btn btn-primary"
                    style="background-color: #012640; color:white; border-radius: 25%; position: absolute; right: 10px; top: 10px;"
                    onclick="window.location.href='../../index.php'">
                    <i class="bi bi-house-fill"></i>
                </button>
            </div>

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

                <div class="input-group" style="position: relative;">
                    <input type="password" id="password" name="password" class="form-control my-2" style="border-radius: 8px; width: 100%;" placeholder="Senha" required>
                    <button type="button" class="btn" id="toggleSenha" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; color: #1A3C53;">
                        <i class="bi bi-eye-slash" id="iconSenha"></i>
                    </button>
                </div>

                <button type="submit" class="btn btn-primary w-100 my-2" style="color: white; border: none; background-color: #1A3C53; border-radius: 8px">Entrar</button>
            </form>

            <a href="#" class="btnEsqueciSenha btn-sm" data-bs-toggle="modal" data-bs-target="#esqueciSenhaModal" style="color: #00376B;">Esqueci minha senha</a>

            <?php include '../password/esqueciSenha.php'; ?>

            <div class="card cardCadastre col-sm-10" style="border-radius: 8px">
                <span class="card-text">Não tem uma conta?
                    <a href="register.php">Cadastre-se</a>
                </span>
            </div>
            <div class="card col-sm-10 mt-3">
                <span class="card-text"><a href="register.php">Voltar para o início</a>
                </span>
            </div>
        </div>
    </div>

    <script>
        var alert = document.querySelectorAll('.alert');

        // Define o tempo para esconder os alertas (2000ms = 2 segundos)
        if (alert) {
            setTimeout(function() {
                alert.forEach(function(element) {
                    element.style.display = 'none';
                });
            }, 2000);
        }

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