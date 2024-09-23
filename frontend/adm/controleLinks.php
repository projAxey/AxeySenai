<?php
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
            <div class="title title-admin">GERENCIAR LINKS</div>
            <div class="table-responsive">
                <table class="table table-striped table-striped-admin">
                    <thead>
                        <tr>
                            <th class="th-admin">TÍTULO</th>
                            <th class="th-admin">LINK</th>
                            <th class="th-admin">ICONE</th>
                            <th class="th-admin">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>INSTAGRAM</td>
                            <td>https://www.instagram.com/</td>
                            <td><i class="fa-brands fa-instagram"></i></td>
                            <td class="actions actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-title="Instagram" data-link="https://www.instagram.com/" data-icon="fa-brands fa-instagram"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-title="Instagram"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-title="Instagram" data-link="https://www.instagram.com/" data-icon="fa-brands fa-instagram"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>FACEBOOK</td>
                            <td>https://www.facebook.com/</td>
                            <td><i class="fa-brands fa-facebook"></i></td>
                            <td class="actions actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-title="Facebook" data-link="https://www.facebook.com/" data-icon="fa-brands fa-facebook"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-title="Facebook"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-title="Facebook" data-link="https://www.facebook.com/" data-icon="fa-brands fa-facebook"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>TWITTER</td>
                            <td>https://www.twitter.com/</td>
                            <td><i class="fa-brands fa-twitter"></i></td>
                            <td class="actions actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-title="Twitter" data-link="https://www.twitter.com/" data-icon="fa-brands fa-twitter"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-title="Twitter"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-title="Twitter" data-link="https://www.twitter.com/" data-icon="fa-brands fa-twitter"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>LINKEDIN</td>
                            <td>https://www.linkedin.com/</td>
                            <td><i class="fa-brands fa-linkedin"></i></td>
                            <td class="actions actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-title="LinkedIn" data-link="https://www.linkedin.com/" data-icon="fa-brands fa-linkedin"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-title="LinkedIn"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-title="LinkedIn" data-link="https://www.linkedin.com/" data-icon="fa-brands fa-linkedin"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>YOUTUBE</td>
                            <td>https://www.youtube.com/</td>
                            <td><i class="fa-brands fa-youtube"></i></td>
                            <td class="actions actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-title="YouTube" data-link="https://www.youtube.com/" data-icon="fa-brands fa-youtube"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-title="YouTube"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-title="YouTube" data-link="https://www.youtube.com/" data-icon="fa-brands fa-youtube"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>GITHUB</td>
                            <td>https://www.github.com/</td>
                            <td><i class="fa-brands fa-github"></i></td>
                            <td class="actions actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-title="GitHub" data-link="https://www.github.com/" data-icon="fa-brands fa-github"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-title="GitHub"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-title="GitHub" data-link="https://www.github.com/" data-icon="fa-brands fa-github"><i class="fa-solid fa-eye"></i></button>
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
                    <h5 class="modal-title" id="editModalLabel">Editar Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit-title">
                    </div>
                    <div class="mb-3">
                        <label for="edit-link" class="form-label">Link</label>
                        <input type="text" class="form-control" id="edit-link">
                    </div>
                    <div class="mb-3">
                        <label for="edit-icon" class="form-label">Ícone</label>
                        <input type="text" class="form-control" id="edit-icon">
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var title = button.getAttribute('data-title');
                var link = button.getAttribute('data-link');
                var icon = button.getAttribute('data-icon');
                var modalTitle = editModal.querySelector('.modal-title');
                var titleInput = editModal.querySelector('#edit-title');
                var linkInput = editModal.querySelector('#edit-link');
                var iconInput = editModal.querySelector('#edit-icon');
                modalTitle.textContent = 'Editar ' + title;
                titleInput.value = title;
                linkInput.value = link;
                iconInput.value = icon;
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