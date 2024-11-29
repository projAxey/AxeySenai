<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../layouts/head.php';
?>

<div class="container-fluid contLogin d-flex justify-content-center align-items-center min-vh-100">
    <div class="card col-md-6 col-lg-4 cardLogin mx-auto p-4">
        <img src="../../assets/imgs/logoAxey.png" class="card-img-top mx-auto d-block" alt="Imagem de Login" style="width: 18rem;">

        <?php
        if (isset($_GET['aviso'])) {
            if ($_GET['aviso'] == '1') {
                $mensagem = 'Email não enviado';
                $icon = 'error';
            } else if ($_GET['aviso'] == '2') {
                $mensagem = 'Falha ao enviar email para alteração de senha';
                $icon = 'error';
            } else if ($_GET['aviso'] == '3') {
                $mensagem = 'Email enviado para alteração de senha';
                $icon = 'success';
            } else if ($_GET['aviso'] == '4') {
                $mensagem = 'Senha alterada com sucesso';
                $icon = 'success';
            } else if ($_GET['aviso'] == '5') {
                $mensagem = 'Erro ao alterar senha';
                $icon = 'error';
            }
            echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: '$icon',
                        // title: 'Erro',
                        text: '$mensagem',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Fechar'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = 'login.php'; // Redireciona após fechar o alerta
                        }
                    });
                });
            </script>";
        }

        ?>

        <?php
        if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <?= $_SESSION['login_error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            unset($_SESSION['login_error']);
        endif;
        ?>

        <!-- Abas para selecionar tipo de login -->
        <ul class="nav nav-tabs w-90 my-3" id="loginTabs" role="tablist">
            <li class="nav-item navLogin flex-fill" role="presentation">
                <a class="nav-link navLinkLogin active text-center" id="cliente-tab" data-bs-toggle="tab" href="#cliente" role="tab" aria-controls="cliente" aria-selected="true">Cliente</a>
            </li>
            <li class="nav-item navLogin flex-fill " role="presentation">
                <a class="nav-link navLinkLogin text-center" id="prestador-tab" data-bs-toggle="tab" href="#prestador" role="tab" aria-controls="prestador" aria-selected="false">Prestador</a>
            </li>
            <li class="nav-item navLogin flex-fill" role="presentation">
                <a class="nav-link navLinkLogin text-center" id="admin-tab" data-bs-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="false">Admin</a>
            </li>
        </ul>


        <!-- Conteúdo das abas -->
        <div class="tab-content mt-3" id="loginTabsContent">
            <?php $loginTypes = ['cliente', 'prestador', 'admin'];
            foreach ($loginTypes as $type): ?>
                <div class="tab-pane fade <?= $type === 'cliente' ? 'show active' : ''; ?>" id="<?= $type ?>" role="tabpanel" aria-labelledby="<?= $type ?>-tab">
                    <form method="POST" action="../../backend/auth/login.php">
                        <input type="hidden" name="user_type" value="<?= $type ?>"> <!-- Campo oculto indicando o tipo de usuário -->
                        <div class="mb-3">
                            <input type="text" name="email" class="form-control" placeholder="Usuário" required>
                        </div>
                        <div class="input-group mb-3 position-relative">
                            <input type="password" id="password-<?= $type ?>" name="password" class="form-control" placeholder="Senha" required>
                            <button type="button" class="btn position-absolute end-0 me-2" id="toggleSenha-<?= $type ?>" style="background: none; border: none;">
                                <i class="bi bi-eye-slash" id="iconSenha-<?= $type ?>"></i>
                            </button>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style=" background-color: #1A3C53; border: none">Entrar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>


        <!-- Links adicionais -->
        <a href="#" class="btn-sm text-primary text-decoration-none d-block text-center mt-3" data-bs-toggle="modal" data-bs-target="#esqueciSenhaModal">Esqueci minha senha</a>

        <?php include '../password/esqueciSenha.php'; ?>

        <div class="card cardCadastre mt-4 text-center py-2">
            <span class="card-text">Não tem uma conta?
                <a href="register.php" class="text-primary font-weight-bold text-decoration-none">Cadastre-se</a>
            </span>
        </div>
        <div class="card mt-3 text-center py-2" style="background-color: #f1f1f1;">
            <span class="card-text">
                <a href="/projAxeySenai/index.php" class="text-primary text-decoration-none">Voltar para o início</a>
            </span>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Função para esconder alertas após 2 segundos
        var alerts = document.querySelectorAll('.alert');
        if (alerts) {
            setTimeout(function() {
                alerts.forEach(function(element) {
                    element.style.display = 'none';
                });
            }, 2000);
        }


        // Configurar o toggling de senha para cada aba
        var toggleButtons = document.querySelectorAll('[id^="toggleSenha-"]'); // Seleciona todos os botões de toggle pelo prefixo de ID

        toggleButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var type = button.id.split('-')[1]; // Extrai o tipo (cliente, prestador, admin) do ID do botão
                var passwordInput = document.getElementById('password-' + type); // Seleciona o campo de senha correspondente
                var icon = document.getElementById('iconSenha-' + type); // Seleciona o ícone correspondente

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text'; // Altera o tipo para texto
                    icon.classList.remove('bi-eye-slash'); // Altera o ícone
                    icon.classList.add('bi-eye');
                } else {
                    passwordInput.type = 'password'; // Altera o tipo de volta para senha
                    icon.classList.remove('bi-eye'); // Altera o ícone
                    icon.classList.add('bi-eye-slash');
                }
            });
        });
    });
</script>


</body>

</html>