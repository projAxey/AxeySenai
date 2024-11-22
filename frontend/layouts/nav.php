<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
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
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <!-- Verificações para a versão web -->

            <?php if (isset($_SESSION['logged_in']) && isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Cliente'): ?>
                <li class="nav-item d-none d-lg-block">
                    <button class="btnAnuncio" onclick="location.href='/projAxeySenai/frontend/auth/tornaPrestador.php'">FAÇA UM ANÚNCIO</button>
                </li>
            <?php elseif (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Administrador'): ?>
                <li class="nav-item d-none d-lg-block">
                    <button class="btnAnuncio" onclick="location.href='/projAxeySenai/frontend/adm/admin.php'">Administração</button>
                </li>
            <?php elseif (
                isset($_SESSION['tipo_usuario']) &&
                ($_SESSION['tipo_usuario'] === 'Prestador PJ' || $_SESSION['tipo_usuario'] === 'Prestador PF')
            ) : ?>
                <li class="nav-item d-none d-lg-block">
                    <button class="btnAnuncio" onclick="location.href='/projAxeySenai/frontend/prestador/TelaMeusAnuncios.php'">Faça um Anúncio</button>
                </li>
            <?php endif; ?>

            <!-- Verificações para a versão mobile -->
            <?php if (isset($_SESSION['logged_in']) && isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Cliente'): ?>
                <li class="nav-item d-lg-none">
                    <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/cliente/agendamentosCliente.php">Agendamentos</a>
                </li>
            <?php elseif (isset($_SESSION['logged_in']) && isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Administrador'): ?>
                <li class="nav-item d-lg-none">
                    <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/adm/admin.php">Administração</a>
                </li>
            <?php elseif (isset($_SESSION['logged_in']) && isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Prestador'): ?>
                <li class="nav-item d-lg-none">
                    <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/prestador/TelaMeusAnuncios.php">Faça um Anúncio</a>
                </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <li class="nav-item d-none d-lg-block mb-1">
                    <div class="iconeUsuario">
                        <!-- Substituindo o ícone pela foto de perfil -->
                        <img src="/projAxeySenai/files/imgPerfil/<?php echo isset($_SESSION['user_image']) ? $_SESSION['user_image'] : 'user.png'; ?>"
                            alt="" class="rounded-circle" style="width: 2.2rem; height: 2rem; object-fit: cover;">
                        <div id="userDropdown" class="dropdown-menu dropMenuNav mt-2">
                            <?php if (isset($_SESSION['tipo_usuario']) && in_array($_SESSION['tipo_usuario'], ['Cliente'])): ?>
                                <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/cliente/agendamentosCliente.php">Agendamentos</a>

                            <?php endif; ?>
                            <?php if (isset($_SESSION['tipo_usuario']) && in_array($_SESSION['tipo_usuario'], ['Cliente', 'Prestador PF', 'Prestador PJ'])): ?>
                                <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/auth/perfil.php">Perfil</a>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['tipo_usuario']) && in_array($_SESSION['tipo_usuario'], ['Prestador PF', 'Prestador PJ'])): ?>
                                <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/prestador/TelaMeusAnuncios.php">Meus Anúncios</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="/projAxeySenai/backend/auth/logout.php">Sair</a>
                        </div>
                    </div>
                </li>
                <!-- Links adicionais para versão mobile -->
                <li class="nav-item d-lg-none">
                    <?php if (isset($_SESSION['tipo_usuario']) && in_array($_SESSION['tipo_usuario'], ['Cliente', 'Prestador PF', 'Prestador PJ'])): ?>
                        <a class="dropdown-item nav-link" href="/projAxeySenai/frontend/auth/perfil.php">Perfil</a>
                    <?php endif; ?>
                    <a class="dropdown-item nav-link" href="/projAxeySenai/backend/auth/logout.php">Sair</a>
                </li>
            <?php else: ?>
                <li class="nav-item d-none d-lg-block">
                    <button class="btnEntrar" onclick="location.href='/projAxeySenai/frontend/auth/login.php'">Entrar</button>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="/projAxeySenai/frontend/auth/login.php">Entrar/Cadastrar</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?php session_write_close(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Função para alternar o dropdown
        function toggleDropdown(event) {
            event.stopPropagation();
            var dropdown = document.getElementById('userDropdown');
            if (dropdown) {
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
        }

        // Associar o evento ao ícone de usuário
        var iconeUsuario = document.querySelector('.iconeUsuario');
        if (iconeUsuario) {
            iconeUsuario.addEventListener('click', toggleDropdown);
        }

        // Clique fora do dropdown para fechá-lo
        document.addEventListener('click', function(event) {
            var dropdown = document.getElementById('userDropdown');
            if (dropdown && !event.target.closest('.iconeUsuario') && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });

        // Campo de busca
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        if (searchInput && searchResults) {
            searchInput.addEventListener('input', function() {
                let query = this.value;

                if (query.length >= 2) {
                    fetch(`/projAxeySenai/backend/servicos/search.php?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            searchResults.innerHTML = '';

                            if (data.length > 0) {
                                data.forEach(item => {
                                    let resultItem = document.createElement('div');
                                    resultItem.classList.add('dropdown-item');
                                    resultItem.textContent = item.nome_produto;

                                    resultItem.addEventListener('click', function() {
                                        window.location.href = `/projAxeySenai/frontend/cliente/telaAnuncio.php?id=${item.produto_id}`;
                                    });
                                    searchResults.appendChild(resultItem);
                                });
                                searchResults.style.display = 'block';
                            } else {
                                searchResults.style.display = 'none';
                            }
                        })
                        .catch(error => console.error('Erro ao buscar produtos:', error));
                } else {
                    searchResults.style.display = 'none';
                }
            });

            // Clique fora da barra de pesquisa para esconder os resultados
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.barraPesquisa')) {
                    searchResults.style.display = 'none';
                }
            });

            // Redirecionamento ao pressionar Enter ou ao clicar no ícone de lupa
            searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    redirectToSearch();
                }
            });
        }

        // Função de redirecionamento para a busca
        function redirectToSearch() {
            let query = searchInput ? searchInput.value : '';
            if (query.length > 0) {
                window.location.href = `/projAxeySenai/frontend/cliente/todosServicos.php?palavra=${encodeURIComponent(query)}`;
            }
        }

        // Adiciona o evento de clique ao ícone de lupa, se existir
        const searchIcon = document.querySelector('.fas.fa-search');
        if (searchIcon) {
            searchIcon.addEventListener('click', redirectToSearch);
        }
    });
</script>