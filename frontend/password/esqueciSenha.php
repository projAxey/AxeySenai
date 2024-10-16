<div class="modal fade" id="esqueciSenhaModal" tabindex="-1" aria-labelledby="esqueciSenhaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> 
        <div class="modal-content">
            <div class="modal-body">
                <form id="formRecuperaSenha" action="../../backend/password/esqueciSenhaBackend.php" method="POST">
                    <div class="form-group">
                        <label for="emailRecuperaSenha" class="mb-3">Informe o E-mail cadastrado</label>
                        <input type="email" class="form-control mb-3" name="emailRecuperaSenha" id="emailRecuperaSenha">
                    </div>
                        <button type="submit" class="btn btn-primary mt-3" name ="btnRecuperar" style="background-color: #1A3C53; border: none" onclick="esqueciSenha(event)">Recuperar Senha</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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
    var erro = getParameterByName('erro');

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
    }
</script>
