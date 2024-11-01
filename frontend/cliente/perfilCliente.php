<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../layouts/head.php';
include '../layouts/nav.php';

require_once '../../config/conexao.php';

$cliente_id = $_SESSION['cliente_id'] ?? null;

if ($cliente_id) {
    // Busca os dados do cliente no banco de dados
    $sql = "SELECT * FROM Clientes WHERE cliente_id = :cliente_id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $stmt->execute();

    // Obtém os dados do cliente
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se encontrou o cliente
    if (!$cliente) {
        die('Cliente não encontrado.');
    }
} else {
    die('ID do cliente não fornecido.');
}

$nomeSocialPreenchido = !empty($cliente['nome_social']);

?>

<body class="bodyCards">
    <script src="../../assets/js/perfilCliente.js"></script>

    <div class="container mt-4">
        <button type="button" id='meusAgendamentos' class="mb-2 btn btn-primary btn-servicos-contratados"
            style="background-color: #012640; color:white" onclick="window.location.href='../../index.php';">
            Voltar para Tela Inicial
        </button>

        <div class="row d-flex flex-wrap">
            <div class="col-md-4 mt-2">
                <div class="text-center area-foto-perfil">
                    <img id="fotoPerfil" src="../../assets/imgs/ruivo.png" alt="Ícone de usuário" class=" foto-perfil" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                </div>
                <div class="d-grid sidebar-menu">
                    <button type="button" class="btn btn-primary mb-2 mt-2" id="alterar-foto" style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#modalAlterarFoto">
                        <i class="bi bi-pencil"></i> Alterar Foto
                    </button>
                    <button class="btn btn-primary edit-perfil mb-2" id="editarPerfil" style="background-color: #012640;"><i class="bi bi-pencil">
                        </i>Editar Perfil</button>
                    <button type="button" class="btn btn-primary btnAlteraSenha mb-2" data-bs-toggle="modal" id="AlteraSenha" data-bs-target="#mdlAlteraSenha" style="background-color: #012640; color:white;"><i class="bi bi-pencil">
                        </i>Alterar Senha</button>
                    <button type="button" id='meusAgendamentos' class="mb-2 btn btn-primary btn-servicos-contratados"
                        style="background-color: #012640; color:white" onclick="window.location.href='servicosContratados.php';">
                        Serviços Contratados
                    </button>
                    <button type="button" id='meusAgendamentos' class="mb-2 btn btn-primary btn-meus-agendamentos"
                        style="background-color: #012640; color:white" onclick="window.location.href='agendamentosCliente.php'">
                        Meus Agendamentos
                    </button>

                </div>
                <!-- Modal de Upload de Foto -->
                <div class="modal fade" id="modalAlterarFoto" tabindex="-1" aria-labelledby="modalAlterarFotoLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalAlterarFotoLabel">Subir Nova Foto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formFotoPerfil">
                                    <div class="mb-3">
                                        <label for="inputFotoPerfil" class="form-label">Escolha uma nova foto de perfil</label>
                                        <input class="form-control" type="file" id="inputFotoPerfil" accept="image/*">
                                    </div>
                                    <div class="text-center">
                                        <img id="previewFotoPerfil" src="#" alt="Prévia da Foto" class="img-thumbnail" style="display:none; width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary" style="background-color: #012640; color:white" id="salvarFoto">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <form id="editForm" method="POST" action="../../backend/edita/editaPerfil.php">
                    <div class="row g-3">
                        <!-- Nome completo -->
                        <div class="col-md-12">
                            <label for="nome" class="form-label" id="nomeLabel">Nome Completo*</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= $cliente['nome']; ?>" placeholder="Ex: João Antonio da Silva" disabled>
                        </div>

                        <!-- Nome Social -->
                        <div class="form-check mb-3" style="display: none;">
                            <input class="form-check-input" type="checkbox" id="usarNomeSocialField">
                            <label class="form-check-label" for="usarNomeSocialField">
                                Desejo usar Nome Social
                            </label>
                        </div>

                        <?php if ($nomeSocialPreenchido): ?>
                            <div id="nomeSocialFields" class="mb-3">
                                <label for="nomeSocial" class="form-label">Nome Social *</label>
                                <input type="text" class="form-control" id="nomeSocial" name="nomeSocial" value="<?= $cliente['nome_social']; ?>" placeholder="Ex: Joãozinho" disabled>
                            </div>
                        <?php else: ?>
                            <div id="nomeSocialFields" class="d-none mb-3">
                                <label for="nomeSocial" class="form-label">Nome Social *</label>
                                <input type="text" class="form-control" id="nomeSocial" name="nomeSocial" placeholder="Ex: Joãozinho">
                            </div>
                        <?php endif; ?>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $cliente['email']; ?>" maxlength="100" disabled>
                        </div>

                        <!-- Data de Nascimento -->
                        <div class="col-md-6">
                            <label for="dataNascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" value="<?= $cliente['data_nascimento']; ?>" disabled>
                        </div>

                        <!-- CPF -->
                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $cliente['cpf']; ?>" pattern="\d{11}" maxlength="11" disabled>
                        </div>

                        <!-- Celular -->
                        <div class="col-md-6">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="tel" class="form-control" id="celular" name="celular" value="<?= $cliente['celular']; ?>" pattern="\(\d{2}\) \d{5}-\d{4}" placeholder="(XX) XXXXX-XXXX" maxlength="15" disabled>
                        </div>

                        <!-- Telefone -->
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" value="<?= $cliente['telefone']; ?>" pattern="\(\d{2}\) \d{4}-\d{4}" placeholder="(XX) XXXX-XXXX" maxlength="14" disabled>
                        </div>

                        <!-- CEP -->
                        <div class="col-md-6">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" value="<?= $cliente['cep']; ?>" pattern="\d{5}-\d{3}" placeholder="XXXXX-XXX" disabled>
                            <small id="cepHelp" class="form-text text-muted">
                                <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep" target="_blank" style="text-decoration: none; color: #012640;">Não sei meu Cep</a>
                            </small>
                        </div>
                        
                           <!-- Estado -->
                        <div class="col-md-6">
                            <label for="uf" class="form-label">Uf</label>
                            <input type="text" class="form-control" id="uf" name="uf" disabled>
                        </div>

                        <!-- Cidade -->
                        <div class="col-md-6">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" value="<?= $cliente['cidade']; ?>" disabled>
                        </div>

                        <!-- Bairro -->
                        <div class="col-md-6">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" value="<?= $cliente['bairro']; ?>" disabled>
                        </div>

                        <!-- Endereço -->
                        <div class="col-md-6">
                            <label for="logradouro" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="logradouro" name="logradouro" value="<?= $cliente['logradouro']; ?>" disabled>
                        </div>

                        <!-- Número -->
                        <div class="col-md-6">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="<?= $cliente['numero']; ?>" maxlength="10" disabled>
                        </div>

                        <!-- Complemento -->
                        <div class="col-md-6">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" value="<?= $cliente['complemento']; ?>" maxlength="25" disabled>
                        </div>
                    </div>

                    <!-- Botão Salvar -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary mb-2" style="background-color: #012640; color:white; display:none;">Salvar</button>
                        <button type="button" id="cancelarEdicao" class="btn btn-secondary mb-2" style="display:none;">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include '../layouts/footer.php';
    ?>
    <!-- <script src="../../assets/js/global.js"></script> -->
    <script src="../../assets/js/editaPerfil.js"></script>
    <script src="../../assets/js/validaCadastro.js"></script>
    
</body>

</html>