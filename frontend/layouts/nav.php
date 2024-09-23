<?php session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-nav navGeral">
    <a class="navbar-brand" href="/projAxeySenai/index.php">
        <img class="logoNav" src="/projAxeySenai/assets/imgs/logo.png" alt="Logo Axey">
    </a>
    <div class="d-flex align-items-center">
        <div class="barraPesquisa">
            <i class="fas fa-search"></i>
            <input class="form-control pesquisa" type="search" placeholder="Buscar" aria-label="Search">
        </div>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item d-none d-lg-block">
                <button class="btnAnuncio" onclick="location.href='/projAxeySenai/projetoAxeySenai/frontend/planos/planos.php'">ANUNCIE GRÁTIS</button>
            </li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <li class="nav-item d-none d-lg-block">
                    <div class="iconeUsuario" onclick="toggleDropdown(event)">
                        <i class="fa-solid fa-user"></i>
                        <div id="userDropdown" class="dropdown-menu dropMenuNav mt-2">
                            <?php
                            // Verifica o tipo de usuário e exibe o link correspondente
                            if ($_SESSION['tipo_usuario'] === 'prestador') {
                                echo '<a class="nav-link" href="/projAxeySenai/projetoAxeySenai/frontend/prestador/perfilPrestador.php">Perfil</a>';
                            } else {
                                echo '<a class="nav-link" href="/projAxeySenai/projetoAxeySenai/frontend/cliente/perfilCliente.php">Perfil</a>';
                            }
                            ?>
                            <a class="dropdown-item nav-link" href="/projAxeySenai/projetoAxeySenai/frontend/planos/planos.php">Planos</a>
                            <a class="dropdown-item" href="/projAxeySenai/projetoAxeySenai/backend/logout.php">Sair</a>
                        </div>
                    </div>
                </li>
            <?php else: ?>
                <li class="nav-item d-none d-lg-block">
                    <button class="btnEntrar" onclick="location.href='/projAxeySenai/projetoAxeySenai/frontend/auth/login.php'">Entrar</button>
                </li>
            <?php endif; ?>

            <li class="nav-item d-lg-none">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <?php
                    // Verifica o tipo de usuário e exibe o link correspondente
                    if ($_SESSION['tipo_usuario'] === 'prestador') {
                        echo '<a class="nav-link" href="/projAxeySenai/projetoAxeySenai/frontend/prestador/perfilPrestador.php">Perfil</a>';
                    } else {
                        echo '<a class="nav-link" href="/projAxeySenai/projetoAxeySenai/frontend/cliente/perfilCliente.php">Perfil</a>';
                    }
                    ?>
                    <a class="dropdown-item nav-link" href="/projAxeySenai/projetoAxeySenai/frontend/planos/planos.php">Planos</a>
                    <a class="dropdown-item" href="/projAxeySenai/projetoAxeySenai/backend/logout.php">Sair</a>
                <?php else: ?>
                    <a class="nav-link" href="/projAxeySenai/paginas/registro/login.php">Entrar/Cadastrar</a>
                <?php endif; ?>
            </li>
            <li class="nav-item d-lg-none">
                <a class="nav-link" href="/projAxeySenai/paginas/geral/planos.php">Anuncie Grátis</a>
            </li>
        </ul>
    </div>
</nav>

<script>
    function toggleDropdown(event) {
        event.stopPropagation();
        var dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('show');

        dropdown.style.left = '50%';
        dropdown.style.right = 'auto';
        dropdown.style.transform = 'translateX(-50%)';

        var rect = dropdown.getBoundingClientRect();
        if (rect.right > window.innerWidth) {
            dropdown.style.left = 'auto';
            dropdown.style.right = '0';
            dropdown.style.transform = 'none';
        } else if (rect.left < 0) {
            dropdown.style.left = '0';
            dropdown.style.right = 'auto';
            dropdown.style.transform = 'none';
        }
    }

    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById('userDropdown');
        if (!event.target.closest('.iconeUsuario') && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    });

    document.getElementById('userDropdown').addEventListener('click', function(event) {
        event.stopPropagation();
    });
</script>
