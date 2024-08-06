<?php

class LoginPage {
    public function render() {
        $this->head();
        echo '<body>';
        $this->content();
        $this->footer();
        echo $this->getScripts();
        echo '</body></html>';
    }

    private function head() {
        include '../../padroes/head.php';
    }

    private function content() {
        echo '
        <div class="container-fluid contLogin mt-5">
            <div class="card col-md-4 cardLogin" style="border-radius: 8px">
                <img src="../../assets/imgs/logoAxey.png" class="card-img-top" alt="Imagem de Login">
                <input type="text" class="form-control form-control-sm" style="border-radius: 8px" placeholder="Usuário">
                <input type="password" class="form-control form-control-sm" style="border-radius: 8px" placeholder="Senha">

                <button type="submit" id="entrarBtn" class="btn btn-primary btn-sm btn-block" style="color: white; border: none; background-color: #1A3C53; border-radius: 8px">Entrar</button>
    
                <a href="#" class="btnEsqueciSenha btn-sm" data-toggle="modal" data-target="#esqueciSenhaModal" style="color: #00376B;">Esqueci minha senha</a>

                <div class="modal fade" id="esqueciSenhaModal" tabindex="-1" role="dialog" aria-labelledby="esqueciSenhaModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="cpfRecuperaSenha">Informe o CPF cadastrado</label>
                                        <input type="number" class="form-control" id="cpfRecuperaSenha" placeholder="000.000.000-00">
                                    </div>
                                    <div class="form-group">
                                        <label for="nascimentoRecuperaSenha">Informe a data de Nascimento</label>
                                        <input type="date" class="form-control" id="nascimentoRecuperaSenha">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer esqueciSenhaModalFooter">
                                <button type="button" class="btn btn-primary" style="background-color: #1A3C53; border: none">Recuperar Senha</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card cardCadastre col-sm-10" style="border-radius: 8px">
                    <span class="card-text">Não tem uma conta?
                        <a href="cadastroUsuarios.php" style="display: inline-block;"> Cadastre-se</a>
                    </span>
                </div>
            </div>
        </div>';
    }

    private function footer() {
        include '../../padroes/footer.php';
    }

    private function getScripts() {
        return '
            <script>
                document.getElementById("entrarBtn").addEventListener("click", function() {
                    window.location.href = "../../index.php";
                });
            </script>';
    }
}

$page = new LoginPage();
$page->render();
?>
