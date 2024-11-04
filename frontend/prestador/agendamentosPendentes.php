<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}
?>
<?php
include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php';

$prestador_id = $_SESSION['id']; // ID do prestador logado, assumindo que está salvo na sessão

// Consulta para obter agendamentos do prestador logado
$sql = "
    SELECT 
        a.agendamento_id,
        a.id_agendas,
        p.nome_produto AS produto,
        c.nome AS cliente,
        a.data_agenda,
        a.hora_prestacao,
        a.status,
        a.criacao,
        a.alteracao
    FROM 
        Agendamentos a
    JOIN 
        Produtos p ON a.produto = p.produto_id
    JOIN 
        Clientes c ON a.cliente = c.cliente_id
    WHERE 
        p.prestador = :prestador_id
";

$stmt = $conexao->prepare($sql);
$stmt->bindParam(':prestador_id', $prestador_id);
$stmt->execute();
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body class="bodyCards" style="min-height: 100vh;">
    <main class="main-admin">
    <div class="container container-admin">
        <ol class="breadcrumb breadcrumb-admin">
            <li class="breadcrumb-item">
                <a href="/projAxeySenai/frontend/auth/perfil.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
            </li>
        </ol>

        <div class="title-admin">MEUS AGENDAMENTOS</div>

        <div class="list-group">
            <?php foreach ($agendamentos as $agendamento): ?>
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div class="flex-column">
                        <h5 class="mb-1"><?php echo htmlspecialchars($agendamento['produto']); ?></h5>
                        <p class="mb-1"><strong>Cliente:</strong> <?php echo htmlspecialchars($agendamento['cliente']); ?></p>
                        <p class="mb-1"><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($agendamento['data_agenda'])); ?></p>
                        <?php
$statusMapping = [
    1 => ['class' => 'btn btn-secondary', 'text' => 'Pendente de aprovação'],
    2 => ['class' => 'btn btn-success', 'text' => 'Aceito'],
    3 => ['class' => 'btn btn-danger', 'text' => 'Recusado']
];

$statusInfo = $statusMapping[$agendamento['status']] ?? ['class' => '', 'text' => 'Status desconhecido'];
?>

<p class="mb-1 mt-2 <?php echo $statusInfo['class']; ?>">
    <strong>Status:</strong> <?php echo htmlspecialchars($statusInfo['text']); ?>
</p>
                    </div>
                    <div>
                    <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal" data-agendamento-id="<?php echo htmlspecialchars($agendamento['agendamento_id']); ?>">
    <i class="fa-solid fa-eye"></i> Ver Detalhes
</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

    <!-- Modal para detalhes do agendamento -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Visualizar Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Serviço:</strong> <span id="modal-servico"></span></p>
                <p><strong>Cliente:</strong> <span id="modal-cliente"></span></p>
                <p><strong>Data prevista do serviço:</strong> <span id="modal-data"></span></p>
                <input type="hidden" id="agendamento_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnAprovar">Aprovar</button>
                <button type="button" class="btn btn-danger" id="btnRecusar">Recusar</button>
            </div>
        </div>
    </div>
</div>
</body>
<?php
include '../layouts/footer.php';
?>
<script src="../../assets/JS/global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const viewButtons = document.querySelectorAll(".view-admin");
    const modalServico = document.getElementById("modal-servico");
    const modalCliente = document.getElementById("modal-cliente");
    const modalData = document.getElementById("modal-data");
    const agendamentoIdInput = document.getElementById("agendamento_id");

    viewButtons.forEach(button => {
        button.addEventListener("click", function() {
            const produto = button.closest(".list-group-item").querySelector("h5").innerText;
            const cliente = button.closest(".list-group-item").querySelector("p").innerText.split(": ")[1]; // Obtém o cliente da <p>
            const data = button.closest(".list-group-item").querySelectorAll("p")[1].innerText.split(": ")[1]; // Obtém a data da <p>
            const agendamentoId = button.getAttribute("data-agendamento-id");

            modalServico.innerText = produto;
            modalCliente.innerText = cliente;
            modalData.innerText = data;
            agendamentoIdInput.value = agendamentoId;
        });
    });

    document.getElementById("btnAprovar").addEventListener("click", function() {
        confirmarAcao(2); // 2 para "Aprovado"
    });

    document.getElementById("btnRecusar").addEventListener("click", function() {
        confirmarAcao(3); // 3 para "Recusado"
    });

    function confirmarAcao(status) {
        const agendamento_id = agendamentoIdInput.value;
        const acao = status === 2 ? "aprovar" : "recusar";

        // Fecha o modal Bootstrap antes de abrir o SweetAlert
        const bootstrapModal = bootstrap.Modal.getInstance(document.getElementById('viewModal'));
        if (bootstrapModal) {
            bootstrapModal.hide();
        }

        Swal.fire({
            title: `Tem certeza que deseja ${acao} este serviço?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: status === 2 ? "Aprovar" : "Recusar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                atualizarStatus(agendamento_id, status);
            } else {
                // Reabre o modal Bootstrap caso o usuário cancele
                if (bootstrapModal) {
                    bootstrapModal.show();
                }
            }
        });
    }

    function atualizarStatus(agendamento_id, status) {
        fetch("../../backend/agendamentos/atualizar_agendamento.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `agendamento_id=${agendamento_id}&status=${status}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "Sucesso!",
                    text: "Status atualizado com sucesso.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload(); // Recarrega a página para atualizar a lista de agendamentos
                });
            } else {
                Swal.fire({
                    title: "Erro",
                    text: data.message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        })
        .catch(error => {
            console.error("Erro ao tentar atualizar o status:", error);
            Swal.fire({
                title: "Erro",
                text: "Ocorreu um erro ao atualizar o status.",
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    }
});
</script>

</html>