<?php
include '../layouts/head.php';
include '../layouts/nav.php';
?>

<body class="bodyCards">
    <div class="container mt-4">
        <button type="button" id='meusAgendamentos' class="mb-2 btn btn-primary btn-servicos-contratados"
            style="background-color: #012640; color:white" onclick="window.location.href='../../index.php';">
            Voltar para Tela Inicial
        </button>
        
        <div class="row d-flex flex-wrap">
            <div class="col-md-4 mt-2">
                <div class="text-center area-foto-perfil mb-2">
                    <img id="fotoPerfil" src="../../assets/imgs/ruivo.png" alt="Ícone de usuário" class="foto-perfil" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                </div>
                <div class="d-grid sidebar-menu">
                    <?php
                    if ($_SESSION['tipo_usuario'] === 'cliente') { ?>
                        <!-- PERFIL PRESTADOR -->
                        <button type="button" id='meusAgendamentos' class="mb-2 btn btn-primary btn-servicos-contratados"
                            style="background-color: #012640; color:white" onclick="window.location.href='../cliente/servicosContratados.php';">
                            Serviços Contratados 
                        </button>
                        <button type="button" id='meusAgendamentos' class="mb-2 btn btn-primary btn-meus-agendamentos"
                            style="background-color: #012640; color:white" onclick="window.location.href='../cliente/agendamentosCliente.php'">
                            Meus Agendamentos 
                        </button>
                    <?php } else { ?>
                        <button type="button" id='show-calendar' class="mb-2 mt-2 btn btn-primary btnVerificaDisponibilidade"
                            style="background-color: #012640; color:white" data-toggle="modal" data-target="#calendarModal">
                            Ajustar Agenda 
                        </button>
                        <button type="button" id='btnAgendamentos' class="mb-2 btn btn-primary btnAgendamentos"
                            style="background-color: #012640; color:white" onclick="window.location.href='../prestador/agendamentosPendentes.php'">
                            Agendamentos pendentes 
                        </button>     
                        <button type="button" id='btnMeusProdutos' class="mb-2 btn btn-primary btn-meus-produtos"
                            style="background-color: #012640; color:white" onclick="window.location.href='../prestador/TelaMeusProdutos.php'">
                            Meus Serviços 
                        </button>          
                        <button type="button" id='MeusDestaques' class="mb-2 btn btn-primary btnMeusDestaques"
                            style="background-color: #012640; color:white" onclick="window.location.href='../prestador/destaquesPrestador.php'">
                            Meus Destaques 
                        </button>
                    <?php } ?>

                    <!-- Botão comum pra todos os usuários -->
                    <button type="button" class="btn btn-primary mb-2" id="alterar-foto" style="background-color: #012640; color:white" data-bs-toggle="modal" data-bs-target="#modalAlterarFoto">
                        <i class="bi bi-pencil"></i> Alterar Foto
                    </button>
                    <button class="btn btn-primary edit-perfil mb-2" id="editarPerfil" style="background-color: #012640;">
                        <i class="bi bi-pencil"></i>Editar Perfil
                    </button>
                    <button type="button" class="btn btn-primary btnAlteraSenha mb-2" data-bs-toggle="modal" id="AlteraSenha" data-bs-target="#mdlAlteraSenha" style="background-color: #012640; color:white;">
                        <i class="bi bi-pencil"></i>Alterar Senha
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

            <div class="col-md-8 mt-2">
            <form class="mt-3" id="editForm">
                <div class="row g-3">
                    <div class="mb-3" id="nomeCompleto">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" disabled>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-2" id="respLegal">
                        <label for="respLegal" class="form-label">Responsável Legal</label>
                        <input type="text" class="form-control" name="responsavelLegal" disabled>
                    </div>
                    <div class="col-md-12" id="nome-social-div">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="nome-social-checkbox" disabled>
                            <label class="form-check-label" for="nome-social-checkbox">Usar Nome Social</label>
                        </div>
                    </div>

                    <div class="col-md-12" id="nome-social-field" style="display: none;">
                        <label for="nome-social" class="form-label">Nome Social</label>
                        <input type="text" class="form-control" id="nome-social" maxlength="100" disabled>
                    </div>
                    <div class="mb-3" id="nomeFantasiaField">
                        <label for="nomeFantasia" class="form-label">Nome Fantasia *</label>
                        <input type="text" class="form-control" id="nomeFantasia" name="nomeFantasia" disabled>
                    </div>
                    <div class="mb-3" id="razaoSocialField">
                        <label for="razaoSocial" class="form-label">Razão Social *</label>
                        <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" disabled>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email"disabled>
                            <div class="emailFeedback"></div>
                        </div>
                        <div class="col-md-5" id="dataNascimentoFields">
                            <label for="dataNascimento" class="form-label">Data de Nascimento *</label>
                            <input type="date" class="form-control text-center" id="dataNascimento" name="dataNascimento" disabled>
                            <div class="invalid-feedback">Por favor, insira uma data acima de 1924 e abaixo de 2124.</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6" id="cnpjFields" class="d-none">
                            <label for="cnpj" class="form-label">CNPJ *</label>
                            <input type="text" class="form-control" id="cnpj" name="cnpj" maxlength="18" disabled>
                            <div class="invalid-feedback">Por favor, preencha um CNPJ válido.</div>
                        </div>
                        <div class="col-md-6" id="cpfFields" class="d-none">
                            <label for="cpf" class="form-label">CPF *</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" disabled>
                            <div class="invalid-feedback">Por favor, preencha um CPF válido.</div>
                        </div>
                        <div class="col-md-6" id="categoriaFields">
                            <label for="seguimento" class="form-label">Categoria *</label>
                            <select class="form-select" id="categoria" name="categoria" disabled>
                                <option value="" disabled selected>Selecione uma categoria</option>
                                <option value="teste">Aqui vem do banco</option>
                            </select>
                        </div>
                    </div>

                    <div id="descricaoFields">
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição do Negócio *</label>
                            <textarea class="form-control descricaoNegocio" id="descricao" name="descricao" disabled></textarea>
                            <div class="invalid-feedback" id="descricao-error">A descrição deve ter pelo menos 30 caracteres.</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="celular" class="form-label">Celular</label>
                        <input type="tel" class="form-control" id="celular" pattern="\(\d{2}\) \d{5}-\d{4}" required aria-required="true" maxlength="15" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="tel" class="form-control" id="telefone" pattern="\(\d{2}\) \d{4}-\d{4}" maxlength="14" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" pattern="\d{5}-\d{3}" required aria-required="true" disabled>
                        <small id="cepHelp" class="form-text text-muted">
                            <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep" target="_blank" style="text-decoration: none;">Não sei meu CEP</a>
                        </small>
                    </div>
                    <div class="col-md-5">
                        <label for="endereco" class="form-label">Endereço *</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" disabled>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary mb-2" id="botaoSalvar" style="background-color: #012640; color:white" disabled>Salvar</button>

                        <button type="cancel" class="btn btn-secondary mb-2" id="botaoCancelar" style=" color:white" disabled>Cancelar</button>
                    </div>
                </div>

                    <div class="modal fade" id="mdlAlteraSenha" tabindex="-1" aria-labelledby="mdlAlteraSenhaLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="senhaAtual">Senha atual</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="senhaAtual" style="background-color: white; border: 1px solid #1A3C53; border-radius: 5px;">
                                                <button type="button" class="btn" id="toggleSenhaAtual" style = "color: #1A3C53; ">
                                                    <i class="bi bi-eye-slash" id="iconSenhaAtual" style="color: #1A3C53;"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="novaSenha">Nova Senha</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="novaSenha" style="background-color: white; border: 1px solid #1A3C53; border-radius: 5px;">
                                                <button type="button" class="btn" id="toggleNovaSenha" style = "color: #1A3C53;">
                                                    <i class="bi bi-eye-slash" id="iconNovaSenha" style="color: #1A3C53;"></i>
                                                </button>
                                            </div>
                                            <small id="passwordHelpBlock" class="form-text text-muted">
                                                Sua senha deve ter entre 8 e 20 caracteres.
                                            </small>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer alteraSenhaFooter">
                                    <button type="submit" class="btn btn-primary mb-2"
                                    style="background-color: #012640; color:white">Confirmar Senha</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        sessionStorage.setItem('tipo_usuario', '<?php echo $_SESSION["tipo_usuario"]; ?>');
    </script>
    <?php
    include '../layouts/footer.php';
    ?>
    <!-- <script src="../../assets/JS/global.js"></script> -->
    <!-- <script src="../../assets/js/editaPerfil.js"></script> -->
    <script src="../../assets/js/validaPerfil.js"></script>
    
</body>
</html>
