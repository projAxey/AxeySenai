 
  document.getElementById('nome-social-checkbox').addEventListener('change', function () {
    var nomeSocialField = document.getElementById('nome-social-field');
    if (this.checked) {
        nomeSocialField.style.display = 'block';
    } else {
        nomeSocialField.style.display = 'none';
    }
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
  
  inputFotoPerfil.addEventListener('change', function(event) {
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewFotoPerfil.src = e.target.result;
            previewFotoPerfil.style.display = "block";
        }
        reader.readAsDataURL(file);
    }
  });
  document.getElementById('salvarFoto').addEventListener('click', function() {
    if (previewFotoPerfil.src) {
        fotoAtual.src = previewFotoPerfil.src;
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalAlterarFoto'));
        modal.hide();
    }
  });
  