<?php

class Page {
    public function render() {
        $this->head();
        echo '<body class="bodyCards">';
        $this->nav();
        echo '<div class="main-container">';
        $this-> Container();
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
                    <div class="group-buttom d-flex flex-column py-2">
                        <a type="submit" class="btn btn-primary">Verificar disponibilidade</a>
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
            </script>';
    }
}

$page = new Page();
$page->render();
