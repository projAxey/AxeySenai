<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .navbar{
            padding: 0;
        }

        .navbar-light .navbar-toggler-icon {
            background-image: none;
            width: 1em;
            height: 1em;
            font-size: 2em;
            color: white;
        }

        .navbar-light .navbar-toggler-icon::after {
            content: '\2630'; 
        }

        .navbar-light .navbar-toggler {
            border: none;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #fff;
        }

        .bg-nav {
            background-color: #012640;
        }

        .btnAnuncio {
            background-color: #012640;
            color: gold;
            border-color: gold;
            border-radius: 20vh;
            font-size: 1rem; 
            margin: 0.5rem 2rem; 
            font-weight: bold;
        }

        .barraPesquisa {
            position: relative;
            width: 40vw; 
        }

        .barraPesquisa i {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            font-size: 1rem;
        }

        .barraPesquisa input[type="search"] {
            padding-left: 3rem;
        }

        .pesquisa {
            width: 100%;
            height: 1.8rem;
            font-size: 1rem;
        }

        .iconeUsuario {
            margin: 0.5rem 0.5rem 0rem 0rem;
            width: 2rem;
            height: 2rem;
            border: 0.2rem solid #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
        }

        .iconeUsuario i {
            font-size: 1.2rem;
            color: #fff;
        }

        .dropdown-menu {
            text-align: center;
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            transform: translateX(-50%);
            background-color: #012640; /* Cor do fundo do dropdown */
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            min-width: 160px;
            z-index: 1000;
            padding: 0;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
        }

        .dropdown-menu a {
            display: block;
            padding: 8px 16px;
            color: #fff; /* Cor do texto dos itens do dropdown */
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #5790bc; 
        }

        .dropdown-menu.show {
            display: block;
        }

        .logoNav {
            margin-left: 1rem;
            height: 2rem;
        }

        @media (max-width: 768px) {
            .navbar-light .navbar-toggler {
                margin: 0;
            }

            .barraPesquisa {
                width: 50vw;
            }

            .btnAnuncio,
            .iconeUsuario { 
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-nav">
        <a class="navbar-brand" href="/projAxeySenai/index.php">
            <img class="logoNav" src="/projAxeySenai/assets/imgs/logo.png" alt="Logo Axey">
        </a>
        <div class="d-flex align-items-center">
            <div class="barraPesquisa">
                <i class="fas fa-search"></i>
                <input class="form-control pesquisa" type="search" placeholder="Buscar" aria-label="Search">
            </div>
        </div>
        <button class="navbar-toggler" type="button" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-lg-block">
                    <button class="btnAnuncio" onclick="location.href='/projAxeySenai/paginas/geral/planos.php'">ANUNCIE GRÁTIS</button>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <div class="iconeUsuario" onclick="toggleDropdown(event)">
                        <i class="fa-solid fa-user"></i>
                        <div id="userDropdown" class="dropdown-menu mt-2">
                            <a href="/projAxeySenai/paginas/prestador/TelaPerfilPrestador.php">Perfil</a>
                            <a href="/projAxeySenai/paginas/geral/planos.php">Planos</a>
                            <a href="/projAxeySenai/registro/login.php">Sair</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="/projAxeySenai/paginas/registro/login.php">Entrar/Cadastrar</a>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="/projAxeySenai/paginas/geral/planos.php">Anuncie Grátis</a>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var navbarToggler = document.querySelector('.navbar-toggler');
            var navbarCollapse = document.querySelector('#navbarNav');

            navbarToggler.addEventListener('click', function () {
                navbarCollapse.classList.toggle('show');
            });
        });

        function toggleDropdown(event) {
            event.stopPropagation(); // Evita que o clique no dropdown feche o menu
            var dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');

            // Ajuste o menu dropdown se ele sair da tela
            var rect = dropdown.getBoundingClientRect();
            if (rect.right > window.innerWidth) {
                dropdown.style.left = 'auto';
                dropdown.style.right = '0';
                dropdown.style.transform = 'none';
            } else {
                dropdown.style.left = '0';
                dropdown.style.right = 'auto';
                dropdown.style.transform = 'translateX(-50%)';
            }
        }

        document.addEventListener('click', function (event) {
            var target = event.target;
            var dropdown = document.getElementById('userDropdown');
            if (!target.closest('.iconeUsuario') && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>
