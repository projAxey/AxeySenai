<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva -->
    <title>Calendário de Eventos</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css' />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Torna o calendário responsivo, ocupando toda a largura disponível em telas menores */
        #calendar {
            width: 100%;
            max-width: 1000px;
            /* Limita a largura máxima em telas maiores */
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

        /* Define a largura da modal para 50% da tela e centraliza */
        .modal-dialog {
            max-width: 50%;
            /* Ocupa 2/4 ou 50% da tela */
            margin: 30px auto;
            /* Centraliza a modal */
        }

        /* Tamanho da fonte do título do mês para dispositivos maiores */
        .fc-center h2 {
            font-size: 1.5rem;
        }

        /* Media queries para dispositivos menores */
        @media (max-width: 768px) {
            #calendar {
                margin: 20px auto;
                width: 100%;
                font-size: 0.85rem;
                /* Reduz o tamanho da fonte */
            }

            .fc-header-toolbar {
                font-size: 0.9rem;
                /* Ajusta o tamanho da fonte da toolbar */
            }

            .modal-dialog {
                max-width: 90%;
                /* Aumenta a largura da modal para telas menores */
                margin: 20px;
            }

            .fc-button {
                margin: 0 5px;
            }

            .fc-center h2 {
                font-size: 1.25rem;
                /* Reduz o tamanho do título do mês */
            }
        }

        /* Media queries para dispositivos ainda menores */
        @media (max-width: 480px) {
            .fc-center h2 {
                font-size: 1rem;
                /* Reduz ainda mais o tamanho do título do mês */
            }
        }
    </style>
</head>

<body>
    <div class="container calendar">
        <div id='calendar'>
            <!-- Modal para adicionar evento -->
            <div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Adicionar Serviço</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="eventForm">
                                <div class="form-group">
                                    <label for="description">Descrição do Serviço</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="start">Data/Hora de Início</label>
                                    <input type="datetime-local" class="form-control" id="start" name="start" required>
                                </div>
                                <div class="form-group">
                                    <label for="end">Data/Hora de Fim</label>
                                    <input type="datetime-local" class="form-control" id="end" name="end" required>
                                </div>
                                <div class="form-group">
                                    <label for="title">Título do Serviço</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="start">Data/Hora de Início</label>
                                    <div class="input-group">
                                        <input type="datetime-local" class="form-control" id="start" name="start"
                                            required>
                                        <div class="input-group-append">
                                            <select class="form-control" id="startType">
                                                <option value="datetime-local">Data e Hora</option>
                                                <option value="date">Data</option>
                                                <option value="time">Hora</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-custom-white" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-custom-blue" id="saveEvent">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js'></script>

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale/pt-br.js'></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                locale: 'pt-br',
                editable: true,
                header: {
                    height: '100%',
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                selectable: true,
                selectHelper: true,
                select: function (start, end) {
                    $('#eventModal').modal('show');
                    $('#start').val(start.format('YYYY-MM-DDTHH:mm'));
                    $('#end').val(end.format('YYYY-MM-DDTHH:mm'));
                    $('#saveEvent').off('click').on('click', function () {
                        var title = $('#title').val();
                        var start = $('#start').val();
                        var end = $('#end').val();
                        if (title) {
                            $.ajax({
                                url: 'insert.php',
                                method: 'POST',
                                data: {
                                    title: title,
                                    start: start,
                                    end: end
                                },
                                success: function () {
                                    $('#calendar').fullCalendar('refetchEvents');
                                    alert('Serviço adicionado com sucesso!');
                                    $('#eventModal').modal('hide');
                                    $('#eventForm')[0].reset();
                                }
                            });
                        }
                    });
                }
            });

            $('#startType').change(function () {
                var selectedType = $(this).val();
                $('#start').attr('type', selectedType);
            });

            $('#endType').change(function () {
                var selectedType = $(this).val();
                $('#end').attr('type', selectedType);
            });
        });
    </script>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Aqui você colocaria seu código para inserir no banco de dados
        echo "<script>alert('Serviço inserido com sucesso!');</script>";
    }
    ?>
</body>

</html>