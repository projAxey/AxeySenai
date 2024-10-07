document.addEventListener('DOMContentLoaded', function () {
    var confirmaUserModal = new bootstrap.Modal(document.getElementById('confirmaUser'), {
        backdrop: 'static',
        keyboard: false
    });
    var confirmaPessoaModal = new bootstrap.Modal(document.getElementById('confirmaPessoa'), {
        backdrop: 'static',
        keyboard: false
    });

    confirmaUserModal.show();

    // Adiciona eventos de clique aos botões para alternar os campos
    document.querySelectorAll(".btn-selectable").forEach(function (el) {
        el.addEventListener('click', function () {
            if (this.id === 'btnCompra') {
                document.getElementById('tipoUsuario').value = 'cliente'; // define como cliente
                confirmaUserModal.hide();
                toggleFields('compra');
            } else if (this.id === 'btnVende') {
                document.getElementById('tipoUsuario').value = 'prestador'; // define como prestador
                confirmaUserModal.hide();
                confirmaPessoaModal.show();
                toggleFields('venda');
            } else if (this.id === 'btnJuridica') {
                document.getElementById('tipoPrestador').value = 'PJ'; // define como PJ
                confirmaPessoaModal.hide();
                toggleFields('juridica');
            } else if (this.id === 'btnFisica') {
                document.getElementById('tipoPrestador').value = 'PF'; // define como PF
                confirmaPessoaModal.hide();
                toggleFields('fisica');
            }
        });
    });

    // Função para mostrar ou ocultar campos do formulário com base no tipo de pessoa selecionado
    function toggleFields(type, type2) {
        document.getElementById('categoriaFields').classList.toggle('d-none', type === 'compra');
        document.getElementById('descricaoFields').classList.toggle('d-none', type === 'compra');
        document.getElementById('juridicaFields').classList.toggle('d-none', type !== 'juridica');
        document.getElementById('cnpjFields').classList.toggle('d-none', type !== 'juridica');
        document.getElementById('cpfFields').classList.toggle('d-none', type === 'juridica');
        document.getElementById('respLegal').classList.toggle('d-none', type === 'compra');


        // Ajusta a visibilidade dos campos Nome Social e Data de Nascimento
        if (type === 'juridica') {
            document.getElementById('nomeFields').classList.add('d-none');
            document.getElementById('nomeSocialFields').classList.add('d-none');
            document.getElementById('dataNascimentoFields').classList.add('d-none');
            document.getElementById('usarNomeSocialField').classList.add('d-none');

        } else {
            document.getElementById('nomeSocialFields').classList.toggle('d-none', !document.getElementById('usarNomeSocial').checked);
            document.getElementById('dataNascimento').classList.remove('d-none');
            document.getElementById('usarNomeSocialField').classList.remove('d-none');
        }
        if (type === 'fisica') {
            document.getElementById('respLegal').classList.add('d-none');
        }
    }

    // Mostra ou oculta o campo Nome Social com base na seleção
    document.getElementById('usarNomeSocial').addEventListener('change', function () {
        if (!document.getElementById('juridicaFields').classList.contains('d-none')) {
            document.getElementById('nomeSocialFields').classList.add('d-none');
        } else {
            document.getElementById('nomeSocialFields').classList.toggle('d-none', !this.checked);
        }
    });

    //senhas
    const senhaInput = document.getElementById('senha');
    const senhaRepetidaInput = document.getElementById('senha_repetida');
    const senhaIcon = document.getElementById('senha-icon');
    const senhaRepetidaIcon = document.getElementById('senha-repetida-icon');
    const senhaError = document.getElementById('senha-error');
    const senhaRepetidaError = document.getElementById('senha-repetida-error');

    // Função de validação da senha
    function validarSenha(senha) {

        const senhaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return senhaRegex.test(senha);
    }
    // Alterna a visibilidade da senha
    function togglePasswordVisibility(input, icon) {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye', isPassword);
        icon.classList.toggle('bi-eye-slash', !isPassword);
    }

    // Evento para alternar a visibilidade da senha
    document.getElementById('toggleSenha').addEventListener('click', function () {
        togglePasswordVisibility(senhaInput, senhaIcon);
    });

    // Evento para alternar a visibilidade da senha repetida
    document.getElementById('toggleSenhaRepetida').addEventListener('click', function () {
        togglePasswordVisibility(senhaRepetidaInput, senhaRepetidaIcon);
    });

    // Validação da senha ao digitar
    senhaInput.addEventListener('input', function () {
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
    senhaRepetidaInput.addEventListener('input', function () {
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

});