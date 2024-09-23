// Prestador
// Variáveis globais
var startDate, endDate, startDayDate, checkbox;
var pulaFinalDeSemana = true;
var today = new Date();
var eventos = [{
    title: 'Disponibilidade',
    start: '2024-09-20T16:00:00',
    color: 'Blue',
    navLinks: true,

},
{
    start: '2024-09-24',
    end: '2024-09-28',
    overlap: false,
    display: 'background',
    color: '#ff9f89'

},
{
    start: '2024-09-11T10:00:00',
    end: '2024-09-11T16:00:00',
    display: 'background',
    color: '#ff9f89'
}]


// console.log(today);
var todayDate = today.getFullYear() + '-' +
    String(today.getMonth() + 1).padStart(2, '0') + '-' +
    String(today.getDate()).padStart(2, '0');
// console.log(todayDate)
var currentTime = today.toTimeString().split(' ')[0].substring(0, 5); // Hora atual no formato HH:MM
// console.log(currentTime)

// Função para capturar e formatar as datas
function captureAndFormatDates(info) {
    startDate = new Date(info.startStr);
    endDate = new Date(info.endStr);

    // console.log(startDate);
    // console.log(endDate);

    // Ajustar a data final para o dia correto
    if (endDate > startDate) {
        startDate.setDate(startDate.getDate() + 1);
        // console.log(startDate)
        endDate.setDate(endDate.getDate());
    }

    // Função para formatar a data no formato DD-MM-YYYY
    function formatDateToDDMMYYYY(date) {
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    var formattedStartDateBRL = formatDateToDDMMYYYY(startDate);
    var formattedEndDateBRL = formatDateToDDMMYYYY(endDate);

    // Se a data inicial e a data final são iguais, exibir apenas uma data
    var displayDate = (startDate.getTime() === endDate.getTime()) ?
        formattedStartDateBRL :
        formattedStartDateBRL + " - " + formattedEndDateBRL;

    return {
        displayDate: displayDate
    };
}

// console.log(startDate);
// console.log(endDate);
// console.log(today);

document.addEventListener('DOMContentLoaded', function () {
    var userState = 0; // Estado do usuário: 0 para editar, 1 para visualizar
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        height: '100%',
        editable: false,
        titleFormat: { // will produce something like "Tuesday, September 18, 2018"
            month: 'short',
            year: 'numeric',
        },
        headerToolbar: {
            start: '',
            center: 'title',
            end: '',
        },
        footerToolbar: {
            start: 'today',
            center: '',
            end: 'prevYear,prev,next,nextYear'
        },
        eventColor: 'green',
        events: eventos,
        selectable: true,
        select: function (info) {
            var dates = captureAndFormatDates(info);
            var displayDate = dates.displayDate;

            // Verificar se o usuário está no modo de edição (0) ou visualização (1)
            if (userState === 0) {
                // Definir a data no input do formulário
                document.getElementById('serviceDate').value = displayDate;

                // Exibir os campos de hora editáveis e esconder os campos de visualização
                document.getElementById('timeEditableFields').style.display = 'block';
                document.getElementById('timeDisplayFields').style.display = 'none';

                // Exibir o formulário pop-up
                document.getElementById('popupForm').style.display = 'block';
            } else if (userState === 1) {
                Swal.fire({
                    title: 'Detalhes do Serviço',
                    html: `
                    <p><strong>Data:</strong> ${displayDate}</p>
                    <p><strong>Hora Início:</strong> 08:00</p>
                    <p><strong>Hora Fim:</strong> 12:00</p>
                    <p><strong>Título:</strong> Meu Título</p>
                    <p><strong>Descrição:</strong> Minha Descrição</p>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Fechar'
                });
            }

            // console.log(startDate);
            // console.log(endDate);
        }
    });

    // Inicializar o calendário
    calendar.render();
    // // Evento para abrir o calendário no modal
    // var showCalendarButton = document.getElementById('show-calendar');
    // var showCalendarButtonPrestador = document.getElementById('showcalendarprestador');
    // if (showCalendarButton) {
    //     showCalendarButton.addEventListener('click', function () {
    //         document.getElementById('calendarModal').style.display = 'block';
    //         calendar.render();
    //     });
    // } else if (showCalendarButtonPrestador) {
    //     showCalendarButtonPrestador.addEventListener('click', function () {
    //         document.getElementById('calendarModal').style.display = 'block';
    //         calendar.render();
    //     });
    // }

    // Evento para abrir o calendário no modal
    var showCalendarButton = document.getElementById('show-calendar');
    var showCalendarButtonPrestador = document.getElementById('showcalendarprestador');
    var calendarModal = document.getElementById('calendarModal');
    var calendar = typeof calendar !== 'undefined' ? calendar : null;

    if (showCalendarButton) {
        showCalendarButton.addEventListener('click', function () {
            if (calendarModal && calendar) {
                calendarModal.style.display = 'block';
                calendar.render();
            }
        });
    } else if (showCalendarButtonPrestador) {
        showCalendarButtonPrestador.addEventListener('click', function () {
            if (calendarModal && calendar) {
                calendarModal.style.display = 'block';
                calendar.render();
            }
        });
    }

    // Evento para fechar o modal calendario
    var closeModalButton = document.querySelector('.close');
    if (closeModalButton) {
        closeModalButton.addEventListener('click', function () {
            document.getElementById('calendarModal').style.display = 'none';
        });
    }

    // Evento para fechar o formulário pop-up
    var closePopupButton = document.querySelector('.close-popup');
    var saveEvent = document.querySelector('#saveEvent');
    var serviceForm = document.getElementById('serviceForm');

    // // dataFornecida(202)
    // console.log(startDate)

    // var startDayDate =
    //     startDate.getFullYear() + '-' +
    //     String(startDate.getMonth() + 1).padStart(2, '0') + '-' +
    //     String(startDate.getDate()).padStart(2, '0');

    // dataFornecida = startDate;
    // eventos.forEach(function (evento) {
    //     if (evento.start === dataFornecida) {
    //         console.log("A data " + dataFornecida + " coincide com o evento: ");
    //     } else {
    //         console.log("A data " + dataFornecida + " não coincide com o evento: ");
    //     }
    // });

    // Evento de fechar o popup
    if (closePopupButton) {
        closePopupButton.addEventListener('click', function () {
            document.getElementById('popupForm').style.display = 'none';
            serviceForm.reset();
        });
    }

    // Evento de salvar
    if (saveEvent) {
        saveEvent.addEventListener('click', function () {
            // console.log('Salvou');

            // Evento de submit do formulário
            serviceForm.addEventListener('submit', function (event) {
                event.preventDefault();

                // Inicializando as variáveis corretamente
                var serviceDate = `${startDate} - ${endDate}`;
                var startTime = document.getElementById('eventHoraInicio').value;
                var endTime = document.getElementById('eventHoraFim').value;
                // var checkbox = document.getElementById("flexCheckChecked").value;

                function validateCheckbox() {
                    var checkbox = document.getElementById("flexCheckChecked");                
                    if (checkbox.checked) {
                        // console.log("A checkbox está marcada.");
                        pulaFinalDeSemana = true;
                    } else {
                        // console.log("A checkbox não está marcada.");
                        pulaFinalDeSemana = false;
                    }
                
                    // console.log(pulaFinalDeSemana); // Loga o valor no console
                
                    return pulaFinalDeSemana; // Retorna o valor da variável
                }

                pulaFinalDeSemana = validateCheckbox();
                // console.log(pulaFinalDeSemana)

                // var title = document.getElementById('eventTitle').value;
                // var description = document.getElementById('eventDesc').value;

                // Exemplo de inicialização correta de startDate, endDate e currentTime (certifique-se de ajustar)
                var todayDate = new Date().toISOString().split('T')[0]; // Data de hoje
                var currentTime = new Date().toTimeString().split(' ')[0]; // Hora atual (ajustável)

                var startDayDate =
                    startDate.getFullYear() + '-' +
                    String(startDate.getMonth() + 1).padStart(2, '0') + '-' +
                    String(startDate.getDate()).padStart(2, '0');

                var endDayDate =
                    endDate.getFullYear() + '-' +
                    String(endDate.getMonth() + 1).padStart(2, '0') + '-' +
                    String(endDate.getDate()).padStart(2, '0');

                // Verificação dos campos e das condições
                if (!serviceDate || !startTime || !endTime) {
                    Swal.fire({
                        title: 'Erro',
                        text: 'Todos os campos devem ser preenchidos.',
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    });
                    return;
                } else if (endDayDate < startDayDate) {
                    Swal.fire({
                        title: 'Erro',
                        text: 'A data inicial não pode ser maior que a data final.',
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('popupForm').style.display = 'none'
                        }
                    });
                    return;
                } else if (startDayDate < todayDate) {
                    Swal.fire({
                        title: 'Erro',
                        text: 'A data inicial não pode ser menor que a data atual.',
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('popupForm').style.display = 'none'
                        }
                    });
                    return;
                } else if (startDayDate === todayDate && endDayDate === todayDate && startTime < currentTime) {
                    Swal.fire({
                        title: 'Erro',
                        text: 'A hora inicial não pode ser menor que a hora atual.',
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('popupForm').style.display = 'none'
                        }
                    });
                    return;
                } else if (startDayDate === todayDate && endDayDate === todayDate && endTime < startTime) {
                    Swal.fire({
                        title: 'Erro',
                        text: 'A hora final não pode ser menor que a hora inicial.',
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('popupForm').style.display = 'none'
                        }
                    });
                    return;
                }

                // Se tudo estiver correto, exibe mensagem de sucesso
                Swal.fire({
                    title: 'Sucesso',
                    text: 'Serviço salvo com sucesso.',
                    icon: 'success',
                    confirmButtonText: 'Fechar'
                });

                // Limpar o formulário e fechar o popup
                serviceForm.reset();
                document.getElementById('popupForm').style.display = 'none';
            });
        });
    }

});
