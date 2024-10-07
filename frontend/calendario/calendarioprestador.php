<link rel="stylesheet" href="../../assets/css/calendario.css">
<script src="../../assets/JS/calendario.js"></script>
<script src="../../assets/JS/disponibilidadeInserir.js"></script>


<!-- O Formulário Pop-up -->
<div id="popupForm" class="popup-form popup-form-calendar">
    <h3>Serviço</h3>
    <form id="cadastroDisponibilidade" action="javascript:void(0);"> <!-- Mudei para evitar o envio normal -->
        <div class="mb-3">
            <label for="startserviceDate" class="form-label">Data Início</label>
            <input type="date" id="startserviceDate" name="startDayDate" class="form-control">
        </div>
        <div class="mb-3">
            <label for="endserviceDate" class="form-label">Data Fim</label>
            <input type="date" id="endserviceDate" name="endDayDate" class="form-control">
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="eventHoraInicio" class="form-label">Hora Início</label>
                <input type="time" id="eventHoraInicio" name="startTime" class="form-control">
            </div>
            <div class="col">
                <label for="eventHoraFim" class="form-label">Hora Fim</label>
                <input type="time" id="eventHoraFim" name="endTime" class="form-control">
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" id="saveEventDisponibilidade" class="btn btn-primary" style="width: 45%;">Salvar</button>
            <button type="button" id="close-cadastro-disponibilidade" class="btn btn-secondary" style="width: 45%;">Fechar</button>
        </div>
    </form>
</div>
