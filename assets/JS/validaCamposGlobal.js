// Inicializa e exiibe as modais de cadastro quando a págna é carregada
document.addEventListener('DOMContentLoaded', function () {
    // Validação do Nome Completo quando o campo perde o foco
    const nomeInput = document.getElementById('nome');
    if (nomeInput) {
        document.getElementById('nome').addEventListener('blur', function () {
            const nomeInput = this;
            const nomeValor = nomeInput.value.trim();

            // Expressão regular para validar o nome completo
            const nomeRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ]{2,}\s[A-Za-zÀ-ÖØ-öø-ÿ]{1,}/;

            if (!nomeRegex.test(nomeValor)) {

                nomeInput.classList.add('is-invalid');
                nomeInput.nextElementSibling.textContent = 'Por favor, insira um nome completo válido (ex: João Silva).';
            } else {
                nomeInput.classList.remove('is-invalid');
                nomeInput.nextElementSibling.textContent = '';
            }
        });
    }

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
        if (document.getElementById('descricao').classList.contains('d-none') === true) {
            document.getElementById('descricao').addEventListener('input', function () {
                const descricao = this.value;
                const errorElement = document.getElementById('descricao-error');
                const charCountElement = document.getElementById('charCount');

                // Atualiza a contagem de caracteres em tempo real
                charCountElement.textContent = `${descricao.length} caracteres`;

                if (descricao.length < 30) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                    errorElement.style.display = 'block';
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    errorElement.style.display = 'none';
                }
            });
        }
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
                document.getElementById('cpfFeedback').style.display = 'block';
            } else {
                this.classList.remove('is-invalid');
                document.getElementById('cpfFeedback').style.display = 'none';
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

    // Formata o número de telefone conforme o usuário digita
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

    // Formata o CEP e preenche os campos de endereço com base no CEP
    document.getElementById('cep').addEventListener('input', function () {
        console.log("teste aq")
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
});
