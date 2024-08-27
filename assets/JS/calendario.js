document.addEventListener('DOMContentLoaded', function() {
    var userState = 0; // Estado do usuário: 0 para editar, 1 para visualizar
    var calendarEl = document.getElementById('calendar');

    if (!calendarEl) {
        console.error("Elemento do calendário não encontrado.");
        return;
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        initialView: 'dayGridMonth',
        timeZone: 'UTC',
        locale: 'pt-br',
        height: '100%',
        editable: true,
        headerToolbar: {
            start: 'today',
            center: 'title',
            end: 'prevYear,prev,next,nextYear'
        },
        eventColor: 'green',
        events: [
            { title: 'All Day Event', start: '2024-08-01' },
            { title: 'Long Event', start: '2024-08-07', end: '2024-08-10' },
            { title: 'Conference', start: '2024-08-11', end: '2024-08-13' },
            { title: 'Meeting', start: '2024-08-12T10:30:00', end: '2024-08-12T12:30:00' },
            { title: 'Lunch', start: '2024-08-12T12:00:00' },
            { title: 'Meeting', start: '2024-08-12T14:30:00' },
            { title: 'Happy Hour', start: '2024-08-12T17:30:00' },
            { title: 'Dinner', start: '2024-08-12T20:00:00' },
            { title: 'Birthday Party', start: '2024-08-13T07:00:00' },
            { title: 'Vacation', start: '2024-08-13', end: '2024-08-17' }
        ],
        selectable: true,
        select: function(info) {
            var startDate = new Date(info.start);
            var endDate = new Date(info.end);

            var formattedStartDate = startDate.toISOString().split('T')[0];
            var formattedEndDate = new Date(endDate.getTime() - 86400000).toISOString().split('T')[0];

            if (userState === 0) {
                document.getElementById('serviceDate').value = formattedStartDate + " - " + formattedEndDate;
                document.getElementById('timeEditableFields').style.display = 'block';
                document.getElementById('timeDisplayFields').style.display = 'none';
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

    document.getElementById('show-calendar').addEventListener('click', function() {
        document.getElementById('calendarModal').style.display = 'block';
        calendar.render();
    });

    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('calendarModal').style.display = 'none';
    });

    document.querySelector('.close-popup').addEventListener('click', function() {
        document.getElementById('popupForm').style.display = 'none';
    });

    document.getElementById('serviceForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var serviceDate = document.getElementById('serviceDate').value;
        var startTime = document.getElementById('eventHoraInicio').value;
        var endTime = document.getElementById('eventHoraFim').value;
        var title = document.getElementById('eventTitle').value;
        var description = document.getElementById('eventDesc').value;

        var today = new Date().toISOString().split('T')[0];
        var currentTime = new Date().toTimeString().split(' ')[0]; 

        var startDate = new Date(serviceDate.split(' - ')[0]);
        var endDate = new Date(serviceDate.split(' - ')[1] || serviceDate.split(' - ')[0]);

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

        if (startDate.toISOString().split('T')[0] === today) {
            if (startTime < currentTime) {
                Swal.fire({
                    title: 'Erro',
                    text: 'A hora inicial não pode ser menor que a hora atual.',
                    icon: 'error',
                    confirmButtonText: 'Fechar'
                });
                return;
            }
        }

        if (startDate.getTime() === endDate.getTime()) {
            if (endTime < startTime) {
                Swal.fire({
                    title: 'Erro',
                    text: 'A hora final não pode ser menor que a hora inicial.',
                    icon: 'error',
                    confirmButtonText: 'Fechar'
                });
                return;
            }
        }

        Swal.fire({
            title: 'Sucesso',
            text: 'Serviço salvo com sucesso.',
            icon: 'success',
            confirmButtonText: 'Fechar'
        });

        document.getElementById('serviceForm').reset();
        document.getElementById('popupForm').style.display = 'none';
    });

    calendar.render();
});
