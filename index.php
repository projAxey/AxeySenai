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

            <div id="servicos-em-destaque" class="services-container-wrapper container containerCards mb-4">
                <div class="tituloServicos">
                    <h2>Serviços em destaque</h2>
                </div>
                <div class="d-flex align-items-center">
                    <button class="arrow fechaEsquerda flecha me-2">&#9664;</button>
                    <div class="services-container containerServicos d-flex">
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img1.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 1</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 1.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img2.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 2</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 2.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img3.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 3</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 3.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img4.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 4</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 4.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img5.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 5</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 5.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img6.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 6</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 6.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img7.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 7</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 7.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/testeimg2.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 8</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 8.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                    </div>
                    <button class="arrow flechaDireita flecha ms-2">&#9654;</button>
                </div>
            </div>

            <div id="servicos-mais-visitados" class="services-container-wrapper container containerCards mb-4">
                <div class="tituloServicos">
                    <h2>Serviços mais visitados</h2>
                </div>
                <div class="d-flex align-items-center">
                    <button class="arrow fechaEsquerda flecha me-2">&#9664;</button>
                    <div class="services-container containerServicos d-flex">
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img1.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 1</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 1.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img2.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 2</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 2.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img3.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 3</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 3.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img4.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 4</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 4.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img5.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 5</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 5.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img6.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 6</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 6.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/imgTeste/img7.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 7</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 7.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="assets/imgs/testeimg2.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 8</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 8.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                    </div>
                    <button class="arrow flechaDireita flecha ms-2">&#9654;</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        include 'frontend/layouts/footer.php';
    ?>
    <script src="assets/js/servicos.js"></script>
</body>
</html>