<link rel="stylesheet" href="/projAxeySenai/assets/css/calendario.css">

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../frontend/layouts/head.php';
include '../../frontend/layouts/nav.php';
include '../../config/conexao.php';
?>

<?php
$id_clientes = $_SESSION['id'];
$buscaAgendamentosClientes = 'SELECT 
    A.agendamento_id, 
    A.data_agenda, 
    A.status, 
    P.nome_produto,
    AV.nota, 
    AV.comentario
FROM Agendamentos A
LEFT JOIN Avaliacoes AV ON AV.agendamento = A.agendamento_id
JOIN Agendas G ON A.id_agendas = G.agenda_id
JOIN Clientes C ON A.cliente = C.cliente_id
JOIN Produtos P ON A.produto = P.produto_id
WHERE A.cliente = :cliente_id
ORDER BY A.data_agenda ASC;
';

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

            <div class="title-admin">MEUS AGENDAMENTOS</div>
            <div class="table-responsive">
                <table class="table table-striped table-striped-admin">
                    <thead>
                        <tr>
                            <th class="th-admin">TÍTULO</th>
                            <th class="th-admin">DATA PRESTAÇÃO</th>
                            <th class="th-admin">STATUS</th>
                            <th class="th-admin">DETALHES</th>
                            <th class="th-admin">AVALIAÇÃO</th> <!-- Nova coluna -->
                        </tr>
                    </thead>
                    <?php
                    if ($retornoBusca->rowCount() == 0) {
                        echo '<tr><td colspan="5">Nenhum dado cadastrado</td></tr>';
                    } else {
                        while ($rowBusca = $retornoBusca->fetch(PDO::FETCH_ASSOC)) {
                            $agendamentoId = $rowBusca['agendamento_id'];
                            $dataPrestacao = DateTime::createFromFormat('Y-m-d', $rowBusca['data_agenda'])->format('d/m/Y');
                            $status = $rowBusca['status'];
                            $nomeProduto = $rowBusca['nome_produto'];
                            // Traduz o status do agendamento para texto
                            switch ($status) {
                                case 1:
                                    $statusTexto = 'Pendente';
                                    break;
                                case 2:
                                    $statusTexto = 'Aceito';
                                    break;
                                case 3:
                                    $statusTexto = 'Recusado';
                                    break;
                                case 4:
                                    $statusTexto = 'Finalizado';
                                    break;
                                default:
                                    $statusTexto = 'Desconhecido';
                            }
                            // Prepara a exibição da avaliação
                            $nota = $rowBusca['nota'] ?? null;
                            $comentario = $rowBusca['comentario'] ?? null;
                            $avaliacaoHtml = $nota && $comentario ?
                                "<div class='nota-estrelas'>" . str_repeat("<i class='fa-solid fa-star'></i>", $nota) .
                                str_repeat("<i class='fa-regular fa-star'></i>", 5 - $nota) .
                                "<br><strong>Comentário:</strong> $comentario</div>" : ($statusTexto === 'Finalizado' ?
                                    "<button class='btn btn-sm btn-admin avaliar-admin' data-bs-toggle='modal' data-bs-target='#avaliacaoModal' data-agendamento-id='$agendamentoId'>
                                    <i class='fa-solid fa-star'></i> Avaliar
                                </button>" :
                                    "Aguarde finalizar o serviço");

                            // Exibe a linha da tabela
                            echo "
        <tr>
            <td>$nomeProduto</td>
            <td>$dataPrestacao</td>
            <td>$statusTexto</td>
            <td class='actions-admin'>
                <button class='btn btn-sm btn-admin edit-admin viewDisponibilidade' data-bs-toggle='modal' data-bs-target='#viewModal' data-agendamento-id='$agendamentoId'>
                    <i class='fa-solid fa-eye'></i>
                </button>
                <button class='btn btn-sm btn-admin delete-admin excluiDisponibilidade' value='$agendamentoId'>
                    <i class='fa-solid fa-trash'></i>
                </button>
            </td>
            <td>$avaliacaoHtml</td>
        </tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal de Visualização -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Detalhes do Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Campos que serão preenchidos dinamicamente -->
                    <div><strong>Serviço:</strong> <span id="modal-nomeProduto"></span></div>
                    <div><strong>Categoria:</strong> <span id="modal-categoriaProduto"></span></div>
                    <div><strong>Prestador do Serviço:</strong> <span id="modal-nomePrestador"></span></div>
                    <div><strong>Data Prevista de Prestação:</strong> <span id="modal-serviceDate"></span></div>
                    <div><strong>Descrição:</strong> <span id="modal-descricaoServico"></span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Avaliação -->
    <div class="modal fade" id="avaliacaoModal" tabindex="-1" aria-labelledby="avaliacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="avaliacaoModalLabel">Avaliar o Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="avaliacaoAgendamentoId">
                    <div class="form-group text-center">
                        <label for="notaServico" class="mb-2">Nota do Serviço (1 a 5)</label>
                        <div id="notaServico" class="stars">
                            <span class="star" data-value="1">&#9733;</span>
                            <span class="star" data-value="2">&#9733;</span>
                            <span class="star" data-value="3">&#9733;</span>
                            <span class="star" data-value="4">&#9733;</span>
                            <span class="star" data-value="5">&#9733;</span>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="comentarioServico">Comentário</label>
                        <textarea id="comentarioServico" class="form-control" rows="4" placeholder="Escreva seu comentário aqui"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="salvarAvaliacao">Salvar Avaliação</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../layouts/footer.php';
    ?>

    <script src="../../assets/js/calendario.js"></script>
    <script src="../../assets/js/modalCalendarios.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Modal de Avaliação
            const avaliarButtons = document.querySelectorAll('.avaliar-admin');
            avaliarButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const agendamentoId = this.getAttribute('data-agendamento-id');
                    document.getElementById('avaliacaoAgendamentoId').value = agendamentoId;

                    // Resetar estrelas e comentário
                    document.querySelectorAll('#notaServico .star').forEach(star => star.classList.remove('selected'));
                    document.getElementById('comentarioServico').value = '';
                });
            });

            // Seleção de Estrelas
            const stars = document.querySelectorAll('#notaServico .star');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-value');
                    stars.forEach(s => s.classList.remove('selected'));
                    for (let i = 0; i < rating; i++) {
                        stars[i].classList.add('selected');
                    }
                });
            });

            document.getElementById('salvarAvaliacao').addEventListener('click', async function() {
                const agendamentoId = document.getElementById('avaliacaoAgendamentoId').value;
                const nota = document.querySelectorAll('#notaServico .star.selected').length;
                const comentario = document.getElementById('comentarioServico').value;

                if (nota === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Por favor, selecione uma nota.'
                    });
                    return;
                }

                try {
                    const response = await fetch('../../backend/servicos/salva_avaliacao.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            agendamentoId,
                            nota,
                            comentario
                        })
                    });

                    const result = await response.json();
                    if (result.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: result.msg
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: result.msg
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Ocorreu um erro ao salvar a avaliação.'
                    });
                }
            });
        });
    </script>
</body>

</html>