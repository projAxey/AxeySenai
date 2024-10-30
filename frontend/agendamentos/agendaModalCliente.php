<link rel="stylesheet" href="../../assets/css/calendario.css">
<link rel="stylesheet" href="../../assets/css/calendario.css">
<script src="../../assets/JS/calendario.js"></script>
<script src="../../assets/JS/modalCalendarioCliente.js"></script>

<!-- O Formulário Pop-up -->
<div id="popupForm" class="popup-form popup-form-calendar">
    <h3>Especificação de Serviços</h3>
    <form id="cadastroDisponibilidade" action="javascript:void(0);"> <!-- Mudei para evitar o envio normal -->
        <!-- <div class="mb-3 visually-hidden"> -->
            <div class="mb-3 ">
            <label for="nomeProduto" class="form-label">Serviço</label>
            <input type="text" id="nomeProduto" name="nomeProduto" class="form-control" readonly>
        </div>
        <!-- <div class="mb-3 visually-hidden"> -->
        <div class="mb-3 ">
            <label for="categoriaProduto" class="form-label">Categoria</label>
            <input type="text" id="categoriaProduto" name="categoriaProduto" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="serviceDate" class="form-label">Data Prevista Prestação</label>
            <input type="date" id="serviceDate" name="serviceDate" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="nomePrestador" class="form-label">Prestador Do Serviço</label>
            <input type="text" id="nomePrestador" name="nomePrestador" class="form-control" readonly>
        </div>
        <div class="mb-3 ">
            <label for="descricaoServico" class="form-label">Descrição do Serviço</label>
            <!-- <input type="text" id="descricaoServico" name="descricaoServico" class="form-control"> -->
            <textarea class="form-control" id="descricaoServico" name="descricaoServico" disabled readonly></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" id="close-cadastro-disponibilidade" class="btn btn-secondary" style="width: 45%;">Fechar</button>
        </div>
    </form>
</div>