<?php include '../../padroes/head.php'; ?>

<body class="bodyCards">
    <?php include '../../padroes/nav.php'; ?>

    <!-- Inicio Corpo de Pagina -->
    <div class="container">
        <div class="row flex-wrap">

            <!-- Foto/Avaliação/Disponibilidade/Whats -->
            <div class="col-sm-4 mt-2">
                <div class="text-center foto-perfil mt-2">
                    <img src="../../assets/imgs/ruivo.png" alt="Ícone de usuário" class="mb-3">
                </div>

                <!-- Avaliação Estrelas -->
                <div class="rate mb-2">
                    <?php for ($i = 5; $i >= 1; $i--) : ?>
                        <input type="radio" id="star<?= $i ?>" name="rate" value="<?= $i ?>" <?= $i === 1 ? 'onclick="window.location.href=\'../cliente/telaAvaliacao.php\'"' : '' ?> />
                        <label for="star<?= $i ?>" title="<?= $i ?> estrela<?= $i > 1 ? 's' : '' ?>">★</label>
                    <?php endfor; ?>
                </div>

                <!-- Botões -->
                <div class="mb-2">
                    <button type="button" class="btn btn-primary botaoVerificaDisponibilidade" data-bs-toggle="modal" data-bs-target="#calendarModal">
                        <i class="fa-regular fa-calendar"></i> Verificar Disponibilidade
                    </button>
                </div>

                <div>
                    <button type="button" class="btn btn-success mt-2 botaoWhats" id="whatsappButton">
                        <i class="fa-brands fa-whatsapp"></i> Entre em Contato
                    </button>
                </div>
                <!-- Final Botões -->
            </div>

            <!-- Dados Do Prestador -->
            <?php $donoPerfil = true; ?>

            <div class="col-sm-4 mt-2">
                <h3  class="text-left mt-2">
                    Nome Prestador
                    <img width="10%" height="10%" src="https://img.icons8.com/color/48/verified-badge.png" alt="verified-badge" />
                </h3>

                <?php if ($donoPerfil) : ?>
                    <div class="d-flex align-items-center mt-2">
                        <a href="TelaEditarPrestador.php" class="btn btn-outline-primary btn-sm me-2">
                            <img width="16" height="16" src="https://img.icons8.com/material-outlined/24/edit.png" alt="edit-icon" />
                            Editar Informações
                        </a>
                    </div>
                <?php endif; ?>

                <div class="row flex-wrap mt-3">
                    <!-- Cidade -->
                    <div class="col-sm-6 mt-2">
                        <h5 class="text-left">Cidade</h5>
                        <div class="card mb-0">
                            <div class="card-body text-center">
                                <p class="card-text">Joinville</p>
                            </div>
                        </div>
                    </div>

                    <!-- Área de Atuação -->
                    <div class="col-sm-6 mt-2">
                        <h5 class="text-left">Área de Atuação</h5>
                        <div class="card mb-0">
                            <div class="card-body text-center">
                                <p class="card-text">Carpinteiro</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Dados Do Prestador -->

            <!-- Avaliações -->
            <div class="col-sm-4 mt-2">
                <div class="text-center">
                    <h3 class="mt-2" style="background-color:#1B3C54; color:white">84 Serviços Prestados</h3>
                    <h6 class="mt-2">74 Voltariam a contratar seus serviços</h6>
                    <h3 class="mt-4">Avaliações</h3>

                    <?php for ($i = 0; $i < 3; $i++) : ?>
                        <div class="card mb-2">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-1 text-muted">
                                    <img width="50" height="50" src="https://img.icons8.com/ios/50/user--v1.png" alt="user--v1" style="margin-top: 2%;">
                                    Usuario 69
                                    <?php for ($star = 0; $star < 5; $star++) : ?>
                                        <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <?php endfor; ?>
                                </h6>
                                <p class="card-text">Serviço Muito Bom</p>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <!-- Final Avaliações -->

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modalCalendario">
                <div class="modal-header">
                    <h5 class="modal-title" id="calendarModalLabel">Calendário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="calendar">
                        <div class="headerCalendario">
                            <button id="prevMonth" class="btn btn-sm btn-outline-secondary">&lt;</button>
                            <div id="monthYear"></div>
                            <button id="nextMonth" class="btn btn-sm btn-outline-secondary">&gt;</button>
                        </div>
                        <div class="calendar-days">
                            <div class="calendar-day">Dom</div>
                            <div class="calendar-day">Seg</div>
                            <div class="calendar-day">Ter</div>
                            <div class="calendar-day">Qua</div>
                            <div class="calendar-day">Qui</div>
                            <div class="calendar-day">Sex</div>
                            <div class="calendar-day">Sáb</div>
                        </div>
                        <div id="dates" class="calendar-dates"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Final do Modal -->

    <div class="services-container-wrapper container containerCards">
        <div class="tituloServicos">
            <h3 class="titulo">Serviços em destaque</h3>
        </div>
        <button class="arrow fechaEsquerda flecha" onclick="scrollCards('.container1', -1)">&#9664;</button>
        <div class="services-container container1 containerServicos">
            <?php
            $servicos = [
                1 => "Serviço 1",
                2 => "Serviço 2",
                3 => "Serviço 3",
                4 => "Serviço 4",
                5 => "Serviço 5",
                6 => "Serviço 6",
                7 => "Serviço 7",
                8 => "Serviço 8"
            ];
            foreach ($servicos as $id => $title) : ?>
                <div class="card cardServicos">
                    <img src="../../assets/imgs/testeimg2.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $title ?></h5>
                        <p class="card-text">Descrição breve do <?= $title ?>.</p>
                        <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="arrow flechaDireita flecha" onclick="scrollCards('.container1', 1)">&#9654;</button>
    </div>

    <?php include '../../padroes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthYearDiv = document.getElementById('monthYear');
            const datesDiv = document.getElementById('dates');

            const date = new Date();
            let currentYear = date.getFullYear();
            let currentMonth = date.getMonth();

            function updateCalendar() {
                const firstDay = new Date(currentYear, currentMonth, 1);
                const lastDay = new Date(currentYear, currentMonth + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startDay = firstDay.getDay();

                datesDiv.innerHTML = '';

                // Add empty days for the start of the month
                for (let i = 0; i < startDay; i++) {
                    const emptyElement = document.createElement('div');
                    emptyElement.className = 'calendar-date empty';
                    datesDiv.appendChild(emptyElement);
                }

                // Add the actual days of the month
                for (let i = 1; i <= daysInMonth; i++) {
                    const dateElement = document.createElement('div');
                    dateElement.className = 'calendar-date';
                    dateElement.innerText = i;
                    datesDiv.appendChild(dateElement);
                }

                const options = {
                    month: 'long'
                };
                monthYearDiv.innerText = `${new Intl.DateTimeFormat('pt-BR', options).format(new Date(currentYear, currentMonth))} ${currentYear}`;
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
        });

        function scrollCards(containerSelector, direction) {
            const container = document.querySelector(containerSelector);
            const scrollAmount = 300; // Ajuste o valor conforme necessário
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>