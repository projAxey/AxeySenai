<?php
include '../layouts/head.php';
include '../layouts/nav.php';
?>

<body class="bodyCards">
    <!-- Inclua aqui o conteúdo do arquivo 'nav.php' -->

    <div class="main-container">
        <div class="py-3">
            <div class="main container d-flex flex-column flex-md-row justify-content-between">
                <!-- Carousel -->
                <div id="separa-divs" class="carousel-container flex-grow-1 me-md-3">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="../../assets/imgs/imgTeste.png" class="carousel-img" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="../../assets/imgs/imgTeste.png" class="carousel-img" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="../../assets/imgs/imgTeste.png" class="carousel-img" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Main Group -->
                <div class="main-group-func container flex-wrap object-fit d-flex align-self-center" style="width: 900px;">
                    <div class="legenda container text-center mb-3">
                        <p>Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto Descricao do produto</p>
                    </div>
                    <div class="buttom-group d-flex flex-column container text-center">
                        <div class="group-button d-flex flex-column py-2">
                            <a type="submit" class="btn btn-primary">Verificar disponibilidade</a>
                        </div>
                    </div>

                    <!-- Prestador Group -->
                    <div class="d-flex align-items-center text-center" style="margin-top: 30px;">
                        <div class="me-3">
                            <img src="../../assets/imgs/ruivo.png" alt="Foto do Prestador" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <strong style="font-size: 1.2rem; margin-bottom: 5px;">João Antonio da Rosa</strong>
                            <div>
                                <a href="telaServicosPrestador.php" class="btn btn-primary" style="padding: 5px 15px; font-size: 1rem;">Ver mais serviços</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div id="servicos-em-destaque" class="services-container-wrapper container containerCards mb-4">
                <div class="tituloServicos">
                    <h2>Serviços em destaque</h2>
                </div>
                <div class="d-flex align-items-center">
                    <button class="arrow fechaEsquerda flecha me-2">&#9664;</button>
                    <div class="services-container containerServicos d-flex">
                        <div class="card cardServicos mx-2">
                            <img src="../../assets/imgs/imgTeste/img1.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 1</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 1.</p>
                                <a href="telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="../../assets/imgs/imgTeste/img2.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 2</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 2.</p>
                                <a href="telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="../../assets/imgs/imgTeste/img3.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 3</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 3.</p>
                                <a href="telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="../../assets/imgs/imgTeste/img4.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 4</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 4.</p>
                                <a href="telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="../../assets/imgs/imgTeste/img5.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 5</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 5.</p>
                                <a href="telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="../../assets/imgs/imgTeste/img6.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 6</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 6.</p>
                                <a href="telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="../../assets/imgs/imgTeste/img7.png" alt="...">
                            <div class="card-body">
                                <h5 class="card-title-servicos">Serviço 7</h5>
                                <p class="card-text-servicos">Descrição breve do Serviço 7.</p>
                                <a href="frontend/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                            </div>
                        </div>
                        <div class="card cardServicos mx-2">
                            <img src="../../assets/imgs/testeimg2.png" alt="...">
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

    <?php
    include '../layouts/footer.php';
    ?>
   <script src="../../assets/js/servicos.js"></script>
</body>

</html>