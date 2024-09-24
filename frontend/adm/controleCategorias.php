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
            <div class="title-admin">GERENCIAR CATEGORIAS</div>
            <div class="d-flex justify-content-between mb-4">
            <button type="button" id="meusAgendamentos" class="mb-2 btn btn-primary btn-meus-agendamentos"
                    style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novaCategoriaModal">
                    Nova Categoria <i class="bi bi-plus-circle"></i>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-striped-admin">
                    <thead>
                        <tr>
                            <th class="th-admin">TÍTULO</th>
                            <th class="th-admin">DESCRIÇÃO</th>
                            <th class="th-admin">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Manutenção Residencial</td>
                            <td>Reparos Gerais e Pequenas Reformas</td>                         
                            <td class="actions-admin">
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

    <div class="modal fade" id="novaCategoriaModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newModalLabel">Nova Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="col-md-6 mb-3">
                                <label for="service-title" class="form-label">Título</label>
                                <input type="text" class="form-control" id="service-title">
                            </div>
                            <div class="mb-3">
                                <label for="service-provider" class="form-label">Descrição</label>
                                <textarea class="form-control" id="service-provider" rows="4"></textarea>
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
                            <label for="service-provider" class="form-label">Prestador</label>
                            <input type="text" class="form-control" id="service-provider" value="Ana Silva">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>

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
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Visualizar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Título: Reparos Gerais e Pequenas Reformas</p>
                    <p>Categoria: Manutenção Residencial</p>
                    <p>Prestador: Ana Silva</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
include '../layouts/footer.php';
?>

</html>