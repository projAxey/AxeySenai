<?php
include '../../frontend/layouts/head.php';
?>

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
            <!-- Perfil -->

            <div class="col-md-4 mt-2 move_esquerda">

                <div class="text-center area-foto-perfil mt-2">
                    <img src="../../assets/imgs/ruivo.png" alt="Ícone de usuário" class="mb-3 foto-perfil">
                </div>
                <div>
                    <h3 class="text-center">Procurando o Affonso</h3>
                </div>
                <div class="d-grid">
                    <button type="button" id='show-calendar' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Ajustar Agenda </button>
                    <button type="button" id='show' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Agendamentos </button>
                    <button type="button" id='show-' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Gerienciar Agenda </button>
                    <button type="button" id='show-' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Meus Destaques </button>
                    <button type="button" id='show' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Minhas Promoções </button>
                    <button type="button" id='show' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Meus Dados </butto>
                </div>
            </div>

            <!-- Formulário de Edição -->
            <div class="col-md-8 mt-2">
                <h1 class="mb-4">Gerenciador de Agenda</h1>
                <!-- Barra de Ações -->
                <div class="d-flex justify-content-between mb-4">

                    <button class="btn btn-secondary" style="background-color: #012640; color:white"
                        onclick="goBack()">Voltar</button>
                    <button type="button"  id='showcalendarprestador' class="btn btn-primary" style="background-color: #012640; color:white"
                        data-toggle="modal" data-target="#calendarModal">Disponibilizar datas</button>
                </div>

                <!-- Tabela com Cabeçalhos -->
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-striped-admin">
                            <thead>
                                <tr>
                                    <!-- <th class="th-admin">TÍTULO</th> -->
                                    <th class="th-admin">DATA INICIO</th>
                                    <th class="th-admin">DATA FINAL</th>
                                    <th class="th-admin">HORA INICIO</th>
                                    <th class="th-admin">HORA FINAL</th>
                                    <th class="th-admin">AÇÕES</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- <td>Reparos Gerais e Pequenas Reformas</td> -->
                                    <td>16-09-2024</td>
                                    <td>20-09-2024</td>
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
                                    <td>27-09-2024</td>
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

        <?php
        include '../../frontend/calendario/calendarioprestador.php';
        ?>



</body>