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
                document.getElementById('tipoUsuario').value = 'Cliente'; // define como cliente
                confirmaUserModal.hide();
                toggleFields('compra');
            } else if (this.id === 'btnVende') {
                confirmaUserModal.hide();
                confirmaPessoaModal.show();
                toggleFields('venda');
            } else if (this.id === 'btnJuridica') {
                document.getElementById('tipoUsuario').value = 'Prestador PJ'; // define prestador como PJ
                confirmaPessoaModal.hide();
                toggleFields('juridica');
            } else if (this.id === 'btnFisica') {
                document.getElementById('tipoUsuario').value = 'Prestador PF'; // define prestador  como PF
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

    

});