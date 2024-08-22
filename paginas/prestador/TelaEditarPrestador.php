<?php
include '../../padroes/head.php';
?>

<body class="bodyCards">
    <?php
    include '../../padroes/nav.php';
    ?>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Adiciona o SweetAlert2 -->
    <link rel="stylesheet" href="/projAxeySenai/assets/css/style.css">

    <style>
        /* Estilo do Modal */
        .modal {
            display: none;
            /* Inicialmente escondido */
            position: fixed;
            z-index: 1050;
            /* Bootstrap z-index */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-backdrop.show {
            opacity: 0;
        }

        .modal-content {
            background-color: #ffff;
            margin: 5% auto;
            /* Ajustado para melhor centralização */
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 800px;
            height: 90%;
            /* Ajuste da altura do modal */
        }

        .close {
            color: #aaa;
            float: right;
            text-align: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #calendar {
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        /* Estilo do formulário no pop-up */
        .popup-form {
            display: none;
            position: fixed;
            z-index: 1060;
            left: 50%;
            top: 50%;
            margin-top: 1, 5%;
            margin-bottom: 1, 5%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            height: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        textarea {
            resize: none;
            height: 100px;
        }

        a {
            text-decoration: none;
            color: #012640;
        }
    </style>

    <div class="container mt-4">
        <div class="row d-flex flex-wrap">
            <!-- Perfil -->
            <div class="col-md-4 mt-2">
                <div class="text-center area-foto-perfil mt-2">
                    <img src="../../assets/imgs/ruivo.png" alt="Ícone de usuário" class="mb-3 foto-perfil">
                </div>
                <div class="rate text-center mb-3">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="5 estrelas" aria-label="5 estrelas">★</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="4 estrelas" aria-label="4 estrelas">★</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="3 estrelas" aria-label="3 estrelas">★</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="2 estrelas" aria-label="2 estrelas">★</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="1 estrela" aria-label="1 estrela">★</label>
                </div>
                <div class="d-grid">
                    <button type="button" id='show-calendar' class="btn btn-primary botaoVerificaDisponibilidade"
                        data-toggle="modal" data-target="#calendarModal">
                        <i class="fa-regular fa-calendar"></i> Ajustar Disponibilidade </button>
                </div>
            </div>

            <!-- Formulário de Edição -->
            <div class="col-md-8 mt-2">
                <h3 class="text-left">Editar Perfil
                    <img width="5%" height="5%" src="https://img.icons8.com/color/48/verified-badge.png"
                        alt="verified-badge" />
                </h3>
                <h5 class="text-left">Cidade</h5>

                <form class="mt-3" id="editForm">
                    <div class="row g-3">


                        <div class="col-md-12">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" maxlength="100" required
                                aria-required="true">
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="nome-social-checkbox">
                                <label class="form-check-label" for="nome-social-checkbox">
                                    Usar Nome Social
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12" id="nome-social-field" style="display: none;">
                            <label for="nome-social" class="form-label">Nome Social</label>
                            <input type="text" class="form-control" id="nome-social" maxlength="100">
                        </div>
                        <div class="col-md-8">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required aria-required="true"
                                maxlength="100">
                        </div>
                        <div class="col-md-4">
                            <label for="seguimento" class="form-label">Categoria</label>
                            <select class="form-control" id="seguimento" required aria-required="true">
                                <option value="" disabled selected>Selecione uma Categoria</option>
                                <option value="teste">Aqui vem do banco</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="tel" class="form-control" id="celular" pattern="\(\d{2}\) \d{5}-\d{4}"
                                placeholder="(XX) XXXXX-XXXX" required aria-required="true" maxlength="15">
                        </div>
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" pattern="\(\d{2}\) \d{4}-\d{4}"
                                placeholder="(XX) XXXX-XXXX" maxlength="14">
                        </div>
                        <div class="col-md-6">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" pattern="\d{5}-\d{3}"
                                placeholder="XXXXX-XXX" required aria-required="true">
                            <small id="cepHelp" class="form-text text-muted">
                                <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep"
                                    target="_blank">Não sei meu Cep</a>
                            </small>
                        </div>
                        <div class="col-md-6">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade">
                        </div>
                        <div class="col-md-6">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro">
                        </div>
                        <div class="col-md-6">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco">
                        </div>
                        <div class="col-md-6">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" maxlength="10">
                        </div>
                        <div class="col-md-6">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" maxlength="25">
                        </div>

                        <div class="col-md-6">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" id="senha" class="form-control" required aria-required="true"
                                minlength="8" maxlength="20">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Sua senha deve ter entre 8 e 20 caracteres.
                            </small>
                        </div>
                        <div class="col-md-6">
                            <label for="confirma-senha" class="form-label">Confirme a Senha</label>
                            <input type="password" id="confirma-senha" class="form-control" required
                                aria-required="true" minlength="8" maxlength="20">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Sua senha deve ter entre 8 e 20 caracteres.
                            </small>
                        </div>
                        <div class="col-md-12">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" rows="3" maxlength="500"></textarea>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary"
                            style="background-color: #012640; color:white">Salvar</button>
                        <button id="btnCadastroProduto" type="button" class="btn btn-primary"
                            style="background-color: #012640; color:white">Novo Serviço</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div id='calendarModal' class='modal'>
            <div class='modal-content'>
                <span class='close'>&times;</span>
                <div id='calendar'></div>
            </div>
        </div>
        <!-- Final Modal -->
        <!-- Modal -->
        <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
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
        <div id="popupForm" class="popup-form">
            <h3>Serviço</h3>
            <form id="serviceForm">
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
                    <button type="submit" id="saveEvent" class="btn btn-primary" style="width: 45%;">Salvar</button>
                    <button type="button" class="btn btn-secondary close-popup" style="width: 45%;">Fechar</button>
                </div>
                
            </form>
        </div>
    </div>

    <?php include '../../padroes/footer.php'; ?>

    <script src="../../assets/JS/calendario.js"></script>

    <script>

        document.getElementById('cep').addEventListener('input', function () {
            var cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                this.value = cep.replace(/(\d{5})(\d{0,3})/, '$1-$2');
            }
            if (cep.length === 8) {
                fetch('https://viacep.com.br/ws/' + cep + '/json/')
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('endereco').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                            document.getElementById('numero').focus();
                        } else {
                            alert('CEP não encontrado. Por favor, verifique o CEP digitado.');
                        }
                    })
            }
        });

        document.getElementById('celular').addEventListener('input', function () {
            var celular = this.value.replace(/\D/g, '');
            this.value = celular.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        });

        document.getElementById('telefone').addEventListener('input', function () {
            var telefone = this.value.replace(/\D/g, '');
            this.value = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        });

        document.addEventListener('DOMContentLoaded', function () {
            const monthYearDiv = document.getElementById('monthYear');
            const datesDiv = document.getElementById('dates');
            const nomeSocialCheckbox = document.getElementById('nome-social-checkbox');
            const nomeSocialField = document.getElementById('nome-social-field');

            const date = new Date();
            let currentYear = date.getFullYear();
            let currentMonth = date.getMonth();

            function updateCalendar() {
                const firstDay = new Date(currentYear, currentMonth, 1);
                const lastDay = new Date(currentYear, currentMonth + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startDay = firstDay.getDay();

                datesDiv.innerHTML = '';

                for (let i = 0; i < startDay; i++) {
                    const emptyElement = document.createElement('div');
                    emptyElement.className = 'calendar-date empty';
                    datesDiv.appendChild(emptyElement);
                }

                for (let i = 1; i <= daysInMonth; i++) {
                    const dateElement = document.createElement('div');
                    dateElement.className = 'calendar-date';
                    dateElement.innerText = i;
                    datesDiv.appendChild(dateElement);
                }

                monthYearDiv.innerText = `${date.toLocaleString('default', { month: 'long' })} ${currentYear}`;
            }

            document.getElementById('prevMonth').addEventListener('click', function () {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                updateCalendar();
            });

            document.getElementById('nextMonth').addEventListener('click', function () {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                updateCalendar();
            });

            updateCalendar();

            nomeSocialCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    nomeSocialField.style.display = 'block';
                } else {
                    nomeSocialField.style.display = 'none';
                }
            });

            document.getElementById("btnCadastroProduto").addEventListener("click", function () {
                window.location.href = "telaCadastroProduto.php";
            });

            document.getElementById('editForm').addEventListener('submit', function (event) {
                // Adicionar lógica de validação e manipulação de submissão de formulário
                event.preventDefault();
                alert('Formulário salvo com sucesso!');
            });
        });
    </script>
</body>

</html>