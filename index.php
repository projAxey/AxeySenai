<?php
class Page {
    public function render() {
        $this->head();
        echo '<body class="bodyCards">';
        $this->nav();
        echo '<div class="container-fluid p-0 justify-content-center">';
        $this->carousel();
        $this->categories();
        $this->servicesSection("Serviços em destaque", $this->getServices());
        $this->servicesSection("Serviços mais visitados", $this->getServices());
        echo '</div>';
        $this->footer();
        echo $this->getScripts();
        echo '</body>';
    }

    private function head() {
        include 'padroes/head.php';
    }

    private function nav() {
        include 'padroes/nav.php';
    }

    private function footer() {
        include 'padroes/footer.php';
    }

    private function getScripts() {
        return '
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                function scrollCards(containerSelector, direction) {
                    const container = document.querySelector(containerSelector);
                    const cardWidth = container.querySelector(".cardServicos").offsetWidth;
                    container.scrollBy({
                        left: direction * cardWidth,
                        behavior: "smooth"
                    });
                }

                document.addEventListener("DOMContentLoaded", function() {
                    var carousels = document.querySelectorAll(".carousel");
                    carousels.forEach(function(carousel) {
                        new bootstrap.Carousel(carousel);
                    });
                });
            </script>';
    }

    private function carousel() {
        echo '
        <div id="carouselExampleIndicators" class="carousel slide carrosselServicos">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active carrosselItem">
                    <img class="d-block w-100" src="assets/imgs/testeimg1.png" alt="Primeiro slide">
                </div>
                <div class="carousel-item carrosselItem">
                    <img class="d-block w-100" src="assets/imgs/testeimg1.png" alt="Segundo slide">
                </div>
                <div class="carousel-item carrosselItem">
                    <img class="d-block w-100" src="assets/imgs/testeimg1.png" alt="Terceiro slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Próximo</span>
            </a>
        </div>';
    }

    private function categories() {
        $categories = [
            ['icon' => 'fas fa-laptop', 'name' => 'Tecnologia'],
            ['icon' => 'fas fa-utensils', 'name' => 'Culinária'],
            ['icon' => 'fas fa-heart', 'name' => 'Saúde'],
            ['icon' => 'fas fa-home', 'name' => 'Casa'],
            ['icon' => 'fas fa-car', 'name' => 'Automóveis'],
            ['icon' => 'fas fa-book', 'name' => 'Educação'],
            ['icon' => 'fas fa-paw', 'name' => 'Pets'],
            ['icon' => 'fas fa-plane', 'name' => 'Viagens'],
        ];
        echo '<div class="container-fluid categorias"><div class="d-flex flex-nowrap">';
        foreach ($categories as $category) {
            echo "
            <div class='category-card cardsCategorias'>
                <div class='category-icon iconeCategoria'><i class='{$category['icon']}'></i></div>
                <div>{$category['name']}</div>
            </div>";
        }
        echo '</div></div>';
    }

    private function servicesSection($title, $services) {
        echo "<div class='services-container-wrapper container containerCards'>";
        echo "<div class='tituloServicos'><h1>{$title}</h1></div>";
        echo '<button class="arrow fechaEsquerda flecha" onclick="scrollCards(\'.container1\', -1)">&#9664;</button>';
        echo '<div class="services-container container1 containerServicos">';

        foreach ($services as $service) {
            echo "
            <div class='card cardServicos'>
                <img src='{$service['img']}' class='card-img-top' alt='...'>
                <div class='card-body'>
                    <h5 class='card-title'>{$service['title']}</h5>
                    <p class='card-text'>{$service['description']}</p>
                    <a href='paginas/cliente/telaAnuncio.php' class='btn btn-primary btnSaibaMais'>Saiba mais</a>
                </div>
            </div>";
        }
        echo '</div>';
        echo '<button class="arrow flechaDireita flecha" onclick="scrollCards(\'.container1\', 1)">&#9654;</button>';
        echo '</div>';
    }

    private function getServices() {
        return [
            ['title' => 'Serviço 1', 'description' => 'Descrição breve do Serviço 1.', 'img' => 'assets/imgs/testeimg2.png'],
            ['title' => 'Serviço 2', 'description' => 'Descrição breve do Serviço 2.', 'img' => 'assets/imgs/testeimg2.png'],
            ['title' => 'Serviço 3', 'description' => 'Descrição breve do Serviço 3.', 'img' => 'assets/imgs/testeimg2.png'],
            ['title' => 'Serviço 4', 'description' => 'Descrição breve do Serviço 4.', 'img' => 'assets/imgs/testeimg2.png'],
            ['title' => 'Serviço 5', 'description' => 'Descrição breve do Serviço 5.', 'img' => 'assets/imgs/testeimg2.png'],
            ['title' => 'Serviço 6', 'description' => 'Descrição breve do Serviço 6.', 'img' => 'assets/imgs/testeimg2.png'],
            ['title' => 'Serviço 7', 'description' => 'Descrição breve do Serviço 7.', 'img' => 'assets/imgs/testeimg2.png'],
            ['title' => 'Serviço 8', 'description' => 'Descrição breve do Serviço 8.', 'img' => 'assets/imgs/testeimg2.png'],
        ];
    }
}

$page = new Page();
$page->render();
?>
