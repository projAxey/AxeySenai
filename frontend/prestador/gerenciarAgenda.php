<?php
include '../../frontend/layouts/head.php';
include '../../frontend/layouts/nav.php';
?>


<?php
include_once '/xampp/htdocs/projAxeySenai/config/conexao.php';
$buscaTodosAgendamentos = 'SELECT agenda_id, prestador,data_agenda, data_final, hora_inicio, hora_final FROM Agendas WHERE prestador = :prestador_id ORDER BY data_agenda ASC';
$retornoBusca = $conexao->prepare($buscaTodosAgendamentos);
$retornoBusca->bindParam(':prestador_id', $_SESSION['id'], PDO::PARAM_INT);
$retornoBusca->execute();
?>

<link rel="stylesheet" href="/projAxeySenai/assets/css/calendario.css">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
<script src="../../../projAxeySenai/assets/JS/disponibilidadeExcluir.js"></script>
<script src="../../../projAxeySenai/assets/JS/disponibilidadeEditar.js"></script>
<?php include '../../config/conexao.php'
?>

<!-- <link rel="stylesheet" href="/projAxeySenai/projetoAxeySenai/assets/css/calendario.css"> -->

<body class="bodyCards">
 
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
                    <button type="button" id='show-calendar' class="mb-2 btn btn-primary btn-meus-agendamentos" style="background-color: #012640; color:white"
                        data-toggle="modal" data-target="#calendarModal">Cadastrar Datas <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-striped-admin   ">
                            <thead>
                                <tr>
                                    <th class="th-admin">DATA INICIO</th>
                                    <th class="th-admin">DATA FIM</th>
                                    <th class="th-admin">HORA INICIO</th>
                                    <th class="th-admin">HORA FINAL</th>
                                    <th class="th-admin">AÇÕES</th>
                                </tr>
                            </thead>
                            <?php
                            if ($retornoBusca->rowCount() == 0) {
                                echo '<tr><td colspan="5">Nenhum dado cadastrado</td></tr>';
                            } else {
                                while ($rowBusca = $retornoBusca->fetch(PDO::FETCH_ASSOC)) {
                                    $id = $rowBusca['agenda_id'];
                                    $dataInicio = $rowBusca['data_agenda'];
                                    $dataInicio = DateTime::createFromFormat('Y-m-d', $dataInicio)->format('d-m-Y');
                                    $dataFinal = $rowBusca['data_final'];
                                    $dataFinal = DateTime::createFromFormat('Y-m-d', $dataFinal)->format('d-m-Y');
                                    $horaIncio = $rowBusca['hora_inicio'];
                                    $horaFinal = $rowBusca['hora_final'];

                                    echo " 
                                      <tr>
                                      <td scope='row'>$dataInicio</td>
                                      <td>$dataFinal</td>
                                      <td>$horaIncio</td>
                                      <td>$horaFinal</td>
                                      <td class='actions-admin'>
                                      <button id='editaDisponibilidade' class='btn btn-sm btn-admin edit-admin editaDisponibilidade' data-bs-toggle='modal' value='$id' data-bs-target='#editModal'><i class='fa-solid fa-pen'></i></button>
                                      <button id='excluiDisponibilidade' class='btn btn-sm btn-admin delete-admin excluiDisponibilidade' data-bs-toggle='modal' value='$id'  data-bs-target='#deleteModal'><i class='fa-solid fa-trash'></i></button>
                                      </td>
                                      </tr>";
                                }
                            }
                            ?>
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