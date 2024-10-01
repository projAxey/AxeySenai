
<?php

class Page
{
    public function render()
    {
        $this->head();
        echo '<body class="fundoTela">';
        $this->nav();
        $this->backToIndexButton();
        $this->serviceContainer();
        $this->footer();
        echo '</body></html>';
    }

    private function head()
    {
        // Adiciona a inclusão do Font Awesome
        echo '<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">';
        echo '<style>
                .card-hover:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }
                .card-hover {
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }

                /* Pop-up circular no mobile */
                .back-to-index {
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    width: 60px;
                    height: 60px;
                    background-color: #007bff;
                    color: #fff;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 24px;
                    z-index: 1000;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                }

                .back-to-index:hover {
                    background-color: #0056b3;
                }

                /* Mostrar somente em dispositivos móveis */
                @media (min-width: 576px) {
                    .back-to-index {
                        display: none;
                    }
                }
              </style>';
        include '../layouts/head.php';
    }

    private function nav()
    {
        include '../layouts/nav.php';
    }

    private function serviceContainer()
    {
        // Dados simulados
        $services = [
            ['name' => 'Aplicador Piso', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-26'],
            ['name' => 'Projetista', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-20'],
            ['name' => 'Mestre de Obras', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-22'],
            ['name' => 'Encanador', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-18'],
            ['name' => 'Cheff', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-21'],
            ['name' => 'Pintor', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-25'],
            ['name' => 'Marceneiro', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-17'],
            ['name' => 'Eletricista', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-23'],
            ['name' => 'Arquiteto', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-24'],
            ['name' => 'Jardineiro', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-15'],
            ['name' => 'Pedreiro', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-16'],
            ['name' => 'Serralheiro', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-14'],
            // ['name' => 'Aplicador Piso', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-26'],
            // ['name' => 'Projetista', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-20'],
            // ['name' => 'Mestre de Obras', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-22'],
            // ['name' => 'Encanador', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-18'],
            // ['name' => 'Cheff', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-21'],
            // ['name' => 'Pintor', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-25'],
            // ['name' => 'Marceneiro', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-17'],
            // ['name' => 'Eletricista', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-23'],
            // ['name' => 'Arquiteto', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-24'],
            // ['name' => 'Jardineiro', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-15'],
            // ['name' => 'Pedreiro', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-16'],
            // ['name' => 'Serralheiro', 'category' => 'Categoria', 'location' => 'Joinville - SC', 'image' => 'https://via.placeholder.com/150', 'date' => '2024-08-14'],
        ];

        // Obtém o critério de ordenação da requisição (se houver)
        $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'recent';

        echo '
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-user-circle"></i> João Antonio da Rosa</h2>
                    <p>' . count($services) . ' serviços</p>
                </div>
                <div>
                    <form method="get" class="d-inline-block">
                        <div class="form-group mb-0">
                            <label for="sort_by" class="mr-2">Ordenar por:</label>
                            <select id="sort_by" name="sort_by" onchange="this.form.submit()" class="form-control d-inline-block w-auto">
                                <option value="recent"' . ($sortBy == 'recent' ? ' selected' : '') . '>Mais recentes</option>
                                <option value="name"' . ($sortBy == 'name' ? ' selected' : '') . '>Nome (A-Z)</option>
                                <option value="name_desc"' . ($sortBy == 'name_desc' ? ' selected' : '') . '>Nome (Z-A)</option>
                                <option value="category"' . ($sortBy == 'category' ? ' selected' : '') . '>Categoria</option>
                                <option value="location"' . ($sortBy == 'location' ? ' selected' : '') . '>Localização</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">';
        $this->serviceCards($services, $sortBy);
        echo '  </div>
            </div>';
    }

    private function serviceCards($services, $sortBy)    {
        // Função de comparação para ordenação
        usort($services, function ($a, $b) use ($sortBy) {
            switch ($sortBy) {
                case 'name_desc':
                    return strcmp($b['name'], $a['name']);
                case 'recent':
                    return strcmp($b['date'], $a['date']);
                case 'category':
                case 'location':
                case 'name':
                    return strcmp($a[$sortBy], $b[$sortBy]);
                default:
                    return strcmp($a['name'], $b['name']);
            }
        });

        // Renderizando os cards
        foreach ($services as $service) {
            echo '
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <a href="telaAnuncio.php?service=' . urlencode($service['name']) . '" class="text-decoration-none">
                    <div class="card h-100 card-hover">
                        <img src="' . $service['image'] . '" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-dark">' . $service['name'] . '</h5>
                            <p class="card-text text-dark">' . $service['category'] . '</p>
                            <p class="card-text"><small class="text-muted">' . $service['location'] . '</small></p>
                        </div>
                    </div>
                </a>
            </div>';
        }
    }


    private function backToIndexButton()
    {
        echo '
        <a href="#top" class="back-to-index" id="back-to-index">
            <i class="fas fa-arrow-up" id="back-to-index-icon"></i>
        </a>
        <script>
            document.addEventListener("scroll", function() {
                var scrollPosition = window.scrollY + window.innerHeight;
                var documentHeight = document.documentElement.scrollHeight;
                var button = document.getElementById("back-to-index");
                var icon = document.getElementById("back-to-index-icon");

                if (scrollPosition >= documentHeight - 30) { // Pequena margem para compensar arredondamento
                    // No fim da página
                    button.href = "/projAxeySenai/index.php"; // Substitua com a URL da sua área de trabalho
                    icon.className = "fas fa-home";
                } else {
                    // Não no fim da página
                    button.href = "#top";
                    icon.className = "fas fa-arrow-up";
                }
            });
        </script>';
    }

    private function footer()
    {
        include '../layouts/footer.php';
    }
}

$page = new Page();
$page->render();
