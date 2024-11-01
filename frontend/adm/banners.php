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
?>

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
            <div class="table-responsive">
                <table class="table table-striped table-striped-admin">
                    <thead>
                        <tr>
                            <th class="th-admin">LEGENDA</th>
                            <th class="th-admin">IMAGEM</th>
                            <th class="th-admin">PRAZO</th>
                            <th class="th-admin">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>legenda</td>
                            <td>hash da imagem</td>
                            <td>24/06/2023</td>
                            <td class="actions actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>legenda</td>
                            <td>hash da imagem</td>
                            <td>24/06/2023</td>
                            <td class="actions actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Legenda</label>
                        <input type="text" class="form-control" id="edit-title">
                    </div>
                    <div class="mb-3">
                        <label for="edit-link" class="form-label">Data final</label>
                        <input type="text" class="form-control" id="edit-link">
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn mb-2" id="alterar-foto" style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#modalAlterarFoto">
                            <i class="bi bi-pencil"></i> Alterar Foto
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Salvar alterações</button>
                </div>
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
                    <button type="button" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Detalhes do Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Título: <span id="view-title"></span></p>
                    <p>Link: <a id="view-link" href="" target="_blank"></a></p>
                    <p>Ícone: <i id="view-icon"></i></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
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
                    <form" method="post">
                        <div class="col-md-12 mb-3">
                            <label for="bannerImage" class="form-label">Imagem</label>
                            <input type="file" class="form-control" id="bannerImage" name="banner-image" accept="image/*" onchange="previewImages()">
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
                        <button type="submit" name="create_category" class="btn btn-primary">Criar</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="../../assets/JS/previewImgs.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var link = button.getAttribute('data-link');
                var icon = button.getAttribute('data-icon');
                var modalTitle = editModal.querySelector('.modal-title');
                var titleInput = editModal.querySelector('#edit-title');
                var linkInput = editModal.querySelector('#edit-link');
                var iconInput = editModal.querySelector('#edit-icon');
                // modalTitle.textContent = 'Editar ' + title;
                // titleInput.value = title;
                // linkInput.value = link;
                // iconInput.value = icon;
            });

            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var title = button.getAttribute('data-title');
                var modalBody = deleteModal.querySelector('.modal-body');
                modalBody.querySelector('#delete-title').textContent = title;
            });

            var viewModal = document.getElementById('viewModal');
            viewModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var title = button.getAttribute('data-title');
                var link = button.getAttribute('data-link');
                var icon = button.getAttribute('data-icon');
                var modalTitle = viewModal.querySelector('.modal-title');
                var viewTitle = viewModal.querySelector('#view-title');
                var viewLink = viewModal.querySelector('#view-link');
                var viewIcon = viewModal.querySelector('#view-icon');
                modalTitle.textContent = 'Detalhes do ' + title;
                viewTitle.textContent = title;
                viewLink.href = link;
                viewLink.textContent = link;
                viewIcon.className = icon;
            });
        });
    </script>
</body>

</html>
</>