<?php
include 'frontend/layouts/nav.php';
include 'frontend/layouts/head.php';
include 'config/conexao.php';

// Criando a conexão PDO
try {

    // Buscando as imagens da tabela Banners
    $sql = "SELECT image FROM Banners WHERE data_final > CURDATE()";
    $stmt = $conexao->query($sql);

    // Armazenando os banners
    $banners = [];
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $banners[] = $row['image'];
        }
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<body class="bodyCards">
    <div class="main-container">
        <div class="container-fluid p-0">

            <!-- Carrossel -->
            <div id="carouselExampleIndicators" class="carousel slide carrosselServicos" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <?php foreach ($banners as $index => $banner): ?>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index == 0 ? 'active' : ''; ?>"></li>
                    <?php endforeach; ?>
                </ol>
                <div class="carousel-inner">
                    <?php foreach ($banners as $index => $banner): ?>
                        <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?> carrosselItem">
                            <img class="d-block w-100" src="<?php echo $banner; ?>" alt="Banner <?php echo $index + 1; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </a>
            </div>

            <!-- Categorias -->
            <?php

            $query = "SELECT categoria_id, titulo_categoria, icon FROM Categorias WHERE status = 1";
            $stmt = $conexao->prepare($query);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($categories)) {
                echo '<div class="container-fluid categorias"><p>Nenhuma categoria encontrada.</p></div>';
                return;
            }

            echo '<div class="container-fluid categorias">';
            echo '<button class="seta-esquerda">&#9664;</button>';
            echo '<div class="categorias-container d-flex flex-nowrap justify-content-start">';

            foreach ($categories as $category) {
                $url = 'frontend/cliente/todosServicos.php?categoria_id=' . $category['categoria_id'];

                echo "
            <a href='{$url}' class='category-card cardsCategorias p-2' style='text-decoration: none;'>
                <div class='category-icon iconeCategoria mt-2'>
                    <i class='" . htmlspecialchars($category['icon']) . "'></i>
                </div>
                <div class='titiloCategoria mt-2'>{$category['titulo_categoria']}</div>
            </a>";
            }

            echo '</div>';
            echo '<button class="seta-direita">&#9654;</button>';
            echo '</div>';
            ?>

            <?php
            servicesSection("Serviços em destaque", getServicesDestques(), "servicos-em-destaque");
            servicesSection("Serviços disponíveis", getServices(), "servicos-mais-visitados");

            function servicesSection($title, $services, $sectionId)
            {
                echo "<div id='{$sectionId}' class='services-container-wrapper container containerCards'>";
                echo "<div class='tituloServicos'><h2>{$title}</h2></div>";
                echo '<div class="d-flex align-items-center">';
                echo "<button class='arrow flechaEsquerda flecha me-2'>&#9664;</button>";
                echo '<div class="services-container containerServicos d-flex">';


                foreach ($services as $service) {
                    $imagens = explode(',', $service['imagem_produto']);
                    $primeiraImagem = trim($imagens[0]);

                    echo "
    <div class='card cardServicos mx-2 mb-3'>
        <img src='/projAxeySenai/{$primeiraImagem}' alt='Imagem do produto'>
        <div class='card-body'>
            <h5 class='card-title-servicos'>{$service['nome_produto']}</h5>
            <p class='card-text'>{$service['titulo_categoria']}</p>
            <p class='card-text'>R$ " . number_format($service['valor_produto'], 2, ',', '.') . "</p>
            <a href='/projAxeySenai/frontend/cliente/telaAnuncio.php?id={$service['produto_id']}' class='btn btn-primary btnSaibaMais'>Saiba mais</a>
        </div>
    </div>";
                }

                echo '</div>';
                echo "<button class='arrow flechaDireita flecha ms-2'>&#9654;</button>";
                echo '</div></div>';
            }


            function getServices()
            {
                include 'config/conexao.php';

                $query = "SELECT c.titulo_categoria, p.produto_id, p.prestador, p.categoria, p.tipo_produto, p.nome_produto, p.valor_produto, p.descricao_produto, p.imagem_produto 
                FROM Produtos p 
                JOIN Categorias c ON p.categoria = c.categoria_id  
                WHERE p.status = 2 AND p.status_destaque = 1";

                $stmt = $conexao->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna os produtos


            }

            function getServicesDestques()
            {
                include 'config/conexao.php';

                $query = "SELECT c.titulo_categoria, p.produto_id, p.prestador, p.categoria, p.tipo_produto, p.nome_produto, p.valor_produto, p.descricao_produto, p.imagem_produto 
                FROM Produtos p 
                JOIN Categorias c ON p.categoria = c.categoria_id  
                WHERE p.status = 2 AND p.status_destaque = 2";

                $stmt = $conexao->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna os produtos
            }
            ?>

        </div>

    </div>
    <script src="/projAxeySenai/assets/js/servicos.js"></script>
    <?php
    include 'frontend/layouts/footer.php';
    ?>
</body>