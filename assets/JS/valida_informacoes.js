document.addEventListener('DOMContentLoaded', function () {
    // Exibir o modal de confirmação de usuário
    var confirmaUserModal = new bootstrap.Modal(document.getElementById('confirmaUser'));
    confirmaUserModal.show();

    // Manipular o clique no botão "selecionado"
    var selecionados = document.querySelectorAll('.selecionado');
    selecionados.forEach(function (botao) {
        botao.addEventListener('click', function () {
            confirmaUserModal.hide();
            var confirmaPessoaModal = new bootstrap.Modal(document.getElementById('confirmaPessoa'));
            confirmaPessoaModal.show();

            if (this.id === 'btnVende') {
                document.getElementById('seguimentoFields').style.display = 'block';
                document.getElementById('descricaoFields').style.display = 'block';
            }
        });
    });

    // Manipular o clique no botão "selecionado2"
    var selecionados2 = document.querySelectorAll('.selecionado2');
    selecionados2.forEach(function (botao) {
        botao.addEventListener('click', function () {
            var confirmaPessoaModal = new bootstrap.Modal(document.getElementById('confirmaPessoa'));
            confirmaPessoaModal.hide();

            if (this.id === 'btnJuridica') {
                document.getElementById('juridicaFields').style.display = 'block';
                document.getElementById('cnpjFields').style.display = 'block';
            } else if (this.id === 'btnFisica') {
                document.getElementById('fisicaFields').style.display = 'block';
                document.getElementById('cpfFields').style.display = 'block';
            }
        });
    });

    // Máscaras para campos de entrada
    var masks = {
        cnpj: '00.000.000/0000-00',
        cpf: '000.000.000-00',
        celular: '(00) 00000-0000',
        telefone: '(00) 0000-0000',
        cep: '00000-000'
    };

    function applyMask(selector, mask) {
        document.querySelector(selector).addEventListener('input', function () {
            var value = this.value.replace(/\D/g, '');
            var maskedValue = '';
            var maskIndex = 0;

            for (var i = 0; i < value.length; i++) {
                if (mask[maskIndex] === '0') {
                    maskedValue += value[i];
                } else {
                    maskedValue += mask[maskIndex];
                    maskIndex++;
                    i--;
                }
                maskIndex++;
            }

            this.value = maskedValue;
        });
    }

    for (var key in masks) {
        applyMask('#' + key, masks[key]);
    }

    // Buscar CEP
    function buscarCep() {
        var cep = document.getElementById('cep').value.replace(/\D/g, ''); // Remove caracteres não numéricos
        if (cep.length !== 8) {
            alert('CEP inválido. Por favor, digite um CEP válido.');
            return;
        }

        fetch('https://viacep.com.br/ws/' + cep + '/json/')
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('endereco').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                    document.getElementById('numero').focus(); // Mova o foco para o campo de número após preencher o endereço
                } else {
                    alert('CEP não encontrado. Por favor, verifique o CEP digitado.');
                }
            })
            .catch(() => {
                if (document.getElementById('cep').value.length === 8) {
                    alert('Erro ao buscar o CEP. Por favor, tente novamente.');
                }
            });
    }

    document.getElementById('cep').addEventListener('blur', buscarCep);
    document.getElementById('cep').addEventListener('keypress', function (event) {
        if (event.which === 13) { // Se a tecla Enter for pressionada
            buscarCep();
        }
    });
});
