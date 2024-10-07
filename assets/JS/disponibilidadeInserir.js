document.addEventListener("DOMContentLoaded", function () {
    // Captura o ID do prestador PHP a partir do elemento HTML
    // var idPrestador = document.getElementById('idPrestador').value;


    document.getElementById('cadastroDisponibilidade').addEventListener('submit', function (event) {
        event.preventDefault(); // Previne o envio padrão do formulário

        // Captura os valores do formulário
        var startDate = document.getElementById("startserviceDate").value;
        var endDate = document.getElementById("endserviceDate").value;
        var startTime = document.getElementById("eventHoraInicio").value;
        var endTime = document.getElementById("eventHoraFim").value;

        //Data De hoje
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        var todayDate = yyyy + '-' + mm + '-' + dd;

        var hour = today.getHours();
        var minutes = today.getMinutes();

        var timeNow = hour + ":" + minutes;
        // console.log(timeNow);
        // console.log(startTime);



        // Validação simples dos dados
        if (!startDate || !endDate || !startTime || !endTime) {
            Swal.fire({
                icon: "error", // Exibe ícone de erro
                title: "Erro",
                text: "Todos os campos precisam ser preenchidos."
            });
            return; // Sai da função se algum campo estiver vazio
        } else if (startDate > endDate) {
            Swal.fire({
                icon: "error", // Exibe ícone de erro
                title: "Erro",
                text: "A data de inicio deve ser menor que a data de fim."
            });
            return;
        } else if (startDate === endDate && startTime >= endTime) {
            Swal.fire({
                icon: "error", // Exibe ícone de erro
                title: "Erro",
                text: "A hora de fim deve ser maior que a hora de inicial."
            });
            return;
        } else if (startDate < todayDate) {
            Swal.fire({
                icon: "error", // Exibe ícone de erro
                title: "Erro",
                text: "A data de inicio deve ser maior que a data atual."
            });
            return;
        } else if (startDate === todayDate && endDate >= todayDate && startTime < timeNow) {
            Swal.fire({
                icon: "error", // Exibe ícone de erro
                title: "Erro",
                text: "A hora inicial nao pode ser menor que a hora atual."
            });
            return;
        } else {
            // Cria um objeto FormData para enviar os dados
            var formData = new FormData();
            formData.append('startDayDate', startDate);
            formData.append('endDayDate', endDate);
            formData.append('startTime', startTime);
            formData.append('endTime', endTime);
            // formData.append('id_prestador', idPrestador); // Adiciona o ID do prestador

            // Faz a requisição AJAX
            fetch('../../backend/calendario/disponibilidadeInserir.php', {
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
                    // Trata a resposta do servidor
                    // alert(data.msg); // Exibe a mensagem retornada do PHP

                    if (data.status) {
                        // Aqui você pode adicionar o que deve acontecer após o sucesso (ex: limpar campos, redirecionar, etc.)
                        window.location.reload(true);
                        document.getElementById('popupForm').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao enviar os dados.'); // Mensagem genérica de erro
                });
        }
    });

});