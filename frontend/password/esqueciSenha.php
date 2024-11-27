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

                    <input type="hidden" name="user_type" id="user_type">

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-3" name="btnRecuperar" id="btnRecuperar" style="background-color: #1A3C53; border: none">
                            Recuperar Senha
                        </button>

                        <div id="spinner" class="d-none text-center mt-3">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("btnRecuperar").addEventListener("click", function(event) {
        var emailRecuperaSenha = document.getElementById("emailRecuperaSenha");

        if (emailRecuperaSenha.value === "") {
            event.preventDefault(); 
            alert("Por favor, informe o seu e-mail!"); 
        } else {
            var btnRecuperar = document.getElementById("btnRecuperar");
            var spinner = document.getElementById("spinner");

            btnRecuperar.classList.add("d-none"); 
            spinner.classList.remove("d-none"); 
        }
    });

    document.getElementById('esqueciSenhaModal').addEventListener('show.bs.modal', function() {
        var activeTab = document.querySelector('#loginTabs .nav-link.active').id;
        var userType = activeTab.replace('-tab', '');
        document.getElementById('user_type').value = userType;
    });

    function getParameterByName(name) {
        let url = new URL(window.location.href);
        return url.searchParams.get(name);
    }

    var erro = getParameterByName('aviso');

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