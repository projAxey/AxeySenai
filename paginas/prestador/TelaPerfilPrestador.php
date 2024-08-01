<?php
include '../../padroes/head.php';
?>

<body class="bodyCards">
    <?php

    include '../../padroes/nav.php';
    ?>

    <!-- Inicio Corpo de Pagina -->
    <div class="container">
        <div class="row d-flex flex-wrap ">
            <div class="col-sm-4 mt-2">
                <div class="col-sm-12">
                    <div class="text-center foto-perfil mt-2">
                        <img src="../../assets/imgs/icones/img.svg" alt="Ícone de usuário" class="mb-3">
                    </div>
                </div>
                <!-- Final Foto de Perfil -->
                <!-- Avaliação Estrelas-->
                <div class="col-sm-12">
                    <div class="rate">
                        <input type="radio" id="star5" name="rate" value="5" />
                        <label for="star5" title="5 estrelas">★</label>
                        <input type="radio" id="star4" name="rate" value="4" />
                        <label for="star4" title="4 estrelas">★</label>
                        <input type="radio" id="star3" name="rate" value="3" />
                        <label for="star3" title="3 estrelas">★</label>
                        <input type="radio" id="star2" name="rate" value="2" />
                        <label for="star2" title="2 estrelas">★</label>
                        <input onclick="window.location.href='../cliente/telaAvaliacao.php'" type="radio" id="star1" name="rate" value="1" />
                        <label for="star1" title="1 estrela">★</label>
                    </div>
                </div>
                <!-- Final Avaliação Estrelas -->
                <!-- Botões -->
                <!-- Botão Agenda -->
                <div class="col-sm-12">
                    <!-- <button type="button" id="btnCalendario">Success</button> -->
                    <button type="button" data-toggle="modal" data-target="#calendarModal" class="btn btn-primary botaoVerificaDisponibilidade">
                        <i class="fa-regular fa-calendar"></i> Verificar Diponibilidade </button>
                </div>
                <!-- Final Botão agenda -->
                <!-- Botão Whats -->
                <div class="col-sm-12">
                    <button type="button" class="btn btn-success mt-2 botaoWhats" id="whatsappButton"><i class="fa-brands fa-whatsapp"></i> Entre em Contato</button>
                </div>
                <!-- Final Botão Whats -->
                <!-- Final Botões -->
            </div>
            <!-- Final Foto/Avaliação/Disponibilidade/Whats -->
            <!-- Dados Do Prestador -->
            <div class="col-sm-4 mt-2">
                <!-- Nome Prestador -->
                <div class="col-sm-12 mt-2" style="padding-left: 0;">
                    <h3 onclick="window.location.href='TelaInfoPrestador.php'" class="text-left mt-12">Nome Prestador<img width="10%" height="10%" src="https://img.icons8.com/color/48/verified-badge.png" alt="verified-badge" /></h3>
                </div>
                <!-- Final Nome Prestador -->
                <!-- Cidade / Area de Atuação -->
                <div class="row d-flex flex-wrap">
                    <!-- Cidade -->
                    <div class="col-sm-6 mt-6">
                        <h5 class="text-left mt-6">Cidade</h5>
                        <div class="card" style="width: 100% ; align-items:start ; margin:0">
                            <div class="card-body">
                                <p class="card-text" style="text-align:center">Joinville</p>
                            </div>
                        </div>
                    </div>
                    <!-- Final Cidade -->
                    <!-- Area de atuação -->
                    <div class="col-sm-6">
                        <h5 class="text-lef mt-6">Area de Atuação</h5>
                        <div class="card" style="width:100% ; align-items:start ; margin:0">
                            <div class="card-body">
                                <p class="card-text" style="text-align:center">Carpinteiro</p>
                            </div>
                        </div>
                    </div>
                    <!-- Final Area de Atuação -->
                </div>
                <!-- Final Cidade / Area de Atuação -->
            </div>
            <!-- Final Dados Do Prestador -->
            <!-- Avaliações  -->
            <div class="col-sm-4 mt-2">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="text-center mt-6" style="background-color:#1B3C54 ; color:white">84 Serviços Prestados</h3>
                    </div>
                    <div class="col-sm-12">
                        <h6 class="text-center mt-6">74 Voltariam a contratar seus serviços</h6>
                    </div>
                    <div class="col-sm-12">
                        <h3 class="text-center mt-12">Avaliações</h3>
                        <div class="card mb-2" style="width:100% ; align-items:start ; margin:0">
                            <div class="card-body mb-2" style="padding: 0;">
                                <h6 class="card-subtitle mb-1 text-muted" style="margin:0">
                                    <img width="50" height="50" src="https://img.icons8.com/ios/50/user--v1.png" alt="user--v1" style="margin-top: 2%;">
                                    Usuario 69
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                </h6>
                                <p class="card-text " style="text-align: left">Serviço Muito Bom</p>
                            </div>
                        </div>
                        <div class="card mb-2" style="width:100% ; align-items:start ; margin:0">
                            <div class="card-body mb-2" style="padding: 0;">
                                <h6 class="card-subtitle mb-1 text-muted" style="margin:0">
                                    <img width="50" height="50" src="https://img.icons8.com/ios/50/user--v1.png" alt="user--v1" style="margin-top: 2%;">
                                    Usuario 69
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                </h6>
                                <p class="card-text " style="text-align: left">Serviço Muito Bom</p>
                            </div>
                        </div>
                        <div class="card mb-2" style="width:100% ; align-items:start ; margin:0">
                            <div class="card-body mb-2" style="padding: 0;">
                                <h6 class="card-subtitle mb-1 text-muted" style="margin:0">
                                    <img width="50" height="50" src="https://img.icons8.com/ios/50/user--v1.png" alt="user--v1" style="margin-top: 2%;">
                                    Usuario 69
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                    <img width="5%" height="5%" src="https://img.icons8.com/fluency/48/star--v1.png" alt="star--v1" />
                                </h6>
                                <p class="card-text " style="text-align: left">Serviço Muito Bom</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final Avalições -->
            <!-- Modal -->
            <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content modalCalendario">
                        <div class="modal-header">
                            <h5 class="modal-title" id="calendarModalLabel">Calendário</h5>
                            <button type="button" class="close fechaModalCalendario" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
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
            <!-- Serviços Destaque -->
            <div class="services-container-wrapper container containerCards">
                <div class="tituloServicos">
                    <h1 class="titulo">Serviços em destaque</h1>
                </div>
                <button class="arrow fechaEsquerda flecha" onclick="scrollCards('.container1', -1)">&#9664;</button>
                <div class="services-container container1 containerServicos">
                    <div class="card cardServicos">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Serviço 1</h5>
                            <p class="card-text">Descrição breve do Serviço 1.</p>
                            <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                        </div>
                    </div>
                    <div class="card cardServicos">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Serviço 2</h5>
                            <p class="card-text">Descrição breve do Serviço 2.</p>
                            <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                        </div>
                    </div>
                    <div class="card cardServicos">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Serviço 3</h5>
                            <p class="card-text">Descrição breve do Serviço 3.</p>
                            <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                        </div>
                    </div>
                    <div class="card cardServicos">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Serviço 4</h5>
                            <p class="card-text">Descrição breve do Serviço 4.</p>
                            <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                        </div>
                    </div>
                    <div class="card cardServicos">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Serviço 5</h5>
                            <p class="card-text">Descrição breve do Serviço 5.</p>
                            <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                        </div>
                    </div>
                    <div class="card cardServicos">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Serviço 6</h5>
                            <p class="card-text">Descrição breve do Serviço 6.</p>
                            <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                        </div>
                    </div>
                    <div class="card cardServicos">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Serviço 7</h5>
                            <p class="card-text">Descrição breve do Serviço 7.</p>
                            <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                        </div>
                    </div>
                    <div class="card cardServicos">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Serviço 8</h5>
                            <p class="card-text">Descrição breve do Serviço 8.</p>
                            <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                        </div>
                    </div>
                </div>
                <button class="arrow flechaDireita flecha" onclick="scrollCards('.container1', 1)">&#9654;</button>
            </div>
            <!-- Final Serviço Destaque -->
        </div>
    </div>

    <?php
    include '../../padroes/footer.php';
    ?>

    <script>
         
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
            .addEventListener("click", function() {
                const phoneNumber = "554788671192"; 
                const message = encodeURIComponent("Olá, gostaria de mais informações."); 
                const url = `https://wa.me/${phoneNumber}?text=${message}`;
                window.open(url, "_blank");
            });
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> -->
   
    <script src="../../assets/js/modal_calendario.js"></script>
    <script src="../../assets/js/whats_link.js"></script>
    <script src="../../assets/js/valida_informacoes.js"></script>
</body>

</html>