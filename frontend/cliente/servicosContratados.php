<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}
class servicoContratado
{
    public function render()
    {
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

    private function head()
    {
        include '../layouts/head.php';
    }

    private function nav()
    {
        include '../layouts/nav.php';
    }

    private function breadcrumb()
    {
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

    private function titleSection()
    {
        echo '<div class="container container-admin">
                <div class="title-admin">SERVIÇOS CONTRATADOS</div>';
    }

    private function tableSection()
    {
        echo '
        <div class="table-responsive">
            <table class="table table-striped table-striped-admin">
                <thead>
                    <tr>
                        <th class="th-admin">TÍTULO</th>
                        <th class="th-admin">CATEGORIA</th>
                        <th class="th-admin">DATA</th>
                        <th class="th-admin">DETALHES</th>
                        <th class="th-admin">AVALIE</th>
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
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin btn-avaliacao" data-bs-toggle="modal" data-bs-target="#modalAvaliacao">
                                <i class="fa-solid fa-pen-to-square"></i>
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
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin btn-avaliacao" data-bs-toggle="modal" data-bs-target="#modalAvaliacao">
                                <i class="fa-solid fa-pen-to-square"></i>
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
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin btn-avaliacao" data-bs-toggle="modal" data-bs-target="#modalAvaliacao">
                                <i class="fa-solid fa-pen-to-square"></i>
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
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin btn-avaliacao" data-bs-toggle="modal" data-bs-target="#modalAvaliacao">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>';
    }

    private function modal()
    {
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
        </div>
    
        <div class="modal fade" id="modalAvaliacao" tabindex="-1" aria-labelledby="modalAvaliacaoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAvaliacaoLabel">Avaliação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="index.php" method="post">
                            <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5" />
                                <label for="star5" title="5 estrelas">★</label>
                                <input type="radio" id="star4" name="rate" value="4" />
                                <label for="star4" title="4 estrelas">★</label>
                                <input type="radio" id="star3" name="rate" value="3" />
                                <label for="star3" title="3 estrelas">★</label>
                                <input type="radio" id="star2" name="rate" value="2" />
                                <label for="star2" title="2 estrelas">★</label>
                                <input type="radio" id="star1" name="rate" value="1" />
                                <label for="star1" title="1 estrela">★</label>
                            </div>
    
                            <div class="form-group mb-3">
                                <h6>Como você classifica a pontualidade do prestador</h6>
                                <div class="d-flex justify-content-around mt-3">
                                    <div class="op1">
                                        <input type="radio" id="pontualidadeBoa" name="pontualidade" value="Boa" />
                                        <label for="pontualidadeBoa">Boa</label>
                                    </div>
                                    <div class="op2">
                                        <input type="radio" id="pontualidadeMediana" name="pontualidade" value="Mediana" />
                                        <label for="pontualidadeMediana">Mediana</label>
                                    </div>
                                    <div class="op3">
                                        <input type="radio" id="pontualidadeRuim" name="pontualidade" value="Ruim" />
                                        <label for="pontualidadeRuim">Ruim</label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group mb-3">
                                <h6>Aspectos da Satisfação (Marque todos os aplicáveis):</h6>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="aspecto1" name="aspectos[]" value="Cortesia">
                                    <label class="form-check-label" for="aspecto1">Cortesia</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="aspecto2" name="aspectos[]" value="Profissionalismo">
                                    <label class="form-check-label" for="aspecto2">Profissionalismo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="aspecto3" name="aspectos[]" value="Qualidade do Serviço">
                                    <label class="form-check-label" for="aspecto3">Qualidade do Serviço</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="aspecto4" name="aspectos[]" value="Tempo de Resolução">
                                    <label class="form-check-label" for="aspecto4">Tempo de Resolução</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="aspecto5" name="aspectos[]" value="Preço Justo">
                                    <label class="form-check-label" for="aspecto5">Preço Justo</label>
                                </div>
                            </div>
    
                            <div class="form-group mb-4">
                                <h6 for="mensagem">Observação</h6>
                                <textarea class="form-control camnpoAvalia" id="mensagem" name="mensagem" placeholder="Digite sua mensagem" rows="4"></textarea>
                            </div>
    
                            <div class="text-center">
                                <button type="submit" class="btn text-light" style="background-color: #1B3C54; width: 57%;">Enviar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>';
    }


    private function footer()
    {
        include '../layouts/footer.php';
    }

    private function getScripts()
    {
        return '
        <script src="../../assets/JS/global.js"></script>';
    }
}

// Instância da classe e renderização da página
$page = new servicoContratado();
$page->render();
