<?php
include '../../padroes/head.php';
?>


<body>
    <?php include '../../padroes/nav.php'; ?>
    <main class="main-admin">
        <div class="container container-admin">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-admin">
                    <li class="breadcrumb-item">
                        <a href="admin.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                    </li>
                </ol>
            </nav>
            <div class="title-admin">GERENCIAR USUÁRIOS</div>
            <div class="table-responsive">
                <table class="table table-striped table-striped-admin">
                    <thead>
                        <tr>
                            <th class="th-admin">NOME</th>
                            <th class="th-admin">TELEFONE</th>
                            <th class="th-admin">E-MAIL</th>
                            <th class="th-admin">TIPO USUÁRIO</th>
                            <th class="th-admin">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Vinicius Pavesi</td>
                            <td>(47) 98912-4939</td>
                            <td>vinicius.paavesi@gmail.com</td>
                            <td>Administrador</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-name="Vinicius Pavesi" data-phone="(47) 98912-4939"
                                    data-email="vinicius.paavesi@gmail.com" data-user-type="Administrador"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-name="Vinicius Pavesi" data-phone="(47) 98912-4939"
                                    data-email="vinicius.paavesi@gmail.com" data-user-type="Administrador"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-name="Vinicius Pavesi" data-phone="(47) 98912-4939"
                                    data-email="vinicius.paavesi@gmail.com" data-user-type="Administrador"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Vinicius Costa</td>
                            <td>(47) 99698-4949</td>
                            <td>vinicius.costa@gmail.com</td>
                            <td>Prestador</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-name="Vinicius Costa" data-phone="(47) 99698-4949"
                                    data-email="vinicius.costa@gmail.com" data-user-type="Prestador"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-name="Vinicius Costa" data-phone="(47) 99698-4949"
                                    data-email="vinicius.costa@gmail.com" data-user-type="Prestador"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-name="Vinicius Costa" data-phone="(47) 99698-4949"
                                    data-email="vinicius.costa@gmail.com" data-user-type="Prestador"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Affonso Silva</td>
                            <td>(47) 99635-4754</td>
                            <td>affonso.silva@gmail.com</td>
                            <td>Cliente</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-name="Affonso Silva" data-phone="(47) 99635-4754"
                                    data-email="affonso.silva@gmail.com" data-user-type="Cliente"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-name="Affonso Silva" data-phone="(47) 99635-4754"
                                    data-email="affonso.silva@gmail.com" data-user-type="Cliente"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-name="Affonso Silva" data-phone="(47) 99635-4754"
                                    data-email="affonso.silva@gmail.com" data-user-type="Cliente"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Fernando Warmiling</td>
                            <td>(47) 99456-1247</td>
                            <td>fernando.warmiling@gmail.com</td>
                            <td>Cliente</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-name="Fernando Warmiling" data-phone="(47) 99456-1247"
                                    data-email="fernando.warmiling@gmail.com" data-user-type="Cliente"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-name="Fernando Warmiling" data-phone="(47) 99456-1247"
                                    data-email="fernando.warmiling@gmail.com" data-user-type="Cliente"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-name="Fernando Warmiling" data-phone="(47) 99456-1247"
                                    data-email="fernando.warmiling@gmail.com" data-user-type="Cliente"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Luis Felisbino</td>
                            <td>(47) 99756-1379</td>
                            <td>luis.felisbino@gmail.com</td>
                            <td>Cliente</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-name="Luis Felisbino" data-phone="(47) 99756-1379"
                                    data-email="luis.felisbino@gmail.com" data-user-type="Cliente"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-name="Luis Felisbino" data-phone="(47) 99756-1379"
                                    data-email="luis.felisbino@gmail.com" data-user-type="Cliente"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-name="Luis Felisbino" data-phone="(47) 99756-1379"
                                    data-email="luis.felisbino@gmail.com" data-user-type="Cliente"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Maria Oliveira</td>
                            <td>(47) 98877-1234</td>
                            <td>maria.oliveira@gmail.com</td>
                            <td>Administrador</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-name="Maria Oliveira" data-phone="(47) 98877-1234"
                                    data-email="maria.oliveira@gmail.com" data-user-type="Administrador"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-name="Maria Oliveira" data-phone="(47) 98877-1234"
                                    data-email="maria.oliveira@gmail.com" data-user-type="Administrador"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-name="Maria Oliveira" data-phone="(47) 98877-1234"
                                    data-email="maria.oliveira@gmail.com" data-user-type="Administrador"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Pedro Santos</td>
                            <td>(47) 99988-7654</td>
                            <td>pedro.santos@gmail.com</td>
                            <td>Prestador</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-name="Pedro Santos" data-phone="(47) 99988-7654"
                                    data-email="pedro.santos@gmail.com" data-user-type="Prestador"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-name="Pedro Santos" data-phone="(47) 99988-7654"
                                    data-email="pedro.santos@gmail.com" data-user-type="Prestador"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                    data-name="Pedro Santos" data-phone="(47) 99988-7654"
                                    data-email="pedro.santos@gmail.com" data-user-type="Prestador"><i class="fa-solid fa-eye"></i></button>
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
                    <h5 class="modal-title" id="editModalLabel">Editar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="editName">
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="editPhone">
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="editEmail">
                        </div>
                        <div class="mb-3">
                            <label for="editUserType" class="form-label">Tipo Usuário</label>
                            <select class="form-select" id="editUserType">
                                <option value="Administrador">Administrador</option>
                                <option value="Prestador">Prestador</option>
                                <option value="Cliente">Cliente</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Excluir Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja excluir este usuário?
                    <p id="deleteUserInfo"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Visualizar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nome:</strong> <span id="viewName"></span></p>
                    <p><strong>Telefone:</strong> <span id="viewPhone"></span></p>
                    <p><strong>E-mail:</strong> <span id="viewEmail"></span></p>
                    <p><strong>Tipo Usuário:</strong> <span id="viewUserType"></span></p>
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
            var deleteModal = document.getElementById('deleteModal');
            var viewModal = document.getElementById('viewModal');

            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var name = button.getAttribute('data-name');
                var phone = button.getAttribute('data-phone');
                var email = button.getAttribute('data-email');
                var userType = button.getAttribute('data-user-type');
                var modal = editModal.querySelector('form');
                modal.querySelector('#editName').value = name;
                modal.querySelector('#editPhone').value = phone;
                modal.querySelector('#editEmail').value = email;
                modal.querySelector('#editUserType').value = userType;
            });

            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var name = button.getAttribute('data-name');
                var phone = button.getAttribute('data-phone');
                var email = button.getAttribute('data-email');
                var userType = button.getAttribute('data-user-type');
                var modalBody = deleteModal.querySelector('.modal-body');
                modalBody.querySelector('#deleteUserInfo').textContent = `Nome: ${name}, Telefone: ${phone}, E-mail: ${email}, Tipo Usuário: ${userType}`;
            });

            viewModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var name = button.getAttribute('data-name');
                var phone = button.getAttribute('data-phone');
                var email = button.getAttribute('data-email');
                var userType = button.getAttribute('data-user-type');
                var modalBody = viewModal.querySelector('.modal-body');
                modalBody.querySelector('#viewName').textContent = name;
                modalBody.querySelector('#viewPhone').textContent = phone;
                modalBody.querySelector('#viewEmail').textContent = email;
                modalBody.querySelector('#viewUserType').textContent = userType;
            });
        });
    </script>
</body>

</html>