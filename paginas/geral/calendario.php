<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configurações do cabeçalho do documento -->
    <meta charset="UTF-8">
    <title>Calendário de Eventos</title>
    
    <!-- Importação de estilos e scripts externos -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css' />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos customizados para o calendário e botões -->
    <style>
        /* Define a largura do calendário e centraliza-o na tela */
        #calendar {
            width: 70%;
            margin: 40px auto;
        }

        /* Ajusta o espaçamento abaixo da barra de ferramentas do cabeçalho */
        .fc-header-toolbar {
            margin-bottom: 20px;
        }

        /* Aumenta o espaçamento entre os botões de navegação do calendário */
        .fc-button {
            margin: 0 10px;
        }

        /* Transforma o texto do título do mês para maiúsculas */
        .fc-center h2 {
            text-transform: uppercase;
        }

        /* Estilos personalizados para os botões */
        .btn-custom-blue {
            background-color: #1B3C54;
            color: #FFFFFF;
        }
        .btn-custom-blue:hover {
            background-color: #163246;
            color: #FFFFFF;
        }
        .btn-custom-white {
            background-color: #FFFFFF;
            color: #1B3C54;
            border: 1px solid #1B3C54;
        }

        /* Impede o redimensionamento da textarea */
        textarea {
            resize: none;
        }
    </style>
</head>
<body>
    <!-- Contêiner principal do calendário -->
    <div id='calendar'></div>

    <!-- Modal para adicionar um novo evento -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Cabeçalho do modal com título e botão de fechar -->
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Corpo do modal contendo o formulário para adicionar um novo evento -->
                <div class="modal-body">
                    <form id="eventForm">
                        <!-- Campo para descrição do evento -->
                        <div class="form-group">
                            <label for="description">Descrição do Serviço</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <!-- Campo para data e hora de início do evento -->
                        <div class="form-group">
                            <label for="start">Data/Hora de Início</label>
                            <input type="datetime-local" class="form-control" id="start" name="start" required>
                        </div>
                        <!-- Campo para data e hora de fim do evento -->
                        <div class="form-group">
                            <label for="end">Data/Hora de Fim</label>
                            <input type="datetime-local" class="form-control" id="end" name="end" required>
                        </div>
                        <!-- Campo para título do evento -->
                        <div class="form-group">
                            <label for="title">Título do Serviço</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <!-- Campo para data e hora de início com seletor de tipo (data, hora ou ambos) -->
                        <div class="form-group">
                            <label for="start">Data/Hora de Início</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="start" name="start" required>
                                <div class="input-group-append">
                                    <select class="form-control" id="startType">
                                        <option value="datetime-local">Data e Hora</option>
                                        <option value="date">Data</option>
                                        <option value="time">Hora</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Campo para data e hora de fim com seletor de tipo (data, hora ou ambos) -->
                        <div class="form-group">
                            <label for="end">Data/Hora de Fim</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="end" name="end" required>
                                <div class="input-group-append">
                                    <select class="form-control" id="endType">
                                        <option value="datetime-local">Data e Hora</option>
                                        <option value="date">Data</option>
                                        <option value="time">Hora</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Rodapé do modal com botões de ação -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom-white" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-custom-blue" id="saveEvent">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Importação de scripts necessários para o funcionamento do calendário e modais -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale/pt-br.js'></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script para inicialização e configuração do calendário -->
    <script>
        $(document).ready(function() {
            // Inicializa o calendário FullCalendar com as configurações desejadas
            $('#calendar').fullCalendar({
                locale: 'pt-br', // Define o idioma como português do Brasil
                editable: true, // Permite edição de eventos diretamente no calendário
                header: {
                    left: 'prev,next today', // Botões de navegação à esquerda
                    center: 'title', // Título centralizado
                    right: 'month,agendaWeek,agendaDay' // Modos de visualização à direita
                },
                selectable: true, // Permite selecionar períodos de tempo no calendário
                selectHelper: true, // Mostra uma pré-visualização ao selecionar
                // Função chamada ao selecionar um período de tempo
                select: function(start, end) {
                    // Exibe o modal para adicionar um novo evento
                    $('#eventModal').modal('show');
                    // Preenche os campos de data/hora do formulário com os valores selecionados
                    $('#start').val(start.format('YYYY-MM-DDTHH:mm'));
                    $('#end').val(end.format('YYYY-MM-DDTHH:mm'));
                    // Define o comportamento do botão "Salvar" no modal
                    $('#saveEvent').off('click').on('click', function() {
                        var title = $('#title').val();
                        var start = $('#start').val();
                        var end = $('#end').val();
                        // Se o título estiver preenchido, faz uma requisição AJAX para salvar o evento
                        if (title) {
                            $.ajax({
                                url: 'insert.php', // URL do arquivo PHP para inserção no banco de dados
                                method: 'POST', // Método de envio dos dados
                                data: {
                                    title: title,
                                    start: start,
                                    end: end
                                },
                                success: function() {
                                    // Atualiza o calendário para mostrar o novo evento
                                    $('#calendar').fullCalendar('refetchEvents');
                                    // Exibe uma mensagem de sucesso
                                    alert('Evento adicionado com sucesso!');
                                    // Fecha o modal e reseta o formulário
                                    $('#eventModal').modal('hide');
                                    $('#eventForm')[0].reset();
                                }
                            });
                        }
                    });
                }
            });

            // Altera o tipo de campo do input de data/hora de início conforme a seleção do usuário
            $('#startType').change(function() {
                var selectedType = $(this).val();
                $('#start').attr('type', selectedType);
            });

            // Altera o tipo de campo do input de data/hora de fim conforme a seleção do usuário
            $('#endType').change(function() {
                var selectedType = $(this).val();
                $('#end').attr('type', selectedType);
            });
        });
    </script>
    
    <!-- Código PHP para manipulação do formulário de envio do evento -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Código PHP para inserir os dados do evento no banco de dados
        echo "<script>alert('Evento inserido com sucesso!');</script>";
    }
    ?>
</body>
</html>
