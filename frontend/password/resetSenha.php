<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../config/conexao.php';
include '../layouts/head.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica se o token existe nas tabelas Clientes ou Prestadores
    $sqlCheck = "
        SELECT 'Clientes' as tabela, cliente_id as id FROM Clientes WHERE token_temp = :token
        UNION 
        SELECT 'Prestadores' as tabela, prestador_id as id FROM Prestadores WHERE token_temp = :token
        UNION 
        SELECT 'UsuariosAdm' as tabela, UsuarioAdm_id as id FROM UsuariosAdm WHERE token_temp = :token";
    $stmtCheck = $conexao->prepare($sqlCheck);
    $stmtCheck->execute([':token' => $token]);
    $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo "Token inválido ou expirado.";
        exit();
    }
} else {
    echo "Token não fornecido.";
    exit();
}

?>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card col-md-4 align-items-center" style="border-radius: 8px">
        <h2 class="mt-3">Redefinir Senha</h2>
        <!-- Reset Senha Form -->
        <form style="width: 80%;" method="POST" action="../../backend/password/alterarSenhaBackend.php" id="resetPasswordForm">
            <input type="hidden" name="tabela" value="<?= $result['tabela'] ?>">
            <input type="hidden" name="id" value="<?= $result['id'] ?>">
            <div class="form-group mb-3">
                <div class="col-md-12 mt-3">
                    <label for="senha" class="form-label">Digite sua nova Senha *</label>
                    <div class="input-group">
                        <input type="password" name="novaSenha" class="form-control" id="novaSenha" required>
                        <button class="btn btn-outline" style="background-color: #dedede" type="button" id="toggleSenha">
                            <i class="bi bi-eye-slash" id="senha-icon"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback" id="senha-error" style="display: none;">
                        A senha deve ter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma letra minúscula, um número e um caractere especial.
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="senha_repetida" class="form-label">Repita sua nova Senha *</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="senha_repetida" name="senha_repetida" required>
                        <button class="btn btn-outline" style="background-color: #dedede" type="button" id="toggleSenhaRepetida">
                            <i class="bi bi-eye-slash" id="senha-repetida-icon"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback" id="senha-repetida-error" style="display: none;">
                        As senhas não coincidem.
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 my-2" style="color: white; border: none; background-color: #1A3C53; border-radius: 8px" name="btnResetSenha">Redefinir Senha</button>
        </form>
    </div>

    <script>
        document.getElementById('toggleSenha').addEventListener('click', function() {
            const senhaInput = document.getElementById('novaSenha');
            const icon = document.getElementById('senha-icon');
            const isPassword = senhaInput.type === 'password';
            senhaInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('bi-eye', isPassword);
            icon.classList.toggle('bi-eye-slash', !isPassword);
        });

        document.getElementById('toggleSenhaRepetida').addEventListener('click', function() {
            const senhaRepetidaInput = document.getElementById('senha_repetida');
            const icon = document.getElementById('senha-repetida-icon');
            const isPassword = senhaRepetidaInput.type === 'password';
            senhaRepetidaInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('bi-eye', isPassword);
            icon.classList.toggle('bi-eye-slash', !isPassword);
        });

        // Validação da senha
        const senhaInput = document.getElementById('novaSenha');
        const senhaRepetidaInput = document.getElementById('senha_repetida');
        const senhaError = document.getElementById('senha-error');
        const senhaRepetidaError = document.getElementById('senha-repetida-error');

        // Função de validação da senha
        function validarSenha(senha) {
            const senhaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            return senhaRegex.test(senha);
        }

        // Validação da senha ao digitar
        senhaInput.addEventListener('input', function() {
            const senha = this.value;
            const valido = validarSenha(senha);
            if (!valido) {
                senhaInput.classList.add('is-invalid');
                senhaError.style.display = 'block';
            } else {
                senhaInput.classList.remove('is-invalid');
                senhaError.style.display = 'none';
            }
            validarSenhas();
        });

        // Validação ao digitar a senha repetida
        senhaRepetidaInput.addEventListener('input', function() {
            validarSenhas();
        });

        // Função para validar se as senhas coincidem
        function validarSenhas() {
            const senha = senhaInput.value;
            const senhaRepetida = senhaRepetidaInput.value;
            if (senha && senhaRepetida && senha !== senhaRepetida) {
                senhaRepetidaInput.classList.add('is-invalid');
                senhaRepetidaError.style.display = 'block';
            } else {
                senhaRepetidaInput.classList.remove('is-invalid');
                senhaRepetidaError.style.display = 'none';
            }
        }

        // Verifica se o formulário pode ser enviado
        document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
            const senhaValida = validarSenha(senhaInput.value);
            const senhasCoincidem = senhaInput.value === senhaRepetidaInput.value;

            if (!senhaValida || !senhasCoincidem) {
                event.preventDefault(); // Impede o envio do formulário

                if (!senhaValida) {
                    senhaInput.classList.add('is-invalid');
                    senhaError.style.display = 'block';
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'A senha deve ter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma letra minúscula, um número e um caractere especial.'
                    });
                }
                if (!senhasCoincidem) {
                    senhaRepetidaInput.classList.add('is-invalid');
                    senhaRepetidaError.style.display = 'block';
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção!',
                        text: 'As senhas não coincidem.'
                    });
                }
            }
        });
    </script>
</body>

</html>