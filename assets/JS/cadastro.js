document.addEventListener('DOMContentLoaded', function () {
    var confirmaUserModalElement = document.getElementById('confirmaUser');
    var confirmaPessoaModalElement = document.getElementById('confirmaPessoa');

    var confirmaUserModal, confirmaPessoaModal;

    if (confirmaUserModalElement) {
        confirmaUserModal = new bootstrap.Modal(confirmaUserModalElement, {
            backdrop: 'static',
            keyboard: false
        });
    }

    if (confirmaPessoaModalElement) {
        confirmaPessoaModal = new bootstrap.Modal(confirmaPessoaModalElement, {
            backdrop: 'static',
            keyboard: false
        });
    }

    if (confirmaUserModalElement) {
        confirmaUserModal.show();
    } else if (confirmaPessoaModalElement) {
        confirmaPessoaModal.show();
    }

    // Adiciona eventos de clique aos botões para alternar os campos
    document.querySelectorAll(".btn-selectable").forEach(function (el) {
        el.addEventListener('click', function () {
            if (this.id === 'btnCompra') {
                document.getElementById('tipoUsuario').value = 'Cliente'; // define como cliente
                if (confirmaUserModal && confirmaUserModal._isShown) confirmaUserModal.hide();
                toggleFields('compra');
            } else if (this.id === 'btnVende') {
                if (confirmaUserModal && confirmaUserModal._isShown) confirmaUserModal.hide();
                confirmaPessoaModal.show();
                toggleFields('venda');
            } else if (this.id === 'btnJuridica') {
                document.getElementById('tipoUsuario').value = 'Prestador PJ'; // define prestador como PJ
                if (confirmaPessoaModal && confirmaPessoaModal._isShown) confirmaPessoaModal.hide();
                toggleFields('juridica');
            } else if (this.id === 'btnFisica') {
                document.getElementById('tipoUsuario').value = 'Prestador PF'; // define prestador como PF
                if (confirmaPessoaModal && confirmaPessoaModal._isShown) confirmaPessoaModal.hide();
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

document.querySelector('form').addEventListener('submit', function (event) {
    // Verifica se os checkboxes estão marcados
    const privacyPolicyChecked = document.getElementById('privacyPolicyCheckbox').checked;
    const termosDeUsoChecked = document.getElementById('termosDeUsoCheckbox').checked;

    // Se qualquer um dos checkboxes não estiver marcado, impede o envio
    if (!privacyPolicyChecked || !termosDeUsoChecked) {
        event.preventDefault(); // Impede o envio do formulário
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Por favor, verifique se o campo "Politica de Privacidade" e "Termos de Uso" estão marcados.',
            position: 'center',
            showConfirmButton: false,

        });
    }
});
