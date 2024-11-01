<!-- <link rel="stylesheet" href="/projAxeySenai/projetoAxeySenai/assets/css/calendario.css"> -->
<script src="/projAxeySenai/projetoAxeySenai/assets/js/calendario.js"></script>


<!-- Modal -->
<div id='calendarModal' class='modal calendario'>
    <div class='modal-content calendario-content'>
        <span class='close close-calendar'>&times;</span>
        <div id='calendar'></div>
    </div>
</div>
<!-- Final Modal -->
<!-- Modal -->
<div class="modal calendario fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-calendario">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Detalhes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Conteúdo do Modal de Detalhes -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Final Modal com detalhes -->
<!-- O Formulário Pop-up -->
<div id="popupForm" class="popup-form popup-form-calendar">
    <h3>Serviço</h3>
    <form id="serviceFormDisponibilidade">
        <div class="mb-3">
            <label for="serviceDate" id="dateLabel" class="form-label">Datas Selecionadas</label>
            <input type="text" id="serviceDate" name="serviceDate" class="form-control" readonly>
        </div>
        <div class="row mb-3" id="timeEditableFields">
            <div class="col">
                <label for="eventHoraInicio" class="form-label">Hora Início</label>
                <input type="time" id="eventHoraInicio" name="eventHoraInicio" class="form-control">
            </div>
            <div class="col" id="horaFimContainer">
                <label for="eventHoraFim" class="form-label">Hora Fim</label>
                <input type="time" id="eventHoraFim" name="eventHoraFim" class="form-control">
            </div>
        </div>
        <div class="row mb-3" id="timeDisplayFields" style="display: none;">
            <div class="col">
                <label for="startTimeDisplay" class="form-label">Hora Início (Visualizar)</label>
                <input type="text" id="startTimeDisplay" name="startTimeDisplay" class="form-control" readonly>
            </div>
            <div class="col">
                <label for="endTimeDisplay" class="form-label">Hora Fim (Visualizar)</label>
                <input type="text" id="endTimeDisplay" name="endTimeDisplay" class="form-control" readonly>
            </div>
        </div>
        <div class="mb-3">
            <label for="eventTitle" class="form-label">Título</label>
            <input type="text" id="eventTitle" name="eventTitle" class="form-control"
                placeholder="Digite o título do serviço">
        </div>
        <div class="mb-3">
            <label for="eventDesc" class="form-label">Descrição</label>
            <textarea id="eventDesc" name="eventDesc" class="form-control"
                placeholder="Digite a descrição do serviço"></textarea>
        </div>

        <div class="d-flex justify-content-between">
         <button type="button" id="closeCadastroDisponibilidade" class="btn btn-secondary close-popup" style="width: 45%;">Fechar</button>
         <button type="submit" id="saveEventDisponibilidade" class="btn btn-primary" style="width: 45%;">Salvar</button>
        </div>

    </form>
</div>