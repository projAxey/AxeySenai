<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Eventos</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css' />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #calendar {
            width: 100%;
            max-width: 1200px;
            /* Aumentado de 1000px para 1200px */
            margin: 20px auto;
        }

        .fc-header-toolbar {
            margin-bottom: 20px;
        }

        .fc-button {
            margin: 0 10px;
        }

        .fc-center h2 {
            text-transform: uppercase;
        }

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

        textarea {
            resize: none;
        }

        .modal-dialog {
            max-width: 70%;
            /* Aumentado de 60% para 70% */
            margin: 30px auto;
        }

        .fc-center h2 {
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            #calendar {
                margin: 20px auto;
                width: 100%;
                font-size: 0.9rem;
            }

            .fc-header-toolbar {
                font-size: 0.9rem;
            }

            .modal-dialog {
                max-width: 100%;
                margin: 20px;
            }

            .fc-button {
                margin: 0 5px;
            }

            .fc-center h2 {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .fc-center h2 {
                font-size: 1rem;
            }
        }

        /* Estilo para a modal de adicionar serviço */
        .modal-dialog-sm {
            max-width: 30%;
            margin: 30px auto;
        }

        @media (max-width: 768px) {
            .modal-dialog-sm {
                max-width: 80%;
            }
        }

        @media (max-width: 480px) {
            .modal-dialog-sm {
                max-width: 95%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <button type="button" class="btn btn-primary mt-5" data-toggle="modal" data-target="#calendarModal">
            Abrir Calendário
        </button>

        <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agenda de Serviços</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id='calendar'></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-white" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para adicionar evento -->
        <div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-sm" role="document">
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
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
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

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale/pt-br.js'></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                locale: 'pt-br',
                height: 'auto',
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                selectable: true,
                selectHelper: true,
                select: function (start, end) {
                    var now = moment().startOf('day');
                    if (moment(start).isBefore(now)) {
                        alert('Você não pode selecionar uma data anterior ao dia de hoje.');
                        $('#calendar').fullCalendar('unselect');
                        return;
                    }
                    $('#eventModal').modal('show');
                    $('#start').val(moment(start).format('YYYY-MM-DDTHH:mm'));
                    $('#end').val(moment(end).format('YYYY-MM-DDTHH:mm'));

                    $('#saveEvent').off('click').on('click', function () {
                        var title = $('#title').val();
                        var description = $('#description').val();
                        var start = $('#start').val();
                        var end = $('#end').val();
                        if (title) {
                            $.ajax({
                                url: 'insert.php',
                                method: 'POST',
                                data: {
                                    title: title,
                                    description: description,
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
        });
    </script>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<script>alert('Serviço inserido com sucesso!');</script>";
    }
    ?>
</body>

</html>
