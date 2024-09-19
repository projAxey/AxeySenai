<?php
include '../layouts/head.php';
include '../layouts/nav.php';
?>
<body class="bodyCards">
    <div class="container container-admin">
        <ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item">
                <a href="perfilPrestador.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
            </li>
        </ol>

        <div class="title-admin">SERVIÇOS DESTAQUE</div>
        <div class="table-responsive">
            <table class="table table-striped table-striped-admin">
                <thead>
                    <tr>
                        <th class="th-admin">SERVIÇO</th>
                        <th class="th-admin">CATEGORIA</th>
                        <th class="th-admin">STATUS</th>
                        <th class="th-admin">DETALHES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Serviços de Hidráulica e Encanamento</td>
                        <td>Manutenção Residencial</td>
                        <td>Pendete aceite</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Instalação de Sistemas de Iluminação</td>
                        <td>Serviços Elétricos</td>
                        <td>Pendete aceite</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Manutenção e Reparos em Fiação Elétrica</td>
                        <td>Serviços Elétricos</td>
                        <td>Recusado</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Troca de Telhas e Manutenção de Telhados</td>
                        <td>Reparos em Geral</td>
                        <td>Aceito</td>
                        <td class="actions-admin">
                            <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
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
                    <p><strong>Título:</strong> Reparos Gerais e Pequenas Reformas</p>
                    <p><strong>Descrição:</strong>: Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis quidem, repudiandae hic sapiente architecto, temporibus placeat fugae!</p>
                    <p><strong>Categoria:</strong>: Manutenção Residencial</p>
                    <p><strong>Status:</strong>: Pendente aprovação</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar Destaque</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    include '../layouts/footer.php';
    ?>
    <script src="../../assets/JS/global.js"></script>
</body>

</html>