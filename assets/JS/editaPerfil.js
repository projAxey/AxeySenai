

document.addEventListener('DOMContentLoaded', function () {
    // Função para esconder as mensagens após 5 segundos (5000 ms)
    setTimeout(function () {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');

        if (successAlert) {
            successAlert.style.display = 'none';
        }

        if (errorAlert) {
            errorAlert.style.display = 'none';
        }
    }, 2000); // 5000 ms = 5 segundos



    const editarPerfilBtn = document.getElementById('editarPerfil');
const editForm = document.getElementById('editForm');
const camposDesabilitados = editForm.querySelectorAll('input[disabled], textarea[disabled], select[disabled]');
const salvarBtn = editForm.querySelector('button[type="submit"]');
const cancelarBtn = document.getElementById('cancelarEdicao');
const usarNomeSocialCheckbox = document.getElementById('usarNomeSocialField');
const nomeSocialFields = document.getElementById('nomeSocialFields');

// Campos que devem ser habilitados para envio, mas não editáveis
const camposImutaveis = ['endereco', 'bairro', 'cidade', 'uf'];

editarPerfilBtn.addEventListener('click', function () {
    // Itera sobre os campos e habilita os imutáveis para envio (readonly)
    camposDesabilitados.forEach(function (campo) {
        if (camposImutaveis.includes(campo.id)) {
            campo.disabled = false;  // Habilita para envio
            campo.readOnly = true;   // Impede edição
        } else {
            campo.disabled = false;  // Habilita campos editáveis
            campo.readOnly = false;  // Permite edição
        }
    });

    // Exibe os botões de salvar e cancelar
    salvarBtn.style.display = 'block';
    cancelarBtn.style.display = 'block';
    editarPerfilBtn.style.display = 'none'; // Oculta o botão Editar Perfil

    // Mostra o checkbox de Nome Social ao editar
    if (usarNomeSocialCheckbox) {
        usarNomeSocialCheckbox.closest('.form-check').style.display = 'block';

        // Controle a visibilidade do campo "Nome Social" baseado no checkbox
        usarNomeSocialCheckbox.addEventListener('change', function () {
            if (this.checked) {
                nomeSocialFields.classList.remove('d-none');
                nomeSocialFields.querySelector('input').disabled = false;
            } else {
                nomeSocialFields.classList.add('d-none');
                nomeSocialFields.querySelector('input').disabled = true;
            }
        });
    }
});

    cancelarBtn.addEventListener('click', function () {
        Swal.fire({
            title: "Cancelar Edição",
            text: "Você tem certeza que deseja cancelar as edições?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // Desabilita os campos de entrada novamente
                camposDesabilitados.forEach(function (campo) {
                    campo.disabled = true;
                });
                // Oculta os botões de salvar e cancelar e mostra o de editar
                salvarBtn.style.display = 'none';
                cancelarBtn.style.display = 'none';
                editarPerfilBtn.style.display = 'block';

                // Oculta o checkbox de Nome Social e o campo se ele não estava originalmente preenchido
                if (usarNomeSocialCheckbox) {
                    usarNomeSocialCheckbox.closest('.form-check').style.display = 'none';
                    if (!usarNomeSocialCheckbox.checked) {
                        nomeSocialFields.classList.add('d-none');
                    }
                }

                // Recarrega a página
                location.reload();
            }
        });
    });

    salvarBtn.addEventListener('click', function (event) {
        event.preventDefault(); // Previne o envio imediato do formulário

        if (validaCampos(event)) {
            Swal.fire({
                title: "Salvar Edições",
                text: "Você tem certeza que deseja salvar as edições?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Somente submeta se o usuário confirmar
                    editForm.submit(); // O envio é feito aqui após a confirmação
                }
            });
        }
    });
});




document.getElementById('toggleSenhaAtual').addEventListener('click', function () {
    const senhaAtualInput = document.getElementById('senhaAtual');
    const icon = document.getElementById('iconSenhaAtual');
    if (senhaAtualInput.type === 'password') {
        senhaAtualInput.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        senhaAtualInput.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
});


const inputFotoPerfil = document.getElementById('inputFotoPerfil');
const previewFotoPerfil = document.getElementById('previewFotoPerfil');
const fotoAtual = document.getElementById('fotoPerfil');

inputFotoPerfil.addEventListener('change', function (event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewFotoPerfil.src = e.target.result;
            previewFotoPerfil.style.display = "block";
        }
        reader.readAsDataURL(file);
    }
});










