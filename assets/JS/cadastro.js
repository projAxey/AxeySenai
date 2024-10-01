// Inicializa e exiibe as modais de cadastro quando a págna é carregada
// Validação final antes do envio do formulário
function validaForm(event) {
    event.preventDefault();
    var nomeCompleto = document.getElementById('nome').value;
    var nomeSocial = document.getElementById('nomeSocial').value;
    var usarNomeSocial = document.getElementById('usarNomeSocial').checked;
    var nomeFantasia = document.getElementById('nomeFantasia').value;
    var razaoSocial = document.getElementById('razaoSocial').value;
    var email = document.getElementById('email').value;
    var dataNascimento = document.getElementById('dataNascimento').value;
    var cnpj = document.getElementById('cnpj').value.replace(/\D/g, '');
    var cpf = document.getElementById('cpf').value.replace(/\D/g, '');
    var categoria = document.getElementById('categoria').value;
    var descricao = document.getElementById('descricao').value;
    var celular = document.getElementById('celular').value.replace(/\D/g, '');
    var celularValido = celular.length === 11;
    var cep = document.getElementById('cep').value.replace(/\D/g, '');
    var numero = document.getElementById('numero').value;
    var senha = document.getElementById('senha').value;
    var senhaRepetida = document.getElementById('senha_repetida').value;

    if (!nomeCompleto) {
        event.preventDefault();
        alert('Por favor, preencha o campo Nome Completo');

    } else if (!email) {
        event.preventDefault();
        alert('Por favor, preencha o campo E-mail');

    } else if (usarNomeSocial && !nomeSocial) {
        event.preventDefault();
        alert('Por favor, preencha o campo Nome Social');

    } else if (document.getElementById('nomeFantasia').classList.contains('d-none') === true && !nomeFantasia) {
        event.preventDefault();
        alert('Por favor, preencha o campo Nome Fantasia');

    } else if (document.getElementById('razaoSocial').classList.contains('d-none') === true && !razaoSocial) {
        event.preventDefault();
        alert('Por favor, preencha o campo Razão Social');

    } else if (!email) {
        event.preventDefault();
        alert('E-mail inválido. Certifique-se de que o e-mail esteja no formato correto.');

    } else if (document.getElementById('dataNascimento').classList.contains('d-none') === true && !dataNascimento) {
        event.preventDefault();
        alert('Por favor, preencha o campo Data de Nascimento');

    } else if (document.getElementById('cpf').classList.contains('d-none') === true && !validarCPF(cpf)) {
        event.preventDefault();
        alert('CPF inválido.');

    } else if (document.getElementById('cnpj').classList.contains('d-none') === true && !validarCNPJ(cnpj)) {
        event.preventDefault();
        alert('CNPJ inválido.');

    } else if (document.getElementById('categoria').classList.contains('d-none') === true && !categoria) {
        event.preventDefault();
        alert('Por favor, preencha o campo Categoria');

    } else if (document.getElementById('descricao').classList.contains('d-none') === true && !descricao) {
        event.preventDefault();
        alert('Por favor, preencha o campo Descricão');
    } else if (!celularValido) {
        event.preventDefault();
        alert('Celular inválido. Preencha o campo Celular corretamente');

    } else if (!cep) {
        event.preventDefault();
        alert('CEP inválido. Preencha o campo CEP corretamente');

    } else if (!numero) {
        event.preventDefault();
        alert('Por favor, preencha o campo Número');

    } else if (!senha) {
        event.preventDefault(); // Impede o envio do formulário
        alert('Por favor, preencha a senha');
    } else if (senha !== senhaRepetida) {
        event.preventDefault(); // Impede o envio do formulário
        alert('As senhas não coincidem. Por favor, verifique e tente novamente.');
    } else {
        document.getElementById('CadastroUsuarios').submit();
    }
}

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
    function toggleFields(type) {
        document.getElementById('categoriaFields').classList.toggle('d-none', type === 'compra');
        document.getElementById('descricaoFields').classList.toggle('d-none', type === 'compra');
        document.getElementById('juridicaFields').classList.toggle('d-none', type !== 'juridica');

        document.getElementById('cnpjFields').classList.toggle('d-none', type !== 'juridica');
        document.getElementById('cpfFields').classList.toggle('d-none', type === 'juridica');
        document.getElementById('nomeLabel').textContent = type === 'juridica' ? 'Responsável Legal*' : 'Nome Completo*';
        document.getElementById('nome').placeholder = type === 'juridica' ? 'Ex: João Antonio da Silva' : 'Ex: João Antonio da Silva';

        // Ajusta a visibilidade dos campos Nome Social e Data de Nascimento
        if (type === 'juridica') {
            document.getElementById('nomeSocialFields').classList.add('d-none');
            document.getElementById('dataNascimentoFields').classList.add('d-none');
            document.getElementById('usarNomeSocialField').classList.add('d-none');
        } else {
            document.getElementById('nomeSocialFields').classList.toggle('d-none', !document.getElementById('usarNomeSocial').checked);
            document.getElementById('dataNascimento').classList.remove('d-none');
            document.getElementById('usarNomeSocialField').classList.remove('d-none');
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