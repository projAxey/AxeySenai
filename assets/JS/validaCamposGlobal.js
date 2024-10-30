function avisoErro(nomeCampo) {
    Swal.fire({
        icon: 'error',
        title: 'Erro!',
        text: 'Por favor, verifique se o campo ' + nomeCampo + ' esta correto',
        position: 'center',
        showConfirmButton: false,

    });
}
// Validação final antes do envio do formulário
function validaCampos(event) {
    var tipoUsuario = document.getElementById('tipoUsuario') ? document.getElementById('tipoUsuario').value : "<?php echo $tipoUsuario; ?>";

    if (!validaFormulario()) {
        event.preventDefault(); // Impede o envio do formulário se houver campos inválidos
        return;
    }
    var nomeCompleto = document.getElementById('nome') ? document.getElementById('nome').value : '';
    var nome_resp_legal = document.getElementById('nome_resp_legal') ? document.getElementById('nome_resp_legal').value : null;
    var nomeSocial = document.getElementById('nomeSocial') ? document.getElementById('nomeSocial').value : null;
    var usarNomeSocial = document.getElementById('usarNomeSocial') ? document.getElementById('usarNomeSocial').checked : false;
    var nomeFantasia = document.getElementById('nomeFantasia') ? document.getElementById('nomeFantasia').value : null;
    var razaoSocial = document.getElementById('razaoSocial') ? document.getElementById('razaoSocial').value : null;
    var email = document.getElementById('email') ? document.getElementById('email').value : '';
    var dataNascimento = document.getElementById('dataNascimento') ? document.getElementById('dataNascimento').value : null;
    var categoria = document.getElementById('categoria') ? document.getElementById('categoria').value : null;
    var descricao = document.getElementById('descricao') ? document.getElementById('descricao').value : null;
    var celular = document.getElementById('celular') ? document.getElementById('celular').value.replace(/\D/g, '') : null;
    var celularValido = celular.length === 11;
    var cep = document.getElementById('cep') ? document.getElementById('cep').value.replace(/\D/g, '') : null;
    var numero = document.getElementById('numero') ? document.getElementById('numero').value : null;

    // Validação dos campos
    if (tipoUsuario == 'Cliente' || tipoUsuario == 'Prestador PF' || tipoUsuario == 'Administrador') {
        if (!nomeCompleto) {
            avisoErro('Nome Completo');
            event.preventDefault();
            return;
        }
    }

    if (tipoUsuario == 'Prestador PJ') {
        if (!nome_resp_legal) {
            avisoErro('Responsável Legal');
            event.preventDefault();
            return;
        }
    }

    // Verifica se o campo E-mail está preenchido
    if (!email) {
        avisoErro('E-mail');
        event.preventDefault();
        return;
    }

    // Verifica se o campo Nome Social está preenchido
    if (tipoUsuario == 'Cliente' || tipoUsuario == 'Prestador PF') {
        if (usarNomeSocial && !nomeSocial) {
            avisoErro('Nome Social');
            event.preventDefault();
            return;
        }
    }

    // Verifica se o campo Nome Fantasia está preenchido
    if (tipoUsuario == 'Prestador PJ') {
        if (document.getElementById('nomeFantasia') && !document.getElementById('nomeFantasia').classList.contains('d-none') && !nomeFantasia) {
            avisoErro('Nome Fantasia');
            event.preventDefault();
            return;
        }
    }

    // Verifica se o campo Razão Social está preenchido
    if (tipoUsuario == 'Prestador PJ') {
        if (document.getElementById('razaoSocial') && !document.getElementById('razaoSocial').classList.contains('d-none') && !razaoSocial) {
            avisoErro('Razão Social');
            event.preventDefault();
            return;
        }
    }

    // Verifica se o campo Data de Nascimento está preenchido
    if (tipoUsuario == 'Cliente' || tipoUsuario == 'Prestador PF' || tipoUsuario == 'Administrador') {
        if (document.getElementById('dataNascimento') && !document.getElementById('dataNascimento').classList.contains('d-none') && !dataNascimento) {
            avisoErro('Data de Nascimento');
            event.preventDefault();
            return;
        }
    }

    // Verifica se o campo CPF está preenchido
    if (tipoUsuario == 'Cliente' || tipoUsuario == 'Prestador PF' || tipoUsuario == 'Administrador') {
        if (document.getElementById('cpf')) {
            var cpf = document.getElementById('cpf').value.replace(/\D/g, '');
            if (!cpf) {
                avisoErro('CPF');
                event.preventDefault();
                return;
            }
        }
    }

    // Verifica se o campo Cargo está preenchido
    if (tipoUsuario == 'Administrador') {
        if (document.getElementById('cargo')) {
            var cargo = document.getElementById('cargo');
            if (!cargo) {
                avisoErro('Cargo');
                event.preventDefault();
                return;
            }
        }
    }

    // Verifica se o campo Categoria está preenchido
    if (tipoUsuario == 'Prestador PF' || tipoUsuario == 'Prestador PJ') {
        if (document.getElementById('categoria') && !document.getElementById('categoria').classList.contains('d-none') && !categoria) {
            avisoErro('Categoria');
            event.preventDefault();
            return;
        }
    }

    // Verifica se o campo Descrição está preenchido
    if (tipoUsuario == 'Prestador PF' || tipoUsuario == 'Prestador PJ') {
        if (document.getElementById('descricao') && !document.getElementById('descricao').classList.contains('d-none') && !descricao) {
            avisoErro('Descrição');
            event.preventDefault();
            return;
        }
    }

    // Verifica se o celular é válido
    if (!celularValido) {
        avisoErro('Celular');
        event.preventDefault();
        return;
    }

    // Verifica se o CEP está preenchido
    if (cep && !cep.value) {
        avisoErro('CEP');
        event.preventDefault();
        return;
    }

    // Verifica se o Número está preenchido
    if (numero && !numero.value) {
        avisoErro('Número');
        event.preventDefault();
        return;
    }

    return true;
}


function validaFormulario() {
    const camposInvalidos = [];

    // Validação para os campos de nome e responsável legal
    const campoNome = ['nome_resp_legal', 'nome'];
    campoNome.forEach(campoId => {
        const campoInput = document.getElementById(campoId);
        if (campoInput && campoInput.classList.contains('is-invalid')) {
            camposInvalidos.push(campoId);
        }
    });

    // Validação do e-mail
    const emailInput = document.getElementById('email');
    if (emailInput && emailInput.classList.contains('is-invalid')) {
        camposInvalidos.push('email');
    }

    // Validação da data de nascimento
    const dataNascimentoInput = document.getElementById('dataNascimento');
    if (dataNascimentoInput && dataNascimentoInput.classList.contains('is-invalid')) {
        camposInvalidos.push('dataNascimento');
    }

    // Validação da descrição
    const descricaoInput = document.getElementById('descricao');
    if (descricaoInput && descricaoInput.classList.contains('is-invalid')) {
        camposInvalidos.push('descricao');
    }

    // Validação do CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput && cpfInput.classList.contains('is-invalid')) {
        camposInvalidos.push('cpf');
    }

    // Validação do CNPJ
    const cnpjInput = document.getElementById('cnpj');
    if (cnpjInput && cnpjInput.classList.contains('is-invalid')) {
        camposInvalidos.push('cnpj');
    }

    // Se houver campos inválidos, exiba uma mensagem de erro e retorne falso
    if (camposInvalidos.length > 0) {
        avisoErro(camposInvalidos);  // Essa função deve exibir as mensagens de erro adequadas
        return false;
    }

    // Se todos os campos estiverem válidos, retorne verdadeiro
    return true;
}

// Função de validação reutilizável
function validarNomeCampo(campoId) {
    const campoInput = document.getElementById(campoId);
    if (campoInput) {
        campoInput.addEventListener('blur', function () {
            const valorCampo = this.value.trim();

            // Expressão regular para validar o nome completo ou nome de responsável legal
            const nomeRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ]{2,}\s[A-Za-zÀ-ÖØ-öø-ÿ]{1,}/;

            if (!nomeRegex.test(valorCampo)) {
                campoInput.classList.add('is-invalid');
                campoInput.nextElementSibling.textContent = 'Por favor, insira um nome completo válido (ex: João Silva).';

            } else {
                campoInput.classList.remove('is-invalid');
                campoInput.nextElementSibling.textContent = '';
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    validarNomeCampo('nome'); // Validação para o campo 'nome'
    validarNomeCampo('nome_resp_legal'); // Validação para o campo 'nome_resp_legal'



    // Valida o e-mail em tempo real
    function validarEmail(email) {
        // Expressão regular para validar o formato do e-mail
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Valida o e-mail em tempo real
    document.getElementById('email').addEventListener('input', function () {
        const emailInput = this;
        const emailValor = emailInput.value;
        const emailFeedback = document.querySelector('.emailFeedback');

        if (!validarEmail(emailValor)) {
            emailInput.classList.add('is-invalid');
            emailFeedback.textContent = 'Por favor, insira um e-mail válido.';
            emailFeedback.classList.add('text-danger'); // Adiciona uma classe para estilizar o feedback
        } else {
            emailInput.classList.remove('is-invalid');
            emailFeedback.textContent = '';
            emailFeedback.classList.remove('text-danger'); // Remove a classe se o e-mail estiver válido
        }
    });

    // Função para validar a Data de Nascimento
    function validarDataNascimento(dataNascimento) {
        const data = new Date(dataNascimento);
        const anoNascimento = data.getFullYear();
        return anoNascimento > 1924 && anoNascimento <= new Date().getFullYear();
    }

    // Validação da Data de Nascimento quando o campo é alterado
    const dataNascimentoInput = document.getElementById('dataNascimento');
    if (dataNascimentoInput) {
        document.getElementById('dataNascimento').addEventListener('input', function () {
            const dataNascimentoInput = this;
            const dataNascimento = dataNascimentoInput.value;

            if (dataNascimento) {
                const valido = validarDataNascimento(dataNascimento);
                if (!valido) {
                    dataNascimentoInput.classList.add('is-invalid');
                    dataNascimentoInput.nextElementSibling.textContent = 'Data de nascimento fora do padrão permitido.';
                } else {
                    dataNascimentoInput.classList.remove('is-invalid');
                    dataNascimentoInput.nextElementSibling.textContent = '';
                }
            }
        });
    }

    // Seleciona o campo de descrição e adiciona o evento de input
    const descricaoElement = document.getElementById('descricao');
    if (descricaoElement) {
        const errorElement = document.getElementById('descricao-error');
        const charCountElement = document.getElementById('charCount');
        let validacaoAtivada = false; // A validação só será ativada após o clique no campo

        // Função para atualizar a contagem de caracteres e validar
        function atualizarDescricao() {
            const descricao = descricaoElement.value;

            // Atualiza a contagem de caracteres em tempo real
            charCountElement.textContent = `${descricao.length} caracteres`;

            if (descricao.length < 30 || descricao.length > 200) {
                descricaoElement.classList.add('is-invalid');
                descricaoElement.classList.remove('is-valid');
                errorElement.style.display = 'block';
            } else {
                descricaoElement.classList.remove('is-invalid');
                descricaoElement.classList.add('is-valid');
                errorElement.style.display = 'none';
            }
        }

        // Ativa a validação somente após o clique no campo
        descricaoElement.addEventListener('focus', function () {
            if (!validacaoAtivada) {
                descricaoElement.addEventListener('input', atualizarDescricao);
                validacaoAtivada = true;
            }
        });
    }



    // Função para formatar o CPF
    function formatarCPF(cpf) {
        // Remove todos os caracteres que não sejam números
        cpf = cpf.replace(/\D/g, '');

        // Aplica a formatação do CPF
        if (cpf.length <= 11) {
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        return cpf;
    }

    // Função para validar o CPF
    function validarCPF(cpf) {
        if (cpf.length !== 11 || /^(.)\1{10}$/.test(cpf)) return false;
        var add = 0;
        for (var i = 0; i < 9; i++) add += parseInt(cpf.charAt(i)) * (10 - i);
        var rev = 11 - (add % 11);
        rev = (rev === 10 || rev === 11) ? 0 : rev;
        if (rev !== parseInt(cpf.charAt(9))) return false;
        add = 0;
        for (i = 0; i < 10; i++) add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        rev = (rev === 10 || rev === 11) ? 0 : rev;
        return rev === parseInt(cpf.charAt(10));
    }

    // Função para formatar o CNPJ  
    function formatarCNPJ(cnpj) {
        cnpj = cnpj.replace(/\D/g, '');
        if (cnpj.length > 14) {
            cnpj = cnpj.substring(0, 14);
        }
        // Aplica a formatação do CNPJ
        cnpj = cnpj.replace(/(\d{2})(\d)/, '$1.$2');
        cnpj = cnpj.replace(/(\d{3})(\d)/, '$1.$2');
        cnpj = cnpj.replace(/(\d{3})(\d{4})/, '$1/$2');
        cnpj = cnpj.replace(/(\d{4})(\d{2})$/, '$1-$2');
        return cnpj;
    }
    // Função para validar o CNPJ
    function validarCNPJ(cnpj) {
        if (cnpj.length !== 14 || /^(.)\1{13}$/.test(cnpj)) return false;
        var tamanho = cnpj.length - 2;
        var numeros = cnpj.substring(0, tamanho);
        var digitos = cnpj.substring(tamanho);
        var soma = 0,
            pos = tamanho - 7;
        for (var i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado !== parseInt(digitos.charAt(0))) return false;
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (var i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        return resultado === parseInt(digitos.charAt(1));
    }
    // Verifica se o campo CPF existe
    const cpfElement = document.getElementById('cpf');
    if (cpfElement) {
        cpfElement.addEventListener('input', function () {
            this.value = formatarCPF(this.value);
        });

        // Validação do CPF quando o campo perde o foco
        document.getElementById('cpf').addEventListener('blur', function () {
            var cpf = this.value.replace(/\D/g, '');
            if (!validarCPF(cpf)) {
                this.classList.add('is-invalid');
                document.getElementById('invalid-feedback').style.display = 'block';
            } else {
                this.classList.remove('is-invalid');
                document.getElementById('invalid-feedback').style.display = 'none';
            }
        });
    }

    // Verifica se o campo CNPJ existe
    const cnpjElement = document.getElementById('cnpj');
    if (cnpjElement) {
        cnpjElement.addEventListener('input', function () {
            this.value = formatarCNPJ(this.value);
        });

        // Validação do CNPJ quando o campo perde o foco
        document.getElementById('cnpj').addEventListener('blur', function () {
            var cnpj = this.value.replace(/\D/g, '');
            if (!validarCNPJ(cnpj)) {
                this.classList.add('is-invalid');
                document.getElementById('cnpjFeedback').style.display = 'block';
            } else {
                this.classList.remove('is-invalid');
                document.getElementById('cnpjFeedback').style.display = 'none';
            }
        });
    }






    // Formata o número de celular conforme o usuário digita
    const celularInput = document.getElementById('celular');
    if (celularInput) {
        document.getElementById('celular').addEventListener('input', function (e) {
            var celular = e.target.value.replace(/\D/g, '');
            var aviso = document.getElementById('aviso-celular');

            if (celular.length > 11) {
                celular = celular.slice(0, 11);
            }

            // Verifica o início do número
            if (celular.length > 2 && celular.charAt(2) !== '9') {
                aviso.textContent = 'O número de celular deve começar com 9 após o DDD.';
                aviso.style.display = 'block';
            } else {
                aviso.textContent = '';
                aviso.style.display = 'none';
            }

            // Aplica a formatação
            if (celular.length > 7) {
                celular = celular.replace(/(\d{0,2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            } else if (celular.length > 2) {
                celular = celular.replace(/(\d{0,2})(\d{0,5})/, '($1) $2');
            } else if (celular.length > 0) {
                celular = celular.replace(/(\d{0,2})/, '($1');
            }
            e.target.value = celular;
        });
    }


    // Formata o número de telefone conforme o usuário digita
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        document.getElementById('telefone').addEventListener('input', function (e) {
            var telefone = e.target.value.replace(/\D/g, '');
            var aviso = document.getElementById('aviso-telefone');

            if (telefone.length > 10) {
                telefone = telefone.slice(0, 10);
            }

            // Verifica o início do número
            if (telefone.length > 2 && telefone.charAt(2) !== '3') {
                aviso.textContent = 'O número de telefone deve começar com 3 após o DDD.';
                aviso.style.display = 'block';
            } else {
                aviso.textContent = '';
                aviso.style.display = 'none';
            }

            // Aplica a formatação
            if (telefone.length > 6) {
                telefone = telefone.replace(/(\d{0,2})(\d{0,4})(\d{0,4})/, '($1) $2-$3');
            } else if (telefone.length > 2) {
                telefone = telefone.replace(/(\d{0,2})/, '($1) ');
            }
            e.target.value = telefone;
        });
    }

    // Formata o CEP e preenche os campos de endereço com base no CEP
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        document.getElementById('cep').addEventListener('input', function () {
            var cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                this.value = cep.replace(/(\d{5})(\d{0,3})/, '$1-$2');
            }
            if (cep.length === 8) {
                fetch('https://viacep.com.br/ws/' + cep + '/json/')
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('endereco').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('uf').value = data.uf;
                            document.getElementById('numero').focus();
                        } else {
                            alert('CEP não encontrado. Por favor, verifique o CEP digitado.');
                        }
                    })
            }
        });
    }

    //senhas
    const senhaInput = document.getElementById('senha');
    const senhaRepetidaInput = document.getElementById('senha_repetida');
    const senhaIcon = document.getElementById('senha-icon');
    const senhaRepetidaIcon = document.getElementById('senha-repetida-icon');
    const senhaError = document.getElementById('senha-error');
    const senhaRepetidaError = document.getElementById('senha-repetida-error');
    // Executar o código somente se os campos de senha existirem
    if (senhaInput && senhaRepetidaInput && senhaIcon && senhaRepetidaIcon && senhaError && senhaRepetidaError) {

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

    }


});
