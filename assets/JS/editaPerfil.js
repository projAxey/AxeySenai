

document.addEventListener('DOMContentLoaded', function () {

    const editarPerfilBtn = document.getElementById('editarPerfil');
    const editForm = document.getElementById('editForm');
    const camposDesabilitados = editForm.querySelectorAll('input[disabled], textarea[disabled], select[disabled]');
    const salvarBtn = editForm.querySelector('button[type="submit"]');
    const cancelarBtn = document.getElementById('cancelarEdicao');
    const usarNomeSocialCheckbox = document.getElementById('usarNomeSocialField');
    const nomeSocialFields = document.getElementById('nomeSocialFields');

    editarPerfilBtn.addEventListener('click', function () {
        // Habilita os campos de entrada
        camposDesabilitados.forEach(function (campo) {
            campo.disabled = false;
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
        event.preventDefault();
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
                    // Chame a função de validação aqui
                    editForm.submit(); // Somente submeta se for válido

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

document.getElementById('toggleNovaSenha').addEventListener('click', function () {
    const novaSenhaInput = document.getElementById('novaSenha');
    const icon = document.getElementById('iconNovaSenha');
    if (novaSenhaInput.type === 'password') {
        novaSenhaInput.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        novaSenhaInput.type = 'password';
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
document.getElementById('salvarFoto').addEventListener('click', function () {
    if (previewFotoPerfil.src) {
        fotoAtual.src = previewFotoPerfil.src;
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalAlterarFoto'));
        modal.hide();
    }


});


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
}, 3000); // 5000 ms = 5 segundos





