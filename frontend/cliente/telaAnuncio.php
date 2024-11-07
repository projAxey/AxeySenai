<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php';

// Consulta SQL corrigida
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prestador_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$buscaServico = 'SELECT prod.imagem_produto, prod.produto_id, prod.nome_produto, prod.descricao_produto, prod.prestador, prest.nome_social, prest.nome_fantasia, prest.nome_resp_legal, prest.url_foto, prest.prestador_id
FROM Produtos prod
INNER JOIN Prestadores prest
ON prest.prestador_id = prod.prestador 
WHERE prod.produto_id = :id';

$stmtServico = $conexao->prepare($buscaServico);

$stmtServico->bindParam(':id', $id, PDO::PARAM_INT);
$stmtServico->execute();
$servico = $stmtServico->fetch(PDO::FETCH_ASSOC);
?>


<body class="bodyCards">
    <div class="main-container">
        <div class="py-3">
            <div class="main container d-flex flex-column flex-md-row justify-content-between">
                <?php
                $produto_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                $queryImagens = '
    SELECT imagem_produto 
    FROM Produtos 
    WHERE produto_id = :id
';
                $stmtImagens = $conexao->prepare($queryImagens);
                $stmtImagens->bindParam(':id', $produto_id, PDO::PARAM_INT);
                $stmtImagens->execute();
                $resultado = $stmtImagens->fetch(PDO::FETCH_ASSOC);
                $imagens = [];
                if ($resultado && !empty($resultado['imagem_produto'])) {
                    $imagens = explode(',', $resultado['imagem_produto']);
                }
                ?>

                <!-- Carousel -->
                <div id="separa-divs" class="carousel-container flex-grow-1 me-md-3">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            if (!empty($imagens)) {
                                $isActive = true;
                                foreach ($imagens as $imagem) {
                                    $imagem = trim($imagem);
                                    $activeClass = $isActive ? 'active' : '';
                                    echo '
                    <div class="carousel-item ' . $activeClass . '">
                        <img src="/projAxeySenai/' . htmlspecialchars($imagem) . '" class="carousel-img" alt="Imagem do produto">
                    </div>';
                                    $isActive = false; // Após a primeira iteração, desativa o "active"
                                }
                            } else {
                                echo '
                <div class="carousel-item active">
                    <img src="../../assets/imgs/default.png" class="carousel-img" alt="Imagem padrão">
                </div>';
                            }
                            ?>
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
                <div class="main-group-func container d-flex flex-column align-items-center justify-content-center">
                    <div class="legenda text-center mb-2 mt-4">
                        <h3><?php echo $servico['nome_produto'] ?></h>
                    </div>
                    <div class="legenda text-center mb-3">
                        <p><?php echo $servico['descricao_produto'] ?></p>
                    </div>
                    <div class="buttom-group text-center">
                        <div class="group-button py-2">
                            <a class="btn btn-primary" id="verificarDisponibilidadeBtn" data-produto-id="<?php echo $produto_id; ?>">
                                Verificar disponibilidade
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center text-center" style="margin-top: 30px;">
                        <div class="me-3">
                            <img src="/projAxeySenai/files/imgPerfil/<?php echo $servico['url_foto'] ?>" alt="Foto do Prestador" style="width: 6rem; height: 6rem; object-fit: cover; border-radius: 5px;">
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <strong style="font-size: 1.2rem; margin-bottom: 5px;">
                                <?php
                                if (isset($servico['nome_social']) && $servico['nome_social'] != null) {
                                    echo $servico['nome_social'];
                                } else if (isset($servico['nome_fantasia']) && $servico['nome_fantasia'] != null) {
                                    echo $servico['nome_fantasia'];
                                } else {
                                    echo $servico['nome_resp_legal'];
                                }
                                ?>
                            </strong>
                            <div>
                                <a href="telaServicosPrestador.php?id=<?php echo htmlspecialchars($servico['prestador_id']); ?>" class="btn btn-primary" style="padding: 5px 15px; font-size: 1rem;">Ver mais serviços</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal para login ou criação de conta -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Cabeçalho da modal com ícone e estilo de fundo personalizado -->
                    <div class="modal-header text-white text-center" style="background-color: #012640;">
                        <h5 class="modal-title w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-circle me-2"></i> <!-- Ícone de perfil -->
                            Sessão Inativa
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <!-- Corpo da modal com texto amigável e espaçamento ajustado -->
                    <div class="modal-body text-center">
                        <p class="fs-5 mb-4 text-muted">
                            Vimos que você ainda não está logado 😢<br>
                            Deseja realizar login para continuar? 😄
                        </p>
                    </div>
                    <!-- Rodapé da modal com botões estilizados e espaçamento adicional -->
                    <div class="modal-footer justify-content-center">
                        <a href="/projAxeySenai/frontend/auth/login.php" class="btn text-white" style="background-color: #012640;">Sim, fazer login</a>
                        <a href="/projAxeySenai/frontend/auth/criarConta.php" class="btn btn-outline-dark">Criar conta</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Agora não</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        function getServices()
        {
            include '../../config/conexao.php';
            $query = "SELECT c.titulo_categoria, p.produto_id, p.prestador, p.categoria, p.tipo_produto, p.nome_produto, p.valor_produto, p.descricao_produto, p.imagem_produto 
              FROM Produtos p 
              JOIN Categorias c ON p.categoria = c.categoria_id  
              WHERE p.status = 2 AND p.categoria_produto = 1";

            $stmt = $conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna os produtos


        }

        servicesSection("Serviços disponíveis", getServices(), "servicos-mais-visitados");

        function servicesSection($title, $services, $sectionId)
        {
            echo "<div id='{$sectionId}' class='services-container-wrapper container containerCards mb-4'>";
            echo "<div class='tituloServicos'><h2>{$title}</h2></div>";
            echo '<div class="d-flex align-items-center">';
            echo "<button class='arrow flechaEsquerda flecha me-2'>&#9664;</button>";
            echo '<div class="services-container containerServicos d-flex">';


            foreach ($services as $service) {
                // Verifica se a coluna de imagem contém mais de uma imagem separada por vírgula
                $imagens = explode(',', $service['imagem_produto']);
                // Pega apenas a primeira imagem da lista
                $primeiraImagem = trim($imagens[0]);

                echo "
    <div class='card cardServicos mx-2'>
        <img src='/projAxeySenai/{$primeiraImagem}' alt='Imagem do produto'>
        <div class='card-body'>
            <h5 class='card-title-servicos'>{$service['nome_produto']}</h5>
            <p class='card-text-servicos'>{$service['titulo_categoria']}</p>
            <a href='/projAxeySenai/frontend/cliente/telaAnuncio.php?id={$service['produto_id']}' class='btn btn-primary btnSaibaMais'>Saiba mais</a>
        </div>
    </div>";
            }

            echo '</div>';
            echo "<button class='arrow flechaDireita flecha ms-2'>&#9654;</button>";
            echo '</div></div>';
        }

        ?>




    </div>

    <?php
    include '../layouts/footer.php';
    ?>
    <script src="../../assets/js/servicos.js"></script>

    <!-- Busca Agendamentos do Prestador -->
    <?php
    $buscaAgenda = 'SELECT Agendas.prestador
     FROM Agendas 
     INNER JOIN Prestadores ON Agendas.prestador = Prestadores.prestador_id
     INNER JOIN Produtos ON Agendas.prestador = Produtos.prestador
     WHERE Produtos.produto_id = :id';

    $stmtAgenda = $conexao->prepare($buscaAgenda);

    $stmtAgenda->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtAgenda->execute();
    $agenda = $stmtAgenda->fetch(PDO::FETCH_ASSOC);
    // echo $agenda['Agendas_prestador'];
    // var_dump($agenda);

    ?>
    <php>

        <script>
            // Função para verificar a disponibilidade e exibir o SweetAlert2
            document.addEventListener("DOMContentLoaded", function() {
                const btnVerificar = document.getElementById("verificarDisponibilidadeBtn");

                btnVerificar.addEventListener("click", function(event) {
                    event.preventDefault();

                    const produtoId = btnVerificar.getAttribute("data-produto-id");

                    // Verifique se o usuário está logado usando PHP no HTML
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        // Usuário logado, redireciona para agendar
                        var possuiAgenda = <?php echo $agenda ? 'true' : 'false'; ?>;
                        // alert(possuiAgenda)
                        if (possuiAgenda) {
                            window.location.href = "../../frontend/cliente/agendarServico.php?id=" + produtoId;
                        } else {
                            Swal.fire({
                                title: 'Atenção!',
                                text: "Este prestador não possui agenda disponivel",
                                icon: 'warning',
                                cancelButtonText: 'Cancelar'
                            });
                        }
                    <?php else: ?>
                        // Usuário não logado, exibe alerta SweetAlert
                        var myModal = new bootstrap.Modal(document.getElementById('loginModal'), {});
                        myModal.show();
                    <?php endif; ?>
                });
            });
        </script>
</body>

</html>