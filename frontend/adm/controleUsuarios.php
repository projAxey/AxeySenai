<?php
include '../layouts/head.php';
include '../layouts/nav.php';
?>

<body>
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
            <div class="d-flex justify-content-between mb-4">
                <button type="button" id="meusAgendamentos" class="mb-2 btn btn-primary btn-meus-agendamentos"
                    style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novoUsuario">
                    Novo Usuário <i class="bi bi-plus-circle"></i>
                </button>
            </div>
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
                                <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="row g-">
                            <div class="mb-3" id="nomeCompleto">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome" name="nome">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-2" id="respLegal">
                                <label for="respLegal" class="form-label">Responsável Legal</label>
                                <input type="text" class="form-control" name="responsavelLegal">
                            </div>
                            <div class="col-md-12" id="nome-social-div">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="nome-social-checkbox">
                                    <label class="form-check-label" for="nome-social-checkbox">Usar Nome Social</label>
                                </div>
                            </div>

                            <div class="col-md-12" id="nome-social-field" style="display: none;">
                                <label for="nome-social" class="form-label">Nome Social</label>
                                <input type="text" class="form-control" id="nome-social" maxlength="100">
                            </div>
                            <div class="mb-3" id="nomeFantasiaField">
                                <label for="nomeFantasia" class="form-label">Nome Fantasia *</label>
                                <input type="text" class="form-control" id="nomeFantasia" name="nomeFantasia">
                            </div>
                            <div class="mb-3" id="razaoSocialField">
                                <label for="razaoSocial" class="form-label">Razão Social *</label>
                                <input type="text" class="form-control" id="razaoSocial" name="razaoSocial">
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-7">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                    <div class="emailFeedback"></div>
                                </div>
                                <div class="col-md-5" id="dataNascimentoFields">
                                    <label for="dataNascimento" class="form-label">Data de Nascimento *</label>
                                    <input type="date" class="form-control text-center" id="dataNascimento" name="dataNascimento">
                                    <div class="invalid-feedback">Por favor, insira uma data acima de 1924 e abaixo de 2124.</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6" id="cnpjFields" class="d-none">
                                    <label for="cnpj" class="form-label">CNPJ *</label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" maxlength="18">
                                    <div class="invalid-feedback">Por favor, preencha um CNPJ válido.</div>
                                </div>
                                <div class="col-md-6" id="cpfFields" class="d-none">
                                    <label for="cpf" class="form-label">CPF *</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14">
                                    <div class="invalid-feedback">Por favor, preencha um CPF válido.</div>
                                </div>
                                <div class="col-md-6" id="categoriaFields">
                                    <label for="seguimento" class="form-label">Categoria *</label>
                                    <select class="form-select" id="categoria" name="categoria">
                                        <option value="" selected>Selecione uma categoria</option>
                                        <option value="teste">Aqui vem do banco</option>
                                    </select>
                                </div>
                            </div>

                            <div id="descricaoFields">
                                <div class="mb-3">
                                    <label for="descricao" class="form-label">Descrição do Negócio *</label>
                                    <textarea class="form-control descricaoNegocio" id="descricao" name="descricao"></textarea>
                                    <div class="invalid-feedback" id="descricao-error">A descrição deve ter pelo menos 30 caracteres.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="celular" class="form-label">Celular</label>
                                <input type="tel" class="form-control" id="celular" pattern="\(\d{2}\) \d{5}-\d{4}" required aria-required="true" maxlength="15" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="telefone" pattern="\(\d{2}\) \d{4}-\d{4}" maxlength="14" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control" id="cep" pattern="\d{5}-\d{3}" required aria-required="true" disabled>
                                <small id="cepHelp" class="form-text text-muted">
                                    <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep" target="_blank" style="text-decoration: none;">Não sei meu CEP</a>
                                </small>
                            </div>
                            <div class="col-md-5">
                                <label for="endereco" class="form-label">Endereço *</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" disabled>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <button type="submit" class="btn btn-primary mb-2" id="botaoSalvar" style="background-color: #012640; color:white" disabled>Salvar</button>

                                <button type="cancel" class="btn btn-secondary mb-2" id="botaoCancelar" style=" color:white" disabled>Cancelar</button>
                            </div>
                        </div>
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
    <div class="modal fade" id="novoUsuario" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Novo Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="CadastroUsuarios" onsubmit="validaCampos(event)" method="POST" action="../../backend/auth/register.php">
                        <div class="row">
                            <div class="mb-3 col-md-12" id="nomeFields">
                                <label for="nome" class="form-label" id="nomeLabel">Nome Completo</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: João Antonio da Silva" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3 col-md-5" id="tipoUsuarioFields">
                                <label for="tipo_usuario" class="form-label">Tipo de Usuário</label>
                                <select class="form-select" id="tipo_usuario" name="tipo_usuario" required>
                                    <option value="" disabled selected>Selecione um tipo de usuário</option>
                                    <option value="A">Administrador</option>
                                    <option value="C">Cliente</option>
                                    <option value="P">Prestador</option>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6" id="cpfFields">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" placeholder="Ex: 123.456.789-00" required>
                                    <div class="invalid-feedback">Por favor, preencha um CPF válido.</div>
                                </div>
                                <div class="col-md-6" id="emailFields">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Ex: joaoantonio@gmail.com" required>
                                    <div class="invalid-feedback">Por favor, preencha um email válido.</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6" id="celularFields">
                                    <label for="celular" class="form-label">Celular</label>
                                    <input type="text" class="form-control" id="celular" name="celular" placeholder="Ex: 11987654321" required>
                                    <div id="aviso-celular" class="text-danger" style="display:none;"></div>
                                </div>
                                <div class="col-md-6" id="telefoneFields">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Ex: 1134567890">
                                    <div id="aviso-telefone" class="text-danger" style="display:none;"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6" id="cepFields">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" maxlength="9" required>
                                    <small id="cepHelp" class="form-text text-muted">
                                        <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank">Não sei meu CEP</a>
                                    </small>
                                </div>
                                <div class="col-md-6" id="cidadeFields">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Ex: São Paulo" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4" id="bairroFields">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Ex: Centro" required>
                                </div>
                                <div class="col-md-4" id="ruaFields">
                                    <label for="rua" class="form-label">Rua</label>
                                    <input type="text" class="form-control" id="rua" name="rua" placeholder="Ex: Av. Paulista" required>
                                </div>
                                <div class="col-md-4" id="numeroFields">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero" maxlength="20" placeholder="Ex: 123" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6" id="ufFields">
                                    <label for="uf" class="form-label">UF</label>
                                    <input type="text" class="form-control" id="uf" name="uf" maxlength="2" placeholder="Ex: SP" required>
                                </div>
                                <div class="col-md-6" id="complementoFields">
                                    <label for="complemento" class="form-label">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Ex: Apto 101">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #1B3C54;">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>



    <script src="../../assets/js/validaPerfil.js"></script>
    <!-- <script>
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
    </script> -->
</body>

</html>