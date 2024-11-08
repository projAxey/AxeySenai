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
        console.log(startTime)
        var startTime = formatTime(startTime);
        console.log(startTime)
        var endTime = document.getElementById("eventHoraFim").value;
        console.log(endTime)
        var endTime = formatTime(endTime);
        console.log(endTime)
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

        //Formata Hora
        function formatTime(time) {
            // Verificar se a hora é válida (HH:MM)
            var timeParts = time.split(":");
            if (timeParts.length === 3) {
                var hour = timeParts[0].padStart(2, '0'); // Preencher horas com 0 à esquerda, se necessário
                var minute = timeParts[1].padStart(2, '0'); // Preencher minutos com 0 à esquerda, se necessário
                var secunds = timeParts[2].padStart(2, '0'); // Preencher minutos com 0 à esquerda, se necessário
                return hour + ":" + minute;
            }
            return "00:00"; // Caso não seja válido, retorna um formato padrão
        }


        // console.log(prestacaoDate)
        // console.log(startDate)
        // console.log(endDate)

        // console.log(prestacaoTime)
        // console.log(startTime)
        // console.log(endTime)

        // Validação dos dados
        if (!prestacaoDate || !prestacaoTime || !servicoDescricao) {
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
        } else if (prestacaoDate === todayDate && prestacaoTime === timeNow){
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A hora de prestação nao pode ser igual a hora atual."
            });
            return;
        } else if ( prestacaoDate > endDate || prestacaoDate < startDate) {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A data esta fora da agenda estipulada pelo prestador"
            });
            return;
        } else if ( prestacaoTime > endTime || prestacaoTime < startTime) {
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "A hora esta fora da agenda estipulada pelo prestador"
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
