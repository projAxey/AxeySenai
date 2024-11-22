# Axey - Guia de Instalação e Uso

Este é o repositório do sistema **Axey**, desenvolvido para facilitar a conexão entre prestadores de serviços e clientes. O sistema é projetado para execução local utilizando o servidor **XAMPP**.

---

## Requisitos

Antes de começar, certifique-se de que o seguinte software esteja instalado na sua máquina:

- **XAMPP** (versão mínima recomendada: 3.3.0)
- **MySQL Workbench** (recomendado)
- Tipo de servidor: **MariaDB**
- Versão do servidor: **10.4.32**
- Charset do servidor: **UTF-8 Unicode (utf8)**
- Browser web atualizado
- IDE para edição de código (recomendado: **VS Code**)

---

## Instalação

Siga os passos abaixo para configurar o sistema localmente:

1. **Baixe o XAMPP**  
   Faça o download e instale o XAMPP a partir do site oficial:  
   [https://www.apachefriends.org](https://www.apachefriends.org).

2. **Clone ou baixe o repositório**  
   - **Via Git**:  
     Execute o comando:
     ```bash
     git clone https://github.com/projAxey/projAxeySenai.git
     ```
   - **Via arquivo `.zip`**:  
     Faça o download do arquivo `.zip`, extraia-o e mova o conteúdo para a pasta `htdocs` do XAMPP:
     ```
     C:/xampp/htdocs/projAxeySenai
     ```

3. **Importe o banco de dados**  
   Siga os passos abaixo no **MySQL Workbench**:

   - Abra sua instância local ou crie uma nova.
   - No menu superior, vá até **Server** e selecione **Data Import**.
   - Escolha a opção **Import from Self-Contained File**.
   - Localize e selecione o arquivo `.sql` fornecido no repositório.
   - Crie um novo Schema com nome `axey`.
   - Na aba **Import Progress**, clique em **Start Import**.
   - Após a conclusão, o banco estará disponível para uso.  
     Caso não apareça na lista lateral, clique em **Refresh** para atualizar.

4. **Configuração do arquivo de conexão com o banco de dados**  
   Localize o arquivo de configuração:
    projAxeySenai/config/conexao.php

   Edite o arquivo com as informações da sua instância do MySQL, como:
- Nome do banco
- Usuário
- Senha
- Host

5. **Certifique-se de que o servidor Apache está ativo**  
Abra o painel do **XAMPP** e inicie o servidor Apache clicando no botão correspondente.

---

## Uso

Abra o navegador web de sua preferência e acesse o sistema através do endereço:  
http://localhost/projAxeySenai

---

## Notas Adicionais

- **Importação do Banco de Dados**: O processo inclui criar uma instância no MySQL Workbench, selecionar o arquivo `.sql`, e garantir que o schema importado esteja visível na interface.
- **Atualização de Schemas**: Caso o schema importado não esteja listado, atualize a interface clicando em **Refresh**.
- **Execução do Servidor Apache**: Certifique-se de que o painel do XAMPP está funcionando corretamente e o servidor Apache está ativado.

## Usuários do Sistema

### Usuário Administrador (ADM)
- **E-mail:** adm@gmail.com
- **Senha:** Axey@123

### Usuário Prestador
- **E-mail:** prestador@gmail.com
- **Senha:** Axey@123

### Usuário Cliente
- **E-mail:** cliente@gmail.com
- **Senha:** Axey@123
---
