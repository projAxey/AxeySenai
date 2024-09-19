<?php
include '../../projetoAxeySenai/frontend/layouts/head.php';
?>

<body class="bodyCards">
    <?php
    include '../../padroes/nav.php';
    ?>


    <style>
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

            <div class="col-md-4 mt-2 move_esquerda">

                <div class="text-center area-foto-perfil mt-2">
                    <img src="../../assets/imgs/ruivo.png" alt="Ícone de usuário" class="mb-3 foto-perfil">
                </div>
                <div>
                    <h3 class="text-center">Procurando o Affonso</h3>
                </div>
                <div class="d-grid">
                    <button type="button" id='show-calendar' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Ajustar Agenda </button>
                    <button type="button" id='show-calendar' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Agendamentos </button>
                    <button type="button" id='show-calendar' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Gerenciar Agenda </button>
                    <button type="button" id='show-calendar' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Meus Destaques </button>
                    <button type="button" id='show-calendar' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Minhas Promoções </button>
                    <button type="button" id='show-calendar' class="mb-2 btn btn-primary botaoVerificaDisponibilidade"
                        style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                        Meus Dados </butto>
                </div>
            </div>

            <!-- Formulário de Edição -->
            <div class="col-md-8 mt-2">
                <h1 class="mb-4">Meus Serviços</h1>
                <!-- Barra de Ações -->
                <div class="d-flex justify-content-between mb-4">

                    <button class="btn btn-secondary" style="background-color: #012640; color:white"
                        onclick="goBack()">Voltar</button>
                    <button class="btn btn-primary" style="background-color: #012640; color:white"
                        onclick="addNewService()">Novo Serviço</button>
                </div>

                <!-- Tabela com Cabeçalhos -->
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-striped-admin">
                            <thead>
                                <tr>
                                    <th class="th-admin">TÍTULO</th>
                                    <th class="th-admin">CATEGORIA</th>
                                    <th class="th-admin">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Reparos Gerais e Pequenas Reformas</td>
                                    <td>Manutenção Residencial</td>
                                    <td class="actions-admin">
                                        <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                                        <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                        <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal"
                                            data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Serviços de Hidráulica e Encanamento</td>
                                    <td>Manutenção Residencial</td>
                                    <td class="actions-admin">
                                        <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                            data-bs-target="#editModal"><i class="fa-solid fa-pen"></i></button>
                                        <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                        <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal"
                                            data-bs-target="#viewModal"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <?php
        include '../../projetoAxeySenai/frontend/calendario/calendario.php';
        ?>


        <script>
            //valida formulario de alteração de cadastro


            document.getElementById('cep').addEventListener('input', function() {

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

                        });
                }
            });

            document.getElementById('celular').addEventListener('input', function() {

                var celular = this.value.replace(/\D/g, '');
                this.value = celular.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            });


            document.getElementById('telefone').addEventListener('input', function() {

                var telefone = this.value.replace(/\D/g, '');
                this.value = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            });


            document.addEventListener('DOMContentLoaded', function() {

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


                document.getElementById('prevMonth').addEventListener('click', function() {

                    currentMonth--;
                    if (currentMonth < 0) {
                        currentMonth = 11;
                        currentYear--;
                    }
                    updateCalendar();
                });


                document.getElementById('nextMonth').addEventListener('click', function() {

                    currentMonth++;
                    if (currentMonth > 11) {
                        currentMonth = 0;
                        currentYear++;
                    }
                    updateCalendar();
                });

                updateCalendar();

                nomeSocialCheckbox.addEventListener('change', function() {

                    if (this.checked) {
                        nomeSocialField.style.display = 'block';
                    } else {
                        nomeSocialField.style.display = 'none';
                    }
                });


                document.getElementById("btnCadastroProduto").addEventListener("click", function() {
                    window.location.href = "telaCadastroProduto.php";
                });

                document.getElementById('editForm').addEventListener('submit', function(event) {

                    // Adicionar lógica de validação e manipulação de submissão de formulário
                    event.preventDefault();
                    alert('Formulário salvo com sucesso!');
                });
            });

            function goBack() {
                alert('Voltar');
                // Aqui você pode adicionar a lógica para voltar à página anterior
            }

            function addNewService() {
                alert('Adicionar novo serviço');
                // Aqui você pode adicionar a lógica para adicionar um novo serviço
            }

            function editService(id) {
                alert('Editar serviço ' + id);
                // Aqui você pode adicionar a lógica para editar o serviço
            }

            function deleteService(id) {
                alert('Excluir serviço ' + id);
                // Aqui você pode adicionar a lógica para excluir o serviço
            }
        </script>
</body>

</html>