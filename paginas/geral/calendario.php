<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Adiciona o SweetAlert2 -->

    <style>
        /* Estilo do Modal */
        .modal {
            display: none;
            /* Inicialmente escondido */
            position: fixed;
            z-index: 1050;
            /* Bootstrap z-index */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            /* Ajustado para melhor centralização */
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 800px;
            height: 90%;
            /* Ajuste da altura do modal */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #calendar {
            width: 100%;
            height: 100%;
            /* Ajuste para ocupar 100% da altura do modal */
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
            overflow: hidden;
            /* Evitar rolagem na página principal */
        }

        /* Estilo do formulário no pop-up */
        .popup-form {
            display: none;
            position: fixed;
            z-index: 1060;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        textarea {
            resize: none;
            height: 100px;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <button id='show-calendar' class='btn btn-primary'>Mostrar Agenda</button>
    </div>

    <!-- O Modal -->
    <div id='calendarModal' class='modal'>
        <div class='modal-content'>
            <span class='close'>&times;</span>
            <div id='calendar'></div>
        </div>
    </div>

    <!-- O Formulário Pop-up -->
    <div id="popupForm" class="popup-form">
        <h3>Serviço</h3>
        <form>
            <div class="mb-3">
                <label for="serviceDate" id="dateLabel" class="form-label">Datas Selecionadas</label>
                <input type="text" id="serviceDate" name="serviceDate" class="form-control" readonly>
            </div>
            <div class="row mb-3" id="timeEditableFields">
                <div class="col">
                    <label for="eventHoraInicio" class="form-label">Hora Início</label>
                    <input type="time" id="eventHoraInicio" name="eventHoraInicio" class="form-control">
                </div>
                <div class="col" id="horaFimContainer">
                    <label for="eventHoraFim" class="form-label">Hora Fim</label>
                    <input type="time" id="eventHoraFim" name="eventHoraFim" class="form-control">
                </div>
            </div>
            <div class="row mb-3" id="timeDisplayFields" style="display: none;">
                <div class="col">
                    <label for="startTimeDisplay" class="form-label">Hora Início (Visualizar)</label>
                    <input type="text" id="startTimeDisplay" name="startTimeDisplay" class="form-control" readonly>
                </div>
                <div class="col">
                    <label for="endTimeDisplay" class="form-label">Hora Fim (Visualizar)</label>
                    <input type="text" id="endTimeDisplay" name="endTimeDisplay" class="form-control" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="eventTitle" class="form-label">Título</label>
                <input type="text" id="eventTitle" name="eventTitle" class="form-control" placeholder="Digite o título do serviço">
            </div>
            <div class="mb-3">
                <label for="eventDesc" class="form-label">Descrição</label>
                <textarea id="eventDesc" name="eventDesc" class="form-control" placeholder="Digite a descrição do serviço"></textarea>
            </div>
            <div class="mb-3">
                <label for="repeatDays" class="form-label">Deseja repetir? (add a question mark)</label>
                <div id="repeatDays" class="d-flex flex-wrap">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dayMon" value="1">
                        <label class="form-check-label" for="dayMon">Seg</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dayTue" value="2">
                        <label class="form-check-label" for="dayTue">Ter</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dayWed" value="3">
                        <label class="form-check-label" for="dayWed">Qua</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dayThu" value="4">
                        <label class="form-check-label" for="dayThu">Qui</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dayFri" value="5">
                        <label class="form-check-label" for="dayFri">Sex</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="daySat" value="6">
                        <label class="form-check-label" for="daySat">Sáb</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="daySun" value="7">
                        <label class="form-check-label" for="daySun">Dom</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" id="saveEvent" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary close-popup">Fechar</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var userState = 0; // Estado do usuário: 0 para editar, 1 para visualizar
            var commercialStartHour = "09:00";
            var commercialEndHour = "18:00";

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                height: '100%',
                editable: true,
                headerToolbar: {
                    start: 'dayGridMonth,timeGridWeek,timeGridDay',
                    center: 'title',
                    end: 'prevYear,prev,next,nextYear'
                },
                selectable: true,
                selectMirror: true,
                timeZone: 'UTC',
                events: [], // Inicia sem eventos
                select: function (info) {
                    var now = new Date().toISOString().split('T')[0];
                    if (info.endStr <= now) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data inválida',
                            text: 'Você não pode selecionar uma data anterior ao dia de hoje.',
                        });
                        calendar.unselect();
                        return;
                    }

                    // Formatar data para DD/MM/YYYY
                    var startDate = new Date(info.startStr);
                    var endDate = new Date(info.endStr);
                    endDate.setDate(endDate.getDate() - 1); // Ajusta o fim para o dia anterior, pois o FullCalendar inclui o dia seguinte por padrão
                    var formattedStartDate = startDate.toLocaleDateString('pt-BR', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                    var formattedEndDate = endDate.toLocaleDateString('pt-BR', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });

                    var selectedDates = formattedStartDate === formattedEndDate ? formattedStartDate : `${formattedStartDate} a ${formattedEndDate}`;

                    // Atualizar o rótulo com base na seleção de datas
                    var dateLabel = document.getElementById('dateLabel');
                    dateLabel.textContent = formattedStartDate === formattedEndDate ? "Data Selecionada" : "Datas Selecionadas";

                    // Definir a hora inicial com o horário do clique do usuário
                    var startTime = info.start.toISOString().substr(11, 5); // Hora de início no formato HH:MM

                    // Verificar se é um multi-select ou um único dia
                    if (formattedStartDate !== formattedEndDate) {
                        document.getElementById('eventHoraInicio').value = commercialStartHour;
                        var endTime = commercialEndHour;
                        
                        // Caso o último horário selecionado esteja fora do horário comercial
                        if (parseInt(info.end.getUTCHours()) < 9 || parseInt(info.end.getUTCHours()) >= 18) {
                            endTime = startTime;
                        }

                        document.getElementById('eventHoraFim').value = endTime;
                    } else {
                        // Para um único dia, aplicar horário comercial diretamente
                        if (parseInt(info.start.getUTCHours()) < 9 || parseInt(info.start.getUTCHours()) >= 18) {
                            startTime = commercialStartHour;
                        }
                        document.getElementById('eventHoraInicio').value = startTime;
                        document.getElementById('eventHoraFim').value = ''; // Limpar o campo de Hora Fim para edição
                    }

                    // Exibir ou ocultar campos com base no estado do usuário
                    if (userState === 0) {
                        document.getElementById('timeEditableFields').style.display = 'flex';
                        document.getElementById('timeDisplayFields').style.display = 'none';
                        document.getElementById('horaFimContainer').style.display = 'block';
                    } else {
                        document.getElementById('timeEditableFields').style.display = 'none';
                        document.getElementById('timeDisplayFields').style.display = 'flex';
                    }

                    // Mostrar o formulário ao selecionar um intervalo de datas válido
                    var popupForm = document.getElementById('popupForm');
                    document.getElementById('serviceDate').value = selectedDates;
                    popupForm.style.display = 'block';
                }
            });

            var modal = document.getElementById('calendarModal');
            var btn = document.getElementById('show-calendar');
            var span = document.getElementsByClassName('close')[0];
            var closePopupButtons = document.querySelectorAll('.close-popup');

            btn.onclick = function () {
                modal.style.display = 'block';
                calendar.render();
            }

            span.onclick = function () {
                modal.style.display = 'none';
            }

            window.onclick = function (event) {
                if (event.target === modal || event.target === document.getElementById('popupForm')) {
                    modal.style.display = 'none';
                    document.getElementById('popupForm').style.display = 'none';
                }
            }

            // Fechar o pop-up do formulário
            closePopupButtons.forEach(function (button) {
                button.onclick = function () {
                    var popupForm = document.getElementById('popupForm');
                    popupForm.style.display = 'none';
                }
            });

            // Lógica para salvar o evento (você pode adaptar conforme necessário)
            document.getElementById('saveEvent').onclick = function (e) {
                e.preventDefault();
                var title = document.getElementById('eventTitle').value.trim();
                var description = document.getElementById('eventDesc').value.trim();
                var eventHoraInicio = document.getElementById('eventHoraInicio').value.trim();
                var eventHoraFim = document.getElementById('eventHoraFim').value.trim();

                if (title === "" || description === "" || eventHoraInicio === "" || eventHoraFim === "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Preenchimento obrigatório',
                        text: 'Por favor, preencha todos os campos antes de salvar.',
                    });
                    return;
                }

                // Adicionar o evento ao calendário
                calendar.addEvent({
                    title: title,
                    start: `${document.getElementById('serviceDate').value}T${eventHoraInicio}:00`,
                    end: `${document.getElementById('serviceDate').value}T${eventHoraFim}:00`,
                    description: description
                });

                // Armazenar os horários preenchidos
                document.getElementById('startTimeDisplay').value = eventHoraInicio;
                document.getElementById('endTimeDisplay').value = eventHoraFim;

                Swal.fire({
                    icon: 'success',
                    title: 'Evento salvo',
                    text: `Evento salvo: ${title} - ${description}\nHorário: ${eventHoraInicio} às ${eventHoraFim}`,
                });

                // Mudar estado do usuário para visualizar (1)
                userState = 1;

                // Fechar o formulário após salvar
                var popupForm = document.getElementById('popupForm');
                popupForm.style.display = 'none';
            }
        });
    </script>
</body>

</html>
