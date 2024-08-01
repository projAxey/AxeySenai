<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Página</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            font-size: 16px; /* Define o tamanho base da fonte, 1rem = 16px */
        }
        .bodyPlanos {
            font-family: 'Arial', sans-serif;
        }
        .custom-cards-wrapper {
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        .custom-cards-container {
            display: flex;
            overflow-x: auto;
            padding: 1.25rem; /* 20px em rem */
            gap: 1.25rem; /* 20px em rem */
            scrollbar-width: none;
            -ms-overflow-style: none;
            transition: transform 0.5s ease;
        }
        .custom-cards-container::-webkit-scrollbar {
            display: none;
        }
        .custom-card {
            flex: 0 0 auto;
            width: 15.625rem; /* 250px em rem */
            border: 0.1875rem solid; /* 3px em rem */
            border-radius: 0.625rem; /* 10px em rem */
            box-shadow: 0.5rem 0.5rem 0.5rem rgba(0, 0, 0, 0.3);
            height: 37.5rem; /* 600px em rem */
            background-color: #012640;
            color: #fff;
        }
        .custom-card .card-img-top {
            width: 6.25rem; /* 100px em rem */
            height: 6.25rem; /* 100px em rem */
            margin-top: 3.125rem; /* 50px em rem */
            margin-bottom: 3.125rem; /* 50px em rem */
        }
        .bg-footer, .bg-nav {
            background-color: #012640;
        }
        .tituloPlanos {
            font-size: 3.125rem; /* 50px em rem */
            font-weight: bold;
            color: #012640;
        }
        .card-title {
            font-size: 1.875rem; /* 30px em rem */
            font-weight: bold;
            color: #fff;
        }
        .btn-primary-custom {
            padding: 0.3125rem 1.875rem; /* 5px 30px em rem */
            border-radius: 0.3125rem; /* 5px em rem */
            font-size: 1.25rem; /* 20px em rem */
            font-weight: bold;
            color: #fff;
        }
        .btn-primary-custom[data-color="2cc406"] {
            background-color: #2cc406;
            border-color: #2cc406;
        }
        .btn-primary-custom[data-color="ce0b37"] {
            background-color: #ce0b37;
            border-color: #ce0b37;
        }
        .btn-primary-custom[data-color="ffa800"] {
            background-color: #ffa800;
            border-color: #ffa800;
        }
        .btn-primary-custom[data-color="3583ed"] {
            background-color: #3583ed;
            border-color: #3583ed;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body class="bodyPlanos">
    <?php include '../../padroes/nav.php'; ?>
    <div class="d-flex justify-content-center align-items-center mt-1">
        <div class="text-center mt-3">
    <h2 class="font-weight-bold">Escolha o Plano Perfeito para Você</h2>
    <p class="lead">Encontre o plano que melhor se adapta às suas necessidades e aproveite todos os nossos benefícios!</p>
</div>
    </div>
    <div class="container d-flex justify-content-center align-items-center mt-2">
        <div class="custom-cards-wrapper">
            <div class="custom-cards-container">
                <div class="custom-card text-center" style="border-color: #2cc406;">
                    <img src="../../assets/imgs/gratis.png" alt="Logo" class="card-img-top mx-auto">
                    <div class="card-body">
                        <h5 class="card-title">Grátis</h5>
                        <p class="card-text">Descrição do plano básico.</p>
                        <a href="../registro/login.php" class="btn btn-primary-custom" data-color="2cc406">Assinar</a>
                    </div>
                </div>
                <div class="custom-card text-center" style="border-color: #ce0b37;">
                    <img src="../../assets/imgs/basico.png" alt="Logo" class="card-img-top mx-auto">
                    <div class="card-body">
                        <h5 class="card-title">Básico</h5>
                        <p class="card-text">Descrição do plano básico.</p>
                        <a href="../registro/login.php" class="btn btn-primary-custom" data-color="ce0b37">Assinar</a>
                    </div>
                </div>
                <div class="custom-card text-center" style="border-color: #ffa800;">
                    <img src="../../assets/imgs/plus.png" alt="Logo" class="card-img-top mx-auto">
                    <div class="card-body">
                        <h5 class="card-title">Plus</h5>
                        <p class="card-text">Descrição do plano básico.</p>
                        <a href="../registro/login.php" class="btn btn-primary-custom" data-color="ffa800">Assinar</a>
                    </div>
                </div>
                <div class="custom-card text-center" style="border-color: #3583ed;">
                    <img src="../../assets/imgs/premium.png" alt="Logo" class="card-img-top mx-auto">
                    <div class="card-body">
                        <h5 class="card-title">Premium</h5>
                        <p class="card-text">Descrição do plano básico.</p>
                        <a href="../registro/login.php" class="btn btn-primary-custom" data-color="3583ed">Assinar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../../padroes/footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function scrollCards(direction) {
            const container = document.querySelector('.custom-cards-container');
            const cardWidth = container.querySelector('.custom-card').offsetWidth;
            container.scrollBy({
                left: direction * cardWidth,
                behavior: 'smooth'
            });
        }
    </script>
</body>
</html>
