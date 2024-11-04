<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    .barraPesquisa {
        position: relative;
    }

    #searchResults {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 100%;
        position: absolute;
        top: 120%;
        max-height: 200px;
        overflow-y: auto;
        margin-left: 130px;
        text-align: start;
    }

    #searchResults .result-item {
        padding: 10px;
        cursor: pointer;
    }

    #searchResults .result-item:hover {
        background-color: gray;
        cursor: pointer;
    }

    .dropdown-item {
        cursor: pointer;
    }

    .dropdown-menu {
        left: 33% !important;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-nav navGeral mb-2">
    <a class="navbar-brand" href="/projAxeySenai/index.php">
        <img class="logoNav" src="/projAxeySenai/assets/imgs/logo.png" alt="Logo Axey">
    </a>
    <div class="d-flex align-items-center">
        <div class="barraPesquisa position-relative">
            <i class="fas fa-search"></i>
            <input class="form-control pesquisa" type="search" placeholder="Buscar" aria-label="Search" id="searchInput">
            <div id="searchResults" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto;"></div>
        </div>
    </div>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <?php if (!isset($_SESSION['logged_in']) || (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Cliente')): ?>
                <li class="nav-item d-none d-lg-block">
                    <button class="btnAnuncio" onclick="location.href='/projAxeySenai/frontend/planos/planos.php'">ANUNCIE GRÁTIS</button>
                </li>
            <?php else: ?>
                <li class="nav-item d-none d-lg-block">
                    <button class="btnAnuncio" onclick="location.href='/projAxeySenai/frontend/planos/planos.php'">FAÇA UM UPGRADE</button>
                </li>
            <?php endif; ?>

            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <li class="nav-item d-none d-lg-block">
                    <div class="iconeUsuario" onclick="toggleDropdown(event)">
                        <i class="fa-solid fa-user"></i>
                        <div id="userDropdown" class="dropdown-menu dropMenuNav mt-2">
                            <p style="color:white; margin-left: 1vh">
                                Olá!
                            </p>
                            <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Administrador'): ?>
                            <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/adm/admin.php">Administração</a>
                            <?php endif; ?>
                            <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/auth/perfil.php">Perfil</a>
                            <a class="dropdown-item" href="/projAxeySenai/backend/auth/logout.php">Sair</a>
                        </div>
                    </div>
                </li>
            <?php else: ?>
                <li class="nav-item d-none d-lg-block">
                    <button class="btnEntrar" onclick="location.href='/projAxeySenai/frontend/auth/login.php'">Entrar</button>
                </li>
            <?php endif; ?>
            <li class="nav-item d-lg-none">
                <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/planos/planos.php">Anuncie Grátis</a>
            </li>
            <li class="nav-item d-lg-none">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/auth/perfil.php">Perfil</a>
                    <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/planos/planos.php">Planos</a>
                    <a class="dropdown-item nav-link" href="/projAxeySenai/backend/auth/logout.php">Sair</a>
                <?php else: ?>
                    <a class="nav-link" href="/projAxeySenai/frontend/auth/login.php">Entrar/Cadastrar</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>

<?php session_write_close(); ?>

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

    document.getElementById('searchInput').addEventListener('input', function() {
        let query = this.value;
        let resultsContainer = document.getElementById('searchResults');

        if (query.length >= 2) {
            fetch(`/projAxeySenai/backend/servicos/search.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(item => {
                            let resultItem = document.createElement('div');
                            resultItem.classList.add('dropdown-item');
                            resultItem.textContent = item.nome_produto;

                            resultItem.addEventListener('click', function() {
                                window.location.href = `/projAxeySenai/frontend/cliente/telaAnuncio.php?id=${item.produto_id}`;
                            });
                            resultsContainer.appendChild(resultItem);
                        });
                        resultsContainer.style.display = 'block';
                    } else {
                        resultsContainer.style.display = 'none';
                    }
                })
                .catch(error => console.error('Erro ao buscar produtos:', error));
        } else {
            resultsContainer.style.display = 'none';
        }
    });

    document.addEventListener('click', function(event) {
        let resultsContainer = document.getElementById('searchResults');
        if (!event.target.closest('.barraPesquisa')) {
            resultsContainer.style.display = 'none';
        }
    });

    // Função para redirecionar ao clicar no ícone de lupa ou pressionar Enter
    document.getElementById('searchInput').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            redirectToSearch();
        }
    });

    function redirectToSearch() {
        let query = document.getElementById('searchInput').value;
        if (query.length > 0) {
            window.location.href = `/projAxeySenai/frontend/cliente/todosServicos.php?palavra=${encodeURIComponent(query)}`;
        }
    }

    // Adiciona o evento de clique no ícone de lupa
    document.querySelector('.fas.fa-search').addEventListener('click', redirectToSearch);
</script>