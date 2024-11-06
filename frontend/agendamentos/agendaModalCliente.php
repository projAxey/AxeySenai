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
<link rel="stylesheet" href="../../assets/css/calendario.css">
<script src="../../assets/JS/calendario.js"></script>
<script src="../../assets/JS/modalCalendarioCliente.js"></script>

<!-- O Formulário Pop-up -->
<div id="popupForm" class="popup-form popup-form-calendar">
    <h3>Especificação de Serviços</h3>
    <form id="cadastroDisponibilidade" action="javascript:void(0);"> <!-- Mudei para evitar o envio normal -->
        <!-- <div class="mb-3 visually-hidden"> -->
        <div class="mb-1 ">
            <label for="nomeProduto" class="form-label">Serviço</label>
            <input  type="text" id="nomeProduto" name="nomeProduto" class="form-control" disabled >
        </div>
        <!-- <div class="mb-3 visually-hidden"> -->
        <div class="mb-1 ">
            <label for="categoriaProduto" class="form-label">Categoria</label>
            <input type="text" id="categoriaProduto" name="categoriaProduto" class="form-control" disabled>
        </div>
        <div class="mb-1">
            <label for="nomePrestador" class="form-label">Prestador Do Serviço</label>
            <input type="text" id="nomePrestador" name="nomePrestador" class="form-control" disabled>
        </div>
        <div class="mb-1">
            <label for="serviceDate" class="form-label">Data Prevista Prestação</label>
            <input type="date" id="serviceDate" name="serviceDate" class="form-control" disabled>
        </div>
        
        <div class="mb-1">
            <label for="descricaoServico" class="form-label">Descrição do Serviço</label>
            <!-- <input type="text" id="descricaoServico" name="descricaoServico" class="form-control"> -->
            <textarea class="form-control" id="descricaoServico" name="descricaoServico" disabled ></textarea>
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" id="close-cadastro-disponibilidade" class="btn btn-secondary" style="width: 45%;">Fechar</button>
        </div>
    </form>
</div>