<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../layouts/head.php';

?>
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
        // include '../../padroes/head.php';
    }

    private function nav()
    {
        include '../layouts/nav.php';
    }

    private function serviceContainer()
{
    include '../../config/conexao.php'; // Inclua a conexão com o banco de dados

    $categoria_id = null;
    $palavra = null;

    // Verifica se 'categoria_id' está na URL
    if (isset($_GET['categoria_id'])) {
        $categoria_id = intval($_GET['categoria_id']); // Obtém o ID da categoria
    }

    // Verifica se 'palavra' está na URL
    if (isset($_GET['palavra'])) {
        $palavra = trim($_GET['palavra']); // Obtém a palavra e remove espaços em branco
    }

    // Consulta inicial
    $query = "SELECT p.nome_produto, p.categoria, p.imagem_produto, c.titulo_categoria
              FROM Produtos p
              JOIN Categorias c ON p.categoria = c.categoria_id
              WHERE 1=1"; // Usar 1=1 para facilitar a adição de condições dinâmicas

    // Adiciona a condição da categoria, se presente
    if ($categoria_id !== null) {
        $query .= " AND c.categoria_id = :categoria_id";
    }

    // Adiciona a condição da palavra, se presente
    if ($palavra !== null) {
        $query .= " AND (p.nome_produto LIKE :palavra OR p.descricao_produto LIKE :palavra)";
    }

    $stmt = $conexao->prepare($query);

    // Vincula o parâmetro da categoria, se presente
    if ($categoria_id !== null) {
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
    }

    // Vincula o parâmetro da palavra, se presente
    if ($palavra !== null) {
        $palavraParam = '%' . $palavra . '%'; // Usar % para buscar partes da palavra
        $stmt->bindParam(':palavra', $palavraParam, PDO::PARAM_STR);
    }

    $stmt->execute();
    
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC); // Busca os serviços

    // Se não houver serviços, exibe mensagem
    if (empty($services)) {
        echo '<div class="container mt-2"><p>Nenhum serviço encontrado.</p></div>';
        return;
    }

    // Renderização da interface
    $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'recent';

    echo '
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <form method="get" class="d-inline-block">
                    <div class="form-group mb-0 mt-3">
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

    $this->serviceCards($services, $sortBy); // Chama a função que renderiza os cards de serviço

    echo '  </div>
        </div>';
}


    private function serviceCards($services, $sortBy)
    {
        // Renderizando os cards
        foreach ($services as $service) {
            echo '
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <a href="#" class="text-decoration-none">
                    <div class="card h-100 card-hover">
                        <img src="../../' . $service['imagem_produto'] . '" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-dark">' . $service['nome_produto'] . '</h5>
                            <p class="card-text text-dark">' . $service['titulo_categoria'] . '</p>
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
