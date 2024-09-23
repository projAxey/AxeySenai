<?php
include '../../frontend/layouts/head.php';
?>


<!-- <link rel="stylesheet" href="/projAxeySenai/projetoAxeySenai/assets/css/calendario.css"> -->

<body class="bodyCards">
    <?php
    include '../../frontend/layouts/nav.php';
    ?>

    <style>
        textarea {
            resize: none;
            height: 100px;
        }

        a {
            text-decoration: none;
            color: #012640;
        }
    </style>

    <div class="container mt-4">
        <div class="row d-flex flex-wrap">
            <ol class="breadcrumb breadcrumb-admin">
                <li class="breadcrumb-item">
                    <a href="perfilPrestador.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                </li>
            </ol>
            <div class="title-admin">GERENCIADOR DE AGENDA</div>
            <div class="col- mt-2">
                <div class="d-flex justify-content-between mb-4">
                    <button type="button" id='showcalendarprestador' class="mb-2 btn btn-primary btn-meus-agendamentos" style="background-color: #012640; color:white"
                        data-toggle="modal" data-target="#calendarModal">Cadastrar Datas <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-striped-admin">
                            <thead>
                                <tr>
                                    <th class="th-admin">DATA DATA</th>
                                    <th class="th-admin">HORA INICIO</th>
                                    <th class="th-admin">HORA FINAL</th>
                                    <th class="th-admin">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- <td>Reparos Gerais e Pequenas Reformas</td> -->
                                    <td>16-09-2024</td>
                                    <td>04:00</td>
                                    <td>17:00</td>
                                    <td class="actions-admin">
                                        <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                                        <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td>Reparos Gerais e Pequenas Reformas</td> -->
                                    <td>23-09-2024</td>
                                    <td>12:00</td>
                                    <td>17:00</td>
                                    <td class="actions-admin">
                                        <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                                        <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <?php
    include '../../frontend/calendario/calendarioprestador.php';
    ?>



</body>
<?php
include '../layouts/footer.php';
?>
<!-- <script src="../../assets/JS/global.js"></script> -->