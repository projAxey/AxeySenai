<?php

class Page {
    public function render() {
        $this->head();
        echo '<body class="bodyCards">';
        $this->nav();
        echo '<div class="main-container">';
        $this->Container();
        $this->footer();
        echo '</div>';
        echo $this->getScripts();
        echo '</body></html>';
    }

    private function head() {
        include '../../padroes/head.php';
    }

    private function nav() {
        include '../../padroes/nav.php';
    }

    private function Container() {
        echo '<div class="py-3">
                <div class="main container d-flex flex-column flex-md-row">';
        $this->carousel();
        $this->mainGroup();
        echo '</div></div>';
        $this->servicesSection();
        $this->modals();
        $this->popupForm();
    }

    private function carousel() {
        $carousel_images = [
            "../../assets/imgs/imgTeste.png",
            "../../assets/imgs/imgTeste.png",
            "../../assets/imgs/imgTeste.png"
        ];

        echo '<div id="separa-divs">
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">';

        foreach ($carousel_images as $index => $image) {
            echo '<div class="carousel-item ' . ($index === 0 ? 'active' : '') . '">
                    <img src="' . $image . '" class="carousel-img" alt="...">
                </div>';
        }

        echo '  </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>';
    }

    private function mainGroup() {
        echo '<div class="main-group-func container flex-wrap object-fit d-flex align-self-center">
                <div class="container d-flex justify-content-center mt-3 mb-3 imgPrestadorAnuncio">
                    <img src="../../assets/imgs/ruivo.png" alt="" class="rounded-circle">
                </div>
                <div class="legenda container text-center mb-3">
                    <p>Descricao do prestador Descricao do prestador Descricao do prestador Descricao do prestador Descricao do prestador Descricao do prestador Descricao do prestador Descricao do prestador</p>
                </div>
                <div class="buttom-gourp d-flex flex-column container text-center">
                    <a href="../prestador/TelaPerfilPrestador.php" type="submit" class="btn btn-success"><span></span>Entre em contato</a>
                    <div class="group-buttom d-flex flex-column py-2">
                        <button type="button" id="show-calendar" class="btn btn-primary botaoVerificaDisponibilidade" data-toggle="modal" data-target="#calendarModal">
                            <i class="fa-regular fa-calendar"></i> Verificar Disponibilidade 
                        </button>
                    </div>
                </div>
            </div>';
    }

    private function servicesSection() {
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

        echo '<div class="services-container-wrapper container containerCards">
                <div class="tituloServicos">
                    <h3 class="titulo">Serviços em destaque</h3>
                </div>
                <button class="arrow fechaEsquerda flecha" onclick="scrollCards(\'.container1\', -1)">&#9664;</button>
                <div class="services-container container1 containerServicos">';

        foreach ($servicos as $id => $title) {
            echo '<div class="card cardServicos">
                    <img src="../../assets/imgs/testeimg2.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">' . $title . '</h5>
                        <p class="card-text">Descrição breve do ' . $title . '.</p>
                        <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                    </div>
                </div>';
        }

        echo '  </div>
                <button class="arrow flechaDireita flecha" onclick="scrollCards(\'.container1\', 1)">&#9654;</button>
            </div>';
    }

    private function modals() {
        echo '<div id="calendarModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="calendar"></div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel"
                aria-hidden="true">
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
            </div>';
    }

    private function popupForm() {
        echo '<!-- O Formulário Pop-up -->
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
                    <div class="d-flex justify-content-between">
                        <button type="submit" id="saveEvent" class="btn btn-primary" style="width: 45%;">Salvar</button>
                        <button type="button" class="btn btn-secondary close-popup" style="width: 45%;">Fechar</button>
                    </div>
                </form>
            </div>';
    }

    private function footer() {
        include '../../padroes/footer.php';
    }

    private function getScripts() {
        return '
            <script>
                function scrollCards(containerSelector, direction) {
                    const container = document.querySelector(containerSelector);
                    const cardWidth = container.querySelector(\'.cardServicos\').offsetWidth;
                    container.scrollBy({
                        left: direction * cardWidth,
                        behavior: \'smooth\'
                    });
                }
            </script>
            <script src="../../assets/JS/calendario.js"></script>';
    }
}

$page = new Page();
$page->render();
