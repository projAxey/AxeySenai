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
        var startDate = document.getElementById("startDate").value;
        var endDate = document.getElementById("endDate").value;
        var startTime = document.getElementById("eventHoraInicio").value;
        var startTime = formatTime(startTime);
        var endTime = document.getElementById("eventHoraFim").value;
        var endTime = formatTime(endTime);
        var nomeServico = document.getElementById("nomeServico").value;
        var descricaoServico = document.getElementById("descricaoServico").value;
        var prestacaoDate = document.getElementById("prestacaoDate").value;
        var prestacaoTime = document.getElementById("horaPrestacao").value;
        var servicoDescricao = document.getElementById("floatingTextarea").value;

        // Data de hoje
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        var todayDate = yyyy + '-' + mm + '-' + dd;
        var hour = today.getHours();
        var minutes = today.getMinutes();
        var timeNow = hour + ":" + minutes;

        // Formata Hora
        function formatTime(time) {
            var timeParts = time.split(":");
            if (timeParts.length === 3) {
                var hour = timeParts[0].padStart(2, '0');
                var minute = timeParts[1].padStart(2, '0');
                var secunds = timeParts[2].padStart(2, '0');
                return hour + ":" + minute;
            }
            return "00:00";
        }

        // Validação dos dados
        if (!prestacaoDate || !prestacaoTime || !servicoDescricao) {
            Swal.fire({
                icon: "error", // Exibe ícone de erro
                title: "Erro",
                text: "Todos os campos precisam ser preenchidos."
            });
            document.getElementById('loadingSpinner').style.display = 'none';
            return;
        } else if (prestacaoDate < todayDate) {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A data de prestação não pode ser no anterior a data de hoje."
            });
            return;
        } else if (prestacaoDate === todayDate && prestacaoTime < timeNow) {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A hora de prestação não pode ser anterior à hora atual."
            });
            return;
        } else if (prestacaoDate === todayDate && prestacaoTime === timeNow) {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A hora de prestação nao pode ser igual a hora atual."
            });
            return;
        } else if (prestacaoDate > endDate || prestacaoDate < startDate) {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A data esta fora da agenda estipulada pelo prestador"
            });
            return;
        } else if (prestacaoTime > endTime || prestacaoTime < startTime) {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A hora esta fora da agenda estipulada pelo prestador"
            });
            return;
        }


        // Exibe o ícone de carregamento
        document.getElementById('loadingSpinner').style.display = 'block';
        document.getElementById('cadastroDisponibilidadebutton').style.display = 'none';

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
        fetch('../../backend/calendario/solicitaAgendaInserir.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: "success", // Exibe ícone de sucesso
                    title: "Sucesso",
                    text: data.msg
                }).then(() => {
                    window.location.href = "/projAxeySenai/frontend/cliente/agendamentosCliente.php";
                });

                document.getElementById('loadingSpinner').style.display = 'none'; // Esconde o carregamento
            })
            .catch(error => {
                console.error('Erro:', error);
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Erro ao enviar os dados."
                }).then(() => {
                    // Quando o usuário fechar o alerta, a página é recarregada
                    location.reload();
                });

                document.getElementById('loadingSpinner').style.display = 'none'; // Esconde o carregamento
            });

    });

    // Fecha o formulário pop-up e recarrega a página após o clique no "X"
    document.getElementById('close-cadastro-disponibilidade').addEventListener('click', function () {
        document.getElementById('popupForm').style.display = 'none';
        location.reload();  // Recarrega a página quando o usuário fechar a modal
    });
});