<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="/projAxeySenai/assets/css/nav.css">
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
