<?php
include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php';
?>

<?php
// Consulta SQL que unifica os dados das três tabelas, incluindo o ID
$query = "
    SELECT usuarioAdm_id AS id, nome, celular, email, tipo_usuario FROM UsuariosAdm
    UNION
    SELECT prestador_id AS id, nome_resp_legal AS nome, celular, email, tipo_usuario FROM Prestadores
    UNION
    SELECT cliente_id AS id, nome, celular, email, tipo_usuario FROM Clientes
";

$resultado = $conexao->prepare($query);
$resultado->execute();
$usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <main class="main-admin">
        <div class="container container-admin">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-admin">
                    <li class="breadcrumb-item">
                        <a href="admin.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                    </li>
                </ol>
            </nav>

            <div class="title-admin">GERENCIAR USUÁRIOS</div>

            <div class="row g-2 mb-4">
                <!-- Botão Novo Usuário -->
                <div class="col-12 col-md-3">
                    <button type="button" id="meusAgendamentos" class="mb-2 btn btn-primary w-100 btn-meus-agendamentos"
                        style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#novoUsuario">
                        Novo Usuário Adm <i class="bi bi-plus-circle"></i>
                    </button>
                </div>

                <!-- Input para pesquisa por nome -->
                <div class="col-12 col-md-4">
                    <input type="text" id="pesquisarUsuario" class="form-control" placeholder="Pesquisar por nome...">
                </div>

                <!-- Select para ordenar de A-Z ou Z-A -->
                <div class="col-12 col-md-3">
                    <select id="ordenarNomeSelect" class="form-select">
                        <option value="az">Ordenar por Nome (A-Z)</option>
                        <option value="za">Ordenar por Nome (Z-A)</option>
                    </select>
                </div>

                <!-- Filtro de tipos de usuário -->
                <div class="col-12 col-md-2">
                    <select id="filtroTipoUsuario" class="form-select">
                        <option value="todos">Todos</option>
                        <option value="Cliente">Cliente</option>
                        <option value="Prestador PF">Prestador PF</option>
                        <option value="Prestador PJ">Prestador PJ</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-striped-admin" id="tabelaUsuarios">
                    <thead>
                        <tr>
                            <th class="th-admin">NOME</th>
                            <th class="th-admin">CONTATO</th>
                            <th class="th-admin">E-MAIL</th>
                            <th class="th-admin">TIPO USUÁRIO</th>
                            <th class="th-admin">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr data-nome="<?= htmlspecialchars($usuario['nome']) ?>" data-tipo="<?= htmlspecialchars($usuario['tipo_usuario']) ?>">
                                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                <td><?= htmlspecialchars($usuario['celular']) ?></td>
                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                                <td><?= htmlspecialchars($usuario['tipo_usuario']) ?></td>
                                <td class="actions-admin">
                                    <!-- Visualizar Usuário -->
                                    <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                        data-id="<?= htmlspecialchars($usuario['id']) ?>"
                                        data-table="<?php
                                                    // Mapeamento do tipo de usuário para a tabela
                                                    switch ($usuario['tipo_usuario']) {
                                                        case 'Cliente':
                                                            echo 'Clientes';
                                                            break;
                                                        case 'Prestador PF':
                                                        case 'Prestador PJ':
                                                            echo 'Prestadores';
                                                            break;
                                                        case 'Administrador':
                                                            echo 'UsuariosAdm';
                                                            break;
                                                        default:
                                                            echo ''; // Ou um valor padrão, se necessário
                                                            break;
                                                    }
                                                    ?>"
                                        data-name="<?= htmlspecialchars($usuario['nome']) ?>"
                                        data-phone="<?= htmlspecialchars($usuario['celular']) ?>"
                                        data-email="<?= htmlspecialchars($usuario['email']) ?>"
                                        data-user-type="<?= htmlspecialchars($usuario['tipo_usuario']) ?>">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <!-- Excluir Usuário -->
                                    <button class="btn btn-sm btn-admin delete-admin" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-id="<?= htmlspecialchars($usuario['id']) ?>"
                                        data-table="<?php
                                                    // Mapeamento do tipo de usuário para a tabela
                                                    switch ($usuario['tipo_usuario']) {
                                                        case 'Cliente':
                                                            echo 'Clientes';
                                                            break;
                                                        case 'Prestador PF':
                                                        case 'Prestador PJ':
                                                            echo 'Prestadores';
                                                            break;
                                                        case 'Administrador':
                                                            echo 'UsuariosAdm';
                                                            break;
                                                        default:
                                                            echo ''; // Ou um valor padrão, se necessário
                                                            break;
                                                    }
                                                    ?>"
                                        data-name="<?= htmlspecialchars($usuario['nome']) ?>"
                                        data-phone="<?= htmlspecialchars($usuario['celular']) ?>"
                                        data-email="<?= htmlspecialchars($usuario['email']) ?>"
                                        data-user-type="<?= htmlspecialchars($usuario['tipo_usuario']) ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- MODAL DE VISUALIZAR USUÁRIO -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Visualizar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="modalBody">
                    <!-- Os campos serão inseridos aqui -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Excluir Usuário -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Excluir Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja excluir este usuário?
                    <p id="deleteUserInfo"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="novoUsuario" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Novo Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="CadastroUsuarios" onsubmit="validaCampos(event)" method="POST" action="../../backend/auth/register.php">
                        <input type="hidden" id="tipoUsuario" name="tipoUsuario" value="Administrador">

                        <div class="row">
                            <div id="nomeCompleto" class="mb-3">
                                <label for="nome" class="form-label" id="nomeLabel">Nome Completo*</label>
                                <input type="text" class="form-control" id="nome" name="nome">
                                <div class="invalid-feedback"></div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-7 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <div class="emailFeedback"></div>
                            </div>

                            <!-- Data de Nascimento -->
                            <div class="col-md-5 mb-3" id="dataNascimentoFields">
                                <label for="dataNascimento" class="form-label">Data de Nascimento *</label>
                                <input type="date" class="form-control text-center" id="dataNascimento" name="dataNascimento">
                                <div class="invalid-feedback">Por favor, insira uma data acima de 1924 </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- CPF -->
                            <div class="col-md-6" id="cpfFields" class="d-none">
                                <label for="cpf" class="form-label">CPF *</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14">
                                <div id="invalid-feedback" class="invalid-feedback">Por favor, preencha um CPf válido.</div>
                            </div>

                            <!-- Cargo -->
                            <div class="col-md-6 mb-3" id="cargoFields" class="d-none">
                                <label for="cargo" class="form-label">Cargo *</label>
                                <input type="text" class="form-control" id="cargo" name="cargo">
                                <div class="cargoFeedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Celular  -->
                            <div class="col-md-6 mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input type="tel" class="form-control" id="celular" name="celular" pattern="\(\d{2}\) \d{5}-\d{4}" aria-required="true" maxlength="15">
                                <div id="aviso-celular" class="text-danger" style="display:none;"></div>
                            </div>

                            <!-- Senha -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="senha" class="form-label">Digite sua Senha *</label>
                                    <div class="input-group">
                                        <input type="password" name="senha" class="form-control" id="senha">
                                        <button class="btn btn-outline" style="background-color: #dedede" type="button" id="toggleSenha">
                                            <i class="bi bi-eye" id="senha-icon"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback" id="senha-error">
                                        A senha deve ter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma letra minúscula, um número e um caractere especial.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="senha_repetida" class="form-label">Repita sua Senha *</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="senha_repetida" name="senha_repetida">
                                        <button class="btn btn-outline" style="background-color: #dedede" type="button" id="toggleSenhaRepetida">
                                            <i class="bi bi-eye" id="senha-repetida-icon"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback" id="senha-repetida-error">
                                        As senhas não coincidem.
                                    </div>
                                </div>
                            </div>

                            <!-- Botoes de salvar e cancelar -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <button type="submit" class="btn btn-primary mb-2" style="background-color: #012640; color:white;">Salvar</button>
                                <button type="button" id="cancelarEdicao" class="btn btn-secondary mb-2">Cancelar</button>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/validaCamposGlobal.js"></script>
    <script>
        // Ordenar a tabela com base na seleção do usuário (A-Z ou Z-A)
        document.getElementById('ordenarNomeSelect').addEventListener('change', function() {
            let tabela = document.getElementById('tabelaUsuarios').getElementsByTagName('tbody')[0];
            let linhas = Array.from(tabela.getElementsByTagName('tr'));
            let ordem = this.value; // 'az' ou 'za'

            linhas.sort(function(a, b) {
                let nomeA = a.getAttribute('data-nome').toLowerCase();
                let nomeB = b.getAttribute('data-nome').toLowerCase();

                if (ordem === 'az') {
                    return nomeA.localeCompare(nomeB); // A-Z
                } else {
                    return nomeB.localeCompare(nomeA); // Z-A
                }
            });

            // Reordenar a tabela
            linhas.forEach(function(linha) {
                tabela.appendChild(linha);
            });
        });

        // Ativar a função de filtragem quando qualquer um dos filtros mudar
        document.getElementById('pesquisarUsuario').addEventListener('keyup', filtrarTabela);
        document.getElementById('filtroTipoUsuario').addEventListener('change', filtrarTabela);

        function filtrarTabela() {
            let valorPesquisa = document.getElementById('pesquisarUsuario').value.toLowerCase();
            let filtroTipo = document.getElementById('filtroTipoUsuario').value.toLowerCase();
            let linhas = document.querySelectorAll('#tabelaUsuarios tbody tr');

            linhas.forEach(function(linha) {
                let nome = linha.getAttribute('data-nome').toLowerCase();
                let tipo = linha.getAttribute('data-tipo').toLowerCase();

                // Verifica se a linha atende tanto ao filtro de nome quanto ao filtro de tipo de usuário
                if ((filtroTipo === 'todos' || tipo === filtroTipo) && nome.includes(valorPesquisa)) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        }

        // Função de validação para o campo cargo
        function validarCargo(cargo) {
            // Verifica se o cargo está preenchido e tem menos de 30 caracteres
            return cargo.trim() !== "" && cargo.length <= 30;
        }

        // Validação do campo cargo em tempo real
        document.getElementById('cargo').addEventListener('input', function() {
            const cargoInput = this;
            const cargoValor = cargoInput.value;
            const cargoFeedback = document.querySelector('.cargoFeedback'); // Certifique-se de que esse elemento existe

            if (!validarCargo(cargoValor)) {
                cargoInput.classList.add('is-invalid');
                cargoFeedback.textContent = 'Por favor, insira um cargo válido (até 30 caracteres).';
                cargoFeedback.classList.add('text-danger'); // Adiciona uma classe para estilizar o feedback
            } else {
                cargoInput.classList.remove('is-invalid');
                cargoFeedback.textContent = '';
                cargoFeedback.classList.remove('text-danger'); // Remove a classe se o cargo estiver válido
            }
        });


        const cancelarBtn = document.getElementById('cancelarEdicao');
        cancelarBtn.addEventListener('click', function() {
            Swal.fire({
                title: "Cancelar Edição",
                text: "Você tem certeza que deseja cancelar a criação de um novo usuário?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const formulario = document.getElementById('CadastroUsuarios');
                    formulario.reset();
                    // Remove classes de erro, feedbacks e formatações
                    formulario.querySelectorAll('.is-invalid, .text-danger').forEach((el) => el.classList.remove('is-invalid', 'text-danger'));
                    formulario.querySelectorAll('.invalid-feedback, .emailFeedback, .cargoFeedback').forEach((el) => el.style.display = 'none');
                    formulario.querySelectorAll('.text-danger').forEach((el) => el.textContent = '');
                    // Fecha a modal usando o método Bootstrap
                    const modal = bootstrap.Modal.getInstance(document.getElementById('novoUsuario'));
                    modal.hide();
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            // Seleciona todos os botões com a classe 'view-admin'
            const viewButtons = document.querySelectorAll('.view-admin');

            // Adiciona o evento de clique para cada botão
            viewButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const usuarioId = button.getAttribute('data-id');
                    const tabela = button.getAttribute('data-table');

                    // Fazer uma requisição AJAX para buscar os dados do usuário
                    fetch(`../../backend/adm/visualizarUsuario.php?id=${usuarioId}&table=${tabela}`)
                        .then(response => response.json())
                        .then(data => {
                            const modalBody = document.getElementById('modalBody');
                            modalBody.innerHTML = ''; // Limpa o conteúdo anterior

                            // Adiciona campos dinamicamente com os valores do usuário
                            data.columns.forEach(column => {
                                modalBody.innerHTML += `
                            <div class="form-group">
                                <label  class="form-label mb-1" for="${column}">${column}</label>
                                <input type="text" class="form-control mb-3" name="${column}" id="${column}" value="${data[column] || ''}" readonly>
                            </div>
                        `;
                            });
                        })
                        .catch(error => console.error('Erro:', error));
                });
            });
        });

        
    </script>

</body>

</html>