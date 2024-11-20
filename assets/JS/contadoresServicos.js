function loadAdminCounts() {
    fetch('../../backend/adm/contadorDadosServicos.php')
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('servicosAtivos').innerHTML = `${data.servicosAtivos} Serviços ativos`;
                document.getElementById('produtosPendentes').innerHTML = `${data.produtosPendentes} Serviços pendentes`;
                document.getElementById('usuariosAtivos').innerHTML = `${data.usuariosAtivos} Usuários ativos`;
                document.getElementById('prestadoresPendentes').innerHTML = `${data.prestadoresPendentes} Prestadores pendentes`;
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.error('Erro ao buscar contagens:', error));
}

//sobe os contadores quando abre a tela
document.addEventListener('DOMContentLoaded', loadAdminCounts);