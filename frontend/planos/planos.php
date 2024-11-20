
<?php
include '../layouts/head.php';
include '../layouts/nav.php';
?>
<body class="bodyPlanos">
    <div class="main-container">
        <div class="d-flex justify-content-center align-items-center mt-1">
            <div class="text-center mt-3">
                <h2 class="tituloPlanos">Escolha o Plano Perfeito para Você</h2>
                <p class="lead">Encontre o plano que melhor se adapta às suas necessidades e aproveite todos os nossos benefícios!</p>
            </div>
        </div>
        <div class="container d-flex mt-2 mb-2">
            <div class="custom-cards-wrapper">
                <div class="custom-cards-container">
                    <div class="custom-card" style="border-color: #2cc406;">
                        <img src="../../assets/imgs/gratis.png" alt="Logo" class="card-img-top mx-auto">
                        <div class="card-body">
                            <h5 class="card-title">Grátis</h5>
                            <p class="card-text">Descrição do plano básico.</p>
                            <a href="../auth/upgrade.php" class="btn btn-primary-custom" data-color="2cc406">Assinar</a>
                        </div>
                    </div>
                    <div class="custom-card" style="border-color: #ce0b37;">
                        <img src="../../assets/imgs/basico.png" alt="Logo" class="card-img-top mx-auto">
                        <div class="card-body">
                            <h5 class="card-title">Básico</h5>
                            <p class="card-text">Descrição do plano básico.</p>
                            <a href="../auth/upgrade.php" class="btn btn-primary-custom" data-color="ce0b37">Assinar</a>
                        </div>
                    </div>
                    <div class="custom-card" style="border-color: #ffa800;">
                        <img src="../../assets/imgs/plus.png" alt="Logo" class="card-img-top mx-auto">
                        <div class="card-body">
                            <h5 class="card-title">Plus</h5>
                            <p class="card-text">Descrição do plano básico.</p>
                            <a href="../auth/upgrade.php" class="btn btn-primary-custom" data-color="ffa800">Assinar</a>
                        </div>
                    </div>
                    <div class="custom-card" style="border-color: #3583ed;">
                        <img src="../../assets/imgs/premium.png" alt="Logo" class="card-img-top mx-auto">
                        <div class="card-body">
                            <h5 class="card-title">Premium</h5>
                            <p class="card-text">Descrição do plano básico.</p>
                            <a href="../auth/upgrade.php" class="btn btn-primary-custom" data-color="3583ed">Assinar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../layouts/footer.php';
    ?>  
    <!-- <script>
        function scrollCards(direction) {
            const container = document.querySelector('.custom-cards-container');
            const cardWidth = container.querySelector('.custom-card').offsetWidth;
            container.scrollBy({
                left: direction * cardWidth,
                behavior: 'smooth'
            });
        }
    </script> -->
</body>

</html>

