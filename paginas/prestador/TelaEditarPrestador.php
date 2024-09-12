<?php
include '../../padroes/head.php';
?>

<body class="bodyCards">
    <?php
    include '../../padroes/nav.php';
    ?>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Adiciona o SweetAlert2 -->
    <link rel="stylesheet" href="/projAxeySenai/assets/css/style.css">

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

        .modal-backdrop.show {
            opacity: 0;
        }

        .modal-content {
            background-color: #ffff;
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
            text-align: right;
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
            cursor: pointer;
        }

        /* Estilo do formulário no pop-up */
        .popup-form {
            display: none;
            position: fixed;
            z-index: 1060;
            left: 50%;
            top: 50%;
            margin-top: 1, 5%;
            margin-bottom: 1, 5%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            height: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        textarea {
            resize: none;
            height: 100px;
        }

        a {
            text-decoration: none;
            color: #012640;
        }
    </style>

    <div class="container mt-4">
        <div class="row d-flex flex-wrap">
            <!-- Perfil -->
            <div class="col-md-4 mt-2">
                <div class="text-center area-foto-perfil mt-2">
                    <img src="../../assets/imgs/ruivo.png" alt="Ícone de usuário" class="mb-3 foto-perfil">
                </div>
                <div class="rate text-center mb-3">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="5 estrelas" aria-label="5 estrelas">★</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="4 estrelas" aria-label="4 estrelas">★</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="3 estrelas" aria-label="3 estrelas">★</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="2 estrelas" aria-label="2 estrelas">★</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="1 estrela" aria-label="1 estrela">★</label>
                </div>
                <div class="d-grid">
                    <button type="button" id='show-calendar' class="btn btn-primary botaoVerificaDisponibilidade"
                        data-toggle="modal" data-target="#calendarModal">
                        <i class="fa-regular fa-calendar"></i> Ajustar Disponibilidade </button>
                </div>
            </div>

            <!-- Formulário de Edição -->
            <div class="col-md-8 mt-2">
                <h3 class="text-left">Editar Perfil
                    <img width="5%" height="5%" src="https://img.icons8.com/color/48/verified-badge.png"
                        alt="verified-badge" />
                </h3>
                <h5 class="text-left">Cidade</h5>

                <form class="mt-3" id="editForm">
                    <div class="row g-3">


                        <div class="col-md-12">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" maxlength="100" required
                                aria-required="true">
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="nome-social-checkbox">
                                <label class="form-check-label" for="nome-social-checkbox">
                                    Usar Nome Social
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12" id="nome-social-field" style="display: none;">
                            <label for="nome-social" class="form-label">Nome Social</label>
                            <input type="text" class="form-control" id="nome-social" maxlength="100">
                        </div>
                        <div class="col-md-8">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required aria-required="true"
                                maxlength="100">
                        </div>
                        <div class="col-md-4">
                            <label for="seguimento" class="form-label">Categoria</label>
                            <select class="form-control" id="seguimento" required aria-required="true">
                                <option value="" disabled selected>Selecione uma Categoria</option>
                                <option value="teste">Aqui vem do banco</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="tel" class="form-control" id="celular" pattern="\(\d{2}\) \d{5}-\d{4}"
                                placeholder="(XX) XXXXX-XXXX" required aria-required="true" maxlength="15">
                        </div>
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" pattern="\(\d{2}\) \d{4}-\d{4}"
                                placeholder="(XX) XXXX-XXXX" maxlength="14">
                        </div>
                        <div class="col-md-6">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" pattern="\d{5}-\d{3}"
                                placeholder="XXXXX-XXX" required aria-required="true">
                            <small id="cepHelp" class="form-text text-muted">
                                <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep"
                                    target="_blank">Não sei meu Cep</a>
                            </small>
                        </div>
                        <div class="col-md-6">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade">
                        </div>
                        <div class="col-md-6">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro">
                        </div>
                        <div class="col-md-6">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco">
                        </div>
                        <div class="col-md-6">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" maxlength="10">
                        </div>
                        <div class="col-md-6">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" maxlength="25">
                        </div>

                        <div class="col-md-6">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" id="senha" class="form-control" required aria-required="true"
                                minlength="8" maxlength="20">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Sua senha deve ter entre 8 e 20 caracteres.
                            </small>
                        </div>
                        <div class="col-md-6">
                            <label for="confirma-senha" class="form-label">Confirme a Senha</label>
                            <input type="password" id="confirma-senha" class="form-control" required
                                aria-required="true" minlength="8" maxlength="20">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Sua senha deve ter entre 8 e 20 caracteres.
                            </small>
                        </div>
                        <div class="col-md-12">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" rows="3" maxlength="500"></textarea>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary"
                            style="background-color: #012640; color:white">Salvar</button>
                        <button id="btnCadastroProduto" type="button" class="btn btn-primary"
                            style="background-color: #012640; color:white">Novo Serviço</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div id='calendarModal' class='modal'>
            <div class='modal-content'>
                <span class='close'>&times;</span>
                <div id='calendar'></div>
            </div>
        </div>
        <!-- Final Modal -->
        <!-- Modal -->
        <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel">Detalhes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Conteúdo do Modal de Detalhes -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Final Modal com detalhes -->
        <!-- O Formulário Pop-up -->
        <div id="popupForm" class="popup-form">
            <h3>Serviço</h3>
            <form id="serviceForm">
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
                    <input type="text" id="eventTitle" name="eventTitle" class="form-control"
                        placeholder="Digite o título do serviço">
                </div>
                <div class="mb-3">
                    <label for="eventDesc" class="form-label">Descrição</label>
                    <textarea id="eventDesc" name="eventDesc" class="form-control"
                        placeholder="Digite a descrição do serviço"></textarea>
                </div>
                <!-- <div class="mb-3">
                    <label for="repeatDays" class="form-label">Deseja repetir?</label>
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
                </div> -->
                <div class="d-flex justify-content-between">
                    <button type="submit" id="saveEvent" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary close-popup">Fechar</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    include '../../padroes/footer.php';
    ?>

    <script>
        // Variáveis globais
        var startDate, endDate, startDayDate;
        var today = new Date();
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

        document.addEventListener('DOMContentLoaded', function() {
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
                select: function(info) {
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
                showCalendarButton.addEventListener('click', function() {
                    document.getElementById('calendarModal').style.display = 'block';
                    calendar.render();
                });
            }

            // Evento para fechar o modal
            var closeModalButton = document.querySelector('.close');
            if (closeModalButton) {
                closeModalButton.addEventListener('click', function() {
                    document.getElementById('calendarModal').style.display = 'none';
                });
            }

            // Evento para fechar o formulário pop-up
            var closePopupButton = document.querySelector('.close-popup');
            if (closePopupButton) {
                closePopupButton.addEventListener('click', function() {
                    document.getElementById('popupForm').style.display = 'none';
                    document.getElementById("serviceForm").reset();
                });
            }

            // Função de validação do formulário
            var serviceForm = document.getElementById('serviceForm');
            if (serviceForm) {
                serviceForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    var serviceDate = `${startDate} - ${endDate}`;
                    // console.log("Service " + serviceDate);
                    var startTime = document.getElementById('eventHoraInicio').value;
                    var endTime = document.getElementById('eventHoraFim').value;
                    var title = document.getElementById('eventTitle').value;
                    var description = document.getElementById('eventDesc').value;
                    // console.log("StartDate");
                    // console.log(startDate);
                    // console.log(endDate);
                    // console.log(today);
                    // console.log(todayDate);

                    var startDayDate =
                        today.getFullYear() + '-' +
                        String(today.getMonth() + 1).padStart(2, '0') + '-' +
                        String(today.getDate()).padStart(2, '0');


                    // console.log(startDayDate);
                    // Verificar se todos os campos obrigatórios estão preenchidos
                    if (!serviceDate || !startTime || !endTime || !title || !description) {
                        console.log("01");
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
                        console.log("02");
                        Swal.fire({
                            title: 'Erro',
                            text: 'A data inicial não pode ser maior que a data final.',
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reseta o formulário ao clicar em "Fechar"
                                document.getElementById("serviceForm").reset();
                                document.getElementById('popupForm').style.display = 'none'
                            }
                        });
                        return;
                    }
                    // console.log(startDate);
                    // console.log(today);
                    // console.log(startDate.getTime());
                    // console.log(today.getTime());
                    // console.log(startDate.toISOString().split('T')[0]);
                    // console.log(today.toISOString().split('T')[0]);
                    // Verificar se a data inicial é menor que a data de hoje
                    // if (startDate < today) {
                    //     // console.log(startDate);
                    //     // console.log(today);
                    //     console.log("03");
                    //     Swal.fire({
                    //         title: 'Erro',
                    //         text: 'A data inicial não pode ser menor que a data de hoje.',
                    //         icon: 'error',
                    //         confirmButtonText: 'Fechar'
                    //     }).then((result) => {
                    //         if (result.isConfirmed) {
                    //             // Reseta o formulário ao clicar em "Fechar"
                    //             document.getElementById("serviceForm").reset();
                    //             document.getElementById('popupForm').style.display = 'none'
                    //         }
                    //     });
                    //     return;
                    // }
                    // Nova Verificação: Se a data inicial for igual à data atual, a hora inicial não pode ser inferior à hora atual
                    if (startDate === today && startTime < currentTime) {
                        console.log("04");
                        Swal.fire({
                            title: 'Erro',
                            text: 'A hora inicial não pode ser inferior à hora atual.',
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reseta o formulário ao clicar em "Fechar"
                                document.getElementById("serviceForm").reset();
                                document.getElementById('popupForm').style.display = 'none'
                            }
                        });
                        return;
                    }
                    // Verificar se a data inicial é igual à data final
                    if (startDate.getTime() === endDate.getTime() && startDate === today) {

                        console.log("05");
                        // Verificar se a hora final é menor que a hora inicial
                        if (endTime < startTime) {
                            console.log("05.01");
                            Swal.fire({
                                title: 'Erro',
                                text: 'A hora final não pode ser menor que a hora inicial.',
                                icon: 'error',
                                confirmButtonText: 'Fechar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reseta o formulário ao clicar em "Fechar"
                                    document.getElementById("serviceForm").reset();
                                    document.getElementById('popupForm').style.display = 'none'
                                }
                            });
                            return;
                        }
                        // Verificar se a hora inicial é menor que a hora atual
                        if (startTime < currentTime) {
                            console.log("05.02");
                            Swal.fire({
                                title: 'Erro',
                                text: 'A hora inicial não pode ser menor que a hora atual.',
                                icon: 'error',
                                confirmButtonText: 'Fechar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reseta o formulário ao clicar em "Fechar"
                                    document.getElementById("serviceForm").reset();
                                    document.getElementById('popupForm').style.display = 'none'
                                }
                            });
                            return;
                        }
                        if (startDate.toISOString().split('T')[0] < today) {
                            console.log("06");
                            Swal.fire({
                                title: 'Erro',
                                text: 'A data inicial não pode ser menor que a data de hoje.',
                                icon: 'error',
                                confirmButtonText: 'Fechar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reseta o formulário ao clicar em "Fechar"
                                    document.getElementById("serviceForm").reset();
                                    document.getElementById('popupForm').style.display = 'none';
                                }
                            });
                            return;
                        }
                    }
                    // Verificar se a hora final é menor que a hora inicial
                    if (startDate.getTime() == endDate.getTime() && endTime < startTime) {
                        console.log("07")
                        Swal.fire({
                            title: 'Erro',
                            text: 'A hora final não pode ser menor que a hora inicial.',
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reseta o formulário ao clicar em "Fechar"
                                document.getElementById("serviceForm").reset();
                                document.getElementById('popupForm').style.display = 'none';
                            }
                        });
                        return;
                    }
                    //verifica se as datas sao diferentes e valida o start do serviço
                    if (startDate != today) {
                        console.log("08")
                        if (startDate < today) {
                            console.log("08.01")
                            Swal.fire({
                                title: 'Erro',
                                text: 'A data inicial não pode ser menor que a data de hoje.',
                                icon: 'error',
                                confirmButtonText: 'Fechar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reseta o formulário ao clicar em "Fechar"
                                    document.getElementById("serviceForm").reset();
                                    document.getElementById('popupForm').style.display = 'none'
                                }
                            });
                            return;
                        }
                        if (startDate === today && startTime < currentTime) {
                            console.log("08.02")
                            console.log("erro")
                            Swal.fire({
                                title: 'Erro',
                                text: 'A hora inicial não pode ser menor que a hora atual.',
                                icon: 'error',
                                confirmButtonText: 'Fechar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reseta o formulário ao clicar em "Fechar"
                                    document.getElementById("serviceForm").reset();
                                    document.getElementById('popupForm').style.display = 'none'
                                }
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

        document.getElementById('cep').addEventListener('input', function() {
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
                    })
            }
        });

        document.getElementById('celular').addEventListener('input', function() {
            var celular = this.value.replace(/\D/g, '');
            this.value = celular.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        });

        document.getElementById('telefone').addEventListener('input', function() {
            var telefone = this.value.replace(/\D/g, '');
            this.value = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        });

        document.addEventListener('DOMContentLoaded', function() {
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

            document.getElementById('prevMonth').addEventListener('click', function() {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                updateCalendar();
            });

            document.getElementById('nextMonth').addEventListener('click', function() {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                updateCalendar();
            });

            updateCalendar();

            nomeSocialCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    nomeSocialField.style.display = 'block';
                } else {
                    nomeSocialField.style.display = 'none';
                }
            });

            document.getElementById("btnCadastroProduto").addEventListener("click", function() {
                window.location.href = "telaCadastroProduto.php";
            });

            document.getElementById('editForm').addEventListener('submit', function(event) {
                // Adicionar lógica de validação e manipulação de submissão de formulário
                event.preventDefault();
                alert('Formulário salvo com sucesso!');
            });
        });
    </script>
</body>

</html>