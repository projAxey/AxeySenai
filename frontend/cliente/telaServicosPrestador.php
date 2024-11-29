<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../layouts/head.php';
include '../layouts/nav.php';
require_once '../../config/conexao.php';

// Filtra e obtém o ID do prestador
$prestador_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Prepara a consulta para obter os serviços do prestador
$buscaServico = 'SELECT prest.*, prod.*, cat.*
FROM Prestadores prest
INNER JOIN Produtos prod ON prest.prestador_id = prod.prestador 
INNER JOIN Categorias cat ON prod.categoria = cat.categoria_id
WHERE prest.prestador_id = :id';

$stmtServicoPrestador = $conexao->prepare($buscaServico);
$stmtServicoPrestador->bindParam(':id', $prestador_id, PDO::PARAM_INT);
$stmtServicoPrestador->execute();
$servicosPrestador = $stmtServicoPrestador->fetchAll(PDO::FETCH_ASSOC); // Obtem todos os serviços

// Define o critério de ordenação
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'recent';

// Estilos CSS
?>
<style>

    .fundoTela{
        min-height: 50vh;
    }
    .user-photo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        margin-right: 1rem;
    }


    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Pop-up circular no mobile */
    .back-to-index {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background-color: #007bff;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .back-to-index:hover {
        background-color: #0056b3;
    }

    /* Mostrar somente em dispositivos móveis */
    @media (min-width: 576px) {
        .back-to-index {
            display: none;
        }
    }
</style>

<body class="fundoTela">
    <a href="#top" class="back-to-index" id="back-to-index">
        <i class="fas fa-arrow-up" id="back-to-index-icon"></i>
    </a>
    <script>
        document.addEventListener("scroll", function() {
            var scrollPosition = window.scrollY + window.innerHeight;
            var documentHeight = document.documentElement.scrollHeight;
            var button = document.getElementById("back-to-index");
            var icon = document.getElementById("back-to-index-icon");

            if (scrollPosition >= documentHeight - 30) { // Pequena margem para compensar arredondamento
                button.href = "/projAxeySenai/index.php"; // Substitua com a URL da sua área de trabalho
                icon.className = "fas fa-home";
            } else {
                button.href = "#top";
                icon.className = "fas fa-arrow-up";
            }
        });
    </script>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>
                    <?php
                    // Verifica se a foto do usuário está definida e não está vazia
                    if (!empty($servicosPrestador[0]['url_foto'])) {
                        echo "<img src='/projAxeySenai/files/imgPerfil/{$servicosPrestador[0]['url_foto']}' alt='Foto do usuário' class='user-photo' />";
                    }

                    // Exibir o nome do usuário
                    if (!empty($servicosPrestador[0]['nome_social'])) {
                        echo $servicosPrestador[0]['nome_social'];
                    } else if (!empty($servicosPrestador[0]['nome_fantasia'])) {
                        echo $servicosPrestador[0]['nome_fantasia'];
                    } else {
                        echo $servicosPrestador[0]['nome_resp_legal'];
                    }
                    ?>
                </h2>

                <p><?php echo count($servicosPrestador); ?> serviços</p>
            </div>

        </div>
        <div class="row">
        </div>
    </div>

    <?php
    // Função para renderizar os cards de serviço
    function serviceCards($services, $sortBy)
    {
        // Função de comparação para ordenação
        usort($services, function ($a, $b) use ($sortBy) {
            // Verifica se as chaves existem antes de compará-las
            switch ($sortBy) {
                case 'name_desc':
                    return strcmp($b['nome_produto'] ?? '', $a['nome_produto'] ?? ''); // Alterado para o nome correto da coluna
                case 'recent':
                    return strcmp($b['criacao'] ?? '', $a['criacao'] ?? ''); // Alterado para o nome correto da coluna
                case 'category':
                    return strcmp($a['titulo_categoria'] ?? '', $b['titulo_categoria'] ?? ''); // Alterado para o nome correto da coluna
                case 'name':
                default:
                    return strcmp($a['nome_produto'] ?? '', $b['nome_produto'] ?? ''); // Alterado para o nome correto da coluna
            }
        });

        // Inicia o container dos serviços
        echo '<div class="container"><div class="row">';

        // Renderizando os cards
        foreach ($services as $service) {
            // Verifica se a coluna de imagem contém mais de uma imagem separada por vírgula
            $imagens = explode(',', $service['imagem_produto']);
            // Pega apenas a primeira imagem da lista
            $primeiraImagem = trim($imagens[0]);

            // Renderiza o card, ocupando 3 colunas (col-md-3) para que fiquem 4 por linha
            echo "
            <div class='col-md-3 mb-4'>
                <div class='card cardFiltro'>
                    <img src='/projAxeySenai/{$primeiraImagem}' class='card-img-top' alt='Imagem do produto'>
                    <div class='card-body'>
                        <h5 class='card-title-servicos'>{$service['nome_produto']}</h5>
                        <p class='card-text-servicos'>{$service['titulo_categoria']}</p>
                        <a href='/projAxeySenai/frontend/cliente/telaAnuncio.php?id={$service['produto_id']}' class='btn btn-primary btnSaibaMais'>Saiba mais</a>
                    </div>
                </div>
            </div>";
        }

        // Fecha os containers
        echo '</div></div>';
    }

    // Chamada da função (caso necessário)
    serviceCards($servicosPrestador, $sortBy);
    include '../layouts/footer.php';
    ?>

</body>