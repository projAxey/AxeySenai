<?php include '../layouts/head.php';
require_once '../../config/conexao.php';

try {
    // Consulta para buscar todas as categorias
    $sql = "SELECT categoria_id, titulo_categoria FROM Categorias";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar categorias: " . $e->getMessage();
}
?>

<?php
if (isset($_GET['error'])) {
    $mensagem = 'O email já existe nesta tabela';
    echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: '$mensagem',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Fechar'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = 'register.php'; // Redireciona após fechar o alerta
                        }
                    });
                });
            </script>";
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
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: João Antonio da Silva">
                                <div class="invalid-feedback"></div>
                            </div>
                            <!-- Nome resp legal -->
                            <div class="mb-3" id="respLegal">
                                <label for="respLegal" class="form-label">Responsável Legal</label>
                                <input type="text" class="form-control" id="nome_resp_legal" name="nome_resp_legal">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div id="nomeSocialFields" class="d-none mb-3">
                                <label for="nomeSocial" class="form-label">Nome Social *</label>
                                <input type="text" class="form-control" id="nomeSocial" name="nomeSocial" placeholder="Ex: Joãozinho">
                            </div>
                            <div id="usarNomeSocialField" class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="usarNomeSocial">
                                <label class="form-check-label" for="usarNomeSocial">
                                    Desejo usar Nome Social
                                </label>
                            </div>

                            <!-- Campos Jurídicos e Físicos -->
                            <div id="juridicaFields" class="d-none">
                                <div class="mb-3">
                                    <label for="nomeFantasia" class="form-label">Nome Fantasia *</label>
                                    <input type="text" class="form-control" id="nomeFantasia" name="nomeFantasia">
                                </div>
                                <div class="mb-3">
                                    <label for="razaoSocial" class="form-label">Razão Social *</label>
                                    <input type="text" class="form-control" id="razaoSocial" name="razaoSocial">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-7">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Ex: joaoantonio@gmail.com">
                                    <div class="emailFeedback"></div>
                                </div>
                                <div class="col-md-5" id="dataNascimentoFields">
                                    <label for="dataNascimento" class="form-label">Data de Nascimento *</label>
                                    <input type="date" class="form-control text-center" id="dataNascimento" name="dataNascimento">
                                    <div class="invalid-feedback">Por favor, insira uma data acima de 1924 e abaixo de 2025.</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6" id="cnpjFields" class="d-none">
                                    <label for="cnpj" class="form-label">CNPJ *</label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" maxlength="18">
                                    <div id="invalid-feedback" class="invalid-feedback">Por favor, preencha um CNPJ válido.</div>
                                </div>


                                <div class="col-md-6" id="cpfFields" class="d-none">
                                    <label for="cpf" class="form-label">CPF *</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14">
                                    <div id="invalid-feedback" class="invalid-feedback">Por favor, preencha um CPf válido.</div>
                                </div>


                                <div class="col-md-6 d-none" id="categoriaFields">
                                    <label for="categoria" class="form-label">Categoria *</label>
                                    <select class="form-select" id="categoria" name="categoria">
                                        <option value="" disabled selected>Selecione uma categoria</option>
                                        <?php
                                        if (!empty($categorias)) {
                                            foreach ($categorias as $categoria) {
                                                echo '<option value="' . $categoria['categoria_id'] . '">' . htmlspecialchars($categoria['titulo_categoria'], ENT_QUOTES, 'UTF-8') . '</option>';
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
                                    <textarea class="form-control descricaoNegocio" id="descricao" name="descricao"></textarea>
                                    <div class="invalid-feedback" id="descricao-error">A descrição deve ter pelo menos 30 caracteres e menos de 200 caracateres.</div>
                                    <small id="charCount" class="form-text text-muted">0 caracteres</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="celular" class="form-label">Celular *</label>
                                    <input type="text" class="form-control" id="celular" name="celular">
                                    <div id="aviso-celular" class="text-danger" style="display:none;"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone">
                                    <div id="aviso-telefone" class="text-danger" style="display:none;"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="cep" class="form-label">CEP *</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control me-2" id="cep" name="cep" placeholder="00000-000" maxlength="9">
                                        <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep" target="_blank">Não sei meu Cep</a>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <label for="endereco" class="form-label">Endereço *</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco">
                                </div>
                                <div class="col-md-4">
                                    <label for="bairro" class="form-label">Bairro *</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro">
                                </div>
                                <div class="col-md-3">
                                    <label for="numero" class="form-label">Número *</label>
                                    <input type="number" class="form-control numero-menor" id="numero" name="numero" maxlength="8" min="0" step="1" oninput="this.value = this.value.slice(0, 8)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade">
                                </div>
                                <div class="col-md-4">
                                    <label for="uf" class="form-label">Uf</label>
                                    <input type="text" class="form-control" id="uf" name="uf">
                                </div>
                                <div class="col-md-4">
                                    <label for="complemento" class="form-label">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento">
                                </div>
                            </div>

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


                            <?php include 'visualizarDocs.php'; ?>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="privacyPolicyCheckbox">
                                <label class="form-check-label" for="privacyPolicyCheckbox">
                                    Eu li e aceito a <a href="#" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="openDocument('<?= $politica['caminho_arquivo'] ?>')">Politica de Privacidade</a>.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="termosDeUsoCheckbox">
                                <label class="form-check-label" for="termosDeUsoCheckbox">
                                    Eu li e aceito os <a href="#" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="openDocument('<?= $termos['caminho_arquivo'] ?>')">Termos de Uso</a>.
                                </label>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" style="background-color: #1A3C8D;">Cadastrar</button>
                            </div>

                            <div class="d-flex justify-content-center mt-2">
                                <span>Já tem uma conta? </span>
                                <a href="login.php" class="ms-2">Entrar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Usuário -->
    <div class="modal fade" id="confirmaUser" tabindex="-1" aria-labelledby="confirmaUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="../../assets/imgs/imgLogin.png" alt="Img Login" class="logoCadastro">
                    <h3 class="divideTipoCadastro">Vamos Começar?</h3>
                    <div class="btn-selectable btnTipoCadastro" id="btnCompra">Quero comprar ou contratar</div>
                    <div class="btn-selectable btnTipoCadastro" id="btnVende">Quero vender ou prestar serviços</div>
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
    <script src="..\..\assets\js\cadastro.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Função para esconder alertas após 2 segundos
            var alerts = document.querySelectorAll('.alert');
            if (alerts) {
                setTimeout(function() {
                    alerts.forEach(function(element) {
                        element.style.display = 'none';
                    });
                }, 2000);
            }
        });
    </script>

</body>

</html>