function abreFormulario() {
    document.getElementById('popupForm').style.display = 'block';
}

function fechaFormulario() {
    document.getElementById('popupForm').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
document.getElementById('show-calendar').addEventListener('click', abreFormulario);
document.getElementById('close-cadastro-disponibilidade').addEventListener('click', fechaFormulario);

});

