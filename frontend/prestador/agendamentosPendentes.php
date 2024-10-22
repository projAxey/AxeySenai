<?php
include '../layouts/head.php';
include '../layouts/nav.php';
?>
<body class="bodyCards">
    <main class="main-admin">
        <div class="container container-admin">
     
                <ol class="breadcrumb breadcrumb-admin">
                    <li class="breadcrumb-item">
                        <a href="/projAxeySenai/frontend/auth/perfil.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                    </li>
                </ol>

            <div class="title-admin">AGENDAMENTOS PENDENTES</div>
            <div class="table-responsive">
                <table class="table table-striped table-striped-admin">
                    <thead>
                        <tr>
                            <th class="th-admin">SERVIÇO</th>
                            <th class="th-admin">CLIENTE</th>
                            <th class="th-admin">DATA</th>
                            <th class="th-admin">STATUS</th>
                            <th class="th-admin">DETALHES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Serviços de Hidráulica e Encanamento</td>
                            <td>Maria da Silva</td>
                            <td>29/09/2024</td>
                            <td>Pendete aceite</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Instalação de Sistemas de Iluminação</td>
                            <td>Maria da Silva</td>
                            <td>29/09/2024</td>
                            <td>Pendete aceite</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Manutenção e Reparos em Fiação Elétrica</td>
                            <td>Maria da Silva</td>
                            <td>29/09/2024</td>
                            <td>Recusado</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Troca de Telhas e Manutenção de Telhados</td>
                            <td>Maria da Silva</td>
                            <td>29/09/2024</td>
                            <td>Aceito</td>
                            <td class="actions-admin">
                                <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Visualizar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Serviço:</strong> Reparos Gerais e Pequenas Reformas</p>
                    <p><strong>Descrição:</strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis quidem, repudiandae hic sapiente architecto, temporibus placeat fugae!</p>
                    <p><strong>Categoria:</strong> Manutenção Residencial</p>
                    <p><strong>Cliente:</strong> Maria da Silva</p>
                    <p><strong>Data prevista do serviço:</strong> 24/06/2023</p>
                    <p><strong>Local realização do serviço:</strong> R. Arno Waldemar Döhler, 957</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aprovar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Recusar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
include '../layouts/footer.php';
?>
<script src="../../assets/JS/global.js"></script>
</html>