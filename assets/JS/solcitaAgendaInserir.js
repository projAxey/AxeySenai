document.addEventListener("DOMContentLoaded", function () {
    // Captura o formulário correto pelo ID
    document.getElementById('cadastroDisponibilidade').addEventListener('submit', function (event) {
        event.preventDefault(); // Previne o envio padrão do formulário

        // Captura os valores do formulário
        var idAgendamento = document.getElementById("idAgendamento").value;
        var idCliente = document.getElementById("idCliente").value;
        var idProduto = document.getElementById("idProduto").value;
        var idPrestador = document.getElementById("idPrestador").value;
        var idDisponibilidade = document.getElementById("idDisponibilidade").value;
        var nomeServico = document.getElementById("nomeServico").value;
        var descricaoServico = document.getElementById("descricaoServico").value;
        var prestacaoDate = document.getElementById("prestacaoDate").value;
        var prestacaoTime = document.getElementById("horaPrestacao").value;
        var servicoDescricao = document.getElementById("floatingTextarea").value;

        //Data de hoje
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        var todayDate = yyyy + '-' + mm + '-' + dd;
        var hour = today.getHours();
        var minutes = today.getMinutes();
        var timeNow = hour + ":" + minutes;

        // Validação dos dados
        if (!prestacaoDate || !prestacaoTime) {
            Swal.fire({
                icon: "error", // Exibe ícone de erro
                title: "Erro",
                text: "Todos os campos precisam ser preenchidos."
            });
            return;
        } else if (prestacaoDate < todayDate) {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A data de prestação não pode ser no passado."
            });
            return;
        } else if (prestacaoDate === todayDate && prestacaoTime < timeNow) {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A hora de prestação não pode ser anterior à hora atual."
            });
            return;
        }

        // Cria um objeto FormData para enviar os dados
        var formData = new FormData();
        formData.append('idAgendamento', idAgendamento);
        formData.append('idCliente', idCliente);
        formData.append('idProduto', idProduto);
        formData.append('idPrestador', idPrestador);
        formData.append('idDisponibilidade', idDisponibilidade);
        formData.append('nomeServico', nomeServico);
        formData.append('descricaoServico', descricaoServico);
        formData.append('prestacaoDate', prestacaoDate);
        formData.append('prestacaoTime', prestacaoTime);
        formData.append('servicoDescricao', servicoDescricao);

        // Faz a requisição AJAX para o backend
        fetch('/backend/calendario/solicitaAgendaInserir.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: "success", // Exibe ícone de sucesso
                title: "Sucesso",
                text: data.msg
            });
            if (data.status) {
                window.location.reload(true); // Recarrega a página após o sucesso
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "Erro ao enviar os dados."
            });
        });
    });

    // Fecha o formulário pop-up
    document.getElementById('close-cadastro-disponibilidade').addEventListener('click', function () {
        document.getElementById('popupForm').style.display = 'none';
    });
});
