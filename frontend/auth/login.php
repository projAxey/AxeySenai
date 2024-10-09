<?php

session_start();

class LoginPage
{

    public function render()
    {
        $this->head();
        echo '<body>';
        $this->content();
        echo '</body></html>';
    }

    private function head()
    {
        include '../layouts/head.php'; // Aqui está o seu layout head.
    }

    private function content()
    {

        $errorMessage = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
        unset($_SESSION['login_error']);


        $successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        unset($_SESSION['success_message']);

        echo '
        <div class="container-fluid contLogin mt-5">
            <div class="card col-md-4 cardLogin" style="border-radius: 8px">
            
                <img src="../../assets/imgs/logoAxey.png" class="card-img-top" alt="Imagem de Login">';

        if ($errorMessage) {
            echo '<div class="alert alert-danger mt-3" role="alert">' . $errorMessage . '</div>';
        }

        if ($successMessage) {
            echo '<div class="alert alert-success mt-3" role="alert" style="width: 100%; text-align: center;">' . $successMessage . '</div>';
        }

        echo '
                <form style="width: 80%;" method="POST" action="../../backend/auth/login.php">
                    <input type="text" name="email" class="form-control my-2" style="border-radius: 8px" placeholder="Usuário" required>

                    <input type="password" name="password" class="form-control my-2" style="border-radius: 8px" placeholder="Senha" required>

                    <button type="submit" class="btn btn-primary w-100 my-2" style="color: white; border: none; background-color: #1A3C53; border-radius: 8px">Entrar</button>
                </form>
    
                <a href="#" class="btnEsqueciSenha btn-sm" data-bs-toggle="modal" data-bs-target="#esqueciSenhaModal" style="color: #00376B;">Esqueci minha senha</a>

                <div class="modal fade" id="esqueciSenhaModal" tabindex="-1" aria-labelledby="esqueciSenhaModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="emailRecuperaSenha">Informe o E-mail cadastrado</label>
                                        <input type="mail" class="form-control" id="emailRecuperaSenha">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer esqueciSenhaModalFooter">
                                <button type="button" class="btn btn-primary" style="background-color: #1A3C53; border: none">Recuperar Senha</button>
                            </div>
                        </div>
                    </div>
                </div>';

        echo '
                <div class="card cardCadastre col-sm-10" style="border-radius: 8px">
                    <span class="card-text">Não tem uma conta?
                        <a href="register.php" style="display: inline-block;"> Cadastre-se</a>
                    </span>
                </div>

            </div>
        </div>';
    }
}

$page = new LoginPage();
$page->render();
