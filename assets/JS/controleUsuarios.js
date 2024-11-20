// Ordenar a tabela com base na seleção do usuário (A-Z ou Z-A)
document.getElementById('ordenarNomeSelect').addEventListener('change', function () {
    let tabela = document.getElementById('tabelaUsuarios').getElementsByTagName('tbody')[0];
    let linhas = Array.from(tabela.getElementsByTagName('tr'));
    let ordem = this.value; // 'az' ou 'za'

    linhas.sort(function (a, b) {
        let nomeA = a.getAttribute('data-nome').toLowerCase();
        let nomeB = b.getAttribute('data-nome').toLowerCase();

        if (ordem === 'az') {
            return nomeA.localeCompare(nomeB); // A-Z
        } else {
            return nomeB.localeCompare(nomeA); // Z-A
        }
    });

    // Reordenar a tabela
    linhas.forEach(function (linha) {
        tabela.appendChild(linha);
    });
});

// Ativar a função de filtragem quando qualquer um dos filtros mudar
document.getElementById('pesquisarUsuario').addEventListener('keyup', filtrarTabela);
document.getElementById('filtroTipoUsuario').addEventListener('change', filtrarTabela);

function filtrarTabela() {
    let valorPesquisa = document.getElementById('pesquisarUsuario').value.toLowerCase();
    let filtroTipo = document.getElementById('filtroTipoUsuario').value.toLowerCase();
    let linhas = document.querySelectorAll('#tabelaUsuarios tbody tr');

    linhas.forEach(function (linha) {
        let nome = linha.getAttribute('data-nome').toLowerCase();
        let tipo = linha.getAttribute('data-tipo').toLowerCase();

        // Verifica se a linha atende tanto ao filtro de nome quanto ao filtro de tipo de usuário
        if ((filtroTipo === 'todos' || tipo === filtroTipo) && nome.includes(valorPesquisa)) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
    });
}

// Função de validação para o campo cargo
function validarCargo(cargo) {
    // Verifica se o cargo está preenchido e tem menos de 30 caracteres
    return cargo.trim() !== "" && cargo.length <= 30;
}

// Validação do campo cargo em tempo real
document.getElementById('cargo').addEventListener('input', function () {
    const cargoInput = this;
    const cargoValor = cargoInput.value;
    const cargoFeedback = document.querySelector('.cargoFeedback'); // Certifique-se de que esse elemento existe

    if (!validarCargo(cargoValor)) {
        cargoInput.classList.add('is-invalid');
        cargoFeedback.textContent = 'Por favor, insira um cargo válido (até 30 caracteres).';
        cargoFeedback.classList.add('text-danger'); // Adiciona uma classe para estilizar o feedback
    } else {
        cargoInput.classList.remove('is-invalid');
        cargoFeedback.textContent = '';
        cargoFeedback.classList.remove('text-danger'); // Remove a classe se o cargo estiver válido
    }
});


// Cancelar criação de usuarios administradores
const cancelarBtn = document.getElementById('cancelarEdicao');
cancelarBtn.addEventListener('click', function () {
    Swal.fire({
        title: "Cancelar Edição",
        text: "Você tem certeza que deseja cancelar a criação de um novo usuário?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            const formulario = document.getElementById('CadastroUsuarios');
            formulario.reset();
            // Remove classes de erro, feedbacks e formatações
            formulario.querySelectorAll('.is-invalid, .text-danger').forEach((el) => el.classList.remove('is-invalid', 'text-danger'));
            formulario.querySelectorAll('.invalid-feedback, .emailFeedback, .cargoFeedback').forEach((el) => el.style.display = 'none');
            formulario.querySelectorAll('.text-danger').forEach((el) => el.textContent = '');
            const modal = bootstrap.Modal.getInstance(document.getElementById('novoUsuario'));
            modal.hide();
        }
    });
});


/// Visualizar os dados do usuário
document.addEventListener('DOMContentLoaded', function () {
    const viewButtons = document.querySelectorAll('.view-admin');
    viewButtons.forEach(button => {
        button.addEventListener('click', () => {
            const usuarioId = button.getAttribute('data-id');
            const tabela = button.getAttribute('data-table');
            fetch(`../../backend/adm/visualizarUsuario.php?id=${usuarioId}&table=${tabela}`)
                .then(response => response.json())
                .then(data => {
                    const modalBody = document.getElementById('modalBody');
                    modalBody.innerHTML = '';

                    // Adiciona campos dinamicamente com os valores do usuário
                    Object.entries(data).forEach(([label, value]) => {
                        modalBody.innerHTML += `
                            <div class="form-group form-inline texto">
                                <label class="label-custom" for="${label}">${label}:</label>
                                <span>${value || ''}</span>
                            </div>
                        `;
                    });
                })
                .catch(error => console.error('Erro:', error));
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const blockButtons = document.querySelectorAll('.block-admin');

    blockButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            const userName = this.getAttribute('data-name');
            const userType = this.getAttribute('data-user-type');
            const table = this.getAttribute('data-table');
            const isBlock = !this.querySelector('i').classList.contains('fa-lock'); // Identifica se é bloqueio

            // Define prefixo e ID do modal baseado na ação (bloquear ou desbloquear)
            const modalPrefix = isBlock ? 'Block' : 'Unblock';
            const modalId = isBlock ? 'blockModal' : 'unblockModal';

            // Preenche os campos da modal específica
            document.getElementById(`userId${modalPrefix}`).value = userId;
            document.getElementById(`userName${modalPrefix}`).value = userName;
            document.getElementById(`userType${modalPrefix}`).value = userType;
            document.getElementById(`table${modalPrefix}`).value = table;

            // Limpa produtos anteriores do modal específico
            const productWarning = document.getElementById(`productWarning${modalPrefix}`);
            const productsContainer = document.getElementById(`associatedProducts${modalPrefix}`);
            productWarning.style.display = 'none';
            productsContainer.innerHTML = '';

            // Exibir produtos associados somente para Prestadores
            if (table === 'Prestadores') {
                fetch('../../backend/adm/verificaProdutos.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `userId=${userId}&table=${table}`
                })
                    .then(response => response.json())
                    .then(produtos => {
                        if (produtos.length > 0) {
                            productWarning.style.display = 'block';
                            produtos.forEach(produto => {
                                const productItem = document.createElement('li');
                                productItem.textContent = produto.nome_produto;
                                productsContainer.appendChild(productItem);
                            });
                        }
                    });
            }

            // Atualizar informações do usuário no modal específico, com verificação de existência
            const userInfoElement = document.getElementById(`userInfo${modalPrefix}`);
            if (userInfoElement) {
                userInfoElement.textContent = `Usuário: ${userName} (${userType})`;
            }

            // Abrir a modal correta
            const modalInstance = new bootstrap.Modal(document.getElementById(modalId));
            modalInstance.show();

            // Remover a tela escura ao fechar
            document.getElementById(modalId).addEventListener('hidden.bs.modal', function () {
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            });
        });
    });
});

