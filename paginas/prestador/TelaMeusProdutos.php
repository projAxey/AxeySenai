<?php
include '../../padroes/head.php';
?>
<body>
    <?php include '../../padroes/nav.php'; ?>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Adiciona o SweetAlert2 -->
    <link rel="stylesheet" href="/projAxeySenai/assets/css/style.css">

    <div class="container mt-4">
        <div class="row d-flex flex-wrap">
            <ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item">
                    <a href="perfilPrestador.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                </li>
            </ol>
            <div class="col- mt-2">
                <h1 class="mb-4">Meus Serviços</h1>
                <div class="d-flex justify-content-between mb-4">


                        <button type="button" id='meusAgendamentos' class="mb-2 btn btn-primary btn-meus-agendamentos"
                        style="background-color: #012640; color:white" onclick="window.location.href='telaCadastroProduto.php'" >
                        Novo Serviço <i class="bi bi-plus-circle"></i>
                    </button> 
                </div>
                <!-- Tabela com Cabeçalhos -->
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-striped-admin">
                            <thead>
                                <tr>
                                    <th class="th-admin">TÍTULO</th>
                                    <th class="th-admin">CATEGORIA</th>
                                    <th class="th-admin">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Reparos Gerais e Pequenas Reformas</td>
                                    <td>Manutenção Residencial</td>
                                    <td class="actions-admin">
                                        <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                                        <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                        <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal"
                                            data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Serviços de Hidráulica e Encanamento</td>
                                    <td>Manutenção Residencial</td>
                                    <td class="actions-admin">
                                        <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                                        <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                        <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal"
                                            data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include '../../padroes/footer.php'; ?>
    <script src="../../assets/JS/global.js"></script>
    <script>
        // Variáveis globais
        var startDate, endDate;
        var today = new Date();
        console.log(today)
        var todayDate = today.toISOString().split('T')[0];
        // console.log(todayDate)
        var currentTime = today.toTimeString().split(' ')[0].substring(0, 5); // Hora atual no formato HH:MM
        // console.log(currentTime)

        // Função para capturar e formatar as datas
        function captureAndFormatDates(info) {
            startDate = new Date(info.startStr);
            endDate = new Date(info.endStr);

            console.log(startDate);
            console.log(endDate);

            // Ajustar a data final para o dia correto
            if (endDate > startDate) {
                startDate.setDate(startDate.getDate() + 1);
                console.log(startDate)
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

        document.addEventListener('DOMContentLoaded', function () {
            var userState = 0; // Estado do usuário: 0 para editar, 1 para visualizar
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                height: '100%',
                editable: true,
                headerToolbar: {
                    start: 'today',
                    center: 'title',
                    end: 'prevYear,prev,next,nextYear'
                },
                eventColor: 'green',
                events: [{
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
            // Evento para abrir o calendário no modal
            var showCalendarButton = document.getElementById('show-calendar');
            if (showCalendarButton) {
                showCalendarButton.addEventListener('click', function () {
                    document.getElementById('calendarModal').style.display = 'block';
                    calendar.render();
                });
            }

            // Evento para fechar o modal
            var closeModalButton = document.querySelector('.close');
            if (closeModalButton) {
                closeModalButton.addEventListener('click', function () {
                    document.getElementById('calendarModal').style.display = 'none';
                });
            }

            // Evento para fechar o formulário pop-up
            var closePopupButton = document.querySelector('.close-popup');
            if (closePopupButton) {
                closePopupButton.addEventListener('click', function () {
                    document.getElementById('popupForm').style.display = 'none';
                });
            }

            // Função de validação do formulário
            var serviceForm = document.getElementById('serviceForm');
            if (serviceForm) {
                serviceForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    var serviceDate = `${startDate} - ${endDate}`;
                    // console.log("Service " + serviceDate);
                    var startTime = document.getElementById('eventHoraInicio').value;
                    var endTime = document.getElementById('eventHoraFim').value;
                    var title = document.getElementById('eventTitle').value;
                    var description = document.getElementById('eventDesc').value;

                    // Verificar se todos os campos obrigatórios estão preenchidos
                    if (!serviceDate || !startTime || !endTime || !title || !description) {
                        // console.log("01");
                        Swal.fire({
                            title: 'Erro',
                            text: 'Todos os campos devem ser preenchidos.',
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        });
                        return;
                    }

                    // Verificar se a data inicial é menor que a data final
                    if (startDate > endDate) {
                        // console.log("02");
                        Swal.fire({
                            title: 'Erro',
                            text: 'A data inicial não pode ser maior que a data final.',
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        });
                        return;
                    }

                    // Verificar se a data inicial é menor que a data de hoje
                    if (startDate.toISOString().split('T')[0] < today) {
                        // console.log("Start " + startDate);
                        // console.log("today " + today)
                        // console.log("03");
                        // console.log("Start" + startDate.toISOString().split('T')[0]);
                        // console.log(todayDate);
                        Swal.fire({
                            title: 'Erro',
                            text: 'A data inicial não pode ser menor que a data de hoje.',
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        });
                        return;
                    }

                    // Nova Verificação: Se a data inicial for igual à data atual, a hora inicial não pode ser inferior à hora atual
                    if (startDate === today && startTime < currentTime) {
                        // console.log("06");
                        // console.log("Star " + startDate);
                        // console.log(today);

                        Swal.fire({
                            title: 'Erro',
                            text: 'A hora inicial não pode ser inferior à hora atual.',
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        });
                        return;
                    }

                    // Verificar se a data inicial é igual à data final
                    if (startDate.getTime() === endDate.getTime()) {

                        console.log("07");

                        // Verificar se a hora final é menor que a hora inicial
                        if (endTime < startTime) {
                            Swal.fire({
                                title: 'Erro',
                                text: 'A hora final não pode ser menor que a hora inicial.',
                                icon: 'error',
                                confirmButtonText: 'Fechar'
                            });
                            return;
                        }

                        // Verificar se a hora inicial é menor que a hora atual
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

                    // Verificar se a hora final é menor que a hora inicial
                    if (startDate.getTime() == endDate.getTime() && endTime < startTime) {
                        // console.log("08")
                        Swal.fire({
                            title: 'Erro',
                            text: 'A hora final não pode ser menor que a hora inicial.',
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        });
                        return;
                    }

                    //verifica se as datas sao diferentes e valida o start do serviço
                    if (startDate != today) {
                        console.log("09");
                        console.log(todayDate);
                        if (startDate < today) {
                            // console.log("Foi")
                            // console.log("Start " + startDate);
                            // console.log("today " + today);
                            console.log("09");
                            // console.log("Start" + startDate.toISOString().split('T')[0]);
                            // console.log(todayDate);
                            Swal.fire({
                                title: 'Erro',
                                text: 'A data inicial não pode ser menor que a data de hoje.',
                                icon: 'error',
                                confirmButtonText: 'Fechar'
                            });
                            return;
                        }


                    }
                    // console.log(startDate);
                    // console.log(today);
                    // Se tudo estiver correto, você pode prosseguir com o envio ou outra lógica
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Serviço salvo com sucesso.',
                        icon: 'success',
                        confirmButtonText: 'Fechar'
                    });

                    // Limpar os campos do formulário
                    serviceForm.reset();

                    // Fechar o formulário
                    document.getElementById('popupForm').style.display = 'none';
                });
            }
        });

        //valida formulario de alteração de cadastro

        document.getElementById('cep').addEventListener('input', function () {
            var cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                this.value = cep.replace(/(\d{5})(\d{0,3})/, '$1-$2');
            }
            if (cep.length === 8) {
                fetch('https://viacep.com.br/ws/' + cep + '/json/')
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('endereco').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                            document.getElementById('numero').focus();
                        } else {
                            alert('CEP não encontrado. Por favor, verifique o CEP digitado.');
                        }
                    });
            }
        });

        document.getElementById('celular').addEventListener('input', function () {
            var celular = this.value.replace(/\D/g, '');
            this.value = celular.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        });

        document.getElementById('telefone').addEventListener('input', function () {
            var telefone = this.value.replace(/\D/g, '');
            this.value = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        });

        document.addEventListener('DOMContentLoaded', function () {
            const monthYearDiv = document.getElementById('monthYear');
            const datesDiv = document.getElementById('dates');
            const nomeSocialCheckbox = document.getElementById('nome-social-checkbox');
            const nomeSocialField = document.getElementById('nome-social-field');

            const date = new Date();
            let currentYear = date.getFullYear();
            let currentMonth = date.getMonth();

            function updateCalendar() {
                const firstDay = new Date(currentYear, currentMonth, 1);
                const lastDay = new Date(currentYear, currentMonth + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startDay = firstDay.getDay();

                datesDiv.innerHTML = '';

                for (let i = 0; i < startDay; i++) {
                    const emptyElement = document.createElement('div');
                    emptyElement.className = 'calendar-date empty';
                    datesDiv.appendChild(emptyElement);
                }

                for (let i = 1; i <= daysInMonth; i++) {
                    const dateElement = document.createElement('div');
                    dateElement.className = 'calendar-date';
                    dateElement.innerText = i;
                    datesDiv.appendChild(dateElement);
                }

                monthYearDiv.innerText = `${date.toLocaleString('default', { month: 'long' })} ${currentYear}`;
            }

            document.getElementById('prevMonth').addEventListener('click', function () {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                updateCalendar();
            });

            document.getElementById('nextMonth').addEventListener('click', function () {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                updateCalendar();
            });

            updateCalendar();

            nomeSocialCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    nomeSocialField.style.display = 'block';
                } else {
                    nomeSocialField.style.display = 'none';
                }
            });

            document.getElementById("btnCadastroProduto").addEventListener("click", function () {
                window.location.href = "telaCadastroProduto.php";
            });

            document.getElementById('editForm').addEventListener('submit', function (event) {
                // Adicionar lógica de validação e manipulação de submissão de formulário
                event.preventDefault();
                alert('Formulário salvo com sucesso!');
            });
        });

        function goBack() {
            alert('Voltar');
            // Aqui você pode adicionar a lógica para voltar à página anterior
        }

        function addNewService() {
            alert('Adicionar novo serviço');
            // Aqui você pode adicionar a lógica para adicionar um novo serviço
        }

        function editService(id) {
            alert('Editar serviço ' + id);
            // Aqui você pode adicionar a lógica para editar o serviço
        }

        function deleteService(id) {
            alert('Excluir serviço ' + id);
            // Aqui você pode adicionar a lógica para excluir o serviço
        }
    </script>
</body>

</html>