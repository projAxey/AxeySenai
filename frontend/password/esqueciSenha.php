<?php
include '../layouts/head.php';
?>

<div class="modal fade" id="esqueciSenhaModal" tabindex="-1" aria-labelledby="esqueciSenhaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form class="align-items-center text-center" id="formRecuperaSenha" action="../../backend/password/esqueciSenhaBackend.php" method="POST">
                    <div class="form-group">
                        <label for="emailRecuperaSenha" class="mb-3">Informe o E-mail cadastrado</label>
                        <input type="email" class="form-control mb-3 my-2" name="emailRecuperaSenha" id="emailRecuperaSenha" placeholder="Email" required>
                    </div>

                    <!-- Campo oculto para enviar o tipo de usuário -->
                    <input type="hidden" name="user_type" id="user_type">

                    <!-- Centralizar o botão -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-3" name="btnRecuperar" style="background-color: #1A3C53; border: none" onclick="esqueciSenha(event)">Recuperar Senha</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('esqueciSenhaModal').addEventListener('show.bs.modal', function() {
        var activeTab = document.querySelector('#loginTabs .nav-link.active').id;
        var userType = activeTab.replace('-tab', '');
        document.getElementById('user_type').value = userType;
    });



    function esqueciSenha(event) {
        var emailRecuperaSenha = document.getElementById("emailRecuperaSenha");
        if (emailRecuperaSenha.value === "") {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Campo obrigatório',
                text: 'Por favor, informe o seu e-mail!',
                confirmButtonText: 'OK'
            });
        }
    }

    function getParameterByName(name) {
        let url = new URL(window.location.href);
        return url.searchParams.get(name);
    }

    // Verifica se há o parâmetro 'erro' na URL
    var erro = getParameterByName('aviso');

    // Exibe o SweetAlert com base no valor do parâmetro 'erro'
    if (erro === '2') {
        Swal.fire({
            icon: 'error',
            title: 'E-mail não encontrado',
            text: 'O e-mail informado não está cadastrado no sistema.',
            confirmButtonText: 'OK'
        });
    } else if (erro === '1') {
        Swal.fire({
            icon: 'warning',
            title: 'Campo obrigatório',
            text: 'Por favor, informe o seu e-mail.',
            confirmButtonText: 'OK'
        });
    } else if (erro === '3') {
        Swal.fire({
            icon: 'success',
            title: 'E-mail enviado com sucesso',
            text: 'Por favor, acesse seu e-mail para redefinir sua senha.',
            confirmButtonText: 'OK'
        });
    }
</script>