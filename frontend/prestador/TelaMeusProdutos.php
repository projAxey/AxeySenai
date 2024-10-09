<?php 
include '../layouts/head.php'; 

include '../../config/conexao.php'; 

?>

<body class=" bodyCards bodyCadastroProdutos">
<?php

class MeusServicosPage {
    public function render() {
        $this->head();
        echo '<body class="bodyCards">';
        $this->nav();
        echo '<div class="container mt-4">';
        $this->breadcrumb();
        $this->titleSection();
        $this->buttonsSection();
        $this->tableSection(); // Aqui está a seção da tabela
        echo '</div>';
        $this->modals();
        $this->footer();
        echo $this->getScripts();
        echo '</body></html>';
    }

    private function head() {
        include '../layouts/head.php';
    }

    private function nav() {
        include '../layouts/nav.php';
    }

    private function breadcrumb() {
        echo '
        <div class="row d-flex flex-wrap">
            <ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item">
                    <a href="/projAxeySenai/frontend/auth/perfil.php" style="text-decoration: none; color:#012640;">
                        <strong>Voltar</strong>
                    </a>
                </li>
            </ol>';
    }   

    private function titleSection() {
        echo '
            <div class="title-admin">MEUS SERVIÇOS</div>
        </div>';
    }

    private function buttonsSection() {
        echo '
        <div class="d-flex justify-content-between mb-4">
            <button type="button" id="meusAgendamentos" class="mb-2 btn btn-meus-agendamentos"
                style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novoServicoModal">
                Novo Serviço <i class="bi bi-plus-circle"></i>
            </button>
        </div>';
    }

    private function tableSection() {
        include '../../config/conexao.php'; // Inclua a conexão com o banco de dados
    
        // Supondo que $userId já esteja definido como o ID do usuário logado
        $userId = $_SESSION['id']; // Como exemplo, obtendo o user_id da sessão
    
        try {
            // Consulta para obter os produtos do usuário logado junto com o titulo_categoria da tabela Categorias
            $sql = "SELECT p.nome_produto, c.titulo_categoria, p.produto_id, p.status
                    FROM Produtos p
                    JOIN Categorias c ON p.categoria = c.categoria_id 
                    WHERE p.prestador = :userId"; // Supondo que a coluna 'categoria' em Produtos é uma chave estrangeira para 'categoria_id' em Categorias
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar produtos: " . $e->getMessage();
            return; // Adiciona um return para evitar que o código continue em caso de erro
        }
    
        echo '<div class="list-group mb-5">';
        
        // Verifica se há produtos e os exibe
        if (!empty($produtos)) {
            foreach ($produtos as $produto) {
                echo '
    <div class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">' . htmlspecialchars($produto['nome_produto']) . '</h5>
            <p class="mb-1">' . htmlspecialchars($produto['titulo_categoria']) . '</p>
        </div>
        <div>
            <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editService(' . $produto['produto_id'] . ')">
                <i class="fa-solid fa-pen"></i>
            </button>
            <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="confirmDelete(' . $produto['produto_id'] . ')">
                <i class="fa-solid fa-trash"></i>
            </button>
            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="viewService(' . $produto['produto_id'] . ')">
                <i class="fa-solid fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-admin view-photos" data-bs-toggle="modal" data-bs-target="#photosModal" onclick="viewPhotos(' . $produto['produto_id'] . ')">
                <i class="fa-solid fa-image"></i>
            </button>';

// Condição para o status
if ($produto['status'] == 1) {
    echo '
            <button class="btn btn-warning" style="width: 180px; margin-left: 10px;">
                Em aprovação
            </button>';
} elseif ($produto['status'] == 2) {
    echo '
            <button class="btn btn-success" style="width: 180px; margin-left: 10px;">
                Ativo
            </button>';
} elseif ($produto['status'] == 3) {
    echo '
            <button class="btn btn-secondary" style="width: 180px; margin-left: 10px;">
                Bloqueado
            </button>';
}

echo '
        </div>
    </div>';
            }
        } else {
            echo '
                <div class="list-group-item text-center">Nenhum produto encontrado.</div>';
        }
    
        echo '</div>';
    }

    private function modals() {
        
        include '../../config/conexao.php';

        try {
            $sql = "SELECT categoria_id, titulo_categoria FROM Categorias"; 
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar categorias: " . $e->getMessage();
        }
        
        echo '
        <div class="modal fade" id="novoServicoModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Novo Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" action="../../backend/servicos/save_service.php">
            <div class="mb-3 col-md-3">
                <label for="productType" class="form-label">Tipo</label>
                <select class="form-select" id="productType" name="productType" required onchange="toggleFields()">
                    <option value="" disabled selected>Selecione o tipo</option>
                    <option value="1">Produto</option>
                    <option value="2">Serviço</option>
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="serviceName" class="form-label">Título</label>
                    <input type="text" class="form-control" id="serviceName" name="serviceName" required placeholder="Digite o título do produto / serviço">
                </div>
                <div class="col-md-4">
                    <label for="serviceValue" class="form-label">Valor</label>
                    <input type="number" class="form-control" id="serviceValue" name="serviceValue" required placeholder="Digite o valor do produto / serviço">
                </div>
                <div class="col-md-4">
                    <label for="serviceCategory" class="form-label">Categoria</label>
                    <select class="form-select" id="serviceCategory" name="serviceCategory" required>
                                    <option value="" disabled selected>Selecione uma categoria</option>';
                                    foreach ($categorias as $categoria) {
                                        echo '<option value="' . $categoria['categoria_id'] . '">' . $categoria['titulo_categoria'] . '</option>';
                                    }
echo '                          </select>
                </div>
            </div>

            <div class="row mb-3" id="priceField" style="display: none;">
                <div class="col-md-6">
                    <label for="servicePrice" class="form-label">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="text" class="form-control" id="servicePrice" name="servicePrice" placeholder="0,00" onkeyup="formatPrice(this)">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="serviceDescription" class="form-label">Descrição</label>
                <textarea class="form-control" id="serviceDescription" name="serviceDescription" rows="4" maxlength="900" required></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="serviceImages" class="form-label">Imagens</label>
                    <input type="file" class="form-control" id="serviceImages" name="serviceImages[]" multiple accept="image/*" onchange="previewImages()">
                    <div id="imagePreview" class="preview d-flex flex-wrap"></div>
                </div>
                <div class="col-md-6">
                    <label for="serviceVideos" class="form-label">Vídeos</label>
                    <input type="file" class="form-control" id="serviceVideos" name="serviceVideos[]" multiple accept="video/*" onchange="previewVideos()">
                    <div id="videoPreview" class="preview d-flex flex-wrap"></div>
                </div>
            </div>

            <div class="text-center py-3">
                <button type="submit" class="btn text-light" style="background-color: #1B3C54; width: 57%;">Cadastrar</button>
            </div>
        </form>
                    </div>
                </div>
            </div>
        </div>';

        echo '
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="service-title" class="form-label">Título</label>
                                <input type="text" class="form-control" id="service-title" value="Reparos Gerais e Pequenas Reformas">
                            </div>
                            <div class="mb-3">
                                <label for="service-category" class="form-label">Categoria</label>
                                <input type="text" class="form-control" id="service-category" value="Manutenção Residencial">
                            </div>
                            <div class="mb-3">
                                <label for="service-provider" class="form-label">Descrição</label>
                                <textarea class="form-control" id="service-provider" rows="4">Serviço de consultoria personalizada para otimização de processos empresariais, visando eficiência e redução de custos operacionais.</textarea>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="serviceImages" class="form-label">Imagens</label>
                                <input type="file" class="form-control" id="serviceImages" name="serviceImages[]" multiple accept="image/*" onchange="previewImages()">
                                <div id="imagePreview" class="preview d-flex flex-wrap"></div>
                            </div>
                            <div class="col-md-12">
                                <label for="serviceVideos" class="form-label">Vídeos</label>
                                <input type="file" class="form-control" id="serviceVideos" name="serviceVideos[]" multiple accept="video/*" onchange="previewVideos()">
                                <div id="videoPreview" class="preview d-flex flex-wrap"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </div>
            </div>
        </div>';

        echo '
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Excluir Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza de que deseja excluir este serviço?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger">Excluir</button>
                    </div>
                </div>
            </div>
        </div>';

        echo '
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Visualizar Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Título</p>
                        <p>Categoria</p>
                        <p>Descrição</p>
                        <p>Imagens</p>
                        <p>Vídeos</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>';
    }

    private function footer() {
        include '../layouts/footer.php';
    }

    private function getScripts() {
        return '
        <script src="../../assets/js/previewImgs.js"></script>';
    }
    
}
$page = new MeusServicosPage();
$page->render();
 