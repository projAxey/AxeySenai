<?php 
include '../layouts/head.php'; 
include '../layouts/nav.php'; 
?>

<body class="bodyCards">
   <main class="main-admin">
      <div class="container container-admin">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-admin">
               <li class="breadcrumb-item">
                  <a href="../auth/perfil.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
               </li>
            </ol>
         </nav>
         <div class="title-admin">MEUS SERVIÇOS</div>

<?php
include '../../config/conexao.php'; 

// Supondo que $userId já esteja definido como o ID do usuário logado
$userId = $_SESSION['id']; // Como exemplo, obtendo o user_id da sessão

try {
    // Consulta para obter os produtos do usuário logado junto com o titulo_categoria da tabela Categorias
    $sql = "SELECT p.nome_produto, c.titulo_categoria, p.produto_id, p.status, p.valor_produto
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

$categoriesQuery = "SELECT * FROM Categorias";
$categoriesStmt = $conexao->prepare($categoriesQuery);
$categoriesStmt->execute();
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="list-group mb-5">';

// Verifica se há produtos e os exibe
if (!empty($produtos)) {
    foreach ($produtos as $produto) {
        echo '
<div class="list-group-item d-flex justify-content-between align-items-center">
    <div>
        <h5 class="mb-1">' . htmlspecialchars($produto['nome_produto']) . '</h5>
        <p class="mb-1">' . htmlspecialchars($produto['titulo_categoria']) . '</p>
        <p class="mb-1">R$ ' . htmlspecialchars(str_replace('.', ',', $produto['valor_produto'])) . '</p>
    </div>
    <div class="actions-admin">
        <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editService(' . $produto['produto_id'] . ', \'' . htmlspecialchars($produto['nome_produto']) . '\', \'' . htmlspecialchars($produto['valor_produto']) . '\', \'' . htmlspecialchars($produto['titulo_categoria']) . '\')">
            <i class="fa-solid fa-pen"></i>
        </button>
        <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="confirmDelete(' . $produto['produto_id'] . ')">
            <i class="fa-solid fa-trash"></i>
        </button>
        <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
            onclick="viewService(\'' . htmlspecialchars($produto['nome_produto']) . '\', \'' . htmlspecialchars($produto['titulo_categoria']) . '\', \'' . htmlspecialchars($produto['valor_produto']) . '\')">
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
?>

<!-- Modal de Visualização -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Detalhes do Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Título:</strong> <span id="view-service-title"></span></p>
                <p><strong>Categoria:</strong> <span id="view-service-category"></span></p>
                <p><strong>Valor:</strong> <span id="view-service-price"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário de Edição -->
                <form id="editServiceForm" method="POST" action="../../backend/servicos/editarServicoUser.php">
                    <input type="hidden" id="edit-service-id" name="edit-service-id">
                    <div class="mb-3">
                        <label for="edit-service-title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit-service-title" name="edit-service-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-service-title" class="form-label">Valor</label>
                        <input type="text" class="form-control" id="edit-service-price" name="edit-service-price" required>
                    </div>
                    <select class="mb-3 form-select" id="service-category" name="edit-service-category" onchange="updateCategory(this)">
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['categoria_id']; ?>">
                           <?php echo htmlspecialchars($category['titulo_categoria']); ?>
                        </option>
                        <?php endforeach; ?>
                     </select>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja excluir este serviço?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-btn">Excluir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Fotos -->
<div class="modal fade" id="photosModal" tabindex="-1" aria-labelledby="photosModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photosModalLabel">Fotos do Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aqui você pode adicionar a lógica para exibir as fotos -->
                <p>Fotos do produto serão exibidas aqui.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

</div>
      </div>
   </main>

<?php
      include '../layouts/footer.php';
      ?>

<script>
function editService(produtoId, nomeProduto, categoriaId, valorProduto) {
    document.getElementById('edit-service-id').value = produtoId;
    document.getElementById('edit-service-title').value = nomeProduto;
    document.getElementById('edit-service-category').value = categoriaId;
    document.getElementById('edit-service-price').value = valorProduto.replace('.', ',');
}

function viewService(nomeProduto, tituloCategoria, valorProduto) {
    document.getElementById('view-service-title').textContent = nomeProduto;
    document.getElementById('view-service-category').textContent = tituloCategoria;
    document.getElementById('view-service-price').textContent = 'R$ ' + valorProduto.replace('.', ',');
}

let produtoIdParaDeletar;

function confirmDelete(produtoId) {
    produtoIdParaDeletar = produtoId;
}

document.getElementById('confirm-delete-btn').addEventListener('click', function() {
    fetch(`delete_product.php?id=${produtoIdParaDeletar}`, {
        method: 'DELETE'
    })
    .then(response => {
        if (response.ok) {
            console.log('Produto excluído com sucesso.');
            location.reload();
        } else {
            console.error('Erro ao excluir produto.');
        }
    })
    .catch(error => console.error('Erro ao excluir produto:', error));
});
</script>
