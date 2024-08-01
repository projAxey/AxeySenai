<?php
include '../../padroes/head.php';
?>

<body class="bodyCards">
    <?php include '../../padroes/nav.php'; ?>


    <div class="py-3">
        <div class="main container d-flex flex-column flex-md-row">
            <div id="separa-divs">

                <div id="carouselExampleAutoplaying" class="carousel slide teste" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../../assets/imgs/imgTeste.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../../assets/imgs/imgTeste.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../../assets/imgs/imgTeste.png" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"></span>
                    </button>
                </div>
            </div>

            <div class="main-group-func container flex-wrap object-fit d-flex align-self-center">
                <div class="icon img-fluid container altera-img d-flex justify-content-center">
                    <img src="../../assets/imgs/user.png" alt="" class="rounded-circle teste">

                </div>
                <div class="legenda container text-center mb-3">
                    <p>illum quae eligendi unde ipsa reiciendis dolor assumenda voluptates recusandae animi nesciunt earum laboriosam.</p>
                </div>

                <div class="buttom-gourp d-flex flex-column container text-center">
                    <a href="../prestador/TelaPerfilPrestador.php" type="submit" class="btn btn-success"><span></span>Entre em contato</a>
                    <div class="group-buttom d-flex flex-column py-2">
                        <a type="submit" class="btn btn-primary">Verificar disponibilidade</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="services-container-wrapper container containerCards">
        <div class="tituloServicos">
            <h1 class="titulo">Serviços em destaque</h1>
        </div>
        <button class="arrow fechaEsquerda flecha" onclick="scrollCards('.container1', -1)">&#9664;</button>
        <div class="services-container container1 containerServicos">
            <div class="card cardServicos">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Serviço 1</h5>
                    <p class="card-text">Descrição breve do Serviço 1.</p>
                    <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                </div>
            </div>
            <div class="card cardServicos">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Serviço 2</h5>
                    <p class="card-text">Descrição breve do Serviço 2.</p>
                    <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                </div>
            </div>
            <div class="card cardServicos">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Serviço 3</h5>
                    <p class="card-text">Descrição breve do Serviço 3.</p>
                    <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                </div>
            </div>
            <div class="card cardServicos">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Serviço 4</h5>
                    <p class="card-text">Descrição breve do Serviço 4.</p>
                    <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                </div>
            </div>
            <div class="card cardServicos">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Serviço 5</h5>
                    <p class="card-text">Descrição breve do Serviço 5.</p>
                    <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                </div>
            </div>
            <div class="card cardServicos">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Serviço 6</h5>
                    <p class="card-text">Descrição breve do Serviço 6.</p>
                    <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                </div>
            </div>
            <div class="card cardServicos">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Serviço 7</h5>
                    <p class="card-text">Descrição breve do Serviço 7.</p>
                    <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                </div>
            </div>
            <div class="card cardServicos">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Serviço 8</h5>
                    <p class="card-text">Descrição breve do Serviço 8.</p>
                    <a href="paginas/cliente/telaAnuncio.php" class="btn btn-primary btnSaibaMais">Saiba mais</a>
                </div>
            </div>
        </div>
        <button class="arrow flechaDireita flecha" onclick="scrollCards('.container1', 1)">&#9654;</button>
    </div>
    <?php include '../../padroes/footer.php'; ?>
    <script>
        function scrollCards(containerSelector, direction) {
            const container = document.querySelector(containerSelector);
            const cardWidth = container.querySelector('.cardServicos').offsetWidth;
            container.scrollBy({
                left: direction * cardWidth,
                behavior: 'smooth'
            });
        }

        function scrollCards2(containerSelector, direction) {
            const container = document.querySelector(containerSelector);
            const cardWidth = container.querySelector('.cardServicos').offsetWidth;
            container.scrollBy({
                left: direction * cardWidth,
                behavior: 'smooth'
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>



</html>