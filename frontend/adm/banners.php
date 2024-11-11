<?php
include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php';

function showAlert($type, $title, $text) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: '$type',
            title: '$title',
            text: '$text',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/projAxeySenai/frontend/adm/banners.php';
            }
        });
    </script>";
}

if (isset($_POST['create_banner'])) {
    $target_dir = "../../assets/imgs/banners/";
    $target_file = $target_dir . basename($_FILES["banner_image"]["name"]);
    $target_name = "assets/imgs/banners/" . basename($_FILES["banner_image"]["name"]);

    // Verifica se o arquivo foi carregado corretamente
    if (is_uploaded_file($_FILES["banner_image"]["tmp_name"]) && move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)) {
        $titulo_categoria = htmlspecialchars($_POST['titulo_categoria']);
        $dataIni = $_POST['dataIni'];
        $dataFim = $_POST['dataFim'];

        $sql = "INSERT INTO Banners (image, legenda, data_inicial, data_final) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$target_name, $titulo_categoria, $dataIni, $dataFim]);

        if ($stmt->rowCount() > 0) {
            showAlert('success', 'Sucesso', 'Banner cadastrado com sucesso!');
        } else {
            showAlert('error', 'Erro ao cadastrar o banner', 'Erro ao inserir no banco de dados.');
        }
    } else {
        showAlert('error', 'Erro ao fazer upload do arquivo', 'Não foi possível mover o arquivo para o diretório de destino.');
    }
}

if (isset($_POST['update_banner'])) {
    $edit_id = $_POST['edit_id'];
    $edit_legenda = htmlspecialchars($_POST['edit_legenda']);
    $edit_dataFim = $_POST['edit_dataFim'];

    $sql = "UPDATE Banners SET legenda = ?, data_final = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$edit_legenda, $edit_dataFim, $edit_id]);

    if ($stmt->rowCount() > 0) {
        showAlert('success', 'Banner atualizado!', 'O banner foi atualizado com sucesso.');
    } else {
        showAlert('error', 'Erro', 'Não foi possível atualizar o banner.');
    }
}

if (isset($_POST['delete_banner'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM Banners WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$delete_id]);

    if ($stmt->rowCount() > 0) {
        showAlert('success', 'Banner excluído!', 'O banner foi excluído com sucesso.');
    } else {
        showAlert('error', 'Erro', 'Não foi possível excluir o banner.');
    }
}
?>

<style>
    .banners-container {
        width: 100%;
    }
    .banner-item {
        width: 100%;
        max-width: 100%;
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    .banner-item img {
        width: 280px;
        height: 80px;
        border-radius: 8px;
        margin-right: 20px;
    }
    .banner-details {
        flex-grow: 1;
    }
    .banner-actions button {
        margin-right: 10px;
    }
</style>

<body>
    <main class="main-admin">
        <div class="container container-admin">
            <nav aria-label="breadcrumb-admin">
                <ol class="breadcrumb breadcrumb-admin">
                    <li class="breadcrumb-item">
                        <a href="admin.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                    </li>
                </ol>
            </nav>
            <div class="title title-admin">GERENCIAR BANNERS</div>
            <div class="d-flex justify-content-between mb-4">
                <button type="button" id="meusAgendamentos" class="mb-2 btn btn-meus-agendamentos"
                        style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novoBannerModal"> Novo Banner <i class="bi bi-plus-circle"></i>
                </button>
            </div>
            <div class="banners-container">
                <ul class="list-group">
                    <?php
                    $sql = "SELECT * FROM Banners";
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $dataFinal = new DateTime($row['data_final']);
                            $dataFormatada = $dataFinal->format('d/m/Y');

                            echo "<li class='list-group-item banner-item'>";
                            echo "<img src='../../" . htmlspecialchars($row['image']) . "' alt='Banner' class='img-fluid'>";
                            echo "<div class='banner-details'>";
                            echo "<h5 class='mb-1'>" . htmlspecialchars($row['legenda']) . "</h5>";
                            echo "<p class='text-muted'>Válido até: " . $dataFormatada . "</p>";
                            echo "</div>";
                            echo "<div class='banner-actions d-flex'>";
                            echo "<button class='btn btn-primary btn-sm me-2' data-bs-toggle='modal' data-bs-target='#editModal' 
                                    data-id='" . $row['id'] . "' data-title='" . $row['legenda'] . "' data-final-date='" . $row['data_final'] . "'>Editar</button>";
                            echo "<button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' 
                                    data-id='" . $row['id'] . "' data-title='" . $row['legenda'] . "'>Excluir</button>";
                            echo "</div>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>Nenhum banner cadastrado.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </main>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="post" action="" enctype="multipart/form-data">
            <div class="modal-header">
               <h5 class="modal-title" id="editModalLabel">Editar Banner</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <input type="hidden" name="edit_id" id="edit-id">
               <div class="mb-3">
                  <label for="edit-title" class="form-label">Legenda</label>
                  <input type="text" class="form-control" id="edit-title" name="edit_legenda">
               </div>
               <div class="mb-3">
                  <label for="edit-image" class="form-label">Imagem do Banner</label>
                  <input type="file" class="form-control" id="edit-image" name="edit_image" accept="image/*">
               </div>
               <div class="mb-3">
                  <label for="edit-final-date" class="form-label">Data Final</label>
                  <input type="date" class="form-control" id="edit-final-date" name="edit_dataFim">
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary" name="update_banner">Salvar alterações</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Excluir Link</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <p>Tem certeza de que deseja excluir o link <span id="delete-title"></span>?</p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <form method="post" action="">
               <input type="hidden" name="delete_id" id="delete-id">
               <button type="submit" class="btn btn-danger" name="delete_banner">Excluir</button>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="novoBannerModal" tabindex="-1" aria-labelledby="novoBannerModalLabel"
   aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="novoBannerModalLabel">Novo Banner</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form method="post" enctype="multipart/form-data">
               <div class="col-md-12 mb-3">
                  <label for="bannerImage" class="form-label">Imagem</label>
                  <input type="file" class="form-control" id="bannerImage" name="banner_image" accept="image/*" onchange="previewImages()">
                  <div id="imagePreview" class="preview d-flex flex-wrap"></div>
               </div>
               <div class="mb-3">
                  <label for="legendaBanner" class="form-label">Legenda</label>
                  <input type="text" class="form-control" id="titulo_categoria" name="titulo_categoria">
               </div>
               <div class="mb-3">
                  <label for="prazoBanner" class="form-label">Prazo</label>
                  <div class="row">
                     <div class="col">
                        <input type="date" class="form-control" id="dataIni" name="dataIni">
                     </div>
                     <div class="col">
                        <input type="date" class="form-control" id="dataFim" name="dataFim">
                     </div>
                  </div>
               </div>
               <button type="submit" name="create_banner" class="btn btn-primary">Criar</button>
            </form>
         </div>
      </div>
   </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var title = button.getAttribute('data-title');
                var finalDate = button.getAttribute('data-final-date');

                editModal.querySelector('#edit-id').value = id;
                editModal.querySelector('#edit-title').value = title;
                editModal.querySelector('#edit-final-date').value = finalDate;
            });

            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var title = button.getAttribute('data-title');

                deleteModal.querySelector('#delete-title').textContent = title;
                deleteModal.querySelector('#delete-id').value = id;
            });
        });
    </script>
</body>
</html>
