document.addEventListener('DOMContentLoaded', function () {
    var userState = 0; // Estado do usuário: 0 para editar, 1 para visualizar
    var commercialStartHour = "09:00";
    var commercialEndHour = "18:00";

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '2024-08-12', // Definindo a data inicial
        locale: 'pt-br',
        height: '100%',
        editable: true,
        headerToolbar: {
            start: 'dayGridMonth',
            center: 'title',
            end: 'prevYear,prev,next,nextYear'
        },
        eventColor: 'green',
        events: [
            {
                title: 'All Day Event',
                start: '2024-08-01'
            },
            {
                title: 'Long Event',
                start: '2024-08-07',
                end: '2024-08-10'
            },
            {
                title: 'Conference',
                start: '2024-08-11',
                end: '2024-08-13'
            },
            {
                title: 'Meeting',
                start: '2024-08-12T10:30:00',
                end: '2024-08-12T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2024-08-12T12:00:00'
            },
            {
                title: 'Meeting',
                start: '2024-08-12T14:30:00'
            },
            {
                title: 'Happy Hour',
                start: '2024-08-12T17:30:00'
            },
            {
                title: 'Dinner',
                start: '2024-08-12T20:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2024-08-13T07:00:00'
            },
            {
                title: 'Vacation',
                start: '2024-08-13',
                end: '2024-08-17'
            }
        ],
        selectable: true,
        select: function (info) {
            var startDate = new Date(info.start);
            var endDate = new Date(info.end);

            // Formatar as datas no formato YYYY-MM-DD
            var formattedStartDate = startDate.toISOString().split('T')[0];
            var formattedEndDate = new Date(endDate.getTime() - 86400000).toISOString().split('T')[0];

            // Verificar se o usuário está no modo de edição (0) ou visualização (1)
            if (userState === 0) {
                // Definir a data no input do formulário
                document.getElementById('serviceDate').value = formattedStartDate + " - " + formattedEndDate;

                // Exibir os campos de hora editáveis e esconder os campos de visualização
                document.getElementById('timeEditableFields').style.display = 'block';
                document.getElementById('timeDisplayFields').style.display = 'none';

                // Exibir o formulário pop-up
                document.getElementById('popupForm').style.display = 'block';
            } else if (userState === 1) {
                Swal.fire({
                    title: 'Detalhes do Serviço',
                    html: `
                        <p><strong>Data:</strong> ${formattedStartDate} - ${formattedEndDate}</p>
                        <p><strong>Hora Início:</strong> 08:00</p>
                        <p><strong>Hora Fim:</strong> 12:00</p>
                        <p><strong>Título:</strong> Meu Título</p>
                        <p><strong>Descrição:</strong> Minha Descrição</p>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Fechar'
                });
            }
        }
    });

    // Evento para abrir o calendário no modal
    document.getElementById('show-calendar').addEventListener('click', function () {
        document.getElementById('calendarModal').style.display = 'block';
        calendar.render();
    });

    // Evento para fechar o modal
    document.querySelector('.close').addEventListener('click', function () {
        document.getElementById('calendarModal').style.display = 'none';
    });

    // Evento para fechar o formulário pop-up
    document.querySelector('.close-popup').addEventListener('click', function () {
        document.getElementById('popupForm').style.display = 'none';
    });

    // Função de validação do formulário
    document.getElementById('serviceForm').addEventListener('submit', function (event) {
        event.preventDefault();

        var serviceDate = document.getElementById('serviceDate').value;
        var startTime = document.getElementById('eventHoraInicio').value;
        var endTime = document.getElementById('eventHoraFim').value;
        var title = document.getElementById('eventTitle').value;
        var description = document.getElementById('eventDesc').value;

        var today = new Date().toISOString().split('T')[0];
        var startDate = new Date(serviceDate.split(' - ')[0]);

        if (!serviceDate || !startTime || !endTime || !title || !description) {
            Swal.fire({
                title: 'Erro',
                text: 'Todos os campos devem ser preenchidos.',
                icon: 'error',
                confirmButtonText: 'Fechar'
            });
            return;
        }

        if (startDate < new Date(today)) {
            Swal.fire({
                title: 'Erro',
                text: 'A data inicial não pode ser menor que a data de hoje.',
                icon: 'error',
                confirmButtonText: 'Fechar'
            });
            return;
        }

        // Se tudo estiver correto, você pode prosseguir com o envio ou outra lógica
        Swal.fire({
            title: 'Sucesso',
            text: 'Serviço salvo com sucesso.',
            icon: 'success',
            confirmButtonText: 'Fechar'
        });

        // Fechar o formulário
        document.getElementById('popupForm').style.display = 'none';
    });

    // Inicializar o calendário
    calendar.render();
});

function scrollCards(containerSelector, direction) {
    const container = document.querySelector(containerSelector);
    const cardWidth = container.querySelector('.cardServicos').offsetWidth;
    container.scrollBy({
        left: direction * cardWidth,
        behavior: 'smooth'
    });
}

function scrollCards2(containerSelector, direction) {
    const container = document.querySelector(containerSelector);
    const cardWidth = container.querySelector('.cardServicos').offsetWidth;
    container.scrollBy({
        left: direction * cardWidth,
        behavior: 'smooth'
    });
}

document
    .getElementById("whatsappButton")
    .addEventListener("click", function () {
        const phoneNumber = "554788671192"; // Número de telefone com código do país (55 para Brasil)
        const message = encodeURIComponent("Olá, gostaria de mais informações."); // Mensagem opcional
        const url = `https://wa.me/${phoneNumber}?text=${message}`;
        window.open(url, "_blank");
    });