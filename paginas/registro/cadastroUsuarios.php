<!DOCTYPE html>
<html lang="pt-br">

<?php
include '../../padroes/head.php';
?>

<body>


  <div class="row justify-content-center ajustaTela">
    <div class="col-md-6 ">
      <div class="card">
        <div class="card-header text-center">
          <img src="../../assets/imgs/logoPronta.png" alt="Logo da Axey" class="logoCadastro">
          <h3>Crie sua conta. É grátis!</h3>
        </div>
        <div class="card-body">
          <form id="iCadastroUsuarios">
            <div class="form-group">
              <label for="nome">Seu Nome *</label>
              <input type="text" class="form-control" id="nome" placeholder="Ex: João Antonio da Silva" required>
            </div>

            <div id="juridicaFields" style="display: none;">
              <div class="form-group">
                <label for="nomeFantasia">Nome Fantasia *</label>
                <input type="text" class="form-control" id="nomeFantasia" placeholder="" required>
              </div>

              <div class="form-group">
                <label for="razaoSocial">Razão Social *</label>
                <input type="text" class="form-control" id="razaoSocial" required>
              </div>
            </div>

            <div class="form-group" id="fisicaFields" style="display: none;">
              <label for="nomeSocial">Nome Social *</label>
              <input type="text" class="form-control" id="nomeSocial" placeholder="" required>
            </div>

            <div class="form-row">
              <div class="form-group col-md-7">
                <label for="email">Email *</label>
                <input type="email" class="form-control" id="email" placeholder="Ex: joaoantonio@gmail.com" required>
              </div>
              <div class="form-group col-md-5">
                <label for="dataNascimento">Data de Nascimento *</label>
                <input type="date" class="form-control text-center" id="dataNascimento" placeholder="dd/mm/aaaa" required>
              </div>
            </div>


            <div class="form-row">
              <div class="form-group col-md-6" id="cnpjFields" style="display: none;">
                <label for="cnpj">CNPJ *</label>
                <input type="text" class="form-control" id="cnpj" required>
              </div>

              <div class="form-group col-md-6" id="cpfFields" style="display: none;">
                <label for="cpf">CPF *</label>
                <input type="text" class="form-control" id="cpf" required>
              </div>

              <div class="form-group col-md-6" id="seguimentoFields" style="display: none;">
                <label for="seguimento">Seguimento *</label>
                <select class="form-control" id="seguimento" required>
                  <option value="" disabled selected>Selecione um seguimento</option>
                  <option value="teste">Aqui vem do banco</option>
                </select>
              </div>
            </div>

            <div id="descricaoFields" style="display: none;">
              <div class="form-group">
                <label for="descricao">Descrição do Negócio *</label>
                <textarea class="form-control descricaoNegocio" id="descricao" required></textarea>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="celular">Celular *</label>
                <input type="text" class="form-control" id="celular" required>
              </div>
              <div class="form-group col-md-6">
                <label for="telefone">Telefone *</label>
                <input type="text" class="form-control" id="telefone" required>
              </div>
            </div>

            <div class="form-row">
              <div class="col-md-12">
                <label for="cep">CEP *</label>
                <div class="form-group d-flex">

                  <input type="text" class="form-control col-md-4 mr-md-2" id="cep" placeholder="00000-000" required>
                  <a class="col-md-8 mt-2" href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep" target="_blank">Não sei meu Cep</a>
                </div>
              </div>
            </div>

            <div class="form-row">

              <div class="form-group col-md-5">
                <label for="endereco">Endereço *</label>
                <input type="text" class="form-control" id="endereco" placeholder="" required>
              </div>

              <div class="form-group col-md-4">
                <label for="bairro">Bairro *</label>
                <input type="text" class="form-control" id="bairro" placeholder="" required>
              </div>

              <div class="form-group col-md-3">
                <label for="numero">Número *</label>
                <input type="text" class="form-control numero-menor" id="iNumero" name="nNumero" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade">
              </div>

              <div class="form-group col-md-4">
                <label for="estado">Estado</label>
                <input type="text" class="form-control" id="estado">
              </div>

              <div class="form-group col-md-4">
                <label for="complemento">Complemento</label>
                <input type="text" class="form-control" id="complemento">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="senha">Digite sua Senha *</label>
                <input type="password" class="form-control" id="senha" required>
              </div>
              <div class="form-group col-md-6">
                <label for="senha_repetida">Repita sua Senha *</label>
                <input type="password" class="form-control" id="senha_repetida" required>
              </div>
            </div>



            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-primary" style="background-color: #1A3C53; border: none;" onclick="return validar()">Cadastre-se</button>
            </div>
            <div class="d-flex justify-content-center mt-2">
              <span>Já tem uma conta? </span>
              <a href="login.php" style="display: inline-block;">Entrar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirmaUser" tabindex="-1" aria-labelledby="confirmaUser">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body modalCadastro">
          <img src="../../assets/imgs/imgLogin.png" alt="Img Login" class="logoCadastro">
          <h3 class="divideTipoCadastro">Vamos Começar?</h3>
          <div class="btn-selectable selecionado btnTipoCadastro" id="btnCompra">Quero comprar ou contratar</div>
          <div class="btn-selectable selecionado btnTipoCadastro" id="btnVende">Quero vender ou prestar serviços</div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirmaPessoa" tabindex="-1" aria-labelledby="confirmaPessoa">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body modalCadastro">
          <img src="../../assets/imgs/imgLogin.png" alt="Img Login" class="logoCadastro">
          <h3 class="divideTipoCadastro">Você é?</h3>
          <div class="btn-selectable selecionado2 btnTipoCadastro" id="btnJuridica">Pessoa Juridica<span class="texto"> (Possuo CNPJ)</span></div>
          <div class="btn-selectable selecionado2 btnTipoCadastro" id="btnFisica">Pessoa Fisica <span class="texto">(Não possuo CNPJ)</span></div>
        </div>
      </div>
    </div>
  </div>

  <?php
  include '../../padroes/footer.php';
  ?>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  <script>
    function validar() {

      var nome = document.getElementById("nome").value;
      var regex = /^\S{2,}\s+\S+/; // Pelo menos duas palavras com um espaço entre elas
      if (!regex.test(nome)) {
        alert("O nome deve conter pelo menos duas palavras, sendo a primeira com pelo menos dois caracteres e um espaço entre elas.");
        return false;
      }
      var senha = document.getElementById("senha").value;
      var repetirSenha = document.getElementById("senha_repetida").value;

      // Verifica se a senha tem pelo menos 6 caracteres
      if (senha.length < 6) {
        alert("A senha deve ter pelo menos 6 caracteres.");
        return false;
      }

      // Verifica se a senha e a repetição da senha são iguais
      if (senha !== repetirSenha) {
        alert("As senhas não coincidem. Por favor, verifique.");
        return false;
      }
      return true;
    }


    $(document).ready(function() {
      $("#confirmaUser").modal('show');

      $(".selecionado").click(function() {
        $("#confirmaUser").modal('hide');
        $("#confirmaPessoa").modal('show');

        if ($(this).attr('id') == 'btnVende') {
          $("#seguimentoFields").show();
          $("#descricaoFields").show();
        }
      });

      $(".selecionado2").click(function() {
        $("#confirmaPessoa").modal('hide');

        if ($(this).attr('id') == 'btnJuridica') {
          $("#juridicaFields").show();
          $("#cnpjFields").show();
        } else if ($(this).attr('id') == 'btnFisica') {
          $("#fisicaFields").show();
          $("#cpfFields").show();

        }

      });

      $('#iCadastroUsuarios').on('submit', function(e) {
        const formData = new FormData(this)


      });
    });

    $('#cnpj').mask('00.000.000/0000-00');
    $('#cpf').mask('000.000.000-00');
    $('#celular').mask('(00) 00000-0000');
    $('#telefone').mask('(00) 0000-0000');
    $('#cep').mask('00000-000');

    function buscarCep() {
      var cep = $('#cep').val().replace(/\D/g, ''); // Remove caracteres não numéricos
      if (cep.length != 8) {
        alert('CEP inválido. Por favor, digite um CEP válido.');
        return;
      }

      $.ajax({
        url: 'https://viacep.com.br/ws/' + cep + '/json/',
        dataType: 'json',
        success: function(data) {
          if (!data.erro) {
            $('#endereco').val(data.logradouro);
            $('#bairro').val(data.bairro);
            $('#cidade').val(data.localidade);
            $('#estado').val(data.uf);
            $('#numero').focus(); // Mova o foco para o campo de número após preencher o endereço
          } else {
            alert('CEP não encontrado. Por favor, verifique o CEP digitado.');
          }
        },
        error: function() {
          if ($('#cep').val().length == 8) {
            alert('Erro ao buscar o CEP. Por favor, tente novamente.');
          }
        }
      });
    }

    $('#cep').on('blur', buscarCep);
    $('#cep').on('keypress', function(event) {
      if (event.which === 13) { // Se a tecla Enter for pressionada
        buscarCep();
      }
    });
  </script>



</body>

</html>