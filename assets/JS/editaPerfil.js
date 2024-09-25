document.getElementById('usarNomeSocialField').addEventListener('change', function () {
  var nomeSocialField = document.getElementById('nomeSocialFields');
  if (this.checked) {
      nomeSocialField.classList.remove('d-none'); // Remover a classe d-none
  } else {
      nomeSocialField.classList.add('d-none'); // Adicionar a classe d-none
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const editarPerfilBtn = document.getElementById('editarPerfil');
  const editForm = document.getElementById('editForm');
  const camposDesabilitados = editForm.querySelectorAll('input[disabled]');
  const salvarBtn = editForm.querySelector('button[type="submit"]');
  const cancelarBtn = document.getElementById('cancelarEdicao');

  editarPerfilBtn.addEventListener('click', function () {
      // Habilita os campos de entrada
      camposDesabilitados.forEach(function (campo) {
          campo.disabled = false;
      });

      // Exibe o botão de salvar e o botão de cancelar
      salvarBtn.style.display = 'block';
      cancelarBtn.style.display = 'block';
      editarPerfilBtn.style.display = 'none'; // Oculta o botão Editar Perfil
  });

  cancelarBtn.addEventListener('click', function () {
      // Exibe um alerta de confirmação
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
              // Oculta os botões de salvar e cancelar
              location.reload(); 
              salvarBtn.style.display = 'none';
              cancelarBtn.style.display = 'none';
              editarPerfilBtn.style.display = 'block'; // Mostra o botão Editar Perfil novamente
          }
      });
  });

  salvarBtn.addEventListener('click', function (event) {
      // Impede o envio do formulário para mostrar a confirmação
      event.preventDefault();

      // Exibe um alerta de confirmação para salvar
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
              // Se o usuário confirmar, envia o formulário
              editForm.submit();
          }
      });
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


function toggleForm(enable) {
  const formFields = document.querySelectorAll('#editForm input');
  formFields.forEach(function (field) {
    field.disabled = !enable;
  });
}

toggleForm(false);

document.getElementById('editarPerfil').addEventListener('click', function (event) {
  event.preventDefault();
  toggleForm(true);
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
