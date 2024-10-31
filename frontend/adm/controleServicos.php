<?php
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
         <div class="d-flex justify-content-between mb-4">
            <button type="button" class="btn btn-meus-agendamentos"
               style="background-color: #012640; color:white"
               onclick="window.location.href='controleCategorias.php'">
               Gerenciar Categorias
            </button>
            <?php if (isset($_GET['status']) && $_GET['status'] == 1): ?>
               <a href="controleServicos.php" class="btn btn-secondary">
                  Limpar o Filtro
               </a>
            <?php else: ?>
               <form method="GET" action="">
                  <input type="hidden" name="status" value="1">
                  <button type="submit" class="btn btn-success">
                     Aprovações
                  </button>
               </form>
            <?php endif; ?>
         </div>
         <?php
         try {
            // Consultar todas as categorias para preencher o select
            $categoriesQuery = "SELECT * FROM Categorias";
            $categoriesStmt = $conexao->prepare($categoriesQuery);
            $categoriesStmt->execute();
            $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

            $statusFilter = isset($_GET['status']) ? $_GET['status'] : null;

            $sql = "SELECT p.*, c.titulo_categoria, pr.nome_resp_legal, pr.razao_social, pr.prestador_id 
                        FROM Produtos p
                        JOIN Categorias c ON p.categoria = c.categoria_id 
                        JOIN Prestadores pr ON p.prestador = pr.prestador_id";

            if ($statusFilter) {
               $sql .= " WHERE p.status = :status";
            }

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
                        <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                           onclick="fillEditModal('<?php echo $produto['produto_id']; ?>', '<?php echo $produto['nome_produto']; ?>', '<?php echo $produto['titulo_categoria']; ?>', '<?php echo $produto['nome_resp_legal']; ?>', '<?php echo $produto['prestador_id']; ?>', '<?php echo $produto['categoria']; ?>')">
                           <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                           onclick="document.getElementById('delete-product-id').value = '<?php echo $produto['produto_id']; ?>'">
                           <i class="fa-solid fa-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                           onclick="fillViewModal('<?php echo $produto['nome_produto']; ?>', '<?php echo $produto['titulo_categoria']; ?>', '<?php echo $produto['nome_resp_legal']; ?>', '<?php echo $produto['produto_id']; ?>')">
                           <i class="fa-solid fa-eye"></i>
                        </button>

                        <?php if ($produto['status'] == 1): ?>
                           <form method="POST" action="../../backend/servicos/atualizar_status.php" style="display:inline;">
                              <input type="hidden" name="produto_id" value="<?php echo $produto['produto_id']; ?>">
                              <input type="hidden" name="status" value="2">
                              <button type="submit" class="btn btn-success" style="width: 180px; margin-left: 10px;">
                                 Aprovar
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
   <!-- Modal de Edição -->
   <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="editModalLabel">Editar Serviço</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form method="POST" action="../../backend/servicos/editarServicoAdmin.php">
                  <input type="hidden" id="service-id" name="produto_id">
                  <input type="hidden" id="prestador-id" name="prestador_id"> <!-- Campo oculto para prestador_id -->
                  <input type="hidden" id="categoria-id" name="categoria_id"> <!-- Campo oculto para categoria_id -->
                  <div class="mb-3">
                     <label for="service-title" class="form-label">Título</label>
                     <input type="text" class="form-control" id="service-title" name="nome_produto">
                  </div>
                  <div class="mb-3">
                     <label for="service-category" class="form-label">Categoria</label>
                     <select class="form-select" id="service-category" name="categoria" onchange="updateCategory(this)">
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categories as $category): ?>
                           <option value="<?php echo $category['categoria_id']; ?>">
                              <?php echo htmlspecialchars($category['titulo_categoria']); ?>
                           </option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <div class="mb-3">
                     <label for="service-provider" class="form-label">Prestador</label>
                     <input type="text" class="form-control" id="service-provider" readonly> <!-- Exibe o nome do prestador -->
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                     <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                  </div>
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
               <h5 class="modal-title" id="deleteModalLabel">Excluir Serviço</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p>Você tem certeza que deseja excluir este serviço?</p>
               <form method="POST" action="../../backend/servicos/deletarServicoAdmin.php">
                  <input type="hidden" id="delete-product-id" name="produto_id">
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                     <button type="submit" class="btn btn-danger">Excluir</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
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
               <p><strong>Imagens:</strong></p>
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

   <!-- Scripts -->
   <script>
      function fillEditModal(id, title, categoryName, providerName, providerId, categoryId) {
         document.getElementById('service-id').value = id;
         document.getElementById('service-title').value = title;
         document.getElementById('prestador-id').value = providerId; // Enviar o prestador_id oculto
         document.getElementById('service-provider').value = providerName; // Mostrar o nome do prestador
         document.getElementById('categoria-id').value = categoryId; // Enviar o categoria_id oculto
         document.getElementById('service-category').value = categoryId; // Selecionar a categoria correta no select
      }

      function updateCategory(select) {
         var categoryId = select.value;
         document.getElementById('categoria-id').value = categoryId; // Atualizar o campo oculto de categoria_id
      }

      function fillViewModal(title, category, provider) {
         document.getElementById('view-service-title').innerText = title;
         document.getElementById('view-service-category').innerText = category;
         document.getElementById('view-service-provider').innerText = provider;
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
   </script>
   <?php
   include '../layouts/footer.php';
   ?>