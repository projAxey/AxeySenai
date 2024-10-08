<?php
include 'frontend/layouts/head.php';
include 'frontend/layouts/nav.php';
?>

<body class="bodyCards">
    <div class="main-container">
        <div class="container-fluid p-0">

            <div id="carouselExampleIndicators" class="carousel slide carrosselServicos mb-4">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
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
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </a>
            </div>

            <div class="container-fluid categorias mb-4">
                <div class="d-flex flex-nowrap justify-content-center">
                    <a href="frontend/cliente/todosServicos.php" class="category-card cardsCategorias p-2 mx-2">
                        <div class="category-icon iconeCategoria">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <div class="mt-2">Tecnologia</div>
                    </a>
                    <a href="frontend/cliente/todosServicos.php" class="category-card cardsCategorias p-2 mx-2">
                        <div class="category-icon iconeCategoria">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="mt-2">Culinária</div>
                    </a>
                    <a href="frontend/cliente/todosServicos.php" class="category-card cardsCategorias p-2 mx-2">
                        <div class="category-icon iconeCategoria">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="mt-2">Saúde</div>
                    </a>
                    <a href="frontend/cliente/todosServicos.php" class="category-card cardsCategorias p-2 mx-2">
                        <div class="category-icon iconeCategoria">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="mt-2">Casa</div>
                    </a>
                    <a href="frontend/cliente/todosServicos.php" class="category-card cardsCategorias p-2 mx-2">
                        <div class="category-icon iconeCategoria">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="mt-2">Automóveis</div>
                    </a>
                    <a href="frontend/cliente/todosServicos.php" class="category-card cardsCategorias p-2 mx-2">
                        <div class="category-icon iconeCategoria">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="mt-2">Educação</div>
                    </a>
                    <a href="frontend/cliente/todosServicos.php" class="category-card cardsCategorias p-2 mx-2">
                        <div class="category-icon iconeCategoria">
                            <i class="fas fa-paw"></i>
                        </div>
                        <div class="mt-2">Pets</div>
                    </a>
                    <a href="frontend/cliente/todosServicos.php" class="category-card cardsCategorias p-2 mx-2">
                        <div class="category-icon iconeCategoria">
                            <i class="fas fa-plane"></i>
                        </div>
                        <div class="mt-2">Viagens</div>
                    </a>
                </div>
            </div>
   
       private function carousel()
       {
           echo '
           <div id="carouselExampleIndicators" class="carousel slide carrosselServicos mb-4">
               <ol class="carousel-indicators">
                   <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                   <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                   <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
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
               <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                   <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                   <span class="visually-hidden">Anterior</span>
               </a>
               <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                   <span class="carousel-control-next-icon" aria-hidden="true"></span>
                   <span class="visually-hidden">Próximo</span>
               </a>
           </div>';
       }
   
       private function categories()
{    
    include 'config/conexao.php';

    // Consulta para pegar os produtos com status 2
    $query = "SELECT categoria_id, titulo_categoria FROM Categorias"; // Incluindo o id_categoria na consulta
    $stmt = $conexao->prepare($query);
    $stmt->execute();
    
    // Busca os resultados e armazena em um array
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Se não houver categorias, exibir mensagem ou não fazer nada
    if (empty($categories)) {
        echo '<div class="container-fluid categorias mb-4"><p>Nenhuma categoria encontrada.</p></div>';
        return;
    }

    echo '<div class="container-fluid categorias mb-4"><div class="d-flex flex-nowrap justify-content-center">';
    
    // Para cada categoria, gerar o HTML
    foreach ($categories as $category) {
        // Ajustando a URL para incluir o id da categoria
        $url = 'frontend/cliente/todosServicos.php?categoria_id=' . $category['categoria_id']; // Adicionando o id da categoria na URL
        $icon = 'fas fa-folder'; // Ícone padrão, você pode ajustar isso com base na categoria

        echo "
        <a href='{$url}' class='category-card cardsCategorias p-2 mx-2' style='text-decoration: none;'>
            <div class='category-icon iconeCategoria'>
                <i class='{$icon}'></i>
            </div>
            <div class='mt-2'>{$category['titulo_categoria']}</div>
        </a>";
    }
    
    echo '</div></div>';
}
   
       private function servicesSection($title, $services, $sectionId)
       {
           echo "<div id='{$sectionId}' class='services-container-wrapper container containerCards mb-4'>";
           echo "<div class='tituloServicos'><h2>{$title}</h2></div>";
           echo '<div class="d-flex align-items-center">';
           echo "<button class='arrow fechaEsquerda flecha me-2'>&#9664;</button>";
           echo '<div class="services-container containerServicos d-flex">';
   
           foreach ($services as $service) {
               echo "
               <div class='card cardServicos mx-2'>
                   <img src='{$service['imagem_produto']}' alt='...'>
                   <div class='card-body'>
                       <h5 class='card-title-servicos'>{$service['nome_produto']}</h5>
                       <p class='card-text-servicos'>{$service['categoria']}</p>
                       <a href='frontend/cliente/telaAnuncio.php' class='btn btn-primary btnSaibaMais'>Saiba mais</a>
                   </div>
               </div>";
           }
   
           echo '</div>';
           echo "<button class='arrow flechaDireita flecha ms-2'>&#9654;</button>";
           echo '</div></div>';
       }
   
       private function getServices()
       {
        include 'config/conexao.php';

        $query = "SELECT produto_id, prestador, categoria, tipo_produto, nome_produto, valor_produto, descricao_produto, imagem_produto FROM Produtos WHERE status = 2";
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna os produtos
       }
   }
   
   $page = new Page();
   $page->render();
   ?> 

