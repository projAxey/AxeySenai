<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../layouts/head.php';
include '../layouts/nav.php';
?>

<style>
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

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

    @media (min-width: 576px) {
        .back-to-index {
            display: none;
        }
    }
</style>


<body class="fundoTela">



    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <form method="get" class="d-inline-block">
                    <div class="form-group mb-0 mt-3">
                        <label for="sort_by" class="mr-2">Ordenar por:</label>
                        <select id="sort_by" name="sort_by" onchange="this.form.submit()" class="form-control d-inline-block w-auto">
                            <option value="recent" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'recent') ? 'selected' : ''; ?>>Mais recentes</option>
                            <option value="name" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'name') ? 'selected' : ''; ?>>Nome (A-Z)</option>
                            <option value="name_desc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'name_desc') ? 'selected' : ''; ?>>Nome (Z-A)</option>
                            <option value="category" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'category') ? 'selected' : ''; ?>>Categoria</option>
                            <option value="location" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] == 'location') ? 'selected' : ''; ?>>Localização</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <?php
            include '../../config/conexao.php';

            $categoria_id = isset($_GET['categoria_id']) ? intval($_GET['categoria_id']) : null;
            $palavra = isset($_GET['palavra']) ? trim($_GET['palavra']) : null;

            $query = "SELECT p.nome_produto, p.categoria, p.imagem_produto, c.titulo_categoria, produto_id
                      FROM Produtos p
                      JOIN Categorias c ON p.categoria = c.categoria_id
                      WHERE 1=1";

            if ($categoria_id !== null) {
                $query .= " AND c.categoria_id = :categoria_id";
            }

            if ($palavra !== null) {
                $query .= " AND (p.nome_produto LIKE :palavra OR p.descricao_produto LIKE :palavra)";
            }

            $stmt = $conexao->prepare($query);

            if ($categoria_id !== null) {
                $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
            }

            if ($palavra !== null) {
                $palavraParam = '%' . $palavra . '%';
                $stmt->bindParam(':palavra', $palavraParam, PDO::PARAM_STR);
            }

            $stmt->execute();
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($services)) {
                echo '<div class="container mt-2"><p>Nenhum serviço encontrado.</p></div>';
            } else {
                foreach ($services as $service) {
                    // Verifica se a coluna de imagem contém mais de uma imagem separada por vírgula
                    $imagens = explode(',', $service['imagem_produto']);
                    // Pega apenas a primeira imagem da lista
                    $primeiraImagem = trim($imagens[0]);

                    echo "
                    <div class='col-12 col-sm-6 col-lg-3 mb-4'>
                        <div class='card cardServicos h-100'>
                            <img src='/projAxeySenai/" . htmlspecialchars($primeiraImagem) . "' alt='Imagem do produto' class='card-img-top'>
                            <div class='card-body'>
                                <h5 class='card-title-servicos'>" . htmlspecialchars($service['nome_produto']) . "</h5>
                                <p class='card-text-servicos'>" . htmlspecialchars($service['titulo_categoria']) . "</p>
                                <a href='/projAxeySenai/frontend/cliente/telaAnuncio.php?id=" . htmlspecialchars($service['produto_id']) . "' class='btn btn-primary btnSaibaMais'>Saiba mais</a>
                            </div>
                        </div>
                    </div>";
                }
            }
            ?>
        </div>
    </div>

    <a href="#top" class="back-to-index" id="back-to-index">
        <i class="fas fa-arrow-up" id="back-to-index-icon"></i>
    </a>

    <script>
        document.addEventListener("scroll", function() {
            var scrollPosition = window.scrollY + window.innerHeight;
            var documentHeight = document.documentElement.scrollHeight;
            var button = document.getElementById("back-to-index");
            var icon = document.getElementById("back-to-index-icon");

            if (scrollPosition >= documentHeight - 30) {
                button.href = "/projAxeySenai/index.php";
                icon.className = "fas fa-home";
            } else {
                button.href = "#top";
                icon.className = "fas fa-arrow-up";
            }
        });
    </script>

    <?php include '../layouts/footer.php'; ?>

</body>

</html>