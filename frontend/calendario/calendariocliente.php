<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}
?>

<link rel="stylesheet" href="../../assets/css/calendario.css">
<script src="../../assets/JS/calendario.js"></script>
<script src="../../assets/JS/solicitaAgenda.js"></script>
<script src="../../assets/JS/solcitaAgendaInserir.js"></script>


<!-- O Formulário Pop-up -->
<div id="popupForm" class="popup-form popup-form-calendar">
    <h3>Solictação de Serviços</h3>
    <form id="cadastroDisponibilidade" action="javascript:void(0);"> <!-- Mudei para evitar o envio normal -->
        <div class="mb-3 visually-hidden">
            <!-- <div class="mb-3 "> -->
            <label for="idAgendamento" class="form-label">ID Agendamentos</label>
            <input type="number" id="idAgendamento" name="idAgendamento" class="form-control">
        </div>
        <div class="mb-3 visually-hidden">
            <!-- <div class="mb-3 "> -->
            <label for="idCliente" class="form-label">ID Clientes</label>
            <input type="number" id="idCliente" name="idCliente" class="form-control" value="<?php echo $_SESSION['id']; ?>">
        </div>
        <div class="mb-3 visually-hidden">
            <!-- <div class="mb-3 "> -->
            <label for="idProduto" class="form-label">ID Produto</label>
            <input type="number" id="idProduto" name="idProduto" class="form-control">
        </div>
        <div class="mb-3 visually-hidden">
            <!-- <div class="mb-3 "> -->
            <label for="idPrestador" class="form-label">ID Fornecedor</label>
            <input type="number" id="idPrestador" name="idPrestador" class="form-control">
        </div>
        <div class="mb-3 visually-hidden">
            <!-- <div class="mb-3 "> -->
            <label for="idDisponibilidade" class="form-label">id_disponibildiade</label>
            <input type="number" id="idDisponibilidade" name="idDisponibilidade" class="form-control">
        </div>
        <div class="mb-3 visually-hidden">
            <!-- <div class="mb-3 "> -->
            <label for="startDate" class="form-label">Start Agenda</label>
            <input type="date" id="startDate" name="startDate" class="form-control">
        </div>
        <div class="mb-3 visually-hidden">
            <!-- <div class="mb-3 "> -->
            <label for="endDate" class="form-label">End Agenda</label>
            <input type="date" id="endDate" name="endDate" class="form-control">
        </div>
        <div class="mb-3 visually-hidden">
            <!-- <div class="mb-3 "> -->
            <label for="eventHoraInicio" class="form-label">Start Hora Agenda</label>
            <input type="time" id="eventHoraInicio" name="eventHoraInicio" class="form-control">
        </div>
        <div class="mb-3 visually-hidden">
            <!-- <div class="mb-3 "> -->
            <label for="eventHoraFim" class="form-label">End Hora Agenda</label>
            <input type="time" id="eventHoraFim" name="eventHoraFim" class="form-control">
        </div>
        <!-- <div class="mb-3 visually-hidden"> -->
        <div class="mb-3 ">
            <label for="nomeServico" class="form-label">Serviço</label>
            <input type="text" id="nomeServico" name="nomeServico" class="form-control" disabled>
        </div>
        <!-- <div class="mb-3 visually-hidden"> -->
        <div class="mb-3 ">
            <label for="descricaoServico" class="form-label">Descrição do Serviço</label>
            <!-- <input type="text" id="descricaoServico" name="descricaoServico" class="form-control"> -->
            <textarea class="form-control" id="descricaoServico" name="descricaoServico" disabled></textarea>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="prestacaoDate" class="form-label">Data da Prestação</label>
                <input type="date" id="prestacaoDate" name="prestacaoDate" class="form-control">
            </div>
            <div class="col">
                <label for="horaPrestacao" class="form-label">Hora Prestação</label>
                <input type="time" id="horaPrestacao" name="horaPrestacao" class="form-control">
            </div>
            <!-- <div class="col">
                <label for="eventHoraFim" class="form-label">Hora Fim</label>
                <input type="time" id="eventHoraFim" name="endTime" class="form-control">
            </div> -->
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="formGroupExampleInput" class="form-label">Descrição do serviço</label>
                <textarea class="form-control" id="floatingTextarea" name="floatingTextarea"></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" id="close-cadastro-disponibilidade" class="btn btn-secondary" style="width: 45%;">Fechar</button>
            <button type="submit" id="cadastroDisponibilidade" class="btn btn-primary" style="width: 45%;">Salvar</button>
        </div>
    </form>
</div>