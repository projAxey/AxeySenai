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
        $this->tableSection();
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
            <button type="button" id="meusAgendamentos" class="mb-2 btn btn-primary btn-meus-agendamentos"
                style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novoServicoModal">
                Novo Serviço <i class="bi bi-plus-circle"></i>
            </button>
        </div>';
    }

    private function tableSection() {
        echo '
        <div class="table-responsive">
            <table class="table table-striped table-striped-admin">
                <thead>
                    <tr>
                        <th class="th-admin">TÍTULO</th>
                        <th class="th-admin">CATEGORIA</th>
                        <th class="th-admin">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Reparos Gerais e Pequenas Reformas</td>
                        <td>Manutenção Residencial</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal"
                                data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal"
                                data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Serviços de Hidráulica e Encanamento</td>
                        <td>Manutenção Residencial</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal"
                                data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal"
                                data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>';
    }

    private function modals() {
        echo '
        <div class="modal fade" id="novoServicoModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Novo Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="service-title" class="form-label">Título</label>
                                    <input type="text" class="form-control" id="service-title">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="serviceCategory" class="form-label">Categoria</label>
                                    <select class="form-select" id="serviceCategory" name="serviceCategory" required>
                                        <option value="" disabled selected>Selecione uma categoria</option>
                                        <option value="Consultoria">Consultoria</option>
                                        <option value="Treinamento">Treinamento</option>
                                        <option value="Manutenção">Manutenção</option>
                                        <option value="Desenvolvimento">Desenvolvimento</option>
                                        <option value="Outros">Outros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="service-provider" class="form-label">Descrição</label>
                                <textarea class="form-control" id="service-provider" rows="4"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="serviceImages" class="form-label">Imagens</label>
                                    <input type="file" class="form-control" id="serviceImages" name="serviceImages[]" multiple accept="image/*" onchange="previewImages()">
                                    <div id="imagePreview" class="preview d-flex flex-wrap"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="serviceVideos" class="form-label">Vídeos</label>
                                    <input type="file" class="form-control" id="serviceVideos" name="serviceVideos[]" multiple accept="video/*" onchange="previewVideos()">
                                    <div id="videoPreview" class="preview d-flex flex-wrap"></div>
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
 