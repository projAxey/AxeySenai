<?php
class servicoContratado {
    public function render() {
        $this->head();
        echo '<body class="bodyCards">';
        $this->nav();
        echo '<main class="main-admin">';
        $this->breadcrumb();
        $this->titleSection();
        $this->tableSection();
        echo '</main>';
        $this->modal();
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
        <div class="container container-admin">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-admin">
                    <li class="breadcrumb-item">
                        <a href="/projAxeySenai/frontend/auth/perfil.php" style="text-decoration: none; color:#012640;">
                            <strong>Voltar</strong>
                        </a>
                    </li>
                </ol>
            </nav>
        </div>';
    }

    private function titleSection() {
        echo '<div class="container container-admin">
                <div class="title-admin">SERVIÇOS CONTRATADOS</div>';
    }

    private function tableSection() {
        echo '
        <div class="table-responsive">
            <table class="table table-striped table-striped-admin">
                <thead>
                    <tr>
                        <th class="th-admin">TÍTULO</th>
                        <th class="th-admin">CATEGORIA</th>
                        <th class="th-admin">DATA</th>
                        <th class="th-admin">DETALHES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Serviços de Hidráulica e Encanamento</td>
                        <td>Manutenção Residencial</td>
                        <td>24/06/2023</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Instalação de Sistemas de Iluminação</td>
                        <td>Serviços Elétricos</td>
                        <td>24/06/2023</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Manutenção e Reparos em Fiação Elétrica</td>
                        <td>Serviços Elétricos</td>
                        <td>24/06/2023</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Troca de Telhas e Manutenção de Telhados</td>
                        <td>Reparos em Geral</td>
                        <td>24/06/2023</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>';
    }

    private function modal() {
        echo '
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
                        <p>Data do serviço: 24/06/2023</p>
                        <p>Local realização do serviço: R. Arno Waldemar Döhler, 957</p>
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
        <script src="../../assets/JS/global.js"></script>';
    }
}

// Instância da classe e renderização da página
$page = new servicoContratado();
$page->render();
