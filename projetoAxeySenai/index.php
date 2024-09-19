<?php
   class Page
   {
       public function render()
       {
           $this->head();
           echo '<body class="bodyCards">';
           $this->nav();
           echo '<div class="main-container">'; // Container principal centralizado
           echo '<div class="container-fluid p-0">';
           $this->carousel();
           $this->categories();
           $this->servicesSection("Serviços em destaque", $this->getServices(), "servicos-em-destaque");
           $this->servicesSection("Serviços mais visitados", $this->getServices(), "servicos-mais-visitados");
           echo '</div>';
           $this->footer();    
           echo '</div>';
           
           echo $this->getScripts();
           echo '</body>';
       }
   
       private function head()
       {
           include 'frontend/layouts/head.php';
       }
   
       private function nav()
       {
           include 'frontend/layouts/nav.php';
       }
   
       private function footer()
       {
           include 'frontend/layouts/footer.php';
       }
   
       private function getScripts()
       {
           return '
           <script>
       function scrollCards(containerSelector, direction) {
           const container = document.querySelector(containerSelector + " .services-container");
           const cards = container.querySelectorAll(".cardServicos");
           const cardWidth = cards[0].offsetWidth;
   
           if (direction === 1) { // Direita
               container.scrollBy({
                   left: cardWidth,
                   behavior: "smooth"
               });
               setTimeout(function() {
                   container.appendChild(cards[0]);
                   container.scrollLeft -= cardWidth;
               }, 300); // Tempo do movimento, ajustado para corresponder à animação
           } else if (direction === -1) { // Esquerda
               container.scrollLeft += cardWidth;
               setTimeout(function() {
                   container.insertBefore(cards[cards.length - 1], cards[0]);
                   container.scrollBy({
                       left: -cardWidth,
                       behavior: "smooth"
                   });
               }, 0);
           }
       }
   
       document.addEventListener("DOMContentLoaded", function() {
           document.querySelectorAll(".arrow").forEach(function(button) {
               button.addEventListener("click", function() {
                   const direction = this.classList.contains("flechaDireita") ? 1 : -1;
                   const containerId = this.closest(".services-container-wrapper").id;
                   scrollCards("#" + containerId, direction);
               });
           });
       });
   
       // Para garantir que o carrossel funcione bem em dispositivos móveis
       function adjustCarouselForMobile() {
           const containers = document.querySelectorAll(".services-container");
           containers.forEach(container => {
               const containerWidth = container.offsetWidth;
               const cardWidth = container.querySelector(".cardServicos").offsetWidth;
               const cardCount = container.querySelectorAll(".cardServicos").length;
               
               if (cardWidth * cardCount < containerWidth) {
                   container.style.overflowX = "scroll"; // Ativa a rolagem se o carrossel não ocupar toda a largura
               }
           });
       }
   
       window.addEventListener("resize", adjustCarouselForMobile);
       document.addEventListener("DOMContentLoaded", adjustCarouselForMobile);
   </script>';
       }
   
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
           $categories = [
               ['icon' => 'fas fa-laptop', 'name' => 'Tecnologia', 'url' => 'paginas/adm/principal.php'],
               ['icon' => 'fas fa-utensils', 'name' => 'Culinária', 'url' => 'culinaria.php'],
               ['icon' => 'fas fa-heart', 'name' => 'Saúde', 'url' => 'saude.php'],
               ['icon' => 'fas fa-home', 'name' => 'Casa', 'url' => 'casa.php'],
               ['icon' => 'fas fa-car', 'name' => 'Automóveis', 'url' => 'automoveis.php'],
               ['icon' => 'fas fa-book', 'name' => 'Educação', 'url' => 'educacao.php'],
               ['icon' => 'fas fa-paw', 'name' => 'Pets', 'url' => 'pets.php'],
               ['icon' => 'fas fa-plane', 'name' => 'Viagens', 'url' => 'viagens.php'],
           ];
   
           echo '<div class="container-fluid categorias mb-4"><div class="d-flex flex-nowrap justify-content-center">';
           foreach ($categories as $category) {
               echo "
               <a href='{$category['url']}' class='category-card cardsCategorias p-2 mx-2'>
                   <div class='category-icon iconeCategoria'>
                       <i class='{$category['icon']}'></i>
                   </div>
                   <div class='mt-2'>{$category['name']}</div>
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
                   <img src='{$service['img']}' alt='...'>
                   <div class='card-body'>
                       <h5 class='card-title-servicos'>{$service['title']}</h5>
                       <p class='card-text-servicos'>{$service['description']}</p>
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
           return [
               ['title' => 'Serviço 1', 'description' => 'Descrição breve do Serviço 1.', 'img' => 'assets/imgs/imgTeste/img1.png'],
               ['title' => 'Serviço 2', 'description' => 'Descrição breve do Serviço 2.', 'img' => 'assets/imgs/imgTeste/img2.png'],
               ['title' => 'Serviço 3', 'description' => 'Descrição breve do Serviço 3.', 'img' => 'assets/imgs/imgTeste/img3.png'],
               ['title' => 'Serviço 4', 'description' => 'Descrição breve do Serviço 4.', 'img' => 'assets/imgs/imgTeste/img4.png'],
               ['title' => 'Serviço 5', 'description' => 'Descrição breve do Serviço 5.', 'img' => 'assets/imgs/imgTeste/img5.png'],
               ['title' => 'Serviço 6', 'description' => 'Descrição breve do Serviço 6.', 'img' => 'assets/imgs/imgTeste/img6.png'],
               ['title' => 'Serviço 7', 'description' => 'Descrição breve do Serviço 7.', 'img' => 'assets/imgs/imgTeste/img7.png'],
               ['title' => 'Serviço 8', 'description' => 'Descrição breve do Serviço 8.', 'img' => 'assets/imgs/testeimg2.png'],
           ];
       }
   }
   
   $page = new Page();
   $page->render();
   ?>