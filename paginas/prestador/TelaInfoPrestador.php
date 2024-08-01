<?php
include '../../padroes/head.php';
?>

<body class="bodyCards">
    <?php
    include '../../padroes/nav.php';
    ?>
    <!-- Inicio do Nav -->
    <!-- Final do Nav -->

    <!-- Inicio Corpo de Pagina -->
    <!-- <div class="row"> -->
    <div class="container">
        <!-- Dados de Perfil -->
        <div class="row d-flex flex-wrap ">
            <!-- Foto/Avaliação/Botões -->
            <div class="col-sm-4 mt-2">
                <!-- Foto de Perfil -->
                <div class="col-sm-12">
                    <div class="text-center area-foto-perfil mt-2">
                        <img src="../../assets/imgs/icones/img.svg" alt="Ícone de usuário" class="mb-3 foto-perfil">
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
                        <input type="radio" id="star1" name="rate" value="1" />
                        <label for="star1" title="1 estrela">★</label>
                    </div>
                </div>
                <!-- Final Avaliação Estrelas -->
                <!-- Botões -->
                <!-- Botão Agenda -->
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary botaoVerificaDisponibilidade" data-toggle="modal" data-target="#calendarModal">
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
            <!-- Dados Prestador -->
            <div class="col-sm-8 mt-2">
                <div class="col-sm-12 mt-2" style="padding-left: 0;">
                    <h3 class="text-left mt-12">Nome Prestador<img width="5%" height="5%" src="https://img.icons8.com/color/48/verified-badge.png" alt="verified-badge" /></h3>
                    <h5 class="text-left mt-6">Cidade</h5>
                </div>
                <div class="row" style="margin: 1%;">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sobre-nome">Sobrenome</label>
                                <input type="text" class="form-control" id="sobre-nome" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="seguimento">Seguimento</label>
                                <select class="form-control" id="seguimento" required>
                                    <option value="" disabled selected>Selecione um seguimento</option>
                                    <option value="teste">Aqui vem do banco</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="celular">Celular</label>
                                <input type="text" class="form-control" id="celular" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telefone">Telefone</label>
                                <input type="text" class="form-control" id="telefone">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cep">CEP</label>
                                <input type="text" class="form-control" id="cep" requireds>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep" target="_blank">Não sei meu Cep</a>
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="senha">Senha</label>
                                <input type="password" id="senha" class="form-control" aria-describedby="passwordHelpBlock" required>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Your password must be 8-20 characters long,
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirma-senha">Confirma Senha</label>
                                <input type="password" id="cofirma-senha" class="form-control" aria-describedby="passwordHelpBlock">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Your password must be 8-20 characters long
                                </small>
                            </div>

                        </div>
                </div>

                <button type="submit" class="btn btn-primary" style="background-color: #012640; color:white ">Salvar</button>

                <button id="btnCadastroProduto" type="button" class="btn btn-primary" style="background-color: #012640; color:white">Novo Serviço</button>

                </form>

            </div>
        </div>
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
        <!-- Final Modal -->
        <!-- Inicio anuncios Destaque -->
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
        <!-- Final anuncios Destaque -->

    </div>
    <?php
    include '../../padroes/footer.php';
    ?>
    <!-- Cards de Ser -->
    <!-- Final Cards de Ser -->
    <!-- Inicio Seção das avaliações -->
    <!-- Final Seção das Avaliações-->

    <!-- Inicio de Scroll de Serviços -->
    <!-- Final de Scroll de Serviços -->

    <!-- Final Corpo da pagina -->
    <!-- Inicio do Footer -->
    <!-- Final do Footer -->

    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script src="../../assets/js/modal_calendario.js"></script>
    <script src="../../assets/js/whats_link.js"></script>
    <script src="../../assets/js/valida_informacoes.js"></script>

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
 
        // Adiciona um evento de clique ao botão
        document.getElementById("btnCadastroProduto").addEventListener("click", function() {
            // Redireciona para telaCadastroProduto.php
            window.location.href = "telaCadastroProduto.php";
        });
    </script>

</body>

</html>