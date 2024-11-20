document.addEventListener("DOMContentLoaded", function () {
    const excluirAgendamentoButtons = document.querySelectorAll('.excluiDisponibilidade');

    excluirAgendamentoButtons.forEach((button) => {
        button.addEventListener("click", async (event) => {
            event.preventDefault();
            const agendamentoId = button.value;

            try {
                // Primeiramente verifica se o agendamento pode ser excluído
                const statusResponse = await fetch(`../../backend/calendario/buscaAgendamentoStatus.php?id=${agendamentoId}`);
                const statusData = await statusResponse.json();

                // Verifica o status do agendamento
                if (statusData.status == 2) {
                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: "Não é possível apagar agendamentos aprovados. Entre em contato com o fornecedor."
                    });
                } else {
                    // Exibe o alerta de confirmação
                    const confirmDelete = await Swal.fire({
                        title: "Confirma a exclusão do agendamento?",
                        text: "Esta ação é irreversível e excluirá o agendamento permanentemente.",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonColor: "#d33",
                        confirmButtonColor: "#3085d6",
                        cancelButtonText: "Cancelar",
                        confirmButtonText: "Sim, excluir"
                    });

                    // Se confirmado, chama a função para excluir
                    if (confirmDelete.isConfirmed) {
                        await excluirAgendamento(agendamentoId);
                    }
                }
            } catch (error) {
                console.error("Erro ao verificar o status do agendamento:", error);
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Ocorreu um erro ao tentar verificar o status do agendamento."
                });
            }
        });
    });

    // Função para excluir o agendamento
    async function excluirAgendamento(id) {
        try {
            const response = await fetch(`../../backend/calendario/buscaAgendamentosExcluir.php?id=${id}`, { method: "GET" });
            const result = await response.json();

            // Verifica o retorno e exibe a mensagem apropriada
            if (result.status) {
                Swal.fire({
                    icon: "success",
                    title: "Agendamento Excluído",
                    text: result.msg
                }).then(() => {
                    location.reload(); // Recarrega a página para atualizar a lista
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: result.msg // Mensagem de erro
                });
            }
        } catch (error) {
            console.error("Erro ao excluir o agendamento:", error);
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "Ocorreu um erro ao tentar excluir o agendamento."
            });
        }
    }

    document.querySelectorAll('.viewDisponibilidade').forEach(button => {
        button.addEventListener('click', function () {
            const agendamentoId = this.getAttribute('data-agendamento-id');

            // Faz a chamada à API para buscar os dados do agendamento
            fetch(`../../backend/calendario/buscaAgendamentos.php?id=${agendamentoId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao carregar os dados');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }

                    // Preenche os campos da modal com os dados recebidos
                    document.getElementById('modal-nomeProduto').textContent = data.nome_produto || 'Não informado';
                    document.getElementById('modal-categoriaProduto').textContent = data.titulo_categoria || 'Não informado';
                    document.getElementById('modal-serviceDate').textContent = data.data_agenda || 'Não informado';
                    document.getElementById('modal-descricaoServico').textContent = data.servico_descricao || 'Não informado';

                    // Determina o nome do prestador com base na prioridade
                    const nomePrestador =
                        data.nome_fantasia ||
                        data.razao_social ||
                        data.nome_social ||
                        data.nome ||
                        data.nome_resp_legal ||
                        'Não informado';
                    document.getElementById('modal-nomePrestador').textContent = nomePrestador;

                    // Exibe a modal
                    const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
                    viewModal.show();
                    document.querySelector('.modal-backdrop').remove();
                })
                .catch(error => {
                    console.error('Erro:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: error.message || 'Erro ao carregar os dados do agendamento',
                    });
                });
        });

    });


});
