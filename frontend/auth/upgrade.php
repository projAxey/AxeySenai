<!DOCTYPE html>
<html lang="pt-br">

<?php
session_start();
include '../layouts/head.php';
require_once '../../config/conexao.php';

$userId = $_SESSION['id'];

try {
    // Consulta para buscar todas as categorias
    $sql = "SELECT categoria_id, titulo_categoria FROM Categorias";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Consulta para buscar todas as informações do cliente
    $sqlCliente = "SELECT * FROM Clientes WHERE cliente_id = :cliente_id";
    $stmtCliente = $conexao->prepare($sqlCliente);
    $stmtCliente->bindParam(':cliente_id', $userId, PDO::PARAM_INT);
    $stmtCliente->execute();
    $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
}
?>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="../../assets/imgs/logoPronta.png" alt="Logo da Axey" class="logoCadastro">
                        <h3>Crie sua conta. É grátis!</h3>
                    </div>
                    <div class="card-body">
                    <form id="CadastroUsuarios" onsubmit="validaCampos(event)" method="POST" action="../../backend/auth/register.php">

<input type="hidden" id="tipoUsuario" name="tipoUsuario" value="false">

<!-- Nome Completo -->
<div class="mb-3" id="nomeFields">
    <label for="nome" class="form-label" id="nomeLabel">Nome Completo*</label>
    <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: João Antonio da Silva" 
           value="<?= htmlspecialchars($cliente['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <div class="invalid-feedback"></div>
</div>

<!-- Nome responsável legal -->
<div class="mb-3" id="respLegal">
    <label for="respLegal" class="form-label">Responsável Legal</label>
    <input type="text" class="form-control" id="nome_resp_legal" name="nome_resp_legal" 
           value="<?= htmlspecialchars($cliente['nome_resp_legal'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <div class="invalid-feedback"></div>
</div>

<div id="nomeSocialFields" class="d-none mb-3">
    <label for="nomeSocial" class="form-label">Nome Social *</label>
    <input type="text" class="form-control" id="nomeSocial" name="nomeSocial" placeholder="Ex: Joãozinho"
           value="<?= htmlspecialchars($cliente['nomeSocial'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
</div>
<div id="usarNomeSocialField" class="form-check mb-3">
    <input class="form-check-input" type="checkbox" id="usarNomeSocial" 
           <?= isset($cliente['usarNomeSocial']) && $cliente['usarNomeSocial'] ? 'checked' : '' ?>>
    <label class="form-check-label" for="usarNomeSocial">Desejo usar Nome Social</label>
</div>

<!-- Campos Jurídicos e Físicos -->
<div id="juridicaFields" class="d-none">
    <div class="mb-3">
        <label for="nomeFantasia" class="form-label">Nome Fantasia *</label>
        <input type="text" class="form-control" id="nomeFantasia" name="nomeFantasia" 
               value="<?= htmlspecialchars($cliente['nomeFantasia'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>
    <div class="mb-3">
        <label for="razaoSocial" class="form-label">Razão Social *</label>
        <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" 
               value="<?= htmlspecialchars($cliente['razaoSocial'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-7">
        <label for="email" class="form-label">Email *</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Ex: joaoantonio@gmail.com" 
               value="<?= htmlspecialchars($cliente['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div class="emailFeedback"></div>
    </div>
    <div class="col-md-5" id="dataNascimentoFields">
        <label for="dataNascimento" class="form-label">Data de Nascimento *</label>
        <input type="date" class="form-control text-center" id="dataNascimento" name="dataNascimento" 
               value="<?= htmlspecialchars($cliente['dataNascimento'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div class="invalid-feedback">Por favor, insira uma data acima de 1924 e abaixo de 2025.</div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6" id="cnpjFields" class="d-none">
        <label for="cnpj" class="form-label">CNPJ *</label>
        <input type="text" class="form-control" id="cnpj" name="cnpj" maxlength="18" 
               value="<?= htmlspecialchars($cliente['cnpj'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div id="invalid-feedback" class="invalid-feedback">Por favor, preencha um CNPJ válido.</div>
    </div>

    <div class="col-md-6" id="cpfFields" class="d-none">
        <label for="cpf" class="form-label">CPF *</label>
        <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" 
               value="<?= htmlspecialchars($cliente['cpf'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div id="invalid-feedback" class="invalid-feedback">Por favor, preencha um CPF válido.</div>
    </div>

    <div class="col-md-6 d-none" id="categoriaFields">
        <label for="categoria" class="form-label">Categoria *</label>
        <select class="form-select" id="categoria" name="categoria">
            <option value="" disabled selected>Selecione uma categoria</option>
            <?php
            if (!empty($categorias)) {
                foreach ($categorias as $categoria) {
                    echo '<option value="' . htmlspecialchars($categoria['categoria_id'], ENT_QUOTES, 'UTF-8') . '"' . 
                         (isset($cliente['categoria']) && $cliente['categoria'] == $categoria['categoria_id'] ? ' selected' : '') . 
                         '>' . htmlspecialchars($categoria['titulo_categoria'], ENT_QUOTES, 'UTF-8') . '</option>';
                }
            } else {
                echo '<option value="" disabled>Nenhuma categoria disponível</option>';
            }
            ?>
        </select>
    </div>
</div>

<div id="descricaoFields" class="d-none">
    <div class="mb-3">                   
        <label for="descricao" class="form-label">Descrição do Negócio *</label>
        <textarea class="form-control descricaoNegocio" id="descricao" name="descricao"><?= htmlspecialchars($cliente['descricao'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        <div class="invalid-feedback" id="descricao-error">A descrição deve ter pelo menos 30 caracteres e menos de 200 caracteres.</div>
        <small id="charCount" class="form-text text-muted">0 caracteres</small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="celular" class="form-label">Celular *</label>
        <input type="text" class="form-control" id="celular" name="celular" 
               value="<?= htmlspecialchars($cliente['celular'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div id="aviso-celular" class="text-danger" style="display:none;"></div>
    </div>
    <div class="col-md-6">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" 
               value="<?= htmlspecialchars($cliente['telefone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div id="aviso-telefone" class="text-danger" style="display:none;"></div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="cep" class="form-label">CEP *</label>
        <div class="d-flex">
            <input type="text" class="form-control me-2" id="cep" name="cep" placeholder="00000-000" maxlength="9" 
                   value="<?= htmlspecialchars($cliente['cep'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep" target="_blank">Não sei meu Cep</a>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-5">
        <label for="endereco" class="form-label">Endereço *</label>
        <input type="text" class="form-control" id="endereco" name="endereco" 
               value="<?= htmlspecialchars($cliente['endereco'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>
    <div class="col-md-4">
        <label for="bairro" class="form-label">Bairro *</label>
        <input type="text" class="form-control" id="bairro" name="bairro" 
               value="<?= htmlspecialchars($cliente['bairro'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>
    <div class="col-md-3">
        <label for="numero" class="form-label">Número *</label>
        <input type="number" class="form-control numero-menor" id="numero" name="numero" maxlength="8" min="0"
               value="<?= htmlspecialchars($cliente['numero'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="complemento" class="form-label">Complemento</label>
        <input type="text" class="form-control" id="complemento" name="complemento" 
               value="<?= htmlspecialchars($cliente['complemento'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>
    <div class="col-md-4">
        <label for="estado" class="form-label">Estado *</label>
        <input type="text" class="form-control" id="estado" name="estado" 
               value="<?= htmlspecialchars($cliente['estado'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>
    <div class="col-md-4">
        <label for="cidade" class="form-label">Cidade *</label>
        <input type="text" class="form-control" id="cidade" name="cidade" 
               value="<?= htmlspecialchars($cliente['cidade'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="senha" class="form-label">Senha *</label>
        <input type="password" class="form-control" id="senha" name="senha">
    </div>
    <div class="col-md-6">
        <label for="confirmarSenha" class="form-label">Confirmar Senha *</label>
        <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha">
    </div>
</div>

<button type="submit" class="btn btn-primary">Cadastrar</button>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmaPessoa" tabindex="-1" aria-labelledby="confirmaPessoaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="../../assets/imgs/imgLogin.png" alt="Img Login" class="logoCadastro">
                    <h3 class="divideTipoCadastro">Qual o seu tipo de cadastro?</h3>
                    <div class="btn-selectable btnTipoCadastro" id="btnFisica">Pessoa Física<span class="texto"> (Possuo CPF)</span></div>
                    <div class="btn-selectable btnTipoCadastro" id="btnJuridica">Pessoa Jurídica<span class="texto"> (Possuo CNPJ)</span></div>
                </div>
            </div>
        </div>
    </div>
    <script src="..\..\assets\js\validaCamposGlobal.js"></script>
    <script src="..\..\assets\js\upgrade.js"></script>
</body>

</html>