<!-- Modal para Atualizar Agenda -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Atualizar Agenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAgendaForm">
                    <input type="hidden" id="editAgendaId" name="agendaId">
                    <div class="mb-3">
                        <label for="editServiceDate" class="form-label">Data</label>
                        <input type="date" id="editServiceDate" name="serviceDate" class="form-control" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="editEventHoraInicio" class="form-label">Hora Início</label>
                            <input type="time" id="editEventHoraInicio" name="eventHoraInicio" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="editEventHoraFim" class="form-label">Hora Fim</label>
                            <input type="time" id="editEventHoraFim" name="eventHoraFim" class="form-control" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>