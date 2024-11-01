<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
} else if ($_SESSION['tipo_usuario'] != "Administrador") {
    header("Location: ../../index.php");
    exit();
}

include '../layouts/head.php';
include '../layouts/nav.php';
include '../../config/conexao.php';
?>
<?php
// No topo do controleUsuarios.php
if (isset($_GET['clearMessage'])) {
    unset($_SESSION['message']);
}


if (isset($_SESSION['message'])) {
    echo '
    <script>
        Swal.fire({
            title: "Retorno:",
            text: "' . htmlspecialchars($_SESSION['message']) . '",
            timer: 5000,
            showCloseButton: true,
            showConfirmButton: false,
        }).then(() => {
            // Redireciona e limpa a mensagem da sessão
            window.location.href = "controleUsuarios.php?clearMessage=true";
        });
    </script>
    ';
}



?>

<?php
// Consulta SQL que unifica os dados das três tabelas, incluindo o ID
$query = "
    SELECT usuarioAdm_id AS id, nome, celular, email, tipo_usuario, status FROM UsuariosAdm
    UNION
    SELECT prestador_id AS id, nome_resp_legal AS nome, celular, email, tipo_usuario, status FROM Prestadores
    UNION
    SELECT cliente_id AS id, nome, celular, email, tipo_usuario, status FROM Clientes
";

$resultado = $conexao->prepare($query);
$resultado->execute();
$usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .label-custom {
        font-weight: bold;
        margin-right: 0.5rem;
        /* ou o valor desejado */
    }

    .texto {
        font-size: 1.2rem;
    }
</style>

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
                        <?php
                        // Definindo a função fora do loop
                        function getTableForUserType($tipo_usuario)
                        {
                            switch ($tipo_usuario) {
                                case 'Cliente':
                                    return 'Clientes';
                                case 'Prestador PF':
                                case 'Prestador PJ':
                                    return 'Prestadores';
                                case 'Administrador':
                                    return 'UsuariosAdm';
                                default:
                                    return ''; // Ou um valor padrão, se necessário
                            }
                        }
                        ?>

                        <?php foreach ($usuarios as $usuario): ?>
                            <?php
                            // Chama a função para obter a tabela do tipo de usuário
                            $table = getTableForUserType($usuario['tipo_usuario']);
                            $status = $usuario['status']; // Considerando que o status do usuário é carregado no array $usuarios
                            ?>

                            <tr data-nome="<?= htmlspecialchars($usuario['nome']) ?>" data-tipo="<?= htmlspecialchars($usuario['tipo_usuario']) ?>">
                                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                <td><?= htmlspecialchars($usuario['celular']) ?></td>
                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                                <td><?= htmlspecialchars($usuario['tipo_usuario']) ?></td>
                                <td class="actions-admin">
                                    <!-- Visualizar Usuário -->
                                    <button class="btn btn-sm btn-admin view-admin" data-bs-toggle="modal" data-bs-target="#viewModal"
                                        data-id="<?= htmlspecialchars($usuario['id']) ?>"
                                        data-nome="<?= htmlspecialchars($usuario['nome']) ?>"
                                        data-table="<?= htmlspecialchars($table) ?>"
                                        data-user-type="<?= htmlspecialchars($usuario['tipo_usuario']) ?>">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <!-- Botão de Bloqueio ou Desbloqueio -->
                                    <button class="btn btn-sm btn-admin block-admin" data-bs-toggle="modal"
                                        data-bs-target="<?= $status == 2 ? '#unblockModal' : '#blockModal' ?>"
                                        data-id="<?= htmlspecialchars($usuario['id']) ?>"
                                        data-table="<?= htmlspecialchars($table) ?>"
                                        data-name="<?= htmlspecialchars($usuario['nome']) ?>"
                                        data-user-type="<?= htmlspecialchars($usuario['tipo_usuario']) ?>">
                                        <i class="fa-solid <?= $status == 2 ? 'fa-lock' : 'fa-lock-open' ?>"></i>
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
        <div class="modal-dialog modal-lg">
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


    <!-- Modal para Bloquear Usuário -->
    <div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blockModalLabel">Bloquear Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja bloquear este usuário?</p>
                    <p id="userInfo"></p>

                    <!-- Aviso de produtos associados -->
                    <div id="productWarningBlock" style="display: none;">
                        <p><strong>Atenção:</strong> Este usuário possui os seguintes produtos cadastrados, que também serão bloqueados:</p>
                        <ul id="associatedProductsBlock"></ul>
                    </div>

                    <form method="POST" action="../../backend/adm/bloqueiaUsuario.php">
                        <input type="hidden" id="userIdBlock" name="userIdBlock" value="">
                        <input type="hidden" id="userNameBlock" name="userNameBlock" value="">
                        <input type="hidden" id="userTypeBlock" name="userTypeBlock" value="">
                        <input type="hidden" id="tableBlock" name="tableBlock" value="">
                        <div class="text-center d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger" id="confirmBlock">Bloquear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Desbloquear Usuário -->
    <div class="modal fade" id="unblockModal" tabindex="-1" aria-labelledby="unblockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unblockModalLabel">Desbloquear Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja desbloquear este usuário?</p>
                    <p id="userInfoUnblock"></p>

                    <!-- Aviso de produtos associados (reutilizado da modal de bloqueio) -->
                    <div id="productWarningUnblock" style="display: none;">
                        <p><strong>Atenção:</strong> Este usuário possui os seguintes produtos cadastrados, que também serão desbloqueados:</p>
                        <ul id="associatedProductsUnblock"></ul>
                    </div>

                    <form method="POST" action="../../backend/adm/desbloqueiaUsuario.php">
                        <input type="hidden" id="userIdUnblock" name="userIdUnblock" value="">
                        <input type="hidden" id="userNameUnblock" name="userNameUnblock" value="">
                        <input type="hidden" id="userTypeUnblock" name="userTypeUnblock" value="">
                        <input type="hidden" id="tableUnblock" name="tableUnblock" value="">
                        <div class="text-center d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="confirmUnblock">Desbloquear</button>
                        </div>
                    </form>
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

    <script src="../../assets/js/validaCamposGlobal.js"> </script>
    <script src="../../assets/js/controleUsuarios.js"> </script>

</body>

</html>