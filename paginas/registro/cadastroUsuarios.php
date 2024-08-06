<!DOCTYPE html>
<html lang="pt-br">

<?php include '../../padroes/head.php'; ?>

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
            <form id="iCadastroUsuarios">
              <!-- Outros campos -->
              <div class="mb-3">
                <label for="nome" class="form-label" id="nomeLabel">Nome Completo*</label>
                <input type="text" class="form-control" id="nome" placeholder="Ex: João Antonio da Silva" required>
              </div>
              <div id="nomeSocialFields" class="d-none mb-3">
                <label for="nomeSocial" class="form-label">Nome Social *</label>
                <input type="text" class="form-control" id="nomeSocial" placeholder="Ex: Joãozinho">
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="usarNomeSocial">
                <label class="form-check-label" for="usarNomeSocial">
                  Desejo usar Nome Social
                </label>
              </div>

              <!-- Campos Jurídicos e Físicos -->
              <div id="juridicaFields" class="d-none">
                <div class="mb-3">
                  <label for="nomeFantasia" class="form-label">Nome Fantasia *</label>
                  <input type="text" class="form-control" id="nomeFantasia" required>
                </div>
                <div class="mb-3">
                  <label for="razaoSocial" class="form-label">Razão Social *</label>
                  <input type="text" class="form-control" id="razaoSocial" required>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-7">
                  <label for="email" class="form-label">Email *</label>
                  <input type="email" class="form-control" id="email" placeholder="Ex: joaoantonio@gmail.com" required>
                </div>
                <div class="col-md-5">
                  <label for="dataNascimento" class="form-label">Data de Nascimento *</label>
                  <input type="date" class="form-control text-center" id="dataNascimento" required>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6" id="cnpjFields" class="d-none">
                  <label for="cnpj" class="form-label">CNPJ *</label>
                  <input type="text" class="form-control" id="cnpj" maxlength="18" required>
                  <div id="cnpjFeedback" class="invalid-feedback">CNPJ inválido.</div>
                </div>
                <div class="col-md-6" id="cpfFields" class="d-none">
                  <label for="cpf" class="form-label">CPF *</label>
                  <input type="text" class="form-control" id="cpf" maxlength="14" required>
                  <div id="cpfFeedback" class="invalid-feedback">CPF inválido.</div>
                </div>
                <div class="col-md-6 d-none" id="categoriaFields">
                  <label for="seguimento" class="form-label">Categoria *</label>
                  <select class="form-select" id="seguimento" required>
                    <option value="" disabled selected>Selecione um seguimento</option>
                    <option value="teste">Aqui vem do banco</option>
                  </select>
                </div>
              </div>

              <div id="descricaoFields" class="d-none">
                <div class="mb-3">
                  <label for="descricao" class="form-label">Descrição do Negócio *</label>
                  <textarea class="form-control descricaoNegocio" id="descricao" required></textarea>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="celular" class="form-label">Celular *</label>
                  <input type="text" class="form-control" id="celular" maxlength="15" required>
                </div>
                <div class="col-md-6">
                  <label for="telefone" class="form-label">Telefone *</label>
                  <input type="text" class="form-control" id="telefone" maxlength="14" required>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="cep" class="form-label">CEP *</label>
                  <div class="d-flex">
                    <input type="text" class="form-control me-2" id="cep" placeholder="00000-000" maxlength="9" required>
                    <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" id="buscarCep" target="_blank">Não sei meu Cep</a>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-5">
                  <label for="endereco" class="form-label">Endereço *</label>
                  <input type="text" class="form-control" id="endereco" required>
                </div>
                <div class="col-md-4">
                  <label for="bairro" class="form-label">Bairro *</label>
                  <input type="text" class="form-control" id="bairro" required>
                </div>
                <div class="col-md-3">
                  <label for="numero" class="form-label">Número *</label>
                  <input type="text" class="form-control numero-menor" id="iNumero" name="nNumero" required>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="cidade" class="form-label">Cidade</label>
                  <input type="text" class="form-control" id="cidade">
                </div>
                <div class="col-md-4">
                  <label for="estado" class="form-label">Estado</label>
                  <input type="text" class="form-control" id="estado">
                </div>
                <div class="col-md-4">
                  <label for="complemento" class="form-label">Complemento</label>
                  <input type="text" class="form-control" id="complemento">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="senha" class="form-label">Digite sua Senha *</label>
                  <input type="password" class="form-control" id="senha" required>
                </div>
                <div class="col-md-6">
                  <label for="senha_repetida" class="form-label">Repita sua Senha *</label>
                  <input type="password" class="form-control" id="senha_repetida" required>
                </div>
              </div>

              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" style="background-color: #1A3C53; border: none;">Cadastre-se</button>
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

  <?php include '../../padroes/footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var confirmaUserModal = new bootstrap.Modal(document.getElementById('confirmaUser'), {
        backdrop: 'static',
        keyboard: false
      });
      var confirmaPessoaModal = new bootstrap.Modal(document.getElementById('confirmaPessoa'), {
        backdrop: 'static',
        keyboard: false
      });

      confirmaUserModal.show();

      function toggleFields(type) {
        document.getElementById('categoriaFields').classList.toggle('d-none', type !== 'venda');
        document.getElementById('descricaoFields').classList.toggle('d-none', type !== 'venda');
        document.getElementById('juridicaFields').classList.toggle('d-none', type !== 'juridica');
        document.getElementById('cnpjFields').classList.toggle('d-none', type !== 'juridica');
        document.getElementById('cpfFields').classList.toggle('d-none', type !== 'fisica');
        document.getElementById('nomeLabel').textContent = type === 'juridica' ? 'Responsável Legal*' : 'Nome Completo*';
        document.getElementById('nome').placeholder = type === 'juridica' ? 'Ex: João Antonio da Silva' : 'Ex: João Antonio da Silva';
        
        // Ajustar o campo Nome Social
        if (type === 'juridica') {
          document.getElementById('usarNomeSocial').disabled = true;
          document.getElementById('usarNomeSocial').checked = false;
          document.getElementById('nomeSocialFields').classList.add('d-none');
        } else {
          document.getElementById('usarNomeSocial').disabled = false;
        }
      }

      document.querySelectorAll(".btn-selectable").forEach(function(el) {
        el.addEventListener('click', function() {
          if (this.id === 'btnCompra' || this.id === 'btnVende') {
            confirmaUserModal.hide();
            confirmaPessoaModal.show();
            toggleFields(this.id === 'btnVende' ? 'venda' : 'fisica');
          } else if (this.id === 'btnJuridica' || this.id === 'btnFisica') {
            confirmaPessoaModal.hide();
            toggleFields(this.id === 'btnJuridica' ? 'juridica' : 'fisica');
          }
        });
      });

      document.getElementById('usarNomeSocial').addEventListener('change', function() {
        if (!document.getElementById('juridicaFields').classList.contains('d-none')) {
          document.getElementById('nomeSocialFields').classList.add('d-none');
        } else {
          document.getElementById('nomeSocialFields').classList.toggle('d-none', !this.checked);
        }
      });

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
            })
        }
      });

      function formatarCPF(cpf) {
        cpf = cpf.replace(/\D/g, '');
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
      }

      function formatarCNPJ(cnpj) {
        cnpj = cnpj.replace(/\D/g, '');
        return cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
      }

      document.getElementById('cpf').addEventListener('input', function() {
        this.value = formatarCPF(this.value);
      });

      document.getElementById('cnpj').addEventListener('input', function() {
        this.value = formatarCNPJ(this.value);
      });

      document.getElementById('celular').addEventListener('input', function() {
        var celular = this.value.replace(/\D/g, '');
        this.value = celular.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
      });

      document.getElementById('telefone').addEventListener('input', function() {
        var telefone = this.value.replace(/\D/g, '');
        this.value = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
      });

      document.getElementById('cpf').addEventListener('blur', function() {
        var cpf = this.value.replace(/\D/g, '');
        if (!validarCPF(cpf)) {
          this.classList.add('is-invalid');
          document.getElementById('cpfFeedback').style.display = 'block';
        } else {
          this.classList.remove('is-invalid');
          document.getElementById('cpfFeedback').style.display = 'none';
        }
      });

      document.getElementById('cnpj').addEventListener('blur', function() {
        var cnpj = this.value.replace(/\D/g, '');
        if (!validarCNPJ(cnpj)) {
          this.classList.add('is-invalid');
          document.getElementById('cnpjFeedback').style.display = 'block';
        } else {
          this.classList.remove('is-invalid');
          document.getElementById('cnpjFeedback').style.display = 'none';
        }
      });

      document.getElementById('iCadastroUsuarios').addEventListener('submit', function(event) {
        var cpf = document.getElementById('cpf').value.replace(/\D/g, '');
        var cnpj = document.getElementById('cnpj').value.replace(/\D/g, '');
        if (document.getElementById('cpfFields').classList.contains('d-none') === false && !validarCPF(cpf)) {
          event.preventDefault();
          alert('CPF inválido.');
        }
        if (document.getElementById('cnpjFields').classList.contains('d-none') === false && !validarCNPJ(cnpj)) {
          event.preventDefault();
          alert('CNPJ inválido.');
        }
      });

      function validarCPF(cpf) {
        if (cpf.length !== 11 || /^(.)\1{10}$/.test(cpf)) return false;
        var add = 0;
        for (var i = 0; i < 9; i++) add += parseInt(cpf.charAt(i)) * (10 - i);
        var rev = 11 - (add % 11);
        rev = (rev === 10 || rev === 11) ? 0 : rev;
        if (rev !== parseInt(cpf.charAt(9))) return false;
        add = 0;
        for (i = 0; i < 10; i++) add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        rev = (rev === 10 || rev === 11) ? 0 : rev;
        return rev === parseInt(cpf.charAt(10));
      }

      function validarCNPJ(cnpj) {
        if (cnpj.length !== 14 || /^(.)\1{13}$/.test(cnpj)) return false;
        var tamanho = cnpj.length - 2;
        var numeros = cnpj.substring(0, tamanho);
        var digitos = cnpj.substring(tamanho);
        var soma = 0, pos = tamanho - 7;
        for (var i = tamanho; i >= 1; i--) {
          soma += numeros.charAt(tamanho - i) * pos--;
          if (pos < 2) pos = 9;
        }
        var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado !== parseInt(digitos.charAt(0))) return false;
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (var i = tamanho; i >= 1; i--) {
          soma += numeros.charAt(tamanho - i) * pos--;
          if (pos < 2) pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        return resultado === parseInt(digitos.charAt(1));
      }
    });
  </script>
</body>

</html>
