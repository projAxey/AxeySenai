<?php
session_start(); // Colocado antes de qualquer saída HTML
?>
<?php
include '../layouts/head.php';
include '../layouts/nav.php';
?>
<?php
$id_clientes = $_SESSION['id'];
// $produto_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
// echo $produto_id;    
include_once '../../config/conexao.php';
$buscaAgendamentosClientes = 'SELECT 
    Agendamentos.agendamento_id,
    Agendamentos.data_agenda,
    Agendamentos.status,
    Produtos.nome_produto
FROM Agendamentos
INNER JOIN Agendas ON Agendamentos.id_agendas = Agendas.agenda_id
INNER JOIN Clientes ON Agendamentos.cliente = Clientes.cliente_id
INNER JOIN Produtos ON Agendamentos.produto = Produtos.produto_id
INNER JOIN Categorias ON Produtos.categoria = Categorias.categoria_id
WHERE Agendamentos.cliente = :cliente_id
ORDER BY Agendamentos.data_agenda ASC'; 

$retornoBusca = $conexao->prepare($buscaAgendamentosClientes);
$retornoBusca->bindParam(':cliente_id', $id_clientes, PDO::PARAM_INT);
$retornoBusca->execute();
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
                            <th class="th-admin">TÍTULO</th>
                            <th class="th-admin">DATA PRESTAÇÃO</th>
                            <th class="th-admin">STATUS</th>
                            <th class="th-admin">DETALHES</th>
                        </tr>
                    </thead>
                    <?php
                    if ($retornoBusca->rowCount() == 0) {
                        echo '<tr><td colspan="5">Nenhum dado cadastrado</td></tr>';
                    } else {
                        while ($rowBusca = $retornoBusca->fetch(PDO::FETCH_ASSOC)) {
                            $agendamentoId = $rowBusca['agendamento_id'];
                            $dataPrestacao = $rowBusca['data_agenda'];
                            $dataPrestacao = DateTime::createFromFormat('Y-m-d', $dataPrestacao)->format('d/m/Y');
                            $status = $rowBusca['status'];
                            $nomeProduto = $rowBusca['nome_produto'];
                            

                            if($status == 1){
                                $status = 'Pendente';
                            }else if($status == 2){
                                $status = 'Aceito';
                            }else if($status == 3){
                                $status = 'Recusado';
                            }
                            echo " 
                                      <tr>
                                      <td scope='row'>$nomeProduto</td>
                                      <td>$dataPrestacao</td>
                                      <td>$status</td>
                                      <td class='actions-admin'>
                                      <button class='btn btn-sm btn-admin view-admin' data-bs-toggle='modal' data-bs-target='#viewModal' value='$agendamentoId'><i class='fa-solid fa-eye'></i></button>
                                      </td>
                                      </td>
                                      </tr>";
                        }
                    }
                    ?>
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
                    <p>Título: Reparos Gerais e Pequenas Reformas</p>
                    <p>Descrição: Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis quidem, repudiandae hic sapiente architecto, temporibus placeat fugae!</p>
                    <p>Categoria: Manutenção Residencial</p>
                    <p>Prestador: Ana Silva</p>
                    <p>Data prevista do serviço: 24/06/2023</p>
                    <p>Local realização do serviço: R. Arno Waldemar Döhler, 957</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
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