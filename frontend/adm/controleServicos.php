<?php

if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
   header("Location: ../../frontend/auth/redirecionamento.php");
   exit();
} else if ($_SESSION['tipo_usuario'] != "Administrador") {
   header("Location: ../../index.php");
   exit();
}

include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php'; // Conectando ao banco de dados
?>

<body class="bodyCards">
   <main class="main-admin">
      <div class="container container-admin">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-admin">
               <li class="breadcrumb-item">
                  <a href="admin.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
               </li>
            </ol>
         </nav>
         <div class="title-admin">GERENCIAR SERVIÇOS</div>
         <div class="d-flex justify-content-end mb-4 ms-auto">
            <!-- Filtro de Busca -->
            <form method="GET" action="controleServicos.php" class="d-flex">
               <div class="me-2">
                  <select class="form-select" name="status" onchange="this.form.submit()">
                     <option value="" <?php echo !isset($_GET['status']) || $_GET['status'] == '' ? 'selected' : ''; ?>>Todos</option>
                     <option value="1" <?php echo isset($_GET['status']) && $_GET['status'] == 1 ? 'selected' : ''; ?>>Em Aprovação</option>
                     <option value="2" <?php echo isset($_GET['status']) && $_GET['status'] == 2 ? 'selected' : ''; ?>>Aprovados</option>
                     <option value="3" <?php echo isset($_GET['status']) && $_GET['status'] == 3 ? 'selected' : ''; ?>>Bloqueados</option>
                     <option value="4" <?php echo isset($_GET['status']) && $_GET['status'] == 4 ? 'selected' : ''; ?>>Reprovados</option>
                     <option value="5" <?php echo isset($_GET['status']) && $_GET['status'] == 5 ? 'selected' : ''; ?>>Removidos/Inativos</option>
                  </select>
               </div>
            </form>
         </div>

         <?php
         try {
            // Consultar todas as categorias para preencher o select
            $categoriesQuery = "SELECT * FROM Categorias";
            $categoriesStmt = $conexao->prepare($categoriesQuery);
            $categoriesStmt->execute();
            $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

            $statusFilter = isset($_GET['status']) ? $_GET['status'] : null;

            // Consultar os produtos, ordenando pelo status (colocando Aprovação primeiro) e depois por nome
            $sql = "SELECT p.*, c.titulo_categoria, pr.nome_resp_legal, pr.razao_social, pr.prestador_id 
            FROM Produtos p
            JOIN Categorias c ON p.categoria = c.categoria_id 
            JOIN Prestadores pr ON p.prestador = pr.prestador_id";

            // Aplica o filtro de status se selecionado
            if ($statusFilter) {
               $sql .= " WHERE p.status = :status";
            }

            // Adiciona a ordenação, colocando os produtos em 'Aprovação' (status = 1) primeiro
            $sql .= " ORDER BY p.status = 1 DESC, p.nome_produto ASC";  // Ordena por status (Aprovação primeiro) e nome

            $stmt = $conexao->prepare($sql);

            if ($statusFilter) {
               $stmt->bindParam(':status', $statusFilter, PDO::PARAM_INT);
            }

            $stmt->execute();
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
         } catch (PDOException $e) {
            echo "Erro ao buscar produtos: " . $e->getMessage();
         }
         ?>

         <div class="list-group mb-5">
            <?php if (!empty($produtos)): ?>
               <?php foreach ($produtos as $produto): ?>
                  <div class="list-group-item d-flex justify-content-between align-items-center">
                     <div>
                        <h5 class="mb-1"><?php echo htmlspecialchars($produto['nome_produto']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($produto['titulo_categoria']); ?></p>
                        <small>
                           Prestador: <?php echo htmlspecialchars($produto['nome_resp_legal']); ?> <br>
                           Razão Social: <?php echo htmlspecialchars($produto['razao_social']); ?>
                        </small>
                     </div>
                     <div class="actions-admin">
                        <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                           onclick="fillViewModal('<?php echo $produto['nome_produto']; ?>', 
                        '<?php echo $produto['titulo_categoria']; ?>', 
                        '<?php echo $produto['nome_resp_legal']; ?>', 
                        '<?php echo $produto['produto_id']; ?>')">
                           <i class="fa-solid fa-eye"></i>
                        </button>

                        <?php if ($produto['status'] == 1): ?>
                           <form method="POST" action="../../backend/servicos/atualizar_status.php" style="display:inline;">
                              <input type="hidden" name="produto_id" value="<?php echo $produto['produto_id']; ?>">
                              <input type="hidden" name="status" value="2">
                              <button type="submit" class="btn btn-success" name="aprovar" style="width: 92px;">
                                 Aprovar
                              </button>
                           </form>
                           <form method="POST" action="../../backend/servicos/reprovar_produto.php" style="display:inline;">
                              <input type="hidden" name="produto_id" value="<?php echo $produto['produto_id']; ?>">
                              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reproveModal" style="width: 92px" ;
                                 onclick="fillReproveModal('<?php echo $produto['produto_id']; ?>', '<?php echo $produto['nome_produto']; ?>')">
                                 Reprovar
                              </button>
                           </form>
                        <?php elseif ($produto['status'] == 2): ?>
                           <form method="POST" action="../../backend/servicos/atualizar_status.php" style="display:inline;">
                              <input type="hidden" name="produto_id" value="<?php echo $produto['produto_id']; ?>">
                              <input type="hidden" name="status" value="3">
                              <button type="submit" class="btn btn-danger" style="width: 180px; margin-left: 10px;">
                                 Bloquear
                              </button>
                           </form>
                        <?php elseif ($produto['status'] == 3): ?>
                           <form method="POST" action="../../backend/servicos/atualizar_status.php" style="display:inline;">
                              <input type="hidden" name="produto_id" value="<?php echo $produto['produto_id']; ?>">
                              <input type="hidden" name="status" value="2">
                              <button type="submit" class="btn btn-secondary" style="width: 180px; margin-left: 10px;">
                                 Desbloquear
                              </button>
                           </form>
                        <?php elseif ($produto['status'] == 4): ?>
                           <button
                              class="btn btn-danger"
                              style="width: 180px; margin-left: 10px; background-color: orange; border: none"
                              data-bs-toggle="modal"
                              data-bs-target="#rejectionReasonModal"
                              data-reason="<?php echo htmlspecialchars($produto['motivo_recusa']); ?>">
                              Reprovado
                           </button>
                        <?php elseif ($produto['status'] == 5): ?>
                           <button type="button" class="btn btn-danger" style="width: 180px; margin-left: 10px;">
                              Removidos
                           </button>
                        <?php endif; ?>
                     </div>
                  </div>
               <?php endforeach; ?>
            <?php else: ?>
               <div class="list-group-item text-center">Nenhum produto encontrado.</div>
            <?php endif; ?>
         </div>
      </div>
   </main>

   <!-- Modal de Visualização -->
   <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="viewModalLabel">Detalhes do Serviço</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p><strong>Título:</strong> <span id="view-service-title"></span></p>
               <p><strong>Categoria:</strong> <span id="view-service-category"></span></p>
               <p><strong>Prestador:</strong> <span id="view-service-provider"></span></p>
               <!-- Contêiner para as fotos do serviço -->
               <div id="service-photos-container" class="d-flex flex-wrap justify-content-center mt-3">
                  <!-- As fotos serão carregadas dinamicamente aqui -->
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
         </div>
      </div>
   </div>

   <!-- Modal de Reprovação -->
   <div class="modal fade" id="reproveModal" tabindex="-1" aria-labelledby="reproveModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="reproveModalLabel">Reprovar Anúncio</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="../../backend/servicos/reprovar_produto.php">
               <div class="modal-body">
                  <input type="hidden" name="produto_id" id="reprove-product-id">
                  <div class="mb-3">
                     <label for="motivo-recusa" class="form-label">Motivo da Recusa</label>
                     <textarea name="motivo" id="motivo-recusa" class="form-control" rows="4" required></textarea>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-danger">Enviar</button>
               </div>
            </form>
         </div>
      </div>
   </div>


   <!-- Modal para exibir o motivo da recusa -->
   <div class="modal fade" id="rejectionReasonModal" tabindex="-1" aria-labelledby="rejectionReasonModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="rejectionReasonModalLabel">Motivo da Recusa</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p id="rejectionReasonText">Motivo não informado.</p>
            </div>

            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
         </div>
      </div>
   </div>


   <script>
      function fillReproveModal(produtoId, produtoNome) {
         document.getElementById('reprove-product-id').value = produtoId;
      }


      function fillViewModal(title, category, provider, produtoId) {
         document.getElementById('view-service-title').innerText = title;
         document.getElementById('view-service-category').innerText = category;
         document.getElementById('view-service-provider').innerText = provider;

         // Limpa as fotos antigas antes de carregar novas
         const photosContainer = document.getElementById('service-photos-container');
         photosContainer.innerHTML = '';

         // Busca as fotos do serviço
         fetch('../../backend/servicos/get_service_photos.php?produto_id=' + produtoId)
            .then(response => response.json())
            .then(data => {
               if (data.success && data.images.length > 0) {
                  // Adiciona cada imagem ao contêiner
                  data.images.forEach(imageUrl => {
                     const imgElement = document.createElement('img');
                     imgElement.src = imageUrl;
                     imgElement.classList.add('img-fluid', 'm-2');
                     imgElement.style.maxWidth = '150px'; // Define o tamanho das imagens
                     photosContainer.appendChild(imgElement);
                  });
               } else {
                  photosContainer.innerHTML = '<p>Nenhuma imagem disponível para este serviço.</p>';
               }
            })
            .catch(error => {
               console.error('Erro ao carregar imagens:', error);
               photosContainer.innerHTML = '<p>Erro ao carregar imagens.</p>';
            });
      }

      // Adiciona evento para carregar o motivo da recusa ao abrir a modal
      document.addEventListener('DOMContentLoaded', function() {
         const rejectionReasonModal = document.getElementById('rejectionReasonModal');

         rejectionReasonModal.addEventListener('show.bs.modal', function(event) {
            // Botão que acionou a modal
            const button = event.relatedTarget;

            // Motivo da recusa
            const reason = button.getAttribute('data-reason');

            // Atualiza o conteúdo da modal com o motivo da recusa
            const rejectionReasonText = rejectionReasonModal.querySelector('#rejectionReasonText');
            rejectionReasonText.textContent = reason || "Motivo não informado.";
         });
      });
   </script>
   <?php
   include '../layouts/footer.php';
   ?>